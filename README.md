## post.index

・機能  
  
【実装済】  
投稿データを表示(ペジーネーション付)  
各レコードの詳細、編集、削除リンク  
新規投稿リンク  
投稿者名(username)でキーワード検索  
カテゴリで絞り込み  
タイトルが長い場合、抜粋表示する  

【未実装】  
いいね数  
タイトルが長い場合、抜粋表示する  
本文(body1,2,3)でもキーワード検索  

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

・解決方法1  
vueでなく、javascriptで実装した場合、old関数が使えるようになった。
しかし、同じページにリダイレクトさせるとoldで保持した値をカウントしてくれない。
ボタンを押した回数を数えるメソッドなので、oldの値を数えないのは当たり前なのだが。

・解決方法2(実装済)  
バリデーションに引っかかったあと、リダイレクトすることで問題が起きるのなら
未入力があったら、リダイレクトさせなければよい。  

送信ボタンを押せないようにするため、  
カテゴリ、タイトル、本文のinputフォームにrequiredを設定すればいい。

また、本文1,2,3にformで15文字制限を追加。  
```
<input maxlength='15'>
```

<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
