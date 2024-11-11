<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Logistic extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name'];

    public function awbs()
    {
        return $this->hasMany(Awb::class, 'logistic_id');
    }
}
