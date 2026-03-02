<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\Role;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;
use App\Models\UserOtp;

class AuthController extends Controller
{
    public function register(Request $request){
        $validated = $request->validate([
            'name' => 'required|string|max:40',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:4|max:15|confirmed',
            'user_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10000'

        ]);

        if($request->role_id){
            $role_id = $request->role_id;
        } else {
            $role = Role::where('name', 'user')->first();
            $role_id = $role->id;   
        }

              
        $user = new User();
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role_id = $role->id;        
        $user->password = Hash::make($validated['password']);

        if($request->hasFile('user_image')) {
            $filename = $request->file('user_image')->store('users', 'public');
            $user->user_image = $filename;
        }else{
            $filename = null;
        }

        try{
            $user->save();
            return response()->json($user);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to save user.',
                'message' => $e->getMessage()
            ]);
        }
    }
    public function login(Request $request){
        $validated = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|min:4',
        ]);

        $user = User::where('email', $validated['email'])->first();

    if(!$user || !Hash::check($validated['password'], $user->password))
        throw ValidationException::withMessages([
            'error' => ['The provided credentials are incorrect.'],401
        ]);

        if(!$user->is_active){
            return response()->json([
                'message' => '  Account is inactive. Please contact support.'
            ], 403);
        }

        $otp = rand(100000,999999);
        $expires_at = now()->addMinutes(5);

        UserOtp::updateorCreate([
            'user_id'=>$user->id,
            'otp'=>$otp,
            'expires_at'=>$expires_at
        ]);

        Mail::to($user->email)->send(new OtpMail($otp));

        return response()->json([
            'message' => 'OTP sent successfully. Please verify to complete login',
        ],201);
    }
    
    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->json('Logout Successful!');
    }


    public function userInfo(){
        return "me";

    }
}