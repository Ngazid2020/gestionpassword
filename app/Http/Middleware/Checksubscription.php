<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Checksubscription
{
    /**
     * Bloque l'accès si l'organisation de l'utilisateur n'a pas d'abonnement valide.
     * Redirige vers une page d'expiration avec un message clair.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if (! $user) {
            return $next($request);
        }

        $organisation = $user->organisations()->first();

        // Pas d'organisation = on laisse passer (géré ailleurs)
        if (! $organisation) {
            return $next($request);
        }

        // Accès valide → on continue
        if ($organisation->hasActiveAccess()) {
            return $next($request);
        }

        // Expiré ou suspendu → page dédiée
        return redirect()->route('subscription.expired');
    }
}
