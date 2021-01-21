<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
// PostRequestの使用宣言
use App\Http\Requests\PostRequest;

class PostsController extends Controller
{
    public function __construct()
    {
        // ログインしてなくても、投稿一覧と詳細は見られるようにする。
        $this->middleware('auth')->except('index','show');
    }

    public function index()
    {
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
        return view('post.create');
    }

    public function store(PostRequest $request)
    {
        // 複数の入力データを配列にまとめる。
        $savedata = [
            'name' => $request->name,
            'subject' => $request->subject,
            'message' => $request->message,
            'category_id' => $request->category_id,
        ];
        
        $post = new Post;
        // まとめたデータをfillでsaveする。
        $post->fill($savedata)->save();

        return redirect('/post')->with('poststatus','新規投稿しました');
    }
}