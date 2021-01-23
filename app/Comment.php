<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function post()
    {
        // コメントは1つの投稿に所属する
        return $this->belongsTo('App\Post');
    }

    public function user()
    {
        // コメントは1つのユーザーに所属する
        return $this->belongsTo('App\User');
    }

    public function getUserName()
    {
        return $this->user->name;
    }

    protected $fillable = [
        'user_id',
        'post_id',
        'comment',
    ];
}