<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'whatsapp_number',
        'chatbot_schedule_id',
        'chatbot_whatsapp_id',
        'user_id',
        'is_exception',
    ];

    public function chatbotWhatsApp()
    {
        return $this->belongsTo(ChatbotWhatsapp::class, 'chatbot_whatsapp_id');
    }

    public function chatbotSchedule()
    {
        return $this->belongsTo(ChatbotSchedule::class, 'chatbot_schedule_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
