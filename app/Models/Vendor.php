<?php

namespace App\Models;

use App\Models\Service;
use App\Models\TimeSlot;
use App\Models\Appointment;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $fillable = ['name', 'email', 'phone', 'address'];

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function timeSlots()
    {
        return $this->hasMany(TimeSlot::class);
    }
}