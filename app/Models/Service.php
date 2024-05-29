<?php

namespace App\Models;
use App\Models\User;
use App\Models\Appointment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends Model
{
    use HasFactory;
    protected $fillable = ['shop_id', 'name', 'description', 'price', 'is_available',];

    public function shop()
    {
        return $this->belongsTo(User::class,'shop_id');
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function timeslot()
    {
        return $this->hasOne(TimeSlot::class);
    }
}
