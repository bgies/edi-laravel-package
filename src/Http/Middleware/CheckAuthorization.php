<?php

namespace Bgies\EdiLaravel\Http\Middleware;

use Closure;

class CheckAuthorization
{
    public function handle($request, Closure $next)
    {
        if ($request->has('title')) {
            $request->merge([
                'title' => ucfirst($request->title)
            ]);
        }

        return $next($request);
    }
}
