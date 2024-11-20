<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request) {

        $validator = Validator::make($request->all(), [
            'name'      => 'required',
            'email'     => 'required|email',
            'phone'     => 'required',
            'password'  => 'required',
        ]);

        if ($validator->fails()) {
            return validationError('Validation Error', $validator->errors());
        }

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            $user =User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password)
            ]);
        }
        $token = $user->createToken('auth_token')->plainTextToken;

        return success('Login successful', ['access_token' => $token]);
    }
}
