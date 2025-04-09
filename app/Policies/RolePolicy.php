<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class RolePolicy
{
    /**
     * Create a new policy instance.
     */

    public function isAdmin(User $user): Response  //7
    {
        return $user->roles()
    }
}
