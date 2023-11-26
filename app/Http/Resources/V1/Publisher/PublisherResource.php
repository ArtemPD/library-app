<?php

namespace App\Http\Resources\V1\Publisher;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Knuckles\Scribe\Attributes\ResponseField;

class PublisherResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    #[ResponseField('id', type: 'integer', description: 'Publisher ID')]
    #[ResponseField('title', type: 'string', description: 'Publisher Title')]
    #[ResponseField('description', type: 'string', description: 'Publisher Description')]
    #[ResponseField('email', type: 'string', description: 'Publisher Email')]
    #[ResponseField('phone', type: 'array', description: 'Publisher Phone details')]
    #[ResponseField('phone.code', type: 'string', description: 'Publisher Phone code')]
    #[ResponseField('phone.number', type: 'string', description: 'Publisher Phone number')]
    #[ResponseField('phone.value', type: 'string', description: 'Publisher Phone value')]
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'email' => $this->email,
            'phone' => $this->phone_title,
        ];
    }
}
