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
     * @OA\Post(
     * path="/api/register",
     * summary="Rejestracja",
     * security={},
     * description="Rejestrowanie konta za pomocą loginu, emaila i hasła.",
     * operationId="authRegister",
     * tags={"autentykacja"},
     *
     * @OA\RequestBody(
     *    required=true,
     *    description="Dane do rejestracji użytkownika",
     *    @OA\JsonContent(
     *       required={"login","email","password"},
     *       @OA\Property(property="email", type="string", format="email", example="email@example.com"),
     *       @OA\Property(property="login", type="string", example="nickname"),
     *       @OA\Property(property="password", type="string", format="password", example="PassWord12345")
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Zalogowano poprawnie.",
     *    @OA\JsonContent(
     *       @OA\Property(
     *          property="token",
     *          type="string",
     *          example="7qQ0h6rLQk75pcrcugCRjqjQEHpjGzG3Shj7InDkq8HsG4xiD3Z21vuv6plDdKc6qcF54UJDWjb6vBIG"
     *       )
     *    )
     * ),
     * @OA\Response(
     *    response=422,
     *    description="Niepoprawne dane logowania.",
     *    @OA\JsonContent(
     *       @OA\Property(
     *          property="message",
     *          type="string"
     *       ),
     *       @OA\Property(
     *          property="errors",
     *          type="array",
     *          @OA\Items(
     *              @OA\Property(property="login", type="string"),
     *              @OA\Property(property="email", type="string"),
     *              @OA\Property(property="password", type="string")
     *          )
     *       )
     *    )
     * )
     *
     * )
     *
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
