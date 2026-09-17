<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class PurgePublicCache
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (in_array($request->method(), ['POST', 'PUT', 'PATCH', 'DELETE'], true)) {
            try {
                Cache::store('file')->flush();
            } catch (\Throwable) {
                //
            }

            $response->headers->set('X-LiteSpeed-Purge', '*');
        }

        return $response;
    }
}
