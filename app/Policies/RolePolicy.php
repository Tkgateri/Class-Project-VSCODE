<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Role;

class RolePolicy
{
   public function viewAny(User $user)
    {
        return $user->role()->id === 1; // only admin can view all roles
    }
    
    public function view(User $user, Role $model)
    {
        return $user->role()->id === 1; // only admin can view a role
    }

    public function create(User $user)
    {
        return $user->role()->id === 1; // only admin can create a role
    }

    public function update(User $user, Role $model)
    {
        return $user->role()->id === 1; // only admin can update a role
    }

    public function delete(User $user, Role $model)
    {
        return $user->role()->id === 1; // only admin can delete a role
    }
}
