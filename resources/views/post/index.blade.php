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


    <div class="container-fluid">
        <div class="row">
            @foreach ($posts as $post)
            <div class="col-3 my-1">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="{{ action('PostsController@show', $post->id) }}" class="card__link">
                                {{ Str::limit($post->subject,15) }}
                            </a>
                        </h5>
                        <h6 class="card-subtitle mb-2 text-muted">
                            カテゴリ：{{ $post->category->name }}
                        </h6>
                        <p class="card-text">
                            ・{{ $post->body1 }}<br>
                            ・{{ $post->body2 }}<br>
                            ・{{ $post->body3 }}
                        </p>
                        <p>
                            <i class="fas fa-heart pink-heart"></i>
                            {{ $post->likes_count }}
                            <br>
                            <!-- count()は、最初から用意されているクエリビルダ。これを使うとEloquentのコレクションからもデータを取り出せる？ -->
                            コメント：{{ $post->comment->count() }}
                        </p>

                        by:<a href="#" class="card-link">{{ $post->user->username }}</a>
                    </div><!-- card-body -->
                </div><!-- card -->
            </div><!-- col -->
            @endforeach
        </div><!-- row -->
    </div><!-- container -->




    <div class="d-flex justify-content-center mb-5">
        {{ $posts->appends([
        'category_id' => $category_id,
        'searchword' => $searchword,
        ])->links() }}
    </div>

</div>
@endsection

@include('layouts.postfooter')