<?php

namespace App\Http\Controllers;

use App\Http\Requests\DegustationStoreRequest;
use App\Models\Degustation;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DegustationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new Response(
            Degustation::orderBy('created_at', 'DESC')->simplePaginate(15)
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  DegustationStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DegustationStoreRequest $request)
    {
        $degustation = Degustation::create([
            'name' => $request->get('name'),
            'description' => $request->get('description')
        ]);
        $degustation->link = route('degustations.show', ['degustation' => $degustation->id]);

        return response($degustation, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Degustation  $degustation
     * @return \Illuminate\Http\Response
     */
    public function show(Degustation $degustation)
    {
        return response($degustation, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Degustation  $degustation
     * @return \Illuminate\Http\Response
     */
    public function edit(Degustation $degustation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Degustation  $degustation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Degustation $degustation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Degustation  $degustation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Degustation $degustation)
    {
        //auth()->guest()
        $degustation->delete();
    }
}
