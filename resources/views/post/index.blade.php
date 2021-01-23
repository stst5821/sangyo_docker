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
    <div class="mt-4 mb-4">
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
                <td>{{ $post->getUserName() }}</td>
                <td>{{ $post->subject }}</td>
                <td>・{{ $post->body1 }}<br>
                    ・{{ $post->body2 }}<br>
                    ・{{ $post->body3 }}</td>
                <td class="text-nowrap">
                    <!-- $post->idでURLパラメータを送っている。 -->
                    <p><a href="{{ action('PostsController@show', $post->id) }}" class="btn btn-primary btn-sm">詳細</a>
                    </p>
                    <p><a href="{{ action('PostsController@edit', $post->id) }}" class="btn btn-info btn-sm">編集</a></p>
                    <p><a href="" class="btn btn-danger btn-sm">削除</a></p>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center mb-5">
        {{ $posts->links() }}
    </div>

</div>
@endsection

@include('layouts.postfooter')