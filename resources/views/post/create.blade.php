@extends('layouts.app')

@section('title', 'LaravelPjt BBS 投稿ページ')
@section('keywords', 'キーワード1,キーワード2,キーワード3')
@section('description', '投稿ページの説明文')
@section('pageCss')
<link href="/css/post/style.css" rel="stylesheet">
@endsection

@include('layouts.postheader')

@section('content')
<div class="container mt-4">
    <div class="border p-4">
        <h1 class="h4 mb-4 font-weight-bold">
            投稿の新規作成
        </h1>

        <form method="POST" action="{{ route('post.store') }}">
            @csrf

            <fieldset class="mb-4">

                <div class="form-group">
                    <label for="subject">
                        カテゴリー
                    </label>
                    <input id="category_id" name="category_id"
                        class="form-control {{ $errors->has('category_id') ? 'is-invalid' : '' }}"
                        value="{{ old('category_id') }}" type="text">
                    @if ($errors->has('category_id'))
                    <div class="invalid-feedback">
                        {{ $errors->first('category_id') }}
                    </div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="subject">
                        お題
                    </label>
                    <input id="subject" name="subject"
                        class="form-control {{ $errors->has('subject') ? 'is-invalid' : '' }}"
                        value="{{ old('subject') }}" type="text">
                    @if ($errors->has('subject'))
                    <div class="invalid-feedback">
                        {{ $errors->first('subject') }}
                    </div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="message">
                        3行で説明！！！
                    </label>

                    <input id="body1" name="body1" class="form-control {{ $errors->has('body1') ? 'is-invalid' : '' }}"
                        rows="4" value="{{ old('body1') }}" type="text">

                    @if ($errors->has('body1'))
                    <div class="invalid-feedback">
                        {{ $errors->first('body1') }}
                    </div>
                    @endif

                    <input id="body2" name="body2" class="form-control {{ $errors->has('body2') ? 'is-invalid' : '' }}"
                        rows="4" value="{{ old('body2') }}" type="text">
                    @if ($errors->has('body2'))
                    <div class="invalid-feedback">
                        {{ $errors->first('body2') }}
                    </div>
                    @endif
                    <input id="body3" name="body3" class="form-control {{ $errors->has('body3') ? 'is-invalid' : '' }}"
                        rows="4" value="{{ old('body3') }}" type="text">
                    @if ($errors->has('body3'))
                    <div class="invalid-feedback">
                        {{ $errors->first('body3') }}
                    </div>
                    @endif
                </div>

                <div class="mt-5">
                    <a class="btn btn-secondary" href="{{ route('post.index') }}">
                        キャンセル
                    </a>

                    <button type="submit" class="btn btn-primary">
                        投稿する
                    </button>
                </div>
            </fieldset>
        </form>
    </div>
</div>
@endsection

@include('layouts.postfooter')