<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Предположим, у пользователя есть поле role со значением 'admin'
        if (auth()->check() && auth()->user()->hasRole('admin')) {
            return $next($request);
        }

        abort(403, 'Доступ запрещён');
        // return $next($request);
    }
}
