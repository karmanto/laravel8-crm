<?php

namespace App\Policies;

use App\Models\CustomerAdder;
use App\Models\User;

class CustomerAdderPolicy
{
    public function update(User $user, CustomerAdder $customerAdder)
    {
        return $user->id === $customerAdder->user_id;
    }

    public function delete(User $user, CustomerAdder $customerAdder)
    {
        return $user->id === $customerAdder->user_id;
    }

    public function view(User $user, CustomerAdder $customerAdder)
    {
        return $user->id === $customerAdder->user_id;
    }
}
