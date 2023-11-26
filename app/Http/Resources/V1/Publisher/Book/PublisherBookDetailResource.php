<?php

namespace App\Http\Resources\V1\Publisher\Book;

use App\Http\Resources\V1\Author\AuthorResource;
use App\Http\Resources\V1\Publisher\PublisherResource;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Knuckles\Scribe\Attributes\ResponseField;

class PublisherBookDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    #[ResponseField('id', type: 'integer', description: 'Book ID')]
    #[ResponseField('title', type: 'string', description: 'Book title')]
    #[ResponseField('description', type: 'string', description: 'Book description')]
    #[ResponseField('authors', type: AuthorResource::class, description: 'Book authors')]
    #[ResponseField('publisher', type: PublisherResource::class, description: 'Book publisher')]
    public function toArray(Request $request): array
    {
        /** @var Book $this */

        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'author' => $this->authors()->exists() ? AuthorResource::collection($this->authors) : null,
            'publisher' => $this->publisher ? PublisherResource::make($this->publisher) : null,
        ];
    }
}
