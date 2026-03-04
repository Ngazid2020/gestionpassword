<x-guest-layout>
    <style>
        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(5deg);
            }
        }

        @keyframes pulse-glow {

            0%,
            100% {
                box-shadow: 0 0 20px rgba(16, 185, 129, 0.3);
            }

            50% {
                box-shadow: 0 0 40px rgba(16, 185, 129, 0.6);
            }
        }

        @keyframes rotate-cube {
            0% {
                transform: rotateX(0deg) rotateY(0deg);
            }

            100% {
                transform: rotateX(360deg) rotateY(360deg);
            }
        }

        .cube-container {
            perspective: 1000px;
            width: 200px;
            height: 200px;
            margin: 0 auto;
        }

        .cube {
            position: relative;
            width: 100%;
            height: 100%;
            transform-style: preserve-3d;
            animation: rotate-cube 20s linear infinite;
        }

        .cube-face {
            position: absolute;
            width: 200px;
            height: 200px;
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.2), rgba(20, 184, 166, 0.3));
            border: 2px solid rgba(16, 185, 129, 0.5);
            backdrop-filter: blur(10px);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
        }

        .cube-face.front {
            transform: translateZ(100px);
        }

        .cube-face.back {
            transform: rotateY(180deg) translateZ(100px);
        }

        .cube-face.right {
            transform: rotateY(90deg) translateZ(100px);
        }

        .cube-face.left {
            transform: rotateY(-90deg) translateZ(100px);
        }

        .cube-face.top {
            transform: rotateX(90deg) translateZ(100px);
        }

        .cube-face.bottom {
            transform: rotateX(-90deg) translateZ(100px);
        }

        .floating-icon {
            animation: float 3s ease-in-out infinite;
        }

        .security-badge {
            animation: pulse-glow 2s ease-in-out infinite;
        }

        .gradient-text {
            background: linear-gradient(135deg, #10b981, #14b8a6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        input:focus {
            transform: translateY(-2px);
            transition: all 0.3s ease;
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
            .cube-container {
                width: 120px;
                height: 120px;
            }

            .cube-face {
                width: 120px;
                height: 120px;
                font-size: 2rem;
            }

            .cube-face.front {
                transform: translateZ(60px);
            }

            .cube-face.back {
                transform: rotateY(180deg) translateZ(60px);
            }

            .cube-face.right {
                transform: rotateY(90deg) translateZ(60px);
            }

            .cube-face.left {
                transform: rotateY(-90deg) translateZ(60px);
            }

            .cube-face.top {
                transform: rotateX(90deg) translateZ(60px);
            }

            .cube-face.bottom {
                transform: rotateX(-90deg) translateZ(60px);
            }
        }
    </style>

    <div class="min-h-screen flex bg-gradient-to-br from-slate-50 to-slate-100 dark:from-gray-900 dark:to-gray-800">
        <!-- Section gauche - Animation 3D -->
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

            <div class="z-10 text-center">
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

                <h2 class="text-4xl font-bold text-white mb-4">Sécurité Enterprise</h2>
                <p class="text-emerald-100 text-lg max-w-md mx-auto px-8">
                    Vos accès critiques protégés par un chiffrement militaire AES-256
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

        <!-- Section droite - Formulaire -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-6">
            <div class="w-full max-w-md">
                <div class="text-center mb-6">
                    <h1 class="text-4xl font-bold dark:text-white mb-2">
                        La<span class="gradient-text font-extrabold">kile</span>
                    </h1>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">
                        Coffre-fort numérique d'entreprise
                    </p>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl border border-gray-100 dark:border-gray-700 p-8">
                    <div class="mb-6">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Connexion</h2>
                        <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Accédez à votre coffre-fort</p>
                    </div>

                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <form method="POST" action="{{ route('login') }}" class="space-y-4">
                        @csrf

                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Email</label>
                            <input
                                id="email"
                                type="email"
                                name="email"
                                :value="old('email')"
                                required
                                autofocus
                                autocomplete="username"
                                class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all"
                                placeholder="vous@entreprise.com" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Mot de passe</label>
                            <input
                                id="password"
                                type="password"
                                name="password"
                                required
                                autocomplete="current-password"
                                class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all"
                                placeholder="••••••••" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-between text-sm">
                            <label for="remember_me" class="flex items-center cursor-pointer group">
                                <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 rounded border-gray-300 dark:border-gray-600 text-emerald-600 focus:ring-emerald-500 focus:ring-2" />
                                <span class="ml-2 text-gray-600 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white transition">Se souvenir</span>
                            </label>

                            @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="font-medium text-emerald-600 hover:text-emerald-700 dark:text-emerald-400 dark:hover:text-emerald-300 transition">
                                Mot de passe oublié ?
                            </a>
                            @endif
                        </div>

                        <button type="submit" class="w-full btn-lakile text-white font-semibold py-3 rounded-xl shadow-lg flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                            </svg>
                            <span>Se connecter</span>
                        </button>
                    </form>

                    <div class="relative my-6">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-200 dark:border-gray-700"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white dark:bg-gray-800 text-gray-500 dark:text-gray-400">ou</span>
                        </div>
                    </div>

                    <div class="text-center">
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            Pas encore de compte ?
                            <a href="{{ route('register') }}" class="font-semibold text-emerald-600 hover:text-emerald-700 dark:text-emerald-400 dark:hover:text-emerald-300 ml-1">
                                Essai gratuit 14 jours →
                            </a>
                        </p>
                    </div>
                </div>

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
</x-guest-layout>