<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- .envに設定したAPP_NAMEを表示させる -->
    <title>{{ config('app.name') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/post/style.css') }}" />

</head>

<body>
    <div id="app">
        <!-- ヘッダーコンポーネント -->
        <x-header />

        <!-- コンテンツの中身を表示 -->
        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <!-- navのプルダウンを有効にするため、以下のjqueryとbootstrapのCDNを読み込んでいる -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <!-- vue.jsのCDN -->
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.js" defer></script>
    <script src="{{ mix('/js/app.js') }}" defer></script>
</body>

</html>