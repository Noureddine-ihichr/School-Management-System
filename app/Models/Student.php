<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'phone_number',
        'date_of_birth',
        'address',
        'extra_info',
        'profile_picture',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
