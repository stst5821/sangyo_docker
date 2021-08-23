<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Category;
use App\User;
use App\Like;
// PostRequestの使用宣言
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index');
        $this->middleware('verified')->except('index');
    }

    public function index(Request $request)
    {
        // queryメソッドに引数を渡さずに呼び出せば、連想配列ですべてのクエリストリングを取得できる。。
        $query = Post::query(); // ここに複数のクエリを保存できる。

        // viewで表示する”投稿データ”のカテゴリ名を取得する。検索フォームのカテゴリ名ではないので注意。
        $category = new Category; // インスタンス作成
        $categories = $category->getLists(); // Category.phpのgetLists()メソッドでカテゴリテーブルからidとnameだけ取得し、$categoriesに代入。
        
        // =============== ここから 検索フォームでカテゴリを入力し、データ送信後の処理 ===============

        // カテゴリ名が入力されていたら、中身を実行。$categoryNameに検索したいカテゴリを代入。
        if ($request->filled('category')) {
            $categoryName = $request->input('category'); // 検索フォームから入力されたカテゴリ名を変数に代入。
            $category = Category::where('name', $categoryName)->first(); // categoryテーブルのnameカラムと、$categoryNameが一致するレコードを検索し、1件取得。
            $query->where('category_id', $category->id); // 投稿のcategory_idが、$category->idと一致するクエリを$queryに保存する。
        }

        if($request->filled('keyword')) {
            $keyword =  '%' . $this->escape($request->input('keyword')). '%';
            
            // クロージャを使っているが、なぜ使わないといけないか不明。消しても普通に動くのだが。
            $query->where(function($query) use($keyword) {
                $query->where('subject','LIKE',$keyword); // subject、body1~3に、$keywordが入っている投稿を探す。
                $query->orWhere('body1','LIKE',$keyword);
                $query->orWhere('body2','LIKE',$keyword);
                $query->orWhere('body3','LIKE',$keyword);
            });
        }

        // これまで$queryに保存した検索フォームの内容をDBから取得する。
        $posts = $query->orderBy('posts.created_at', 'desc')->paginate(10);

        // =============== ここまで 検索フォームでカテゴリを入力し、データ送信後の処理 ===============

        return view('post.index',[
            'posts' => $posts, 
            'categories' => $categories, // 検索前のindex画面で、投稿ごとのカテゴリを表示するためのデータをviewに送っている。検索フォームのカテゴリデータではない。
            ]);
    }

    // エスケープメソッド ======================================================================================


    private function escape(string $value)
    {
        return str_replace(
            ['\\', '%', '_'],
            ['\\\\', '\\%', '\\_'],
            $value
        );
    }

    // 投稿詳細 ======================================================================================

    public function show(Request $request,$id)
    {
        $post = Post::findOrFail($id);
        $like = $post->likes()->where('user_id', Auth::user()->id)->first();
        return view('post.show',[
            'post' => $post,
            'like' => $like,
        ]);
    }

    // 新規投稿 ======================================================================================

    public function create()
    {
        // ログインしているユーザーの情報をcreate.viewに送っている。
        $auth = Auth::user();
        $category = new Category;
        
        // prependメソッドで、配列の先頭に任意の項目を追加。必ず配列の最初に追加される。prepend(値,キー)
        $categories = $category->getLists()->prepend('選択','');
        return view('post.create',['categories' => $categories, 'auth' => $auth]);
    }

    // 新規投稿の保存 ======================================================================================

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

    // 編集 ======================================================================================

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

    // 削除 ======================================================================================

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $this->authorize('destroy', $post); // PostPolicyのupdateメソッドに書いた条件で認可する。

        $post->comments()->delete(); // コメント削除。Post,commentモデルでリレーション設定をしているので削除できる。
        $post->delete(); // 投稿の削除

        return redirect('/post')->with('poststatus','投稿を削除しました。');
    }
}