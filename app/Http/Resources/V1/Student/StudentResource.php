<?php

namespace App\Http\Resources\V1\Student;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Knuckles\Scribe\Attributes\ResponseField;

class StudentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    #[ResponseField('id', type: 'integer', description: 'Student ID')]
    #[ResponseField('first_name', type: 'string', description: 'Student First Name')]
    #[ResponseField('last_name', type: 'string', description: 'Student Last Name')]
    #[ResponseField('email', type: 'string', description: 'Student Email')]
    #[ResponseField('phone', type: 'array', description: 'Student Phone details')]
    #[ResponseField('phone.code', type: 'string', description: 'Student Phone code')]
    #[ResponseField('phone.number', type: 'string', description: 'Student Phone number')]
    #[ResponseField('phone.value', type: 'string', description: 'Student Phone value')]
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
