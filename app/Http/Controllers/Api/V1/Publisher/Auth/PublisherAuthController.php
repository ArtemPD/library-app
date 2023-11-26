<?php

namespace App\Http\Controllers\Api\V1\Publisher\Auth;

use App\Exceptions\Publisher\Auth\PublisherAuthException;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Publisher\Auth\PublisherAuthSignInRequest;
use App\Http\Resources\V1\Publisher\PublisherResource;
use App\Http\Services\Publisher\PublisherAuthService;
use App\Models\Publisher;
use Illuminate\Http\JsonResponse;
use Knuckles\Scribe\Attributes\Response;
use Knuckles\Scribe\Attributes\ResponseFromApiResource;

/**
 * @group Publisher
 * @subgroup Auth
 */
class PublisherAuthController extends Controller
{
    public function __construct(private readonly PublisherAuthService $publisherAuthService)
    {
    }


    /**
     * Login
     * @param PublisherAuthSignInRequest $request
     * @return JsonResponse
     * @throws PublisherAuthException
     */
    #[ResponseFromApiResource(PublisherResource::class, Publisher::class, 200, '', false)]
    public function login(PublisherAuthSignInRequest $request): JsonResponse
    {
        [$publisher, $token] = $this->publisherAuthService->login(
            $request->validated()['email'],
            $request->validated()['password']
        );

        return PublisherResource::make($publisher)->additional([
            'access_token' => $token,
        ])->response();
    }


    /**
     * Logout
     * @authenticated
     * @return JsonResponse
     */
    #[Response([
        'message' => 'Publisher logged out successfully.',
        'context' => 'logout_successfully',
    ], 200)]
    public function logout(): JsonResponse
    {
        $this->publisherAuthService->logout();

        return response()->json([
            'message' => __("auth.logout.success.message"),
            'context' => __("auth.logout.success.context"),
        ]);
    }
}
