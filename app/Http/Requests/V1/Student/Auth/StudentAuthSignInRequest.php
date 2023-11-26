<?php

namespace App\Http\Requests\V1\Student\Auth;

use App\Exceptions\UnprocessableContentException;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StudentAuthSignInRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'email' => [
                'bail',
                'required',
                'string',
                'email',
                'max:50',
                'exists:students',
            ],
            'password' => ['required', 'string', Password::defaults()],
        ];
    }


    /**
     * Get the request's body parameters.
     *
     * @return array<string, mixed>
     */
    public function bodyParameters(): array
    {
        return [
            'email' => [
                'description' => 'Student`s email',
                'example' => 'student1@user.com',
            ],
            'password' => [
                'description' => 'Student`s password',
                'example' => 'password',
            ]
        ];
    }


    /**
     * @throws UnprocessableContentException
     */
    public function failedValidation(Validator $validator)
    {
        throw new UnprocessableContentException(
            $validator->errors(),
            __('exceptions.auth.student.sign_in.failed')
        );
    }
}
