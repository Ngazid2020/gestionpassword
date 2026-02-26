<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Spatie\Permission\PermissionRegistrar;
use Symfony\Component\HttpFoundation\Response;

class SetSpatieTeamMiddleware
{
    public function handle($request, Closure $next)
    {
        if (filament()->getTenant()) {
            app(PermissionRegistrar::class)
                ->setPermissionsTeamId(filament()->getTenant()->id);
        }

        return $next($request);
    }
}
