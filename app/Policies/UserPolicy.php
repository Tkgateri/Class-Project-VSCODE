<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function viewAny(User $user)
    {
        return $user->role()->id === 1; // only admin can view all users
    }

    public function view(User $user, User $model)
    {
        return $user->id ===$model->id || $user->role()->id === 1; // user can view their own profile or admin can view any profile 
    }

    public function create(User $user)
    {
        return true; // anyone can create a user
    }

    public function update(User $user, User $model)
    {
        return $user->id === $model->id || $user->role()->id ===1; // user can update their own profile or admin can update any profile
    }

    public function delete(User $user, User $model)
    {
        return $user->id === $model->id || $user->role()->id === 1; // user can delete their own profile or admin can delete any profile
    }

}