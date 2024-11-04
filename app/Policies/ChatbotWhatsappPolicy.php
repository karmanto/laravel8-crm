<?php

namespace App\Policies;

use App\Models\ChatbotWhatsapp;
use App\Models\User;

class ChatbotWhatsappPolicy
{
    public function update(User $user, ChatbotWhatsapp $chatbot)
    {
        return $user->id === $chatbot->user_id;
    }

    public function delete(User $user, ChatbotWhatsapp $chatbot)
    {
        return $user->id === $chatbot->user_id;
    }

    public function view(User $user, ChatbotWhatsapp $chatbot)
    {
        return $user->id === $chatbot->user_id;
    }
}
