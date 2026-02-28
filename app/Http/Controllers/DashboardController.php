<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $accounts = Account::where('organisation_id', auth()->user()->organisations()->first()->id)
            ->latest()
            ->take(12)
            ->get();
        // dd(auth()->user()->organisations());
        return view('dashboard', compact('accounts'));
    }
}
