<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Degustation;
use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index(Request $request, Degustation $degustation) {
        $user = $request->user();
        $member = $user->memberships()->select('id')->where('degustation_id', $degustation->id)->first();

        if($user->id !== (int)$degustation->owner_id && !$member) {
            return response()->json([
                'message' => 'You do not have access to this resource.'
            ], 403);
        }

        return response()->json($degustation->members()->get()
            ->map(function(Member $member) {
                $memberUser = $member->user()->select('id', 'login', 'created_at')->first();
                $member->user = $memberUser;
                return $member;
            })
        );
    }

    public function show(Request $request, Degustation $degustation, Member $member) {
        $user = $request->user();
        $memberAuth = $user->memberships()->select('id')->where('degustation_id', $degustation->id)->first();

        if($user->id !== (int)$degustation->owner_id &&
            $degustation->id !== (int)$member->degustation_id &&
            !$memberAuth) {
            return response()->json([
                'message' => 'You do not have access to this resource.'
            ], 403);
        }

        return response()->json($member);
    }

    public function destroy(Request $request, Degustation $degustation, Member $member)
    {
        $user = $request->user();
        if($user->id !== (int)$degustation->owner_id) {
            $member->delete();
            return response()->json([
                'status' => 'ok'
            ]);
        } else {
            return response()->json([
                'message' => 'You do not have access to this resource.'
            ], 403);
        }
    }
}
