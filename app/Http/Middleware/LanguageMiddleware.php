<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LanguageMiddleware
{
    public function handle($request, Closure $next)
    {
        $selectedLanguage = $request->cookie('selected_language');

        if (!is_null($selectedLanguage)) {
            app()->setLocale($selectedLanguage);
        }

        return $next($request);
    }
}