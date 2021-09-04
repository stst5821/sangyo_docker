@extends('layouts.app') @section('title', 'LaravelPjt BBS 投稿の詳細ページ')
@section('keywords', 'キーワード1,キーワード2,キーワード3')
@section('description', '投稿詳細ページの説明文') @section('pageCss')
<link href="/css/post/style.css" rel="stylesheet" />
@endsection @section('content')
<div class="container mt-4">
    <!-- 戻るボタン -->
    <div class="mt-4 mb-4">
        <a href="{{ route('post.index') }}" class="btn btn-info">一覧に戻る</a>
    </div>

    <div class="mb-4 text-right">
        @can('update', $post)

        <!-- 編集ボタン いいね機能があるためomitした。有効にする場合は、削除ボタンを参考に大かっこをつけるのを忘れないようにする。 -->
        <!-- <a href=" action('PostsController@edit', $post->id) " class="btn btn-info">
            編集する
        </a> -->

        <!-- 削除ボタン -->
        <form
            style="display: inline-block;"
            method="POST"
            action="{{ action('PostsController@destroy', $post->id) }}"
        >
            @csrf @method('DELETE')
            <button
                onclick="return confirm('投稿を削除しますか？')"
                class="btn btn-danger"
            >
                削除する
            </button>
        </form>
        @endcan
    </div>

    <!-- コメント投稿のフラッシュメッセージ -->
    @if (session('commentstatus'))
    <div class="alert alert-success mt-4 mb-4">
        {{ session("commentstatus") }}
    </div>
    @endif

    <div class="border p-4">
        <!-- 件名 -->
        <h1 class="h4 mb-4">
            {{ $post->subject }}
        </h1>

        <!-- 本文 -->
        <p class="mb-5">
            ・{!! nl2br(e($post->body1)) !!}<br />
            ・{!! nl2br(e($post->body2)) !!}<br />
            ・{!! nl2br(e($post->body3)) !!}
        </p>

        <!-- 投稿情報 -->
        
        <div class="summary">
            <p>
                <span>{{ $post->getUserName() }}</span> /
                <time>{{ $post->updated_at->format('Y.m.d H:i') }}</time> /
                カテゴリ：{{ $post->category->name }} / ID:{{ $post->id }}
            </p>
        </div>

        <!-- いいね機能 -->

        <!-- :initial-is-liked-byは、v-bindの省略形 -->
        <!-- jsonを使うことで、結果を値ではなく文字列としてvueコンポーネントに渡している。 -->

        <article-like
        :initial-is-liked-by='@json($post->isLikedBy(Auth::user()))'
        :initial-count-likes='@json($post->count_likes)'
        :authorized='@json(Auth::check())'
        endpoint="{{ route('posts.like',['post' => $post]) }}">
        </article-like>

        @guest
        <p class="text-danger">いいねするには<a href="{{ route('login')}}">ログイン</a>してください。</p>
        @endguest
        <br />

        <!-- コメント -->

        <section>
            <h2 class="h5 mb-4">
                コメント
            </h2>

            @forelse($post->comment as $comment)
            <div class="border-top p-4">
                <time class="text-secondary">
                    {{ $comment->user->username }} /
                    {{ $comment->created_at->format('Y.m.d H:i') }} / ID:{{ $comment->id }}
                </time>
                <p class="mt-2">
                    {!! nl2br(e($comment->comment)) !!}
                </p>

                @can('destroy', $comment)
                <!-- 削除ボタン -->
                <form
                    style="display: inline-block;"
                    method="POST"
                    action="{{ action('CommentsController@destroy', $comment->id) }}"
                >
                    @csrf @method('DELETE')
                    <button
                        onclick="return confirm('コメントを削除しますか？')"
                        class="btn btn-danger"
                    >
                        削除する
                    </button>
                </form>
                @endcan
            </div>
            @empty
            <p>コメントはまだありません。</p>
            @endforelse
        </section>

        @auth
        <form class="mb-4" method="POST" action="{{ route('comment.store') }}">
            @csrf
            <input name="post_id" type="hidden" value="{{ $post->id }}" />
            <div class="form-group">
                <label for="body">
                    コメント内容
                </label>
                <textarea
                    id="comment"
                    name="comment"
                    class="form-control {{ $errors->has('comment') ? 'is-invalid' : '' }}"
                    rows="4"
                    >{{ old("comment") }}
                </textarea>
                @if ($errors->has('comment'))
                <div class="invalid-feedback">
                    {{ $errors->first('comment') }}
                </div>
                @endif
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    コメントする
                </button>
            </div>
        </form>
        @endauth

        @guest
        <p class="text-danger">コメントをするには<a href="{{ route('login')}}">ログイン</a>してください。</p>
        @endguest

    </div>
</div>
@endsection
