<?php

namespace App\Policies;

use App\Models\User;

class PurchasePolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function create(User $user): bool
    {
        return $user->role != "b2b_customer" || $user->role != "b2c_customer";
    }

    public function viewAny(User $user): bool
    {
        return $user->role == "b2b_customer" || $user->role == "b2c_customer";
    }
}
