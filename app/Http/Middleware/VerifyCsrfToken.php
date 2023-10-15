<?php

namespace App\Http\Middleware;
use Closure;

use Illuminate\Session\TokenMismatchException;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    public function handle($request, Closure $next)
    {
        try {
            return $next($request);
        } catch (TokenMismatchException $e) {
            // CSRF token mismatch, redirect to the 'start' route
            session()->flash('message', 'The previous page has expired. - 419 PAGE EXPIRED');
            return redirect()->route('start');
        }
    }

    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        //
    ];
}
