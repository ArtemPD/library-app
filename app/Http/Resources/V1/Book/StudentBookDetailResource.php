<?php

namespace App\Http\Resources\V1\Book;

use App\Http\Resources\V1\Author\StudentAuthorResource;
use App\Http\Resources\V1\Category\StudentCategoryResource;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Knuckles\Scribe\Attributes\ResponseField;

class StudentBookDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    #[ResponseField('id', type: 'integer', description: 'Book ID')]
    #[ResponseField('title', type: 'string', description: 'Book title')]
    #[ResponseField('description', type: 'string', description: 'Book description')]
    #[ResponseField('author', type: StudentAuthorResource::class, description: 'Book author')]
    #[ResponseField('category', type: StudentCategoryResource::class, description: 'Book category')]
    public function toArray(Request $request): array
    {
        /** @var Book $this */

        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'author' => $this->author ? StudentAuthorResource::make($this->author) : null,
            'category' => $this->category ? StudentCategoryResource::make($this->category) : null,
        ];
    }
}
