<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UploadImage;


class UploadImageController extends Controller
{
    function show() 
    {
        return view("upload_form");
    }

    function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|file|image|mimes:png,jpeg'
        ]);

        $upload_img = $request->file('image');

        if($upload_img) {
            // アップロードされた画像をstore関数を使って保存する
            // store関数を使うと、ファイル名がランダムになる。ファイル名を指定したい場合はstoreAs()関数を利用
            $path = $upload_img->store('uploads',"public");
            // 画像の保存に成功したらDBに記録する
            if($path){
                // DBに記録する。
                UploadImage::create([
                    // getClientOriginalName()でアップロードした元のファイル名が取得できるので、それをfile_nameに代入。
                    "file_name" => $upload_img->getClientOriginalName(),
                    "file_path" => $path
                ]);
            }
        }
        return redirect("/show");
    }
}