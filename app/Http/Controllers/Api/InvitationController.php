<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Degustation;
use Illuminate\Http\Request;

class InvitationController extends Controller
{
    public function acceptance(Request $request, string $invitationKey)
    {
        $degustation = Degustation::where('invitation_key', $invitationKey)
            ->where('status', '<>', 'completed')
            ->where('status', '<>', 'in progress')->first();
        if(!$degustation) {
            return response()->json([
                'message' => 'The invitation does not exist or has expired.'
            ], 404);
        }

        $user = $request->user();
        $member = $user->memberships()->where('degustation_id', $degustation->id)->first();

        if($user->id === $degustation->owner_id || $member) {
            return response()->json([
                'message' => 'You already belong to the degustation.'
            ]);
        }

        $member = $user->memberships()->firstOrCreate([
            'degustation_id' => $degustation->id
        ]);

        return response([
            'message' => 'You have become a degustation member.',
            'member' => $member
        ]);
    }
}
