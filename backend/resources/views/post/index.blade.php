<x-app>
<div class="table-responsive">
    <!-- 登録完了のメッセージ -->
    @if (session('poststatus'))
    <div class="alert alert-success mt-4 mb-4">
        {{ session("poststatus") }}
    </div>
    @endif
    <div class="container-fluid">
        <div class="row">
            @foreach ($posts as $post)
            <div class="col-3 my-1">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">
                            <a
                                href="{{ action('PostsController@show', $post->id) }}"
                                class="card__link"
                            >
                                {{ Str::limit($post->subject,15) }}
                            </a>
                        </h5>
                        <h6 class="card-subtitle mb-2 text-muted">
                            カテゴリ：{{ $post->category->name }}
                        </h6>
                        <p class="card-text">
                            ・{{ $post->body1 }}<br />
                            ・{{ $post->body2 }}<br />
                            ・{{ $post->body3 }}
                        </p>
                        <p>
                            <i class="fas fa-heart pink-heart"></i>
                            {{ $post->likes_count }}
                            <br />
                            <!-- count()は、最初から用意されているクエリビルダ。これを使うとEloquentのコレクションからもデータを取り出せる？ -->
                            コメント：{{ $post->comment->count() }}
                        </p>
                        by:<a
                            href="#"
                            class="card-link"
                            >{{ $post->user->username }}</a
                        >
                    </div>
                    <!-- card-body -->
                </div>
                <!-- card -->
            </div>
            <!-- col -->
            @endforeach
        </div>
        <!-- row -->
    </div>
    <!-- container -->
    <div class="d-flex justify-content-center mb-5">
        <!-- withQueryString()で、現在のクエリ文字列値をすべてペジネーションリンクへ追加する。自分でクエリ文字列を指定したい場合は、appendsを使う。 -->
        {{ $posts->withQueryString()->links() }}
    </div>
</div>
</x-app>
