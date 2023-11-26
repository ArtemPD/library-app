<?php

namespace App\Http\Resources\V1\Publisher\Book;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Knuckles\Scribe\Attributes\ResponseField;

class PublisherBookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    #[ResponseField('id', type: 'integer', description: 'Book ID')]
    #[ResponseField('title', type: 'string', description: 'Book title')]
    #[ResponseField('description', type: 'string', description: 'Book description')]
    public function toArray(Request $request): array
    {
        /** @var Book $this */

        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
        ];
    }
}
