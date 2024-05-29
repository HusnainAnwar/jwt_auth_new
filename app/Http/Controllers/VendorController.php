<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VendorController extends Controller
{
    public function index()
    {
        $shops = User::where('role',2)->get();
        return response()->json($shops);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'phone' => 'required|string|max:15',
            'password' => 'required|string|min:8',
            'address' => 'required|string',
        ]);

        $shop = User::create($request->all());

        return response()->json($shop, 201);
    }

    public function show($id)
    {
        $shop = User::find($id);

        if (!$shop) {
            return response()->json(['error' => 'Shop not found.'], 404);
        }

        return response()->json($shop);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'string|max:255',
            'email' => 'string|email|max:255|unique:users,email,' . $id,
            'phone' => 'string|max:15',
            'address' => 'string',
        ]);

        $shop = User::find($id);

        if (!$shop) {
            return response()->json(['error' => 'Shop not found.'], 404);
        }

        $shop->update($request->all());

        return response()->json($shop);
    }

    public function destroy($id)
    {
        $shop = User::find($id);

        if (!$shop) {
            return response()->json(['error' => 'Shop not found.'], 404);
        }

        $shop->delete();

        return response()->json(['message' => 'shop deleted successfully.']);
    }

    public function getTimeSlots($id)
    {
        $shop = User::find($id);

        if (!$shop) {
            return response()->json(['error' => 'shop not found.'], 404);
        }

        $timeSlots = $shop->timeSlots;

        return response()->json($timeSlots);
    }
}
