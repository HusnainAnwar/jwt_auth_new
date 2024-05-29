<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Service;
use App\Models\TimeSlot;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Lumen\Routing\Controller;

class AppointmentController extends Controller
{
 

    public function bookAppointment(Request $request)
{
    $this->validate($request, [
        'shop_id' => 'required|exists:users,id',
        'service_id' => 'required|exists:services,id',
        'appointment_date' => 'required|date_format:Y-m-d H:i:s',
    ]);

    // Check if the appointment slot is already taken
    $existingAppointment = Appointment::where('shop_id', $request->shop_id)
        ->where('service_id', $request->service_id)
        ->where('appointment_date', $request->appointment_date)
        ->first();

    if ($existingAppointment) {
        return response()->json(['error' => 'This appointment slot is already booked.'], 409);
    }

    // Retrieve the service details along with the associated time slot
    $service = Service::with('timeslot')->find($request->service_id);

    // If the service or timeslot is not found, return an error response
    if (!$service || !$service->timeslot) {
        return response()->json(['error' => 'Service or time slot not found.'], 404);
    }

    // Create the appointment
    $appointment = Appointment::create([
        'user_id' => Auth::id(),
        'shop_id' => $request->shop_id,
        'service_id' => $request->service_id,
        'appointment_date' => $request->appointment_date,
        'start_time' => $service->timeslot->start_time,
        'end_time' => $service->timeslot->end_time,
        'status' => 'pending',
    ]);

    return response()->json($appointment, 201);
}






    public function myAppointments()
    {
        $user_id=Auth::id();
        $appointments=User::where('id',$user_id)->with('appointments')->get();
        // $appointments = Auth::user()->appointments()->with('vendor', 'service')->get();
        return response()->json($appointments);
    }
}
