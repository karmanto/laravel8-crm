<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AwbAdder extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id', 'trigger_message', 'trigger_from', 'awb_field', 'logistic_field'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
