<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use Illuminate\Http\Request;

class ColocationController extends Controller
{
    class ColocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $userId = auth()->id();

       $colocations = auth()->user()->colocations;

       return view('colocations.index', compact('colocations'));


    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ColocationRequest $request)
    {
        $id = auth()->id();
        $find = Memberships::where('user_id', $id)->first();

        if($find) {
            return view('colocations.create')->with(['Error' => 'You already have a colocation.']);
        }
        $request->merge(['owner_id' => $id]);
        $validated = $request->validated();

        Colocation::create($validated)->attach($validated['owner_id'], [
            'role' => 'owner',
            'joined_at' => now(),
        ]);

        return view('colocations.create')->with(['Success' => 'Colocation created successfully.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Colocation $colocation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Colocation $colocation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Colocation $colocation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Colocation $colocation)
    {
        //
    }
    public function leave(Colocation $colocation)
    {
        $user = auth()->user();

        $membership = $colocation->users()->where('user_id', $user->id)->first();
        if($membership) {
            return redirect()->route('colocations.index')->with('error', 'Owners cannot leave their colocation. Please transfer ownership or delete the colocation.');
        }
        if (!$membership) {
            abort(403);
        }

        $colocation->users()->detach($user->id);

        return redirect()->route('colocations.index')->with('success', 'You have left the colocation.');
    }
}
