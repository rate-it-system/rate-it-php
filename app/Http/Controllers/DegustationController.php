<?php


namespace App\Http\Controllers;


use App\Models\DegustationModel;
use App\Services\Auth;
use App\Services\DegustationService;
use Illuminate\Http\Request;
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

    public function doCreate(Request $request)
    {
        $degustation = new DegustationModel();
        $degustation->setName($request->input('name'));
        $degustation->save();
        DegustationService::setCurrentDegustation($degustation);
        return redirect()->route('addMember', ['msg' => 'Zapisano zmianę']);
    }

    public function addMember()
    {
        return view('app/degustation/addMember');
    }
}
