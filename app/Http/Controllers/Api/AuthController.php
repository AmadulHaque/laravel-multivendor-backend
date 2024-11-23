<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'mail_or_phone' => 'required',
            'password'      => 'required',
        ]);
    
        if ($validator->fails()) {
            return validationError('Validation Error', $validator->errors());
        }
    
        // Determine whether the identifier is an email or a phone number
        $identifier = $request->input('mail_or_phone');
        $fieldType = filter_var($identifier, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';
    
        // Find the user by the identifier
        $user = User::where($fieldType, $identifier)->first();
    
        if (!$user || !Hash::check($request->input('password'), $user->password)) {
            return failure('Invalid credentials', 401);
        }
    
        // Generate token
        $token = $user->createToken('auth_token')->plainTextToken;
    
        return success('Login successful', ['access_token' => $token]);
    }
}
