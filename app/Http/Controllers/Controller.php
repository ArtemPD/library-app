<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;


    /**
     * @param string $message
     * @param string|null $context
     * @return JsonResponse
     */
    protected function successResponse(string $message, string $context = null): JsonResponse
    {
        $response = ['message' => $message];
        if ($context) {
            $response['context'] = $context;
        }
        return response()->json($response);
    }


    /**
     * @param string $message
     * @param string|null $context
     * @param int $status
     * @return JsonResponse
     */
    protected function errorResponse(string $message, string $context = null, int $status = 400): JsonResponse
    {
        $response = ['message' => $message];
        if ($context) {
            $response['context'] = $context;
        }
        return response()->json($response, $status);
    }
}
