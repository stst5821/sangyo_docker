<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    // DBの中で、値を変更していいカラムを指定する。いわゆるホワイトリスト。ブラックリスト型は、$guarded
    protected $fillable = [
        'user_id',
        'subject',
        'body1',
        'body2',
        'body3',
        'category_id',
    ];

    public function user()
    {
        // 投稿は1つのユーザーに所属する
        return $this->belongsTo('App\User');
    }
    
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

    // ユーザーネームを拾ってくるメソッド
    public function getUserName()
    {
        return $this->user->username;
    }

    // PostControllerのindexアクションのカテゴリで絞り込むために使う。
    public function scopeCategoryAt($query, $category_id)
    {
        if (empty($category_id)) {
            return;
        }

        return $query->where('category_id', $category_id);
    }

    // 名前検索用のスコープ
    public function scopeFuzzyName($query, $searchword)
    {
        if(empty($searchword)) {
            return;
        }
        // ここにpostのuser_idからuserテーブルのnameをだしたい
        return $query->where('body1', 'like', "%{$searchword}%");
    }
}