<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Category;
use Illuminate\Support\Facades\Request;

class Header extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
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
