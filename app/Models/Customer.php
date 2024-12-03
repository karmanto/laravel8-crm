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
        'age',
        'address',
        'user_id',
        'is_exception',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function awbs()
    {
        return $this->hasMany(Awb::class, 'customer_id');
    }

    public function events()
    {
        return $this->hasMany(Event::class, 'customer_id');
    }
}
