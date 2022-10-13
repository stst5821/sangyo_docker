<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ChangeNameRequest;
use App\Http\Requests\ChangeUserNameRequest;
use App\Http\Requests\ChangeEmailRequest;
use App\User;
use App\UploadImage;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // メール認証後にのみアクセスできるようにする。exceptで指定のアクションだけ除外できる。
        // web.phpのRouteに->middleware('verified');を追加することもできるが、今回はcontrollerのconstructに書く。
        $this->middleware('verified')->except('index');
    }

    public function index(User $user)
    {
        $authUser    = Auth::user();
        $imagePath = $user->getImagePath($authUser);

        return view('setting.index',[
            'auth' => $authUser,
            'path' => $imagePath
        ]);
    }

    // 名前変更

    public function showChangeNameForm()
    {
        $authUser = Auth::user();
        return view('setting.name',['auth' => $authUser]);
    }

    public function showChangeImageForm()
    {
		//アップロードした画像を取得
		$uploads = UploadImage::orderBy("id", "desc")->get();

		return view("image_list",[
			"images" => $uploads
		]);
    }
    
    public function changeName(ChangeNameRequest $request, User $user)
    {
        $user->changeName($request);
        
        return redirect()->route('setting')->with('status', __('Your name has been changed.'));
    }

    // ユーザー変更

    public function showChangeUserNameForm()
    {
        $authUser = Auth::user();
        
        return view('setting.username',['auth' => $authUser]);
    }
    
    public function changeUserName(ChangeUserNameRequest $request, User $user)
    {
        $user->changeUserName($request);
        return redirect()->route('setting')->with('status', __('Your name has been changed.'));
    }

    public function showChangeMailForm()
    {
        $authUser = Auth::user();

        // guestログインした状態で、直接URLにsetting/emailを入れて飛んでもルートに戻す
        if(Auth::id() == 1) {
            return redirect('/');
        }

        return view('setting.email',['auth' => $authUser]);        
    }

    public function changeEmail(ChangeEmailRequest $request)
    {
        $authUser = Auth::user();

        // 入力されたメルアドが現在のメルアドと同じだったら、変更処理せずsetting.indexにリダイレクトさせる。
        if($authUser->email == $request->get('email'))
        {
            return redirect()->route('setting')->with('status', __('Your email has been changed.'));
        }

        $authUser->email = $request->get('email');
        $authUser->email_verified_at = null; // 新しいメールアドレスの認証を要求するため、email_verified_atをnullに変更する
        $authUser->fill($request->validated())->save();
        $authUser->sendEmailVerificationNotification(); // 認証用メールを送るメソッド
        
        return redirect()->route('setting')->with('status', __('Your email has been changed.'));
    }

    // アイコン画像

    function imageShow() 
    {
        return view("upload_form");
    }

    function upload(Request $request, User $user)
    {
        // TODO:validationはファイルを分ける
        $request->validate([
            'file' => 'required|file|image|mimes:png,jpeg'
        ]);

        $user->storeImage($request);

        return redirect( route('setting') );
    }
}