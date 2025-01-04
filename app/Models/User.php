<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // 'teacher', 'admin', etc.
    ];

   
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Define the relationship with the Teacher model
    public function teacher()
    {
        return $this->hasOne(Teacher::class);
    }

           
    public function isSuperAdmin()
            {
                return $this->role === 'super_admin';
            }
        
    public function isAdmin()
            {
                return $this->role === 'admin';
            }
   

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    
}
