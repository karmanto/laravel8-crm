<?php

namespace App\Policies;

use App\Models\Awb;
use App\Models\User;

class AwbPolicy
{
    public function update(User $user, Awb $awb)
    {
        return $user->id === $awb->customer->user_id;
    }

    public function delete(User $user, Awb $awb)
    {
        return $user->id === $awb->customer->user_id;
    }

    public function view(User $user, Awb $awb)
    {
        return $user->id === $awb->customer->user_id;
    }
}
