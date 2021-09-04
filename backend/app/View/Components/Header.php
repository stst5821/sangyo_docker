<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Category;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use App\UploadImage;

class Header extends Component
{
    public function __construct()
    {
        //
    }

    public function render()
    {
        // viewで表示するカテゴリ名を取得する。
        $category = new Category; // インスタンス作成
        $categories = $category->getLists(); // Category.phpのgetLists()メソッドでカテゴリテーブルからidとnameだけ取得し、$categoriesに代入。

        // カテゴリを選択、検索ワードを入力して検索ボタンを押したあと、値がcategoryとkeywordにそれぞれ入る。
        $defaults = [
            'category' => Request::input('category', ''),
            'keyword'  => Request::input('keyword', ''),
        ];
        
        return view('components.header')
            ->with('defaults', $defaults)
            ->with('categories', $categories);
    }
}
