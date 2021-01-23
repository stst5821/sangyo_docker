@extends('layouts.app')

@section('title', 'LaravelPjt BBS 投稿の詳細ページ')
@section('keywords', 'キーワード1,キーワード2,キーワード3')
@section('description', '投稿詳細ページの説明文')
@section('pageCss')
<link href="/css/post/style.css" rel="stylesheet">
@endsection

@include('layouts.postheader')

@section('content')
<div class="container mt-4">

    <!-- 戻るボタン -->
    <div class="mt-4 mb-4">
        <a href="{{route('post.index')}}" class="btn btn-info">一覧に戻る</a>
    </div>

    <div class="border p-4">

        <!-- 件名 -->
        <h1 class="h4 mb-4">
            {{ $post->subject }}
        </h1>

        <!-- 本文 -->
        <p class="mb-5">
            ・{!! nl2br(e($post->body1)) !!}<br>
            ・{!! nl2br(e($post->body2)) !!}<br>
            ・{!! nl2br(e($post->body3)) !!}
        </p>

        <!-- 投稿情報 -->
        <div class="summary">
            <p><span>{{ $post->getUserName() }}</span> / <time>{{ $post->updated_at->format('Y.m.d H:i') }}</time> /
                カテゴリ：{{ $post->category->name }} / ID:{{ $post->id }}</p>
        </div>

        <section>
            <h2 class="h5 mb-4">
                コメント
            </h2>

            @forelse($post->comments as $comment)
            <div class="border-top p-4">
                <time class="text-secondary">
                    {{ $post->getUserName() }} /
                    {{ $comment->created_at->format('Y.m.d H:i') }} /
                    ID:{{ $comment->id }}
                </time>
                <p class="mt-2">
                    {!! nl2br(e($comment->comment)) !!}
                </p>
            </div>
            @empty
            <p>コメントはまだありません。</p>
            @endforelse
        </section>

        @if(Auth::check())
        <form class="mb-4" method="POST" action="{{ route('comment.store') }}">
            @csrf

            <input name="post_id" type="hidden" value="{{ $post->id }}">

            <div class="form-group">
                <label for="body">
                    本文
                </label>

                <textarea id="comment" name="comment"
                    class="form-control {{ $errors->has('comment') ? 'is-invalid' : '' }}"
                    rows="4">{{ old('comment') }}</textarea>
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

        @if (session('commentstatus'))
        <div class="alert alert-success mt-4 mb-4">
            {{ session('commentstatus') }}
        </div>
        @endif

        @else
        <p>ログインするとコメントができます。</p>
        @endif
    </div>
</div>
@endsection

@include('layouts.postfooter')