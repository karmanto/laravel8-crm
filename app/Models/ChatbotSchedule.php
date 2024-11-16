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

    public function getFormattedSendAfterAttribute()
    {
        $seconds = $this->send_after;

        $days = floor($seconds / 86400); 
        $seconds %= 86400;

        $hours = floor($seconds / 3600);
        $seconds %= 3600;

        $minutes = floor($seconds / 60);
        $seconds %= 60;

        $formatted = [];
        if ($days > 0) {
            $formatted[] = "$days hari";
        }
        if ($hours > 0) {
            $formatted[] = "$hours jam";
        }
        if ($minutes > 0) {
            $formatted[] = "$minutes menit";
        }
        if ($seconds > 0 || empty($formatted)) {
            $formatted[] = "$seconds detik";
        }

        return implode(', ', $formatted);
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
