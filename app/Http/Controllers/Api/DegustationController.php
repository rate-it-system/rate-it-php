<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DegustationStoreRequest;
use App\Models\Degustation;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class DegustationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        return response()->json(
            $request->user()->degustations()->orderBy('updated_at', 'DESC')->simplePaginate(15)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param DegustationStoreRequest $request
     * @return JsonResponse
     */
    public function store(DegustationStoreRequest $request): JsonResponse
    {
        $user = $request->user();
        $invitation_key = Str::random(80);

        $degustation = Degustation::create([
            'owner_id' => $user->id,
            'name' => $request->get('name'),
            'description' => $request->get('description'),
            'invitation_key' => $invitation_key
        ]);
        $degustation->link = route('api.degustations.show', ['degustation' => $degustation->id]);

        return response()->json($degustation);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Degustation $degustation
     * @return JsonResponse
     */
    public function show(Request $request, Degustation $degustation): JsonResponse
    {
        $user = $request->user();
        //TODO: Dodać opcję wyświetlania dla degustatorów
        //$member = $user->membership()->where('degustation_id', $degustation->id)->first();

        if($user->id !== $degustation->owner_id) {
            return response()->json([
                'message' => 'You do not have access to this resource.'
            ], 403);
        }

        return response()->json($degustation);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param DegustationStoreRequest $request
     * @param Degustation $degustation
     * @return JsonResponse
     */
    public function update(DegustationStoreRequest $request, Degustation $degustation): JsonResponse
    {
        if($request->user()->id !== $degustation->owner_id)
            return response()->json([
                'message' => 'You do not have access to this resource.'
            ], 403);

        $degustation->update([
            'name' => $request->get('name'),
            'description' => $request->get('description')
        ]);

        return response()->json($degustation);
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
