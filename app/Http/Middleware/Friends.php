<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class Friends
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $friendId = $request->route()->parameter('userId');

        if (auth()->user()->friends()->where('friend_id', $friendId)->firstOrFail()) {
            return $next($request);
        }

        throw new AccessDeniedHttpException();
    }
}
