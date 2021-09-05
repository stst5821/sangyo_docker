<nav class="navbar navbar-expand-md navbar-light shadow-sm themeColor">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/post') }}">
            <img src="{{ asset('/img/titleLogo1.png') }}" alt="" />
        </a>
        <button
            class="navbar-toggler"
            type="button"
            data-toggle="collapse"
            data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent"
            aria-expanded="false"
            aria-label="{{ __('Toggle navigation') }}"
        >
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
                <!-- 検索フォーム -->
                <form
                    class="form-inline"
                    method="GET"
                    action="{{ route('post.index') }}"
                >
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <!-- プルダウンでカテゴリを選択 -->
                            <select class="custom-select" name="category">
                                <option value="">全て</option>
                                @foreach($categories as $id => $name)

                                <!-- 検索後も、カテゴリ選択が保持される。 -->
                                <!-- $defaults['category']がnullでなく、defaults['category']と$nameが同じだったら、中身を実行。 -->
                                @if((!empty($defaults['category']) &&
                                $defaults['category'] == $name))
                                <!-- selectedをつけて、デフォルトで選択されている状態にすることで、選択したカテゴリを保持している。 -->
                                <option value="{{ $name }}" selected>{{
                                    $name
                                }}</option>
                                @else
                                <option value="{{ $name }}">{{ $name }}</option>
                                @endif @endforeach
                            </select>
                        </div>

                        <!-- テキストエリアで名前検索 -->
                        <input
                            type="text"
                            name="keyword"
                            value="{{ $defaults['keyword'] }}"
                        />

                        <!-- 検索ボタン -->
                        <div class="input-group-append">
                            <button type="submit" class="btn button_subColor btn-outline-dark">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
                <!-- 検索フォームここまで -->
            </ul>

            <!-- 新規投稿 -->
            <div class="my-1">
                <!-- ログインしているときだけ、新規投稿ボタンを表示させる。 -->
                @if(Auth::check())
                <a href="{{ route('post.create') }}" class="btn button_subColor">
                    新規投稿
                </a>
                @else
                <p>ログインすると新規投稿できます。</p>
                @endif
            </div>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{
                        __("Login")
                    }}</a>
                </li>
                @if (Route::has('register'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">{{
                        __("Register")
                    }}</a>
                </li>
                @endif @else

                <li class="nav-item dropdown">
                    <a
                        id="navbarDropdown"
                        class="nav-link dropdown-toggle"
                        href="#"
                        role="button"
                        data-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false"
                        v-pre
                    >
                        {{ Auth::user()->username }} <span class="caret"></span>
                    </a>

                    <div
                        class="dropdown-menu dropdown-menu-right"
                        aria-labelledby="navbarDropdown"
                    >
                        <a class="dropdown-item" href="{{ route('setting') }}">
                            {{ __("myPage") }}
                        </a>

                        <form
                            id="logout-form"
                            action="{{ route('logout') }}"
                            method="POST"
                            style="display: none;"
                        >
                            @csrf
                        </form>

                        <a
                            class="dropdown-item"
                            href="{{ route('password.form') }}"
                        >
                            {{ __("Change Password") }}
                        </a>

                        <a
                            class="dropdown-item"
                            href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();"
                        >
                            {{ __("Logout") }}
                        </a>
                    </div>
                </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
