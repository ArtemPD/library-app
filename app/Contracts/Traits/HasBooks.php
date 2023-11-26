<?php

namespace App\Contracts\Traits;

use App\Models\Book;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasBooks
{
    /**
     * @return HasMany
     */
    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }
}

