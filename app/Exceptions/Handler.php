<?php

namespace App\Exceptions;

use GuzzleHttp\Exception\ClientException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }


    /**
     * @param $request
     * @param Throwable $e
     * @return Response|JsonResponse|\Symfony\Component\HttpFoundation\Response
     * @throws Throwable
     */
    public function render($request, Throwable $e): Response|JsonResponse|\Symfony\Component\HttpFoundation\Response
    {
        $result = null;

        if ($e instanceof UnauthorizedException || $e instanceof AuthenticationException) {
            $result = response()->json([
                'message' => __('exceptions.auth.unauthorized'),
                'status_code' => 401,
            ], 401);
        }

        if ($e instanceof TooManyRequestsHttpException) {
            $result = response()->json([
                'message' => $e->getMessage() ?: __('exceptions.auth.too_many_requests'),
                'context' => 'too_many_requests',
            ], 429);
        }

        if ($e instanceof AuthorizationException) {
            $result = response()->json([
                'message' => $e->getMessage() ?: __("exceptions.auth.access denied"),
                'status_code' => 403,
            ], 403);
        }

        if ($e instanceof AccessDeniedHttpException) {
            $result = response()->json([
                'message' => $e->getMessage() ?: __("exceptions.auth.access denied"),
                'status_code' => 403,
            ], 403);
        }

        if ($e instanceof NotFoundHttpException) {
            $result = response()->json([
                'message' => $e->getMessage() ?: __("exceptions.http.404 Not Found"),
                'status_code' => 404,
            ], 404);
        }

        if ($e instanceof MethodNotAllowedHttpException) {
            $result = response()->json([
                'message' => $e->getMessage() ?: __("exceptions.http.405 Method Not Allowed"),
                'status_code' => 405,
            ], 405);
        }

        if ($e instanceof ModelNotFoundException) {
            $result = response()->json([
                'message' => __("exceptions.http.404 Not Found"),
                'status_code' => 404,
            ], 404);
        }

        if ($e instanceof HttpResponseException) {
            $result = response()->json([
                'message' => __("exceptions.http.422 Unprocessable Content"),
                'errors' => $e->getResponse()->getContent(),
                'status_code' => 422,
            ], 422);
        }

        if ($e instanceof ClientException) {
            $result = response()->json([
                'message' => __('exceptions.auth.Client Exception') . $e->getResponse()->getReasonPhrase(),
                'errors' => json_decode($e->getResponse()->getBody()->getContents()),
                'status_code' => $e->getResponse()->getStatusCode(),
            ], 422);
        }

        return $result ?? parent::render($request, $e);
    }
}
