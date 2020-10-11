<?php


namespace App\Http\Controllers;


use App\Services\Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function loginPage()
    {
        return view('Auth/login');
    }

    public function login(Request $request)
    {
        if (Auth::loginByPassword($request->input('email'), $request->input('password'))) {
            return redirect('/');;
        } else {
            return view('Auth/login', ['msg' => "Logowanie nieudane", 'email' => $request->input('email')]);
        }
    }
}
