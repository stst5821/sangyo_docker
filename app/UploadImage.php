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
}