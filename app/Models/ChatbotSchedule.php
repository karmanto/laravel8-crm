<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class ChatbotSchedule extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'message',
        'trigger_message',
        'trigger_from',
        'send_after',
    ];

    public function documents()
    {
        return $this->hasMany(Document::class, 'chatbot_schedule_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted()
    {
        static::deleting(function ($chatbotSchedule) {
            foreach ($chatbotSchedule->documents as $document) {
                Storage::delete($document->filepath);
                $document->delete();
            }
        });
    }
}
