<?php


namespace App\Http\Controllers;


use App\Services\Auth;
use Illuminate\Support\Facades\Hash;

class MainController
{
    public function __construct()
    {
        Auth::securePage();
    }

    public function home()
    {
        echo "dziala";
        exit;
    }
}
