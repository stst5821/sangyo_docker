const mix = require("laravel-mix");

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.sourceMaps()
    // resources/js/app.jsがトランスパイルされて、public/js/app.jsというファイル名で保存される。
    // https://readouble.com/laravel/7.x/ja/mix.html?header=%25E3%2582%25B9%25E3%2582%25BF%25E3%2582%25A4%25E3%2583%25AB%25E3%2582%25B7%25E3%2583%25BC%25E3%2583%2588%25E3%2581%25AE%25E6%2593%258D%25E4%25BD%259C
    .js(
        "resources/js/app.js",
        "public/js",
        "node_modules/popper.js/dist/popper.js"
    )
    .sourceMaps()
    .sass("resources/sass/app.scss", "public/css")
    .sass("resources/sass/layout.scss", "public/css")
    .version(); // JSのトランスパイルの都度、idを採番する。ブラウザのキャッシュに以前読み込んだJSが残っていると古いJSを使ってしまうが、都度IDを採番することによりそれを防いでいる。
