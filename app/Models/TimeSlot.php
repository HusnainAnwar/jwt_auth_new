<?php

namespace App\Models;
use App\Models\User;
use App\Models\Appointment;
use Illuminate\Database\Eloquent\Model;

class TimeSlot extends Model
{
    protected $table = 'timeslots';

    protected $fillable = ['shop_id', 'start_time', 'end_time'];

    public function shop()
    {
        return $this->belongsTo(User::class, 'shop_id');
    }

    /*public function shop()
    {
        return $this->belongsTo(User::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }*/
}
