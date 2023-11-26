<?php

namespace App\Http\Services\Publisher;


use App\Enums\Role\RoleTypeEnum;
use App\Exceptions\Publisher\Auth\PublisherAuthException;
use App\Models\Publisher;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class PublisherAuthService
{

    /**
     * Login the publisher.
     *
     * @param string $email
     * @param string $password
     * @return array
     * @throws PublisherAuthException
     */
    public function login(string $email, string $password): array
    {
        /** @var Publisher $user */
        $publisher = Publisher::query()->where('email', $email)->first();

        if (!$publisher || !Hash::check($password, $publisher->password)) {
            throw new PublisherAuthException;
        }

        Log::info('Publisher logged in.', ['publisher_id' => $publisher->id]);
        $token = $publisher->createToken(RoleTypeEnum::PUBLISHER->value, ['role:' . RoleTypeEnum::PUBLISHER->value])
            ->plainTextToken;

        return [$publisher, $token];
    }


    /**
     * Logout
     *
     * @return void
     */
    public function logout(): void
    {
        Log::info('Publisher logout in.', ['publisher_id' => auth('sanctum')->user()->id]);
        auth('sanctum')->user()->currentAccessToken()->delete();
    }
}
