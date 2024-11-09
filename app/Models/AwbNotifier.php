<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AwbNotifier extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'message',
        'trigger_awb_status',
    ];
    
    public function documents()
    {
        return $this->hasMany(Document::class, 'awb_notifier_id');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
