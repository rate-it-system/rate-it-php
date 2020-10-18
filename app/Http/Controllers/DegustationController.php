<?php


namespace App\Http\Controllers;


use App\Services\Auth;
use Illuminate\Support\Facades\Hash;

class DegustationController
{
    public function __construct()
    {
        Auth::securePage();
    }

    public function list()
    {
        return view('app/list');
    }
}
