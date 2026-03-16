<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Api\V1\BaseApiController;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\ApiResponseService;

class AuthApiController extends BaseApiController
{
    protected $userRepository;
    public function __construct(UserRepositoryInterface $userRepository){
        parent::__construct($userRepository);
        $this->userRepository = $userRepository;
    }

    public function login(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'password' => 'required',
        ]);

        try {
            $user = User::where('name', $request->name)->first();
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('API Login error: ' . $e->getMessage());
            return ApiResponseService::sendError('Service temporarily unavailable.', 503);
        }

        if (!$user) {
            return ApiResponseService::sendError('Invalid credentials', 401);
        }
        if (!Hash::check($request->password, $user->password)) {
            return ApiResponseService::sendError('Invalid credentials', 401);
        }

        try {
            $user->tokens()->delete();
            $token = $user->createToken('auth_token')->plainTextToken;
            try {
                $user->role = $user->getRoleNames()->first();
            } catch (\Throwable $e) {
                $user->role = null;
            }
            $result = [
                'token' => $token,
                'user' => $user,
            ];
            return ApiResponseService::sendResponse($result, 'Login successful', 200);
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('API Login token error: ' . $e->getMessage());
            return ApiResponseService::sendError('Login failed. Please try again.', 500);
        }
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
        ]);

        try {
            $user = $this->userRepository->create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password, // User model has 'password' => 'hashed' cast
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            \Illuminate\Support\Facades\Log::error('API Register DB error: ' . $e->getMessage());
            return ApiResponseService::sendError('Registration failed. Database error.', 500);
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('API Register error: ' . $e->getMessage(), ['exception' => $e]);
            return ApiResponseService::sendError('Registration failed. Please try again.', 500);
        }

        // Assign default role "User" if exists (do not fail registration if role missing)
        try {
            $defaultRole = \Spatie\Permission\Models\Role::where('name', 'User')->first();
            if ($defaultRole) {
                $user->assignRole($defaultRole);
            }
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('API Register: could not assign role: ' . $e->getMessage());
        }

        return ApiResponseService::sendResponse([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ], 'Register successful', 200);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return ApiResponseService::sendResponse([], 'Logout successful', 200);
    }
}
