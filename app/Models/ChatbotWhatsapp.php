<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChatbotWhatsapp extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id', 'qrcode', 'is_connect', 'is_active', 'whatsapp_number', 'whatsapp_number_linked'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
