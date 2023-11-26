<?php

namespace App\Http\Controllers\Api\V1\Student\Auth;

use App\Exceptions\Student\Auth\StudentAuthException;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Student\Auth\StudentAuthSignInRequest;
use App\Http\Resources\V1\Student\StudentResource;
use App\Http\Services\Student\StudentAuthService;
use App\Models\Student;
use Illuminate\Http\JsonResponse;
use Knuckles\Scribe\Attributes\Response;
use Knuckles\Scribe\Attributes\ResponseFromApiResource;

/**
 * @group Student
 * @subgroup Auth
 */
class StudentAuthController extends Controller
{
    public function __construct(private readonly StudentAuthService $studentAuthService)
    {
    }


    /**
     * Login
     * @param StudentAuthSignInRequest $request
     * @return JsonResponse
     * @throws StudentAuthException
     */
    #[ResponseFromApiResource(StudentResource::class, Student::class, 200, '', false)]
    public function login(StudentAuthSignInRequest $request): JsonResponse
    {
        [$student, $token] = $this->studentAuthService->login(
            $request->validated()['email'],
            $request->validated()['password']
        );

        return StudentResource::make($student)->additional([
            'access_token' => $token,
        ])->response();
    }


    /**
     * Logout
     * @authenticated
     * @return JsonResponse
     */
    #[Response([
        'message' => 'Student logged out successfully.',
        'context' => 'logout_successfully',
    ], 200)]
    public function logout(): JsonResponse
    {
        $this->studentAuthService->logout();

        return response()->json([
            'message' => __("auth.logout.success.message"),
            'context' => __("auth.logout.success.context"),
        ]);
    }
}
