<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- .envに設定したAPP_NAMEを表示させる -->
    <title>{{ config('app.name') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/layout.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/post/style.css') }}" />

</head>

<body>
    <!-- ヘッダーコンポーネント -->
    <x-header />
    <!-- コンテンツの中身を表示 -->
    <main class="py-4">
        {{$slot}}
    </main>
    <x-footer />
    
    <!-- トランスパイルしたJSをBladeに読み込ませる -->
    <script src="{{ mix('/js/app.js') }}"></script>
    <!-- navのプルダウンを有効にするため、以下のjqueryとbootstrapのCDNを読み込んでいる -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
</body>

</html>