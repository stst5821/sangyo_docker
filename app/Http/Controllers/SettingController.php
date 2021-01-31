<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ChangeNameRequest;
use App\Http\Requests\ChangeUserNameRequest;
use App\Http\Requests\ChangeEmailRequest;
use App\User;
use App\UploadImage;

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
        $user = User::find(Auth::user()->id); // 現在ログインしているユーザーのIDを使って、userテーブルからレコードを持ってくる。
        $uploads = UploadImage::find($user->img_id); // $userのimage_idカラムのデータを使って、uploadimageからレコードを持ってくる。
        
        return view('setting.index',
            ['auth' => $auth,
            'uploads' => $uploads
            ]);
    }

    // 名前変更

    public function showChangeNameForm()
    {
        $auth = Auth::user();
        return view('setting.name',['auth' => $auth]);
    }

    public function showChangeImageForm()
    {
		//アップロードした画像を取得
		$uploads = UploadImage::orderBy("id", "desc")->get();

		return view("image_list",[
			"images" => $uploads
		]);
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

    // アイコン画像

    function imageshow() 
    {
        return view("upload_form");
    }

    function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|file|image|mimes:png,jpeg'
        ]);

        $upload_img = $request->file('image');

        if($upload_img) {
            // アップロードされた画像をstore関数を使って保存する
            // store関数を使うと、ファイル名がランダムになる。ファイル名を指定したい場合はstoreAs()関数を利用
            $path = $upload_img->store('uploads',"public");
            // 画像の保存に成功したらDBに記録する
            if($path){
                // DBに記録する。
                UploadImage::create([
                    // getClientOriginalName()でアップロードした元のファイル名が取得できるので、それをfile_nameに代入。
                    "file_name" => $upload_img->getClientOriginalName(),
                    "file_path" => $path
                ]);
            }
        }

        // 上記で保存した最新の画像を取得するため、created_atの降順で並べて、一番最初のコードだけ取ってくる。
        $image = UploadImage::orderBy('created_at', 'desc')->first();
        $user = $auth = Auth::user();
        $user->img_id = $image->id;

        $user->save();

        return redirect( route('setting') );
    }
}