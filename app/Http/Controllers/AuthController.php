<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|unique:users,phone|max:20',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => 'required|integer|in:1,2',
            'address' => 'required|string|max:255', 
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address'=>$request->address,
            'password' => Hash::make($request->password),
            'role' => $request->role
        ]);
        return response()->json(['data' => $user], 201);
    }
    

    public function login(Request $request)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string',
            'password' => 'required|string',
        ]);
    
        // If validation fails, return error response
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        // Attempt to authenticate the user using phone and password
        if (Auth::attempt(['phone' => $request->phone, 'password' => $request->password])) {
            // Authentication successful, generate a JWT token
            $token = JWTAuth::fromUser(Auth::user());
    
            // Return token and user details in the response
            return response()->json([
                'token' => $token,
                'user' => Auth::user(),
            ], 200);
        } else {
            // Authentication failed, return error response
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }

    public function logout(Request $request)
    {

        if (Auth::check()) {

            Auth::logout();

            return response()->json(['message' => 'Logged out successfully'], 200);
        }


        return response()->json(['message' => 'Unauthorized'], 401);
    }
}
