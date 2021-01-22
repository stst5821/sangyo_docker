<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
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
        $auth = Auth::user();
        return view('post.create', ['auth' => $auth]);
    }

    public function store(Request $request)
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
}