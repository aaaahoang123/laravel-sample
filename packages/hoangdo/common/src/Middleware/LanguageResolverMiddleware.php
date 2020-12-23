<?php

namespace HoangDo\Common\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LanguageResolverMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $locale = $request->header('locale') ?? config('app.locale');
        if ($locale) {
            App::setLocale($locale);
        }
        return $next($request);
    }
}
