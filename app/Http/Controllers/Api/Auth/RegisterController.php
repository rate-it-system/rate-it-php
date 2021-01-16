<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $request->validate([
            'login' => ['required', 'string', 'min:3', 'max:255', 'regex:/^[A-Z0-9\.\-\_]{3,30}$/i', 'unique:users'],
            'email' => ['required', 'email', 'min:6', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        return $this->createUser($request->all());
    }

    /**
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function createUser(array $data): \Illuminate\Http\JsonResponse
    {
        $token = $this->generateToken();

        User::create([
            'login' => $data['login'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'api_token' => hash('sha256', $token)
        ]);

        return response()->json([
            'token' => $token
        ]);
    }

    private function generateToken(): string
    {
        return Str::random(80);
    }
}
