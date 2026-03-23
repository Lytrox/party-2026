<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SetUserLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->preferred_locale !== null) {
            App::setLocale(Auth::user()->preferred_locale);
        }

        return $next($request);
    }
}
