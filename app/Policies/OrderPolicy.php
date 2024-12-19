<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;

class OrderPolicy
{
    public function update(User $user, Order $order)
    {
        return $user->id === $order->customer->user_id;
    }

    public function delete(User $user, Order $order)
    {
        return $user->id === $order->customer->user_id;
    }

    public function view(User $user, Order $order)
    {
        return $user->id === $order->customer->user_id;
    }
}
