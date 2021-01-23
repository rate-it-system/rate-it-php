<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    /**
     * @OA\Post(
     * path="/api/login",
     * summary="Logowanie",
     * security={},
     * description="Logowanie za pomocą loginu i hasła.",
     * operationId="authLogin",
     * tags={"autentykacja"},
     *
     * @OA\RequestBody(
     *    required=true,
     *    description="Dane logowania użytkownika",
     *    @OA\JsonContent(
     *       required={"login","password"},
     *       @OA\Property(property="login", type="string", example="nickname|email@example.com"),
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
    public function loginNormal(Request $request): \Illuminate\Http\JsonResponse
    {
        $login = $this->username();

        $request->validate([
            $login => [
                'required',
                ($login === 'login' ? 'string' : 'email'),
                'min:'. ($login === 'login' ? '3' : '6'),
                ($login === 'login' ? 'regex:/^[A-Z0-9\.\-\_]{3,30}$/i' : 'max:255'),
                'exists:users,'. $login
            ],
            'password' => ['required', 'string', 'min:8'],
        ]);

        if (Auth::attempt([
            $login => $request->input($login),
            'password' => $request->input('password')
        ])) {
            $token = $this->generateToken();

            $user = Auth::user();
            $user->update(['api_token' => hash('sha256', $token)]);

            return response()->json([
                'token' => $token
            ]);
        }

        return response()->json([
            'message' => 'Incorrect login details. Try again.',
            'errors' => (object)[
                'password' => ['Inncorrect password.']
            ]
        ], 422);
    }

    private function username(): string
    {
        $login = request()->get('login');
        if(filter_var($login, FILTER_VALIDATE_EMAIL)) {
            request()->merge(['email' => $login]);
            return 'email';
        }

        return 'login';
    }

    public function redirectToProvider(Request $request, string $socialType)
    {
        if(method_exists($this, strtolower($socialType).'Redirect')) {
            try {
                $redirect = $this->{$socialType . 'Redirect'}();
                return redirect()->to($redirect);
            } catch (ClientException $msg) {
                return response()->json([
                    'message' => 'An error occurred while connecting to the authorizing server.'
                ], 500);
            }
        } else
            abort(404);
    }

    public function handleProviderCallback(string $socialType)
    {
        if(method_exists($this, $socialType . 'Callback')) {
            try {
                $callback = $this->{$socialType . 'Callback'}();
                return $this->loginOrRegisterSocialMedia($callback);
            } catch (ClientException $msg) {
                return response()->json([
                    'message' => 'The authorization token has expired or does not exist.' . $msg->getMessage()
                ], 400);
            }
        } else
            abort(404);
    }

    private function githubRedirect()
    {
        return Socialite::driver('github')->stateless()->redirect()->getTargetUrl();
    }

    private function facebookRedirect()
    {
        return Socialite::driver('facebook')->stateless()->redirect()->getTargetUrl();
    }

    private function googleRedirect()
    {
        return Socialite::driver('google')->stateless()->redirect()->getTargetUrl();
    }

    private function githubCallback()
    {
        return Socialite::driver('github')->stateless()->user();
    }

    private function facebookCallback()
    {
        return Socialite::driver('facebook')->stateless()->user();
    }

    private function googleCallback()
    {
        return Socialite::driver('google')->stateless()->user();
    }

    private function loginOrRegisterSocialMedia($callbackUser)
    {
        $token = $this->generateToken();

        try {
            $user = User::firstOrCreate([
                'email' => $callbackUser->getEmail(),
            ], [
                'login' => $callbackUser->getNickname() ?? str_replace('-', '.', Str::slug($callbackUser->getName())),
                'password' => Hash::make(Str::random(80))
            ]);
        } catch (QueryException $ex) {
            $user = User::create([
                'login' => $callbackUser->getNickname() ??
                    str_replace('-', '_', Str::slug($callbackUser->getName().' '.rand(0,100))),
                'email' => $callbackUser->getEmail(),
                'password' => Hash::make(Str::random(80))
            ]);
        }

        $user->update([
            'api_token' => hash('sha256', $token)
        ]);

        return response()->json(['token' => $token]);
    }

    private function generateToken(): string
    {
        return Str::random(80);
    }
}
