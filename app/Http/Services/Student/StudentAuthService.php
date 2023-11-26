<?php

namespace App\Http\Services\Student;


use App\Enums\Role\RoleTypeEnum;
use App\Exceptions\Student\Auth\StudentAuthException;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class StudentAuthService
{

    /**
     * Login the student.
     *
     * @param string $email
     * @param string $password
     * @return array
     * @throws StudentAuthException
     */
    public function login(string $email, string $password): array
    {
        /** @var Student $user */
        $student = Student::query()->where('email', $email)->first();

        if (!$student || !Hash::check($password, $student->password)) {
            throw new StudentAuthException;
        }

        Log::info('Student logged in.', ['student_id' => $student->id]);
        $token = $student->createToken(RoleTypeEnum::STUDENT->value, ['role:' . RoleTypeEnum::STUDENT->value])
            ->plainTextToken;

        return [$student, $token];
    }


    /**
     * @return void
     */
    public function logout(): void
    {
        auth('sanctum')->user()->currentAccessToken()->delete();
    }
}
