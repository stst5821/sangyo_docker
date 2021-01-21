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

        <!-- 投稿情報 -->
        <div class="summary">
            <p><span>{{ $post->name }}</span> / <time>{{ $post->updated_at->format('Y.m.d H:i') }}</time> /
                カテゴリ：{{ $post->category->name }} / ID:{{ $post->id }}</p>
        </div>

        <!-- 本文 -->
        <p class="mb-5">
            {!! nl2br(e($post->message)) !!}
        </p>

        <section>
            <h2 class="h5 mb-4">
                コメント
            </h2>

            @forelse($post->comments as $comment)
            <div class="border-top p-4">
                <time class="text-secondary">
                    {{ $comment->name }} /
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
    </div>
</div>
@endsection

@include('layouts.postfooter')