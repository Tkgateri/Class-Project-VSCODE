<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserOtp extends Model
{   
    protected $table = 'user_otps';

    protected $fillable = [
        'otp',
        'expires_at',
        'user_id',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public function is_expired()
    {
        return $this->expires_at < now();
    }
}


