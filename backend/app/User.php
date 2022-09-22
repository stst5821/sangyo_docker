<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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