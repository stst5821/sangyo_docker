<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//get関数 第一引数でURLを指定、第二引数には関連付ける処理をする。
// ここでは無名関数(クロージャ)が指定されている。クロージャ内にはviewヘルパ関数で[welcome]の名前のviewを呼び出す処理を記述している。
Route::get('/', function () {
    return view('welcome');
});

// ['verify' => true]をつけて、メール認証を有効にする。
Auth::routes(['verify' => true]);

// indexは省略してアクセスできるようにするのが一般的なので、/home/indexとはせず、/homeだけにしている。
Route::get('/home', 'HomeController@index')->name('home');

// パスワード変更
Route::get('/setting/change', 'Auth\ChangePasswordController@showChangePasswordForm')->name('password.form');
Route::post('/setting/change', 'Auth\ChangePasswordController@ChangePassword')->name('password.change');

// ユーザー削除
Route::get('/setting/deactive', 'Auth\DeactiveController@showDeactiveForm')->name('deactive.form');
Route::post('/setting/deactive', 'Auth\DeactiveController@deactive')->name('deactive');

Route::get('/setting', 'SettingController@index')->name('setting');

Route::get('/setting/name','SettingController@showChangeNameForm')->name('name.form');
Route::post('/setting/name','SettingController@ChangeName')->name('name.change');

// 投稿一覧

// Route::get('post', 'PostsController@index');
// Route::get('show', 'PostsController@show')->name('post.show');

Route::resource('post', 'PostsController', ['only' => ['index', 'show','create','store']]);