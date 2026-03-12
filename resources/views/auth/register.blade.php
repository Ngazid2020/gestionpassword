<x-guest-layout>
    <x-slot name="title">Enregistrement</x-slot>

    <div class="min-h-screen flex bg-gradient-to-br from-slate-50 to-slate-100 dark:from-gray-900 dark:to-gray-800">

        {{-- ═══════════════════════════════════
             SECTION GAUCHE — Animation 3D
        ═══════════════════════════════════ --}}
        <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-emerald-600 to-teal-600 items-center justify-center relative overflow-hidden">
            <div class="absolute inset-0">
                <div class="absolute top-20 left-20 floating-icon" style="animation-delay: 0s;">
                    <div class="text-6xl opacity-20">🔒</div>
                </div>
                <div class="absolute top-40 right-32 floating-icon" style="animation-delay: 1s;">
                    <div class="text-5xl opacity-20">🛡️</div>
                </div>
                <div class="absolute bottom-32 left-32 floating-icon" style="animation-delay: 2s;">
                    <div class="text-4xl opacity-20">✅</div>
                </div>
                <div class="absolute bottom-20 right-20 floating-icon" style="animation-delay: 1.5s;">
                    <div class="text-5xl opacity-20">🔐</div>
                </div>
            </div>

            <div class="z-10 text-center px-8">
                <div class="cube-container mb-8">
                    <div class="cube">
                        <div class="cube-face front">🔒</div>
                        <div class="cube-face back">🛡️</div>
                        <div class="cube-face right">✅</div>
                        <div class="cube-face left">🔐</div>
                        <div class="cube-face top">💼</div>
                        <div class="cube-face bottom">🌐</div>
                    </div>
                </div>

                <h2 class="text-4xl font-bold text-white mb-4">Essai gratuit 14 jours</h2>
                <p class="text-emerald-100 text-lg max-w-md mx-auto">
                    Créez votre coffre-fort d'entreprise en moins de 2 minutes. Sans carte bancaire.
                </p>

                <div class="mt-8 flex items-center justify-center gap-4 text-white text-sm">
                    <div class="security-badge bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full">
                        <span class="font-semibold">99.9% Uptime</span>
                    </div>
                    <div class="security-badge bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full" style="animation-delay: 0.5s;">
                        <span class="font-semibold">ISO 27001</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- ═══════════════════════════════════
             SECTION DROITE — Formulaire
        ═══════════════════════════════════ --}}
        <div class="w-full lg:w-1/2 flex items-center justify-center p-6 overflow-y-auto">
            <div class="w-full max-w-md py-8">

                {{-- Logo --}}
                <div class="text-center mb-6">
                    <h1 class="text-4xl font-bold dark:text-white mb-2">
                        La<span class="gradient-text font-extrabold">kile</span>
                    </h1>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">
                        Coffre-fort numérique d'entreprise
                    </p>
                </div>

                {{-- Card formulaire --}}
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl border border-gray-100 dark:border-gray-700 p-8">

                    <div class="mb-6">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Créer un compte</h2>
                        <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Rejoignez 2 400+ équipes sécurisées</p>
                    </div>

                    {{-- FORMULAIRE ORIGINAL INTACT --}}
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <!-- Organisation -->
                        <div>
                            <x-input-label for="organisation" :value="__('Organisation')" />
                            <x-text-input id="organisation" class="block mt-1 w-full" type="text" name="organisation" :value="old('organisation')" required autofocus autocomplete="organisation" />
                            <x-input-error :messages="$errors->get('organisation')" class="mt-2" />
                        </div>

                        <!-- Name -->
                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Email Address -->
                        <div class="mt-4">
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Password -->
                        <div class="mt-4">
                            <x-input-label for="password" :value="__('Password')" />
                            <x-text-input id="password" class="block mt-1 w-full"
                                            type="password"
                                            name="password"
                                            required autocomplete="new-password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Confirm Password -->
                        <div class="mt-4">
                            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                            type="password"
                                            name="password_confirmation" required autocomplete="new-password" />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>

                        <div class="mt-6 space-y-3">
                            <button type="submit" class="w-full btn-lakile text-white font-semibold py-3 rounded-xl shadow-lg flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                </svg>
                                <span>{{ __('S\'inscrire') }}</span>
                            </button>

                            <div class="text-center">
                                <a class="text-sm text-gray-500 dark:text-gray-400 hover:text-emerald-600 dark:hover:text-emerald-400 transition" href="{{ route('login') }}">
                                    {{ __('Already registered?') }}
                                </a>
                            </div>
                        </div>
                    </form>

                </div>

                {{-- Badges sécurité --}}
                <div class="mt-6 flex items-center justify-center gap-4 text-xs text-gray-400 dark:text-gray-500">
                    <div class="flex items-center gap-1"><span>🔒</span><span>AES-256</span></div>
                    <span>•</span>
                    <div class="flex items-center gap-1"><span>✅</span><span>RGPD</span></div>
                    <span>•</span>
                    <div class="flex items-center gap-1"><span>🛡️</span><span>ISO 27001</span></div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50%       { transform: translateY(-20px) rotate(5deg); }
        }
        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 20px rgba(16, 185, 129, 0.3); }
            50%       { box-shadow: 0 0 40px rgba(16, 185, 129, 0.6); }
        }
        @keyframes rotate-cube {
            0%   { transform: rotateX(0deg) rotateY(0deg); }
            100% { transform: rotateX(360deg) rotateY(360deg); }
        }

        .cube-container { perspective: 1000px; width: 180px; height: 180px; margin: 0 auto; }
        .cube { position: relative; width: 100%; height: 100%; transform-style: preserve-3d; animation: rotate-cube 20s linear infinite; }
        .cube-face {
            position: absolute; width: 180px; height: 180px;
            background: linear-gradient(135deg, rgba(16,185,129,0.2), rgba(20,184,166,0.3));
            border: 2px solid rgba(16,185,129,0.5);
            backdrop-filter: blur(10px);
            display: flex; align-items: center; justify-content: center;
            font-size: 2.8rem;
        }
        .cube-face.front  { transform: translateZ(90px); }
        .cube-face.back   { transform: rotateY(180deg) translateZ(90px); }
        .cube-face.right  { transform: rotateY(90deg) translateZ(90px); }
        .cube-face.left   { transform: rotateY(-90deg) translateZ(90px); }
        .cube-face.top    { transform: rotateX(90deg) translateZ(90px); }
        .cube-face.bottom { transform: rotateX(-90deg) translateZ(90px); }

        .floating-icon  { animation: float 3s ease-in-out infinite; }
        .security-badge { animation: pulse-glow 2s ease-in-out infinite; }

        .gradient-text {
            background: linear-gradient(135deg, #10b981, #14b8a6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .btn-lakile {
            background: linear-gradient(135deg, #10b981, #14b8a6);
            transition: all 0.3s ease;
        }
        .btn-lakile:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(16, 185, 129, 0.4);
        }

        @media (max-width: 1024px) {
            .cube-container { width: 120px; height: 120px; }
            .cube-face { width: 120px; height: 120px; font-size: 2rem; }
            .cube-face.front  { transform: translateZ(60px); }
            .cube-face.back   { transform: rotateY(180deg) translateZ(60px); }
            .cube-face.right  { transform: rotateY(90deg) translateZ(60px); }
            .cube-face.left   { transform: rotateY(-90deg) translateZ(60px); }
            .cube-face.top    { transform: rotateX(90deg) translateZ(60px); }
            .cube-face.bottom { transform: rotateX(-90deg) translateZ(60px); }
        }
    </style>
</x-guest-layout>
