<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Degustation;
use App\Models\Degustationfeature;
use Illuminate\Http\Request;

class FeatureController extends Controller
{
    public function index(Request $request, Degustation $degustation)
    {
        $user = $request->user();
        $member = $user->memberships()->select('id')->where('degustation_id', $degustation->id)->first();

        if($user->id !== (int)$degustation->owner_id && !$member) {
            return response()->json([
                'message' => 'You do not have access to this resource.'
            ], 403);
        }

        return response()->json(
            $degustation->features()->orderBy('updated_at', 'DESC')->get()
        );
    }

    public function store(Request $request, Degustation $degustation)
    {
        $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:255']
        ]);

        $user = $request->user();
        if($user->id !== (int)$degustation->owner_id) {
            return response()->json([
                'message' => 'You do not have access to this resource.'
            ], 403);
        }

        if($degustation->status !== 'created'){
            return response()->json([
                'message' => 'Cannot be edited while degustation is in progress.'
            ], 403);
        }

        $feature = $degustation->features()->create([
            'name' => $request->input('name')
        ]);

        return response()->json($feature);
    }

    public function show(Request $request, Degustation $degustation, Degustationfeature $feature)
    {
        $user = $request->user();
        $member = $user->memberships()->select('id')->where('degustation_id', $degustation->id)->first();

        if(($user->id !== (int)$degustation->owner_id && !$member) ||
            $degustation->id !== (int)$feature->degustation_id) {
            return response()->json([
                'message' => 'You do not have access to this resource.'
            ], 403);
        }

        return response()->json($feature);
    }

    public function update(Request $request, Degustation $degustation, Degustationfeature $feature)
    {
        $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:255']
        ]);

        $user = $request->user();
        $member = $user->memberships()->select('id')->where('degustation_id', $degustation->id)->first();

        if(($user->id !== (int)$degustation->owner_id && !$member) ||
            $degustation->id !== (int)$feature->degustation_id) {
            return response()->json([
                'message' => 'You do not have access to this resource.'
            ], 403);
        }

        if($degustation->status !== 'created'){
            return response()->json([
                'message' => 'Cannot be edited while degustation is in progress.'
            ], 403);
        }

        $feature->update([
            'name' => $request->input('name')
        ]);

        return response()->json($feature);
    }

    public function destroy(Request $request, Degustation $degustation, Degustationfeature $feature)
    {
        $user = $request->user();
        $member = $user->memberships()->select('id')->where('degustation_id', $degustation->id)->first();

        if($user->id !== (int)$degustation->owner_id || $member ||
            $degustation->id !== (int)$feature->degustation_id) {
            return response()->json([
                'message' => 'You do not have access to this resource.'
            ], 403);
        }

        if($degustation->status !== 'created'){
            return response()->json([
                'message' => 'Cannot be edited while degustation is in progress.'
            ], 403);
        }

        $feature->delete();

        return response()->json(['status' => 'ok']);
    }
}
