<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'chatbot_schedule_id',
        'name',
        'filepath',
        'type',
    ];

    public function chatbotSchedule()
    {
        return $this->belongsTo(ChatbotSchedule::class, 'chatbot_schedule_id');
    }
}
