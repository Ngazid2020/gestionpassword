<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $organisationId = auth()->user()->organisations()->first()->id;

        $accounts = Account::where('organisation_id', $organisationId)
            ->latest()
            // ->take(12)
            ->get()
            ->map(function ($account) {
                // On prépare l'URL du favicon si une URL existe
                if ($account->url) {
                    $domain = parse_url($account->url, PHP_URL_HOST);
                    $account->favicon_url = "https://www.google.com/s2/favicons?sz=128&domain=" . ($domain ?? $account->url);
                } else {
                    $account->favicon_url = null;
                }
                return $account;
            });

        return view('dashboard', compact('accounts'));
    }
}
