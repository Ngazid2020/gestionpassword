<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Illuminate\Session\TokenMismatchException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            \App\Http\Middleware\SeoMiddleware::class,
        ]);
        $middleware->alias([
            'subscription' => \App\Http\Middleware\Checksubscription::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // ← Ajouter ceci
        $exceptions->renderable(function (MethodNotAllowedHttpException $e, $request) {
            if ($request->is('livewire/update')) {
                return redirect('/dashboard');
            }
        });

        // Fix erreur 419 — session expirée
        $exceptions->renderable(function (TokenMismatchException $e, $request) {
            return redirect('/login')
                ->withErrors(['session' => 'Votre session a expiré, veuillez vous reconnecter.']);
        });
    })
    ->create();
