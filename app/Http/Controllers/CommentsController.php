<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// バリデーションの設定を読み込み↓
use App\Http\Requests\CommentRequest;
use App\Comment;

class CommentsController extends Controller
{
    public function __construct()
    {
        // ログインしてなくても、投稿一覧と詳細は見られるようにする。
        $this->middleware('auth');
    }
    
    public function store(CommentRequest $request)
    {
        $savedata = [
            'post_id' => $request->post_id,
            'comment' => $request->comment,
        ];

        $comment = new Comment;
        $comment->fill($savedata)->save();

        return redirect()->route('post.show', [$savedata['post_id']])->with('commentstatus','新規投稿しました');
        
    }
}