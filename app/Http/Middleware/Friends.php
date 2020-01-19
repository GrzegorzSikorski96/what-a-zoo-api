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

        if (auth()->id() == $friendId || auth()->user()->friends()->whereIn('friend_id', [auth()->id(), $friendId])->whereIn('user_id', [auth()->id(), $friendId])->firstOrFail()) {
            return $next($request);
        }

        throw new AccessDeniedHttpException();
    }
}
