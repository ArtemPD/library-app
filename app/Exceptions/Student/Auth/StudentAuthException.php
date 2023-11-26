<?php

namespace App\Exceptions\Student\Auth;

use Exception;
use Illuminate\Http\JsonResponse;
use JetBrains\PhpStorm\Pure;
use Throwable;

class StudentAuthException extends Exception
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
            'message' => __('exceptions.auth.student.sign_in.password.failed'),
            'context' => 'student_failed_to_login',
            'errors' => [
                'password' => [
                    __('exceptions.auth.student.sign_in.password.failed')
                ]
            ],
            'status_code' => $this->getCode(),
        ], $this->getCode());
    }

}
