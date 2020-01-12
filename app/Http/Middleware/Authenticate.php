<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;
use Tymon\JWTAuth\Http\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param Request $request
     * @param Closure $next
     * @return string
     */
    public function handle($request, Closure $next)
    {
        $this->authenticate($request);

        if (auth()->user()->blocked_at == null) {
            return $next($request);
        }

        throw new UnauthorizedException();
    }
}
