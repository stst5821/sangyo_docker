<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// バリデーションの設定を読み込み↓
use App\Http\Requests\CommentRequest;
use App\Comment;
use Illuminate\Support\Facades\Auth;


class CommentsController extends Controller
{
    public function __construct()
    {
        // ログインしてなくても、投稿一覧と詳細は見られるようにする。
        $this->middleware('auth');

    }
    
    public function store(CommentRequest $request)
    {
        $auth = Auth::user();
        $savedata = [
            'post_id' => $request->post_id,
            'user_id' => $auth->id,
            'comment' => $request->comment,
        ];

        $comment = new Comment;
        $comment->fill($savedata)->save();

        // with('キー','値')で、フラッシュメッセージの内容を指定できる。
        return redirect()->route('post.show', [$savedata['post_id']])->with('commentstatus','コメントを投稿しました');
        
    }

    public function destroy($id)
    {
        $auth = Auth::user();
        $comment = Comment::findOrFail($id);

        $this->authorize('destroy',$comment);

        $comment->delete();

        // back()で、直前のページに戻る。
        return back()->with('commentstatus','コメントを削除しました');
    }
}