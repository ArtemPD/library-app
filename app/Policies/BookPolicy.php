<?php

namespace App\Policies;

use App\Models\Book;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Foundation\Auth\User as Authenticatable;

class BookPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Authenticatable $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Authenticatable $user, Book $book): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Authenticatable $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Authenticatable $user, Book $book): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Authenticatable $user, Book $book): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Authenticatable $user, Book $book): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Authenticatable $user, Book $book): bool
    {
        //
    }
}
