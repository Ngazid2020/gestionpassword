<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }
}
