<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Awb extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'customer_id',
        'logistic_id',
        'awb_notifier_status_id',
        'awb_number',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function logistic()
    {
        return $this->belongsTo(Logistic::class, 'logistic_id');
    }

    public function awbNotifier()
    {
        return $this->belongsTo(awbNotifier::class, 'awb_notifier_status_id');
    }
}
