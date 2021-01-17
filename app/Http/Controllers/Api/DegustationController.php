<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DegustationStoreRequest;
use App\Models\Degustation;
use App\Models\Member;
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
     * @OA\Get(
     *     path="/degustations",
     *     @OA\Response(response="200", description="Display a listing of projects.")
     * )
     */
    public function index(Request $request): JsonResponse
    {
        $memberDegustations = $request->user()->memberships()
            ->orderBy('updated_at', 'DESC')->get()
            ->map(function(Member $member){
                return $member->degustation()->first();
            });
        $degustations = $request->user()->degustations()->orderBy('updated_at', 'DESC')->get()
            ->concat($memberDegustations)
            ->map(function(Degustation $degustation){
                $degustation->addOwnerToObject();
                return $degustation;
            });

        return response()->json(
            $degustations
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

        $member = $user->memberships()->select('id')->where('degustation_id', $degustation->id)->first();

        if($user->id !== (int)$degustation->owner_id && !$member) {
            return response()->json([
                'message' => 'You do not have access to this resource.'
            ], 403);
        }

        $degustation->addOwnerToObject();

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
        if($request->user()->id !== (int)$degustation->owner_id) {
            return response()->json([
                'message' => 'You do not have access to this resource.'
            ], 403);
        }

        if($degustation->status !== 'created'){
            return response()->json([
                'message' => 'Cannot be edited while degustation is in progress.'
            ], 403);
        }

        $degustation->update([
            'name' => $request->get('name'),
            'description' => $request->get('description')
        ]);

        return response()->json($degustation);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param Degustation $degustation
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Request $request, Degustation $degustation)
    {
        $user = $request->user();
        if($user->id === (int)$degustation->owner_id) {
            $degustation->delete();
            return response()->json([
                'status' => 'ok'
            ]);
        } else if($degustation->status !== 'created'){
            return response()->json([
                'message' => 'Cannot be edited while degustation is in progress.'
            ], 403);
        } else {
            return response()->json([
                'message' => 'You do not have access to this resource.'
            ], 403);
        }
    }
}
