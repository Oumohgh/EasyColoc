<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use Illuminate\Support\Facades\Auth;
use App\Models\Membership;
use App\Models\User;

use App\Http\Requests\ColocationRequest;
use Illuminate\Http\Request;

class ColocationController extends Controller
{
    public function index()
    {
        $colocations = auth()->user()->colocations;
        return view('colocations.index', compact('colocations'));
    }

    public function create()
    {
        return view('colocations.create');
    }

    public function store(ColocationRequest $request)
    {
        $user = auth()->user();

        $alreadyMember = Membership::where('user_id', $user->id)->whereNull('left_at')->exists();

        if ($alreadyMember) {
            return redirect()->route('colocations.create')->with('error', 'Vous avez deja une colocation active.');
        }


        $colocation = Colocation::create($request->validated());


        $colocation->members()->attach($user->id, [
            'role'      => 'owner',
            'joined_at' => now(),
        ]);

        return redirect()->route('colocations.index')->with('success', 'Colocation created successfully.');
    }

    public function show(Colocation $colocation)
    {
        $members  = $colocation->activeMembers()->get();
        $expenses = $colocation->expenses()->latest()->get();
        return view('colocations.show', compact('colocation', 'members', 'expenses'));
    }

    public function edit(Colocation $colocation)
    {
        return view('colocations.edit', compact('colocation'));
    }

    public function update(Request $request, Colocation $colocation)
    {
        $colocation->update($request->validated());

        return redirect()->route('colocations.show', $colocation)->with('success', 'Colocation updated successfully.');
    }

    public function destroy(Colocation $colocation)
    {
        $colocation->cancel();

        return redirect()->route('colocations.index')->with('success', 'Colocation cancelled successfully.');
    }

    public function leave(Colocation $colocation)
    {
        $user = auth()->user();

        $membership = Membership::where('user_id', $user->id)->where('colocation_id', $colocation->id)->whereNull('left_at')->first();

        if (!$membership) {
            abort(403);
        }
        // if ($membership->role === 'owner') {
        //     return redirect()->route('colocations.index');
        // }

        $membership->update(['left_at' => now()]);

        $hasDebt = $colocation->expenses()
                              ->whereHas('shares', fn($q) =>
                                  $q->where('user_id', $user->id)
                                    ->where('is_paid', false)
                              )->exists();

        if ($hasDebt) {
            $user->des;
        } else {
            $user->;
        }

        return redirect()->route('colocations.index')
                         ->with('success', 'Vous avez quitte la colocation.');
    }

}
