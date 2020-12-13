<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use App\Models\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        $login = request()->get('login');
        if(filter_var($login, FILTER_VALIDATE_EMAIL)) {
            request()->merge(['email' => $login]);
            return 'email';
        }

        return 'login';
    }

    public function facebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function facebookCallback()
    {
        return $this->loginWithSocialMedia(Socialite::driver('facebook')->user());
    }

    public function google()
    {
        return Socialite::driver('google')->redirect();
    }

    public function googleCallback()
    {
        return $this->loginWithSocialMedia(Socialite::driver('google')->user());
    }

    private function loginWithSocialMedia($user)
    {
        $user = User::firstOrCreate([
            'email' => $user->getEmail()
        ], [
            'login' => $user->getNickname() ?? str_replace('-', '.',  Str::slug($user->getName())),
            'password' => Hash::make(Str::random(50))
        ]);

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
