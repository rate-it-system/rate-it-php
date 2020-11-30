<?php

namespace App\Http\Controllers;

use App\Http\Requests\MemberStoreRequest;
use App\Models\Degustation;
use App\Models\Member;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Degustation $degustation
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Degustation $degustation)
    {
        $members = $degustation->members()
            ->orderBy('name', 'asc')
            ->simplePaginate(15);

        //TODO:Dodać podgląd
        return response()->json($members);
    }

    /**
     * Show the form for adding a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        //TODO:Dodać podgląd
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param MemberStoreRequest $request
     * @param Degustation $degustation
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(MemberStoreRequest $request, Degustation $degustation)
    {
        $member = $degustation->members()->create([
            'user_id' => $request->get('user_id')
        ]);
        $member->link = route('members.show', ['degustation' => $degustation->id, 'member' => $member->id]);

        //TODO:Dodać przekierowanie
        return response()->json($member);
    }

    /**
     * Display the specified resource.
     *
     * @param Degustation $degustation
     * @param \App\Models\Member $member
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Degustation $degustation, Member $member)
    {
        //TODO:Dodać podgląd
        return response()->json(
            $degustation->members()->findOrFail($member->id)->user()
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Degustation $degustation
     * @param \App\Models\Member $member
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Degustation $degustation, Member $member)
    {
        $degustation->products()->findOrFail($member->id)->delete();
        return redirect()->route('members.index', ['degustation' => $degustation->id])
            ->with(['success' => 'Usunięto członka degustacji.']);
    }
}
