<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use App\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;
    protected $redirectTo = RouteServiceProvider::HOME;

    // あらかじめDBに登録してあるゲスト用レコードのidを定数に指定する。
    private const GUEST_USER_ID = 1;

    // ログイン後のリダイレクト先を指定できる。
    public function redirectPath()
    {
        return ( route('setting') );
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'username';
    }

    // ゲストログイン処理

    public function guestLogin()
    {
        if(Auth::loginUsingId(self::GUEST_USER_ID)) {
            return redirect('/setting');
        }
        // guestログインが失敗した場合は、topに戻す
        return redirect('/');
    }
}