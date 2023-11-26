<?php

namespace App\Policies;

use App\Contracts\Interfaces\UserInterface;
use App\Models\Book;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Foundation\Auth\User as Authenticatable;

class BookPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(UserInterface $user): bool
    {
        //
    }


    /**
     * Determine whether the user can view the model.
     */
    public function view(UserInterface $user, Book $book): bool
    {
        return $user->isPublisher() && $book->publisher->is($user);
    }


    /**
     * Determine whether the user can create models.
     */
    public function create(UserInterface $user): bool
    {
        return $user->isPublisher();
    }


    /**
     * Determine whether the user can update the model.
     */
    public function update(UserInterface $user, Book $book): bool
    {
        return $user->isPublisher() && $book->publisher->is($user);
    }


    /**
     * Determine whether the user can delete the model.
     */
    public function delete(UserInterface $user, Book $book): bool
    {
        return $user->isPublisher() && $book->publisher->is($user);
    }


    /**
     * Determine whether the user can restore the model.
     */
    public function restore(UserInterface $user, Book $book): bool
    {
        return $user->isPublisher() && $book->publisher->is($user);
    }


    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(UserInterface $user, Book $book): bool
    {
        return $user->isPublisher() && $book->publisher->is($user);
    }
}
