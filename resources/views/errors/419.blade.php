<!DOCTYPE html>
<html lang="fr" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Session expirée — Lakile</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gradient-to-br from-gray-950 via-gray-900 to-gray-950
             flex items-center justify-center px-4">

    <div class="text-center max-w-md w-full">

        {{-- Icône --}}
        <div class="flex items-center justify-center mb-6">
            <div class="w-24 h-24 rounded-3xl
                        bg-gradient-to-br from-indigo-500 to-purple-600
                        flex items-center justify-center shadow-2xl">
                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71
                             c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898
                             0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                </svg>
            </div>
        </div>

        {{-- Code erreur --}}
        <p class="text-indigo-400 font-bold text-sm tracking-widest uppercase mb-2">
            Erreur 419
        </p>

        {{-- Titre --}}
        <h1 class="text-3xl font-black text-white mb-3">
            Session expirée
        </h1>

        {{-- Description --}}
        <p class="text-gray-400 text-sm leading-relaxed mb-8">
            Votre session a expiré par mesure de sécurité.<br>
            Reconnectez-vous pour continuer.
        </p>

        {{-- Boutons --}}
        <div class="flex flex-col sm:flex-row gap-3 justify-center">

            <a href="{{ route('login') }}"
               class="inline-flex items-center justify-center gap-2
                      px-6 py-3 rounded-2xl font-semibold text-sm text-white
                      bg-gradient-to-r from-indigo-500 to-purple-600
                      hover:from-purple-600 hover:to-indigo-500
                      transition-all duration-300 shadow-lg hover:shadow-indigo-500/30">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3
                             3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                </svg>
                Se reconnecter
            </a>

            <a href="{{ url()->previous() !== url()->current() ? url()->previous() : '/' }}"
               class="inline-flex items-center justify-center gap-2
                      px-6 py-3 rounded-2xl font-semibold text-sm
                      text-gray-300 hover:text-white
                      bg-white/5 hover:bg-white/10
                      border border-white/10 hover:border-white/20
                      transition-all duration-300">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Page précédente
            </a>

        </div>

        {{-- Branding --}}
        <p class="mt-10 text-xs text-gray-600">
            © {{ date('Y') }} <span class="text-indigo-500 font-semibold">Lakile</span>
            — Gestion sécurisée des accès
        </p>

    </div>

</body>
</html>