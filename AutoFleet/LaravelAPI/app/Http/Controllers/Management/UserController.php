<?php

namespace App\Http\Controllers\Management;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Models\User;

class UserController
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }













    /**
     * Create a new user.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'nullable|string',
        ]);

        $user = $this->userService->createUser($validatedData);

        return response()->json($user, 201);
    }


























    /**
     * Get a user by ID.
     */
    public function show($id)
    {
        try {
            $user = $this->userService->getUserById($id);
            return response()->json($user);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'User not found'], 404);
        }
    }





























    /**
     * Update an existing user.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $id,
            'password' => 'sometimes|string|min:8',
            'role' => 'nullable|string',
        ]);

        try {
            $user = $this->userService->updateUser($id, $validatedData);
            return response()->json($user);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'User not found'], 404);
        }
    }



































    /**
     * Delete a user.
     */
    public function destroy($id)
    {
        try {
            $this->userService->deleteUser($id);
            return response()->json(['message' => 'User deleted successfully']);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'User not found'], 404);
        }
    }
























    /**
     * Get all users.
     */
    public function index()
    {
        $users = $this->userService->getAllUsers();
        return response()->json($users);
    }




















    /**
     * Update user role.
     */
    public function updateRole(Request $request, $id)
    {
        $validatedData = $request->validate([
            'role' => 'required|string',
        ]);

        try {
            $user = $this->userService->updateUserRole($id, $validatedData['role']);
            return response()->json($user);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'User not found'], 404);
        }
    }

































    /**
     * Send email verification notification.
     */
    public function sendVerificationEmail($id)
    {
        try {
            $user = $this->userService->getUserById($id);
            $this->userService->sendEmailVerification($user);

            return response()->json(['message' => 'Verification email sent']);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'User not found'], 404);
        }
    }

















}
