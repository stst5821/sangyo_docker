<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function posts()
    {
        // カテゴリは複数の投稿を持つ
        return $this->hasMany('App\Post');
    }

    public function getLists()
    {
        // pluck()メソッドで特定のキーのみ取得できる。
        $categories = Category::orderBy('id','asc')->pluck('name', 'id');
        return $categories;
    }
}