<?php

namespace App\Policies;

use App\Models\AwbNotifier;
use App\Models\User;

class AwbNotifierPolicy
{
    public function update(User $user, AwbNotifier $notifier)
    {
        return $user->id === $notifier->user_id;
    }

    public function delete(User $user, AwbNotifier $notifier)
    {
        return $user->id === $notifier->user_id;
    }

    public function view(User $user, AwbNotifier $notifier)
    {
        return $user->id === $notifier->user_id;
    }
}
