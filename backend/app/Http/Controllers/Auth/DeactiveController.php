<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// AuthとUserモデルの使用宣言を追加。
use Illuminate\Support\Facades\Auth;
use App\User;

class DeactiveController extends Controller
{
    public function showDeactiveForm()
    {
        return view('auth/deactive');
    }
    
    public function Deactive()
    {
        // ↓ソフトデリート
        // User::find(Auth::id())->delete();
        
        // ↓ハードデリート ユーザーに紐づく投稿とコメントも同時に削除する。
        $user = User::find(Auth::id());
        $user->comment()->delete();
        $user->post()->delete();
        $user->forceDelete();
        return redirect('/');
    }
}