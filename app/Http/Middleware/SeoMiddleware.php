<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class SeoMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Configuration par défaut (à adapter pour Lakile)
        $seo = [
            'title' => config('app.name'),
            'description' => 'La solution SaaS pour gérer votre activité avec efficacité.',
            'image' => asset('images/og-default.jpg'),
            'canonical' => $request->fullUrl(),
        ];

        // Partage des données avec toutes les vues Blade
        View::share('seo', (object) $seo);

        return $next($request);
    }
}