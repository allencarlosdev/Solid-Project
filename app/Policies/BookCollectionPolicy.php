<?php

namespace App\Policies;

use App\Models\BookCollection;
use App\Models\User;

class BookCollectionPolicy
{
    /**
     * Determine if the user can view the collection.
     */
    public function view(User $user, BookCollection $collection): bool
    {
        return $collection->user_id === $user->id;
    }

    /**
     * Determine if the user can update the collection.
     */
    public function update(User $user, BookCollection $collection): bool
    {
        return $collection->user_id === $user->id;
    }

    /**
     * Determine if the user can delete the collection.
     */
    public function delete(User $user, BookCollection $collection): bool
    {
        return $collection->user_id === $user->id;
    }

    /**
     * Determine if the user can add books to the collection.
     */
    public function addBook(User $user, BookCollection $collection): bool
    {
        return $collection->user_id === $user->id;
    }

    /**
     * Determine if the user can remove books from the collection.
     */
    public function removeBook(User $user, BookCollection $collection): bool
    {
        return $collection->user_id === $user->id;
    }
}
