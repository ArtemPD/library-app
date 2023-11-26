<?php

namespace App\Http\Requests\V1\Publisher\Auth;

use App\Exceptions\UnprocessableContentException;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class PublisherAuthSignInRequest extends FormRequest
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
                'exists:publishers',
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
                'description' => 'Publisher email',
                'example' => 'publisher1@gmail.com',
            ],
            'password' => [
                'description' => 'Publisher`s password',
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
            __('exceptions.auth.publisher.sign_in.failed')
        );
    }
}
