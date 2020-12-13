<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DegustationStoreRequest;
use App\Models\Degustation;
use Exception;
use Illuminate\Http\JsonResponse;

class DegustationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        return response()->json(
            Degustation::orderBy('created_at', 'DESC')->simplePaginate(15)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param DegustationStoreRequest $request
     * @return JsonResponse
     */
    public function store(DegustationStoreRequest $request)
    {
        $degustation = Degustation::create([
            'name' => $request->get('name'),
            'description' => $request->get('description')
        ]);
        $degustation->link = route('api.degustations.show', ['degustation' => $degustation->id]);

        return response()->json($degustation);
    }

    /**
     * Display the specified resource.
     *
     * @param Degustation $degustation
     * @return JsonResponse
     */
    public function show(Degustation $degustation)
    {
        return response()->json($degustation);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param DegustationStoreRequest $request
     * @param Degustation $degustation
     * @return void
     */
    public function update(DegustationStoreRequest $request, Degustation $degustation)
    {
        $degustation->update([
            'name' => $request->get('name'),
            'description' => $request->get('description')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Degustation $degustation
     * @return void
     * @throws Exception
     */
    public function destroy(Degustation $degustation)
    {
        $degustation->delete();
    }
}
