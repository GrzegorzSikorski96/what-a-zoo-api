<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Helpers\ApiResponse;
use Exception;
use Illuminate\Contracts\Container\Container;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

/**
 * Class Handler
 * @package App\Exceptions
 */
class Handler extends ExceptionHandler
{
    /**
     * @var ApiResponse
     */
    protected $apiResponse;

    /**
     * Handler constructor.
     * @param Container $container
     * @param ApiResponse $apiResponse
     */
    public function __construct(Container $container, ApiResponse $apiResponse)
    {
        parent::__construct($container);
        $this->apiResponse = $apiResponse;
    }

    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param Exception $exception
     * @return void
     * @throws Exception
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param Request $request
     * @param Exception $exception
     * @return JsonResponse|Response|\Symfony\Component\HttpFoundation\Response
     * @throws Exception
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof UnauthorizedHttpException) {
            $message = __('messages.exceptions.unauthorized');

            $preException = $exception->getPrevious();
            if ($preException instanceof TokenExpiredException) {
                $message = 'TOKEN_EXPIRED';
            } elseif ($preException instanceof TokenInvalidException) {
                $message = 'TOKEN_INVALID';
            } elseif ($preException instanceof TokenBlacklistedException) {
                $message = 'TOKEN_BLACKLISTED';
            }

            if ($exception instanceof TokenExpiredException) {
                $message = 'TOKEN_EXPIRED';
            }

            return $this->apiResponse
                ->setMessage($message)
                ->setFailureStatus(401)
                ->getResponse();
        }

        if ($exception instanceof AccessDeniedHttpException) {
            return $this->apiResponse
                ->setMessage(__('messages.exceptions.forbidden'))
                ->setFailureStatus(403)
                ->getResponse();
        }

        if ($exception instanceof TokenBlacklistedException) {
            return $this->apiResponse
                ->setMessage('TOKEN_BLACKLISTED')
                ->setFailureStatus(401)
                ->getResponse();
        }

        if ($exception instanceof ModelNotFoundException) {
            return $this->apiResponse
                ->setMessage(__('messages.exceptions.not_found'))
                ->setFailureStatus(404)
                ->getResponse();
        }

        if ($exception instanceof NotFoundHttpException) {
            return $this->apiResponse
                ->setMessage(__('messages.exceptions.not_found'))
                ->setFailureStatus(404)
                ->getResponse();
        }

        if ($exception instanceof UnauthorizedException || $exception instanceof UnauthorizedHttpException) {
            return $this->apiResponse
                ->setMessage(__('messages.exceptions.unauthorized'))
                ->setFailureStatus(401)
                ->getResponse();
        }

        return parent::render($request, $exception);
    }
}
