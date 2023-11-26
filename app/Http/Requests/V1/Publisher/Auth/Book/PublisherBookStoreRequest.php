<?php

namespace App\Http\Requests\V1\Publisher\Auth\Book;

use App\Exceptions\UnprocessableContentException;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class PublisherBookStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'author_ids' => ['required', 'array'],
            'author_ids.*' => ['integer', 'exists:authors,id'],
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
            'title' => [
                'description' => 'Title of the book',
                'example' => 'Cooking'
            ],
            'description' => [
                'description' => 'Description of the book',
                'example' => 'Book about cooking'
            ],
            'author_ids' => [
                'description' => 'Author IDs of the book',
                'example' => [1, 2, 3]
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
            __('exceptions.auth.publisher.book.create.failed')
        );
    }
}
