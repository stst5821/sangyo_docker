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
        // ログインしてなくても、投稿一覧と詳細は見られるようにする。
        $this->middleware('auth')->except('index','show');
    }

    public function index()
    {
        // joinする postとuser 
        // $posts = Post::join('users', 'users.id', '=', 'posts.user_id')->paginate(10);
        $posts = Post::orderBy('created_at', 'desc')->paginate(10);
        return view('post.index',['posts' => $posts]);
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
        $categories = $category->getLists()->prepend('選択',0);
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

    public function edit($post_id)
    {
        $post = Post::findOrFail($post_id);
        $category = new Category;
        
        // prependメソッドで、配列の先頭に任意の項目を追加。必ず配列の最初に追加される。prepend(値,キー)
        $categories = $category->getLists()->prepend('選択',0);
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
        $post->comments()->delete(); // コメント削除。Post,commentモデルでリレーション設定をしているので削除できる。
        $post->delete(); // 投稿の削除

        return redirect('/post')->with('poststatus','投稿を削除しました。');
    }
}