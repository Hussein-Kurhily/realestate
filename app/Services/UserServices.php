<?php

namespace App\Services;

use App\Models\User as UserModel;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class UserService
{
    use HasApiTokens;
    /**
     * Create a new user.
     *
     * @param array $data
     * @return UserModel
     */
    public function createUser(array $data): UserModel
    {
        return UserModel::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => Hash::make($data['password']),
            'acc_state' => false,
        ]);
    }
}
