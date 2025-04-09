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
        return in_array('admin', $user->roles())
            ? Response::allow()
            : Response::deny("You do not have admin privileges");
    }
}
