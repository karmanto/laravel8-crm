<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChatbotSchedule extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'description', 'message', 'document_id', 'trigger_message', 'trigger_from', 'send_after', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function customers()
    {
        return $this->hasMany(Customer::class, 'chatbot_schedule_id');
    }
}
