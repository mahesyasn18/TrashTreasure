<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_image',
        'phone_number',
        'account_number',
        'address',
        'role_user_id'
    ];

    public function role()
    {
        return $this->belongsTo(RoleUser::class);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function penukaranPoin()
    {
        return $this->hasMany(PenukaranPoin::class, 'user_id');
    }
    
    public function penukaranSampah()
    {
        return $this->hasMany(PenukaranSampah::class, 'user_id');
    }

    public function poin()
    {
        return $this->has(Poin::class, 'user_id');
    }

}
