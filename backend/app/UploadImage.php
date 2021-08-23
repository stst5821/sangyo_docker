<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UploadImage extends Model
{
    protected $table = "upload_image";
    protected $fillable = [
        "file_name",
        "file_path"
    ];

    public function user()
    {
        // 投稿は1つのユーザーに所属する
        return $this->belongsTo('App\User')->withTrashed();
    }
}