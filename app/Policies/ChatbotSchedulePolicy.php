<?php

namespace App\Policies;

use App\Models\ChatbotSchedule;
use App\Models\User;

class ChatbotSchedulePolicy
{
    public function update(User $user, ChatbotSchedule $chatbot)
    {
        return $user->id === $chatbot->user_id;
    }

    public function delete(User $user, ChatbotSchedule $chatbot)
    {
        return $user->id === $chatbot->user_id;
    }

    public function view(User $user, ChatbotSchedule $chatbot)
    {
        return $user->id === $chatbot->user_id;
    }
}
