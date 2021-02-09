<!-- ('layoutsディレクトリのapp.bladeを使うという意味') -->
@extends('layouts.app')

@section('title', 'LaravelPjt BBS 投稿の一覧ページ')
@section('keywords', 'キーワード1,キーワード2,キーワード3')
@section('description', '投稿一覧ページの説明文')
@section('pageCss')
<link href="/css/post/style.css" rel="stylesheet">
@endsection

@include('layouts.postheader')

@section('content')


<div class="table-responsive">

    <!-- 検索フォーム -->
    <div class="mt-4 mb-4">
        <form class="form-inline" method="GET" action="{{ route('post.index') }}">
            <div class="form-group">
                <input type="text" name="searchword" value="{{$searchword}}" class="form-control"
                    placeholder="名前を入力してください">
            </div>
            <input type="submit" value="検索" class="btn btn-info ml-2">
        </form>
    </div>

    <div class="mt-4 mb-4">
        <p>{{ $posts->total() }}件が見つかりました。</p>
    </div>

    <div class="mt-4 mb-4">
        @foreach($categories as $id => $name)
        <span class="btn">
            <a href="{{ route('post.index', ['category_id'=>$id]) }}" title="{{ $name }}">
                {{ $name }}
            </a>
        </span>
        @endforeach
    </div>

    <div class=" mt-4 mb-4">
        <!-- ログインしているときだけ、新規投稿ボタンを表示させる。 -->
        @if(Auth::check())
        <a href="{{ route('post.create') }}" class="btn btn-primary">
            投稿の新規作成
        </a>
        @else
        <p>ログインすると新規投稿できます。</p>
        @endif
    </div>

    <!-- 登録完了のメッセージ -->
    @if (session('poststatus'))
    <div class="alert alert-success mt-4 mb-4">
        {{ session('poststatus')}}
    </div>
    @endif

    <table class="table table-hover">

        <thead>
            <tr>
                <th>ID</th>
                <th>カテゴリ</th>
                <th>作成日時</th>
                <th>名前</th>
                <th>お題</th>
                <th>本文</th>
                <th>いいね</th>
                <th>処理</th>
            </tr>
        </thead>
        <tbody id="tbl">
            @foreach ($posts as $post)
            <tr>
                <td>{{ $post->id }}</td>
                <td>{{ $post->category->name }}</td>
                <td>{{ $post->created_at->format('Y.m.d') }}</td>
                <!-- Post.phpで作ったgetUserNameメソッドで、ユーザー名を取得する。 -->
                <td>{{ $post->user->username }}</td>
                <!-- 表示する文字数を15文字に制限する。 -->
                <td>{{ Str::limit($post->subject,15) }}</td>
                <td>・{{ $post->body1 }}<br>
                    ・{{ $post->body2 }}<br>
                    ・{{ $post->body3 }}</td>
                <td>{{ $post->likes_count }}</td>
                <td class="text-nowrap">
                    <!-- $post->idでURLパラメータを送っている。 -->
                    <p>
                        <a href="{{ action('PostsController@show', $post->id) }}" class="btn btn-primary btn-sm">
                            詳細
                        </a>
                    </p>
                    <!-- ログインしているときだけ、編集・削除ボタンを表示させる。 -->
                    @if(Auth::check())

                    <!-- ログインユーザーが投稿した記事のみ編集と削除ができる -->
                    @can('update', $post)
                    <!-- 編集はedit画面に飛ばす処理なので、hrefを使う。 -->
                    <p>
                        <a href="{{ action('PostsController@edit', $post->id) }}" class="btn btn-info btn-sm">
                            編集
                        </a>
                    </p>
                    <!-- 削除は、画面遷移なしでそのままdestroyアクションを実行するので、formメソッドを使う -->
                    <form method="POST" action=" {{ action('PostsController@destroy', $post->id) }}">
                        @csrf
                        @method('DELETE')
                        <!-- 削除クリック時に確認ダイアログ表示 -->
                        <button onclick="return confirm('投稿を削除しますか？')" class="btn btn-danger btn-sm">削除</a>
                    </form>
                    @endcan
                    @endif

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>



    <div class="d-flex justify-content-center mb-5">
        {{ $posts->appends([
        'category_id' => $category_id,
        'searchword' => $searchword,
        ])->links() }}
    </div>

</div>
@endsection

@include('layouts.postfooter')