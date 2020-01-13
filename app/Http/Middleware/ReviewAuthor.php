<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\Review;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class ReviewAuthor
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
        $review = Review::findOrFail($request->all()['id']);

        if ($review->author == auth()->user()) {
            return $next($request);
        }

        throw new AccessDeniedHttpException();
    }
}
