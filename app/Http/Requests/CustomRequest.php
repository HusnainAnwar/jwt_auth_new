<?php

namespace App\Http\Requests;

use Laravel\Lumen\Http\Request;

class CustomRequest extends Request
{
    public function authorize()
    {
        // Your authorization logic here
        return true; // Example: Always return true for simplicity
    }

    public function rules()
    {
        return [
            
                'name' => 'required|string|max:255',
                'phone' => 'required|string|max:10|unique:users',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6|',
        ];
        
    }
    public function validate($rules, ...$params)
    {
      return $this->validate($rules,$params);
    }

}

