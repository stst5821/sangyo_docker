<?php

namespace App;

use App\Like;
use Auth;
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
        return $this->belongsTo('App\User')->withTrashed();
    }
    
    public function comment()
    {
        // 投稿は複数のコメントを持つので、hasMany
        return $this->hasMany('App\Comment');
    }

    public function category()
    {
        // 投稿は1つのカテゴリを持つので、belongsTo 投稿はカテゴリに所属する。
        return $this->belongsTo('App\Category');
    }

    // いいね機能

    public function likes()
    {
        return $this->hasMany('App\Like');
    }

    public function like_by()
    {
        return Like::where('user_id', Auth::user()->id)->first();
    }

    // いいね機能 ここまで

    // ユーザーネームを拾ってくるメソッド
    public function getUserName()
    {
        return $this->user->username;
    }

    // ユーザーネームを拾ってくるメソッド
    public function getCategoryName()
    {
        return $this->category->name;
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
}