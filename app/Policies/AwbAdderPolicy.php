<?php

namespace App\Policies;

use App\Models\AwbAdder;
use App\Models\User;

class AwbAdderPolicy
{
    public function update(User $user, AwbAdder $awbAdder)
    {
        return $user->id === $awbAdder->user_id;
    }

    public function delete(User $user, AwbAdder $awbAdder)
    {
        return $user->id === $awbAdder->user_id;
    }

    public function view(User $user, AwbAdder $awbAdder)
    {
        return $user->id === $awbAdder->user_id;
    }
}
