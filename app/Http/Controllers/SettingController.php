<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ChangeNameRequest;
use App\Http\Requests\ChangeUserNameRequest;
use App\Http\Requests\ChangeEmailRequest;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // メール認証後にのみアクセスできるようにする。exceptで指定のアクションだけ除外できる。
        // web.phpのRouteに->middleware('verified');を追加することもできるが、今回はcontrollerのconstructに書く。
        $this->middleware('verified')->except('index');
    }

    public function index()
    {
        $auth = Auth::user();
        return view('setting/index',['auth' => $auth]);
    }

    // 名前変更

    public function showChangeNameForm()
    {
        $auth = Auth::user();
        return view('setting.name',['auth' => $auth]);
    }
    
    public function ChangeName(ChangeNameRequest $request)
    {
        $user = Auth::user();
        $user->name = $request->get('name');
        $user->save();
        return redirect()->route('setting')->with('status', __('Your name has been changed.'));
    }

    // ユーザー変更

    public function showChangeUserNameForm()
    {
        $auth = Auth::user();
        return view('setting.username',['auth' => $auth]);
    }
    
    public function ChangeUserName(ChangeUserNameRequest $request)
    {
        $user = Auth::user();
        $user->username = $request->get('username');
        $user->save();
        return redirect()->route('setting')->with('status', __('Your name has been changed.'));
    }

    public function showChangeMailForm()
    {
        $auth = Auth::user();
        return view('setting.email',['auth' => $auth]);        
    }

    public function ChangeEmail(ChangeEmailRequest $request)
    {
        $user = Auth::user();

        // 入力されたメルアドが現在のメルアドと同じだったら、変更処理せずsetting.indexにリダイレクトさせる。
        if($user->email == $request->get('email'))
        {
            return redirect()->route('setting')->with('status', __('Your email has been changed.'));
        }

        $user->email = $request->get('email');
        $user->email_verified_at = null;
        $user->save();
        $user->sendEmailVerificationNotification();
        
        return redirect()->route('setting')->with('status', __('Your email has been changed.'));
    }
}