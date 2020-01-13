<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\Zoo;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class VisitedZoo
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
        $zoo = Zoo::findOrFail($request->all()['zoo_id']);

        if ($zoo->isVisited()) {
            $request['user_id'] = auth()->id();
            return $next($request);
        }

        throw new AccessDeniedHttpException();
    }
}
