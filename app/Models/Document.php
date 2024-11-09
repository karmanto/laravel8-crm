<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'documents';

    protected $fillable = [
        'chatbot_schedule_id',
        'awb_notifier_id',
        'name',
        'filepath',
    ];
    public function chatbotSchedule()
    {
        return $this->belongsTo(ChatbotSchedule::class, 'chatbot_schedule_id');
    }
    
    public function awbNotifier()
    {
        return $this->belongsTo(AwbNotifier::class, 'awb_notifier_id');
    }
}
