<?php

namespace App\Http\Controllers;

use App\Models\TimeSlot;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;

class TimeSlotController extends Controller
{
    public function index()
    {
        $timeSlots = TimeSlot::all();
        return response()->json($timeSlots);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'shop_id' => 'required|exists:users,id',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        $timeSlot = TimeSlot::create($request->all());
        return response()->json($timeSlot, 201);
    }

    public function show($id)
    {
        // Find the shop by ID
        $shop = User::find($id);

        if (!$shop) {
            return response()->json(['error' => 'Shop not found.'], 404);
        }

        // Retrieve all time slots associated with the shop
        $timeSlots = $shop->timeSlots;

        // Check if there are no time slots
        if ($timeSlots->isEmpty()) {
            return response()->json(['message' => 'No time slots found for this shop.'], 404);
        }

        return response()->json($timeSlots);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'shop_id' => 'required|exists:users,id',
            'start_time' => 'date_format:H:i',
            'end_time' => 'date_format:H:i|after:start_time',
        ]);

        $timeSlot = TimeSlot::find($id);

        if (!$timeSlot) {
            return response()->json(['error' => 'TimeSlot not found.'], 404);
        }

        $timeSlot->update($request->all());

        return response()->json($timeSlot);
    }

    public function destroy($user_id, $time_slot_id)
    {
        $timeSlot = TimeSlot::where('shop_id', $user_id)->find($time_slot_id);

        if (!$timeSlot) {
            return response()->json(['error' => 'TimeSlot not found.'], 404);
        }

        $timeSlot->delete();

        return response()->json(['message' => 'TimeSlot deleted successfully.']);
    }


}
