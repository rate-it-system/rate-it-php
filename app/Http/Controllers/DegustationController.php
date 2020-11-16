<?php


namespace App\Http\Controllers;


use App\Services\Auth;
use App\Services\DegustationService;
use Illuminate\Support\Facades\Hash;

class DegustationController
{
    public function __construct()
    {
        Auth::securePage();
    }

    public function list()
    {
        return view('App/list', ["list" => DegustationService::getMyDegustations()]);
    }

    public function create()
    {
        return view('app/degustation/create');
    }
}
