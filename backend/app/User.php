<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use SoftDeletes;

    public function post()
    {
        return $this->hasMany('App\Post');
    }

    public function comment()
    {
        return $this->hasMany('App\Comment');
    }

    public function category()
    {
        return $this->hasMany('App\Category');
    }

    public function upload_image()
    {
        return $this->hasOne('App\UploadImage', 'id', 'img_id');
    }
    
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function getImagePath($authUser)
    {
        $image = $authUser->upload_image;

        if ( app()->isLocal() ) {
            // ローカル
            $path = $image->file_path;
        } else {
            // 本番
            $path = Storage::disk('s3')->url($uploads->file_path);
        }

        return $path;
    }

    public function storeImage($request)
    {
        $authUser = Auth::user();
        $image = UploadImage::find($authUser->img_id);
        
        if ( app()->isLocal() ) {
            // ローカル用
            $uploadImg = $request->file('file');
        } else {
            // 本番用　S3にファイルを保存
            $uploadImg = Storage::disk('s3')->putFile('/', $request->file('file'), 'public');

            // デフォルト画像以外なら、現在登録している画像をS3から削除する
            if ($image->id !== 1){
                Storage::disk('s3')->delete($image->file_path);
            }
        }

        if(empty($uploadImg)) {
            return redirect( route('setting') );
        }

        // store関数を使うと、ファイル名がランダムになる。ファイル名を指定したい場合はstoreAs()関数を利用
        $path = $uploadImg->store('uploads',"public");

        if(empty($path)) {
            return redirect( route('setting') );
        }
        
        // 画像の保存に成功したらDBに記録する
        $image = UploadImage::create([
            // getClientOriginalName()でアップロードした元のファイル名が取得できるので、それをfile_nameに代入。
            "file_name" => $uploadImg->getClientOriginalName(),
            "file_path" => $path
        ]);

        // userのimg_idに保存した画像のidを代入
        $authUser->img_id = $image->id;
        $authUser->save();
    }

    public function changeName($request)
    {
        if (empty($request)) {
            return;
        }

        $authUser = Auth::user();
        $authUser->name = $request->get('name');
        $authUser->save();

        return;
    }

    // ローカルスコープ。PostControllerのindexアクションのカテゴリで絞り込むために使う。
    public function scopeCategoryAt($query, $category_id)
    {
        if (empty($category_id)) {
            return;
        }

        return $query->where('category_id', $category_id);
    }

    public function scopeNameAt($query, $searchword)
    {
        if (empty($searchword)) {
            return;
        }
        return $query->where('username', 'like', "%{$searchword}%");
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'name', 'email', 'password','img_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}