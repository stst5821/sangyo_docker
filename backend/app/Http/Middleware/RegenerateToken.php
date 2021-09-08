<?php

namespace App\Http\Middleware;

use Closure;

// 新規投稿時に、投稿ボタンを連打した場合エラー画面を表示させ、多重投稿を防ぐ。

class RegenerateToken
{
    public function handle($request, Closure $next)
    {
        // return $next~の前に書くことで、Before Middleware(ルーティングする前の処理)となる。
        if ($request->method() === 'POST') {
            $request->session()->regenerateToken();
        }

        return $next($request);
    }
}
