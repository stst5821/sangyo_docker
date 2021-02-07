## 文字数カウント機能

・フレームワーク  
vue.js

・機能  
最大15文字でフォームに入力された値をリアルタイムでカウントする

・問題点  
バリデーションに引っかかった場合、再度同じページリダイレクトされるが、その際、入力していた値がリセットされてしまう。  

・原因  
Laravelのold関数が、vueの以下の記述のせいで毎回空白で上書きされてしまう。
```
data: {
    myText: ''
    },
```

・解決方法
見つからず。
vueでなく、javascriptで実装した場合、old関数が使えるようになった。
しかし、同じページにリダイレクトさせるとoldで保持した値をカウントしてくれない。
ボタンを押した回数を数えるメソッドなので、oldの値を数えないのは当たり前なのだが。


ひとまず、vueのカウント機能はオミットし、HTMLで文字数制限をする。
<input maxlength='15'>


<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
