<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChatbotSchedule extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'time_sending',
        'gmt_time_sending',
        'chatbot_closing',
        'chatbot_repeat',
        'trigger_new_customer',
        'message_fu1',
        'message_fu2',
        'message_fu3',
        'message_fu7',
        'message_fu14',
        'message_fu21',
        'message_fu25',
        'trigger_order',
        'trigger_update_awb',
        'message_in_kurir',
        'message_delivered',
        'message_fu3ac',
        'message_fu7ac',
        'message_fu14ac',
        'message_fu21ac',
        'message_fu25ac',
        'message_fu3ar',
        'message_fu7ar',
        'message_fu14ar',
        'message_fu21ar',
        'message_fu25ar',
        'awb_pattern',
        'logistic_pattern',
        'age_pattern',
        'name_pattern',
        'address_pattern',
        'total_order_pattern',
        'message_delivering',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function chatbotClosing()
    {
        return $this->belongsTo(ChatbotWhatsapp::class, 'chatbot_closing');
    }

    public function chatbotRepeat()
    {
        return $this->belongsTo(ChatbotWhatsapp::class, 'chatbot_repeat');
    }

    public function documents()
    {
        return $this->hasMany(Document::class, 'chatbot_schedule_id');
    }
}
