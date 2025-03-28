<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use App\Notifications\CustomVerifyEmail;

class UserService
{

    public function createUser(array $data)
    {
        // Hash the password before storing it in the database
        $data['password'] = Hash::make($data['password']);

        // Create the user record
        return User::create($data);
    }

















    public function updateUser($id, array $data)
    {
        $user = User::find($id);

        if (!$user) {
            throw new ModelNotFoundException('User not found');
        }

        // If password is being updated, hash it
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        // Update user data
        $user->update($data);

        return $user;
    }





















    public function deleteUser($id)
    {
        $user = User::find($id);

        if (!$user) {
            throw new ModelNotFoundException('User not found');
        }

        return $user->delete();
    }






















    public function getUserById($id)
    {
        $user = User::find($id);

        if (!$user) {
            throw new ModelNotFoundException('User not found');
        }

        return $user;
    }



















    public function getAllUsers()
    {
        return User::all();
    }

   














    public function sendEmailVerification(User $user)
    {
        $user->notify(new CustomVerifyEmail());
    }


















    public function activateUser($id)
    {
        $user = User::find($id);

        if (!$user) {
            throw new ModelNotFoundException('User not found');
        }

        // Assuming there's a field to mark user as active
        $user->active = true;
        $user->save();

        return $user;
    }

   





















    public function deactivateUser($id)
    {
        $user = User::find($id);

        if (!$user) {
            throw new ModelNotFoundException('User not found');
        }

        // Assuming there's a field to mark user as inactive
        $user->active = false;
        $user->save();

        return $user;
    }





















    public function hasRole(User $user, $role)
    {
        return $user->role === $role;
    }





















    
    public function updateUserRole($id, $role)
    {
        $user = User::find($id);

        if (!$user) {
            throw new ModelNotFoundException('User not found');
        }

        // Update user role
        $user->role = $role;
        $user->save();

        return $user;
    }
}
