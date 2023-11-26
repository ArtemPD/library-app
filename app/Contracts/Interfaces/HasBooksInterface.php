<?php


namespace App\Contracts\Interfaces;

use Illuminate\Database\Eloquent\Relations\HasMany;

interface HasBooksInterface
{
    /**
     * @return HasMany
     */
    public function books(): HasMany;
}

