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

    public function index()
    {
        $authUser    = Auth::user();
        $image = $authUser->upload_image;

        if ( app()->isLocal() ) {
            // ローカル
            $path = $image->file_path;
        } else {
            // 本番
            $path = Storage::disk('s3')->url($uploads->file_path);
        }

        return view('setting.index',[
            'auth' => $authUser,
            'path' => $path
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

        // guestログインした状態で、直接URLにsetting/emailを入れて飛んでもルートに戻す
        if(Auth::id() == 1) {
            return redirect('/');
        }

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
        $user->email_verified_at = null; // 新しいメールアドレスの認証を要求するため、email_verified_atをnullに変更する
        $user->fill($request->validated())->save();
        $user->sendEmailVerificationNotification(); // 認証用メールを送るメソッド
        
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
            'file' => 'required|file|image|mimes:png,jpeg'
        ]);

        $user = Auth::user();
        $image_data = UploadImage::find($user->img_id);
        
        if ( app()->isLocal() ) {
            // ローカル用
            $upload_img = $request->file('file');
        } else {
            // 本番用　S3にファイルを保存
            $upload_img = $request->file('file');
            $upload_img = Storage::disk('s3')->putFile('/', $upload_img, 'public');

            // デフォルト画像以外なら、現在登録している画像をS3から削除する
            if ($image_data->id !== 1){
                Storage::disk('s3')->delete($image_data->file_path);
            }
        }

        if(empty($upload_img)) {
            return redirect( route('setting') );
        }

        // store関数を使うと、ファイル名がランダムになる。ファイル名を指定したい場合はstoreAs()関数を利用
        $path = $upload_img->store('uploads',"public");

        // 画像の保存に成功したらDBに記録する
        if(empty($path)) {
            return redirect( route('setting') );
        }

        $image = UploadImage::create([
            // getClientOriginalName()でアップロードした元のファイル名が取得できるので、それをfile_nameに代入。
            "file_name" => $upload_img->getClientOriginalName(),
            "file_path" => $path
        ]);

        // userのimg_idに保存した画像のidを代入
        $user->img_id = $image->id;
        $user->save();

        return redirect( route('setting') );
    }
}