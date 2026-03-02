<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Response;
use App\Notifications\VerifyEmailNotification;

class VerifyemailController extends Controller
{
    public function verify(Request $request, $id, $hash)
    {$user = User::where('id', $id);
    
    if(!hash_equals(sha1($user->email), $hash)) {
        return response()->json(['message' => 'Invalid verification link'], 400);
    }
    
    if($user ->hasVerifiedEmail()) {
        return response()->json([
            'message' => 'Email already verified'
        ], 400);
    }
    
    $user->markEmailAsVerified();
    event(new Verified($user));

    $user->is_active = 1;
    $user->save();
    return response()->json([
        'message' => 'Email verified successfully!'
    ]);
    }
}
