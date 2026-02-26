<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;



use App\Http\Requests\ExpenseRequest;


class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{

    $expenses = Expense::join('colocations', 'expenses.colocation_id','=','colocations.id')
        ->join('memberships', 'colocations.id','=','memberships.colocation_id')
        ->where('memberships.user_id', auth()->id())
        ->wherenull('memberships.left_at')
        ->select('expenses.*')
        ->distinct()
        ->latest()
        ->paginate(10);

    return view('expenses.index', compact('expenses'));
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
    public function store(ExpenseRequest $request)
    {
        $validated = $request->validated();

        Expense::create($validated);

        return redirect()->route('expenses.index')->with('success', 'Depense cree avec succes.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Expense $expense)
    {
        $memberships = $expense->colocation->memberships()
        ->whereNull('left_at')
        ->where('user_id', '!=', $expense->paid_by)
        ->with('user')
        ->get();

        $amountPerPerson = $expense->amount / ($memberships->count() + 1);

        return view('expenses.show', compact('expense', 'memberships', 'amountPerPerson'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Expense $expense)
    {
        $userId = auth()->id();
        if ($expense->paid_by !== $userId && $expense->created_by !== $userId) {
            return redirect()->route('expenses.index')->with('error', 'You can only edit expenses you have paid.');
        }
        return view('expenses.edit', compact('expense'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ExpenseRequest $request, Expense $expense)
    {
        $validated = $request->validated();
        $userId = auth()->id();
        if ($expense->paid_by !== $userId && $expense->created_by !== $userId) {
            return redirect()->route('expenses.index')->with('error', 'You can only edit expenses you have paid.');
        }
        $expense->update($validated);
        return redirect()->route('expenses.index')->with('success', 'Expense updated successfully.');
    }


    public function destroy(Expense $expense)
    {
        $userId = auth()->id();
        if ($expense->paid_by !== $userId && $expense->created_by !== $userId) {
            return redirect()->route('expenses.index')->with('error', 'You can only delete expenses you have paid.');
        }
        $expense->delete();
        return redirect()->route('expenses.index')->with('success', 'Expense deleted successfully.');

        }
}
