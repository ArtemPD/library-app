<?php

namespace App\Exceptions\Publisher\Auth;

use Exception;
use Illuminate\Http\JsonResponse;
use JetBrains\PhpStorm\Pure;
use Throwable;

class PublisherAuthException extends Exception
{

    #[Pure] public function __construct($message = "", $code = 422, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }


    /**
     * @return JsonResponse
     */
    public function render(): JsonResponse
    {
        return response()->json([
            'message' => __('exceptions.auth.publisher.sign_in.password.failed'),
            'context' => 'publisher_failed_to_login',
            'errors' => [
                'password' => [
                    __('exceptions.auth.publisher.sign_in.password.failed')
                ]
            ],
            'status_code' => $this->getCode(),
        ], $this->getCode());
    }

}
