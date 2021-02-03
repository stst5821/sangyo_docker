<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Category;
use App\User;
// PostRequestの使用宣言
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Auth;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index','show');
        $this->middleware('verified')->except('index','show');
    }

    public function index(Request $request)
    {
        // カテゴリ取得
        $category = new Category; // インスタンス作成
        $categories = $category->getLists();

        // requestされたカテゴリIDを$category_idに代入
        $category_id = $request->category_id;
        // 検索文字列を$searchwordに代入
        $searchword = $request->searchword;

        // usersテーブルにpostsテーブルをjoinする
        // select文の中で、posts.idというようにテーブル名を指定する。これをやらないと、usersテーブルのidとpostsテーブルのidが重複してしまう。
        // 普通にusersのidが
        $posts = Post::select('posts.id','users.username','category_id','user_id','subject','body1','body2','body3','posts.created_at','posts.updated_at')
        ->join('users','posts.user_id','=','users.id')
        ->nameAt($searchword) // 名前でワード検索
        ->categoryAt($category_id)
        ->orderBy('posts.created_at', 'desc')
        ->paginate(10);
        
        return view('post.index',[
            'posts' => $posts, 
            'categories' => $categories, 
            'category_id'=>$category_id,
            'searchword' => $searchword
            ]);
    }

    public function show(Request $request,$id)
    {
        $post = Post::findOrFail($id);
        return view('post.show',[
            'post' => $post,
        ]);
    }

    public function create()
    {
        // ログインしているユーザーの情報をcreate.viewに送っている。
        $auth = Auth::user();
        $category = new Category;
        
        // prependメソッドで、配列の先頭に任意の項目を追加。必ず配列の最初に追加される。prepend(値,キー)
        $categories = $category->getLists()->prepend('選択','');
        return view('post.create',['categories' => $categories, 'auth' => $auth]);
    }

    public function store(PostRequest $request)
    {
        $auth = Auth::user();
        // 複数の入力データを配列にまとめる。
        $savedata = [
            'user_id' => $auth->id,
            'subject' => $request->subject,
            'body1' => $request->body1,
            'body2' => $request->body2,
            'body3' => $request->body3,
            'category_id' => $request->category_id,
        ];
        
        $post = new Post;
        // まとめたデータをfillでsaveする。
        $post->fill($savedata)->save();

        return redirect('/post')->with('poststatus','新規投稿しました');
    }

    public function edit($id)
    {
        $category = new Category;
        $categories = $category->getLists();

        // prependメソッドで、配列の先頭に任意の項目を追加。必ず配列の最初に追加される。prepend(値,キー)
        $post = Post::findOrFail($id);
        $this->authorize('update', $post); // PostPolicyのupdateメソッドに書いた条件で認可する。
        return view('post.edit',['categories' => $categories, 'post' => $post]);
    }

    public function update(PostRequest $request)
    {
        $auth = Auth::user();

        $savedata = [
            'user_id' => $auth->id,
            'subject' => $request->subject,
            'body1' => $request->body1,
            'body2' => $request->body2,
            'body3' => $request->body3,
            'category_id' => $request->category_id,
        ];

        $post = new Post;
        $post->fill($savedata)->save();

        return redirect('/post')->with('poststatus', '投稿を編集しました');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $this->authorize('destroy', $post); // PostPolicyのupdateメソッドに書いた条件で認可する。

        $post->comments()->delete(); // コメント削除。Post,commentモデルでリレーション設定をしているので削除できる。
        $post->delete(); // 投稿の削除

        return redirect('/post')->with('poststatus','投稿を削除しました。');
    }
}