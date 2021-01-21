<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'name',
        'subject',
        'message',
        'category_id',
    ];
    
    public function comments()
    {
        // 投稿は複数のコメントを持つので、hasMany
        return $this->hasMany('App\Comment');
    }

    public function category()
    {
        // 投稿は1つのカテゴリを持つので、belongsTo 投稿はカテゴリに所属する。
        return $this->belongsTo('App\Category');
    }
}