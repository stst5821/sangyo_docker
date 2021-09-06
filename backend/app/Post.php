<?php

namespace App;

use App\Like;
use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends Model
{
    // DBの中で、値を変更していいカラムを指定する。いわゆるホワイトリスト。ブラックリスト型は、$guarded
    protected $fillable = [
        'user_id',
        'subject',
        'body1',
        'body2',
        'body3',
        'is_deleted',
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

    public function escape(string $value)
    {
        return str_replace(
            ['\\', '%', '_'],
            ['\\\\', '\\%', '\\_'],
            $value
        );
    }

    // いいね機能

    public function likes()
    {
        // return $this->hasMany('App\Like');
        // belongsToManyの第一引数には、関係するモデル名。第二引数には中間テーブルのテーブル名を渡す。
        // likesテーブルには、created_at、updated_atカラムが存在するため、withTimestamps()メソッドをつけている。
        return $this->belongsToMany('App\User', 'likes')->withTimestamps();
    }

    // 引数の前に?をつけると、その引数がnullでも許容される。
    public function isLikedBy(?User $user):bool
    {
        // 記事をいいねしたユーザーの中に、引数として渡されたユーザーがいるかどうか調べる。
        // (bool)は、型キャストというPHPの機能。boolと書くことで変数をtrueかfalseに変換する。
        // この場合、$userがいればtrueが返り、いなければfalseが返る。
        return $user
            ?(bool)$this->likes->where('id',$user->id)->count()
            :false;
    }

    // アクセサ。このメソッドを使うときは、$post->count_likesという書き方をする。
    public function getCountLikesAttribute():int
    {
        return $this->likes->count();
    }

    // public function like_by()
    // {
    //     return Like::where('user_id', Auth::user()->id)->first();
    // }

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