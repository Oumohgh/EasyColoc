<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Colocation;
use App\Models\Expense;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers        = User::count();
        $activeColocations = Colocation::where('status', 'active')->count();
        $totalExpenses     = Expense::count();
        $bannedUsers       = User::where('is_banned', true)->count();

        $recentUsers = User::latest()->take(5)->get();


        $recentColocations = Colocation::with(['memberships.user'])->latest()->get();

        return view('admin.dashboard', compact('totalUsers','activeColocations','totalExpenses','bannedUsers','recentUsers','recentColocations'
        ));
    }

    public function ban(User $user)
    {

        $user->update(['is_banned' => true]);

        return back()->with('success', "{$user->name} a ete bannee");
    }

    public function unban(User $user)
    {
        $user->update(['is_banned' => false]);

        return back()->with('success', "{$user->name} a ete debanne");
    }
}

