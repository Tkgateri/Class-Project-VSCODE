<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserOtp;

class UserOtpController extends Controller
{
    public function verifyOtp(Request $request){
        $request->validate([
            'username'=> 'required|string',
            'otp'=>'required|string'
               ]);

    $user = User::where('username', $request->username)->first();

    if(!$user) {
        return response()->json([
            'message'=>'User not found'
        ], 404);

        $otpEntry = UserOtp::where('user_id', $user->id)
        ->where('otp', $request->otp)
        ->first();
    }
    
    if (!$otpEntry || $otpEntry->is_expired()) {
        return response()->json([
            'message'=>'Invalid OTP'
        ], 400);
    }
    // OTP is valid, proceed with authentication or other logic
    $otpEntry->delete();
    $user->tokens()->delete();

    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'message'=>'Login successfull!',
        'token'=>$token,
        'user'=>$user
    ]);

    }
}
