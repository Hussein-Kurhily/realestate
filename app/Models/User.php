<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use App\Models\Order ;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'acc_state',
        'verification_code',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //                      Functions

    
    public function createUser(array $data): User {
        return User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => Hash::make($data['password']),
            'acc_state' => false,
        ]);
    }

    public function orders(){
        return $this->hasMany(Order::class, 'user_id') ;
    }
    public function sale_realestate_table(){
        return $this->hasMany(SaleRealestate::class, 'user_id') ;
    }
    public function rent_realestate_table(){
        return $this->hasMany(SaleRealestate::class, 'user_id') ;
    }

}



    // public static function boot()
    // {
    //     parent::boot();

    //     static::creating(function ($user) {
    //         $user->verification_code = rand(100000, 999999);
    //     });

    //     static::created(function ($user) {
    //         Mail::to($user->email)->send(new VerificationMail($user->verification_code));
    //     });
    // }
