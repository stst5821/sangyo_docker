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
        User::find(Auth::id())->delete();
        return redirect('/');
    }
}