<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Lumen\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::all();
        return response()->json($services);
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
        ]);
        $request->merge(['shop_id'=>Auth::id()]);
        // Check if the service already exists for the given shop
        $existingService = Service::where('shop_id', $request->shop_id)
            ->where('name', $request->name)
            ->first();

        if ($existingService) {
            return response()->json(['error' => 'This service already exists for the specified shop.'], 409);
        }

        $service = Service::create($request->all());

        return response()->json($service, 201);
    }



    public function show()
    {
        // Get the authenticated user
        $user = Auth::user();

        // Check if the user has a shop role (assuming role 2 is vendor)
        if ($user->role !== 2) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Assuming the user's shop ID is the same as their user ID
        $shopId = $user->id;

        // Retrieve all services provided by the specified shop
        $services = Service::where('shop_id', $shopId)->get();

        if ($services->isEmpty()) {
            return response()->json(['message' => 'No services found for this shop.'], 404);
        }

        return response()->json($services);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'string|max:255',
            'description' => 'string',
            'price' => 'numeric',
        ]);

        $service = Service::find($id);

        if (!$service) {
            return response()->json(['error' => 'Service not found.'], 404);
        }

        // Check if the new name conflicts with an existing service
        // if ($request->has('name') && $request->name !== $service->name) {
        //     $existingService = Service::where('name', $request->name)->first();
        //     if ($existingService) {
        //         return response()->json(['error' => 'A service with the same name already exists.'], 409);
        //     }
        // }

        // Update the service with the provided data
        $service->update($request->all());

        return response()->json($service);
    }


    public function destroy($id)
    {
        $service = Service::find($id);

        if (!$service) {
            return response()->json(['error' => 'Service not found.'], 404);
        }

        $service->delete();

        return response()->json(['message' => 'Service deleted successfully.']);
    }

    public function deleteServiceByShop(Request $request, $shopId, $serviceId)
    {
        // Validate the Shop ID
        $shop = User::find($shopId);
        if (!$shop) {
            return response()->json(['error' => 'Shop not found.'], 404);
        }

        // Validate the service ID and check if it belongs to the shop
        $service = Service::where('shop_id', $shopId)->find($serviceId);
        if (!$service) {
            return response()->json(['error' => 'Service not found or does not belong to the shop.'], 404);
        }

        // Delete the service
        $service->delete();

        return response()->json(['message' => 'Service deleted successfully.']);
    }

    public function servicesByShop($shopId)
    {
        // Check if the shop exists
        $shop = User::where('role',2)->where('id',$shopId)->first();

        if (!$shop) {
            return response()->json(['error' => 'shop not found.'], 404);
        }

        // Retrieve all services provided by the specified shop
        $services = Service::where('shop_id', $shopId)->get();

        if ($services->isEmpty()) {
            return response()->json(['error' => 'shop does not provide any services.'], 404);
        }

        return response()->json($services);
    }
    public function availableServices()
    {
        $services = DB::table('services')->where('is_available',1)->get();

        if ($services->isEmpty()) {
            return response()->json(['status' => 'error', 'message' => 'No services found.'], 404);
        }
        return response()->json(['status' => 'success', 'message' => 'Services retrieved.', 'services' => $services], 200);
    }
    
}
