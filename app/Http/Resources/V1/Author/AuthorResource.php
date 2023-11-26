<?php

namespace App\Http\Resources\V1\Author;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Knuckles\Scribe\Attributes\ResponseField;

class AuthorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    #[ResponseField('id', type: 'integer', description: 'Author ID')]
    #[ResponseField('first_name', type: 'string', description: 'Author First Name')]
    #[ResponseField('last_name', type: 'string', description: 'Author Last Name')]
    #[ResponseField('email', type: 'string', description: 'Author Email')]
    #[ResponseField('phone', type: 'array', description: 'Author Phone details')]
    #[ResponseField('phone.code', type: 'string', description: 'Author Phone code')]
    #[ResponseField('phone.number', type: 'string', description: 'Author Phone number')]
    #[ResponseField('phone.value', type: 'string', description: 'Author Phone value')]
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone_title,
        ];
    }
}
