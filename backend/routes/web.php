<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

//get関数 第一引数でURLを指定、第二引数には関連付ける処理をする。
// ここでは無名関数(クロージャ)が指定されている。クロージャ内にはviewヘルパ関数で[welcome]の名前のviewを呼び出す処理を記述している。
Route::get('/', 'PostsController@index');

// ゲストログイン
Route::get('guest', 'Auth\LoginController@guestLogin')->name('login.guest');

// ['verify' => true]をつけて、メール認証を有効にする。
// Auth\VerificationControllerにロジックがある。
Auth::routes(['verify' => true]);

// indexは省略してアクセスできるようにするのが一般的なので、/home/indexとはせず、/homeだけにしている。
Route::get('/home', 'HomeController@index')->name('home');

// マイページ
Route::get('/setting', 'SettingController@index')->name('setting');

// パスワード変更
Route::get('/setting/change', 'Auth\ChangePasswordController@showChangePasswordForm')->name('password.form');
Route::post('/setting/change', 'Auth\ChangePasswordController@ChangePassword')->name('password.change');

// ユーザー削除
Route::get('/setting/deactive', 'Auth\DeactiveController@showDeactiveForm')->name('deactive.form');
Route::post('/setting/deactive', 'Auth\DeactiveController@deactive')->name('deactive');

// 氏名変更
Route::get('/setting/name','SettingController@showChangeNameForm')->name('name.form');
Route::post('/setting/name','SettingController@changeName')->name('name.change');

// ユーザーネーム変更
Route::get('/setting/username','SettingController@showChangeUserNameForm')->name('username.form');
Route::post('/setting/username','SettingController@changeUserName')->name('username.change');

// メールアドレス変更
Route::get('/setting/email','SettingController@showChangeMailForm')->name('email.form');
Route::post('/setting/email','SettingController@changeEmail')->name('email.change');

// 画像アップロード
Route::get('/setting/uploadImg','SettingController@imageShow')->name('uploadImg');
Route::post('/upload','SettingController@upload')->name('upload');

// 画像一覧
Route::get('/list','ImageListController@show')->name('image_list');

// 投稿(edit,updateはいいね機能があるため、omit)

Route::resource('post', 'PostsController', ['only' => ['index', 'show','create','store','destroy']]);

// コメント

Route::resource('comment', 'CommentsController',['only' => ['store','destroy']]);

// いいね

// Route::post('/posts/{post}/likes','LikesController@store')->name('likes.store');
// Route::post('/posts/{post}/likes/{like}','LikesController@destroy')->name('likes.destroy');

Route::prefix('posts')->name('posts.')->group(function () {
  Route::put('/{post}/likes', 'PostsController@like')->name('like')->middleware('auth');
  Route::delete('/{post}/likes', 'PostsController@unlike')->name('unlike')->middleware('auth');
});