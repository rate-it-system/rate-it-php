<?php


namespace App\Http\Controllers;


use App\Services\Auth;

class MainController
{
    public function __construct()
    {
        Auth::securePage();
    }

    public function home()
    {
        return view('App/list');
    }
}
