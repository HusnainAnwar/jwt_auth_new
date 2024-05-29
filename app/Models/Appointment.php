<?php

namespace App\Models;

use App\Models\User;
use App\Models\Service;
use App\Models\Barber;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = ['user_id', 'shop_id', 'service_id', 'barber_id', 'appointment_date', 'start_time', 'end_time', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function shop()
    {
        return $this->belongsTo(User::class, 'shop_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

   
}
