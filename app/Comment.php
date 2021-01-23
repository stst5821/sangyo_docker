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

    protected $fillable = [
        'post_id',
        'comment',
    ];
}