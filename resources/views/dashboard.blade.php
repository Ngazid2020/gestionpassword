<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-bold bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 bg-clip-text text-transparent">
            🔐 Mes Comptes
        </h2>
    </x-slot>

    {{-- ══════════════════════════════════════════════════════
     STYLES CUSTOM
══════════════════════════════════════════════════════ --}}
    <style>
        /* Sidebar sticky scroll */
        .sidebar-sticky {
            position: sticky;
            top: 1.5rem;
            max-height: calc(100vh - 5rem);
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: rgba(99, 102, 241, .25) transparent;
        }

        .sidebar-sticky::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-sticky::-webkit-scrollbar-thumb {
            background: rgba(99, 102, 241, .25);
            border-radius: 4px;
        }

        /* Score gauge */
        .gauge-ring {
            transform: rotate(-90deg);
            transform-origin: 50% 50%;
        }

        @keyframes strokeIn {
            from {
                stroke-dashoffset: 220;
            }
        }

        .gauge-arc {
            animation: strokeIn .9s .3s ease both;
        }

        /* Pulse dot */
        @keyframes pulseDot {

            0%,
            100% {
                opacity: 1;
                transform: scale(1);
            }

            50% {
                opacity: .4;
                transform: scale(.75);
            }
        }

        .pulse-dot {
            animation: pulseDot 2s infinite;
        }

        /* Barre de progression */
        @keyframes barGrow {
            from {
                width: 0;
            }
        }

        .bar-anim {
            animation: barGrow .8s ease both;
        }

        /* Card hover lift */
        .account-card {
            transition: transform .35s cubic-bezier(.34, .9, .64, 1), box-shadow .35s ease;
        }

        .account-card:hover {
            transform: translateY(-4px) scale(1.01);
        }

        /* Fade up au chargement */
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(16px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-up {
            animation: fadeUp .5s ease both;
        }
    </style>

    {{-- ══════════════════════════════════════════════════════
     BOUTON CRÉATION (inchangé)
══════════════════════════════════════════════════════ --}}
    <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 flex justify-end">
        <livewire:create-account-modal wire:key="accountModal" />
    </div>

    {{-- ══════════════════════════════════════════════════════
     PAGE PRINCIPALE
══════════════════════════════════════════════════════ --}}
    <div class="min-h-screen bg-gradient-to-br from-gray-100 via-indigo-50 to-purple-100
            dark:from-gray-950 dark:via-gray-900 dark:to-gray-950 py-8">

        <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- ──────────────────────────────────────────────
             WRAPPER : flex sur lg+, colonne sur mobile
        ────────────────────────────────────────────── --}}
            <div class="flex flex-col lg:flex-row gap-7 items-start">

                {{-- ══════════════════════════════════════════
                 SIDEBAR GAUCHE — se place en haut sur mobile
            ══════════════════════════════════════════ --}}
                <aside class="w-full lg:w-72 xl:w-80 flex-shrink-0 sidebar-sticky
                          fade-up" style="animation-delay:.05s">

                    {{-- ── Widget 1 : Score de sécurité ── --}}
                    <div class="rounded-2xl bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl
                            border border-white/60 dark:border-gray-700/60
                            shadow-lg p-5 mb-4">

                        <div class="flex items-center gap-2 mb-4">
                            <span class="text-lg">🛡️</span>
                            <h3 class="font-bold text-gray-800 dark:text-white text-sm tracking-wide uppercase">
                                Score de sécurité
                            </h3>
                        </div>

                        {{-- Jauge circulaire SVG --}}
                        <div class="flex items-center justify-center mb-4">
                            <div class="relative w-32 h-32">
                                <svg viewBox="0 0 80 80" class="w-full h-full" aria-hidden="true">
                                    {{-- fond --}}
                                    <circle cx="40" cy="40" r="35"
                                        fill="none" stroke="currentColor"
                                        stroke-width="6"
                                        class="text-gray-200 dark:text-gray-700" />
                                    {{-- arc dynamique (score 78 / 100 → offset = 220*(1-.78) = 48.4) --}}
                                    <circle cx="40" cy="40" r="35"
                                        fill="none"
                                        stroke="url(#scoreGrad)"
                                        stroke-width="6"
                                        stroke-linecap="round"
                                        stroke-dasharray="220"
                                        stroke-dashoffset="48"
                                        class="gauge-ring gauge-arc" />
                                    <defs>
                                        <linearGradient id="scoreGrad" x1="0%" y1="0%" x2="100%" y2="0%">
                                            <stop offset="0%" stop-color="#6366f1" />
                                            <stop offset="100%" stop-color="#ec4899" />
                                        </linearGradient>
                                    </defs>
                                </svg>
                                <div class="absolute inset-0 flex flex-col items-center justify-center">
                                    <span class="text-3xl font-black text-gray-800 dark:text-white leading-none">78</span>
                                    <span class="text-xs text-gray-400 font-medium mt-0.5">/ 100</span>
                                </div>
                            </div>
                        </div>

                        {{-- Barres indicatrices --}}
                        <div class="space-y-2.5">
                            @php
                            $health = [
                            ['label' => 'Mots de passe forts', 'pct' => 72, 'color' => 'from-indigo-500 to-purple-500'],
                            ['label' => 'Comptes avec URL', 'pct' => 60, 'color' => 'from-purple-500 to-pink-500'],
                            ['label' => 'Catégorisés', 'pct' => 90, 'color' => 'from-pink-500 to-rose-400'],
                            ];
                            @endphp
                            @foreach($health as $h)
                            <div>
                                <div class="flex justify-between text-xs text-gray-500 dark:text-gray-400 mb-1">
                                    <span>{{ $h['label'] }}</span>
                                    <span class="font-semibold">{{ $h['pct'] }}%</span>
                                </div>
                                <div class="h-1.5 rounded-full bg-gray-200 dark:bg-gray-700 overflow-hidden">
                                    <div class="h-full rounded-full bg-gradient-to-r {{ $h['color'] }} bar-anim"
                                        style="width:{{ $h['pct'] }}%"></div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- ── Widget 2 : Statistiques rapides ── --}}
                    <div class="rounded-2xl bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl
                            border border-white/60 dark:border-gray-700/60
                            shadow-lg p-5 mb-4">

                        <div class="flex items-center gap-2 mb-4">
                            <span class="text-lg">📊</span>
                            <h3 class="font-bold text-gray-800 dark:text-white text-sm tracking-wide uppercase">
                                Statistiques
                            </h3>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            @php
                            $stats = [
                            ['icon' => '🔑', 'val' => $accounts->count(), 'label' => 'Comptes', 'grad' => 'from-indigo-500 to-purple-500'],
                            ['icon' => '🗂️', 'val' => $accounts->unique('category_id')->count(), 'label' => 'Catégories', 'grad' => 'from-purple-500 to-pink-500'],
                            ['icon' => '📅', 'val' => $accounts->where('created_at', '>=', now()->startOfMonth())->count(), 'label' => 'Ce mois', 'grad' => 'from-pink-500 to-rose-400'],
                            ['icon' => '✅', 'val' => $accounts->whereNotNull('url')->count(), 'label' => 'Avec URL', 'grad' => 'from-emerald-400 to-teal-500'],
                            ];
                            @endphp
                            @foreach($stats as $s)
                            <div class="rounded-xl p-3
                                    bg-gradient-to-br {{ $s['grad'] }} bg-opacity-10
                                    border border-white/40 dark:border-gray-700/50">
                                <div class="text-xl mb-1">{{ $s['icon'] }}</div>
                                <div class="text-2xl font-black text-gray-800 dark:text-white leading-none">
                                    {{ $s['val'] }}
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">{{ $s['label'] }}</div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- ── Widget 3 : Activité récente ── --}}
                    <div class="rounded-2xl bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl
                            border border-white/60 dark:border-gray-700/60
                            shadow-lg p-5 mb-4">

                        <div class="flex items-center gap-2 mb-4">
                            <span class="text-lg">⚡</span>
                            <h3 class="font-bold text-gray-800 dark:text-white text-sm tracking-wide uppercase">
                                Activité récente
                            </h3>
                        </div>

                        <div class="space-y-3">
                            @forelse($accounts->sortByDesc('updated_at')->take(4) as $recent)
                            <div class="flex items-center gap-3">
                                {{-- Icône initiale --}}
                                <div class="w-8 h-8 rounded-xl flex-shrink-0
                                        bg-gradient-to-br from-indigo-500 to-purple-600
                                        flex items-center justify-center
                                        text-white font-bold text-xs shadow">
                                    {{ strtoupper(substr($recent->name, 0, 1)) }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="text-xs font-semibold text-gray-700 dark:text-gray-200 truncate">
                                        {{ $recent->name }}
                                    </div>
                                    <div class="text-xs text-gray-400">
                                        Maj {{ $recent->updated_at->diffForHumans() }}
                                    </div>
                                </div>
                                <div class="w-1.5 h-1.5 rounded-full pulse-dot
                                        bg-indigo-500 flex-shrink-0"></div>
                            </div>
                            @empty
                            <p class="text-xs text-gray-400 text-center py-2">Aucune activité</p>
                            @endforelse
                        </div>
                    </div>

                    {{-- ── Widget 4 : Alerte sécurité ── --}}
                    <div class="rounded-2xl p-[1px]
                            bg-gradient-to-br from-amber-400 via-orange-500 to-rose-500
                            shadow-lg mb-4">
                        <div class="rounded-2xl bg-white/90 dark:bg-gray-900/90 backdrop-blur-xl p-5">

                            <div class="flex items-center gap-2 mb-3">
                                <span class="text-lg">⚠️</span>
                                <h3 class="font-bold text-gray-800 dark:text-white text-sm tracking-wide uppercase">
                                    Alertes
                                </h3>
                            </div>

                            <div class="space-y-2">
                                @php
                                $noPass = $accounts->whereNull('password')->count();
                                $noUrl = $accounts->whereNull('url')->count();
                                @endphp

                                @if($noPass > 0)
                                <div class="flex items-center gap-2.5 text-xs">
                                    <span class="w-2 h-2 rounded-full bg-rose-500 flex-shrink-0 pulse-dot"></span>
                                    <span class="text-gray-600 dark:text-gray-300">
                                        <strong class="text-rose-500">{{ $noPass }}</strong>
                                        compte{{ $noPass > 1 ? 's' : '' }} sans mot de passe
                                    </span>
                                </div>
                                @endif

                                @if($noUrl > 0)
                                <div class="flex items-center gap-2.5 text-xs">
                                    <span class="w-2 h-2 rounded-full bg-amber-500 flex-shrink-0"></span>
                                    <span class="text-gray-600 dark:text-gray-300">
                                        <strong class="text-amber-500">{{ $noUrl }}</strong>
                                        compte{{ $noUrl > 1 ? 's' : '' }} sans URL
                                    </span>
                                </div>
                                @endif

                                @if($noPass === 0 && $noUrl === 0)
                                <div class="flex items-center gap-2.5 text-xs">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500 flex-shrink-0"></span>
                                    <span class="text-gray-600 dark:text-gray-300">
                                        Aucune alerte — tout est en ordre ✅
                                    </span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- ── Widget 5 : Recherche rapide ── --}}
                    <div class="rounded-2xl bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl
                            border border-white/60 dark:border-gray-700/60
                            shadow-lg p-5">

                        <div class="flex items-center gap-2 mb-3">
                            <span class="text-lg">🔍</span>
                            <h3 class="font-bold text-gray-800 dark:text-white text-sm tracking-wide uppercase">
                                Recherche
                            </h3>
                        </div>

                        <div x-data="{ q: '' }">
                            <input x-model="q"
                                type="text"
                                placeholder="Nom, identifiant…"
                                @input.debounce.300ms="$dispatch('search-accounts', { query: q })"
                                class="w-full text-sm rounded-xl px-3 py-2.5
                                      bg-gray-100 dark:bg-gray-800
                                      border border-gray-200 dark:border-gray-700
                                      text-gray-700 dark:text-gray-200
                                      placeholder-gray-400
                                      focus:outline-none focus:ring-2 focus:ring-indigo-500/50
                                      transition" />
                        </div>

                        {{-- Filtre catégorie --}}
                        @if(isset($categories) && $categories->isNotEmpty())
                        <div class="mt-3 flex flex-wrap gap-1.5">
                            <button wire:click="filterCategory(null)"
                                class="px-2.5 py-1 rounded-lg text-xs font-semibold
                                       bg-indigo-500 text-white transition hover:bg-indigo-600">
                                Tout
                            </button>
                            @foreach($categories as $cat)
                            <button wire:click="filterCategory({{ $cat->id }})"
                                class="px-2.5 py-1 rounded-lg text-xs font-semibold
                                       bg-gray-100 dark:bg-gray-800
                                       text-gray-600 dark:text-gray-300
                                       hover:bg-indigo-100 dark:hover:bg-indigo-900/40
                                       hover:text-indigo-600 dark:hover:text-indigo-400
                                       transition border border-gray-200 dark:border-gray-700">
                                {{ $cat->name }}
                            </button>
                            @endforeach
                        </div>
                        @endif
                    </div>

                </aside>
                {{-- FIN SIDEBAR --}}


                {{-- ══════════════════════════════════════════
                 CONTENU PRINCIPAL — grille 3 colonnes
                 
                 Stratégie responsive :
                 · Mobile  (< md)  : 1 colonne
                 · Tablette (md)   : 2 colonnes  ← sidebar est au-dessus
                 · Desktop  (lg+)  : sidebar à gauche, 3 colonnes à droite
                 
                 On utilise grid-cols-1 md:grid-cols-2 xl:grid-cols-3
                 La sidebar occupe ~288px, donc 3 cols restent confortables
                 dès xl (1280px+). Sur lg (1024px) on garde 2 cols pour ne
                 pas écraser les cards — on passe à 3 sur xl.
            ══════════════════════════════════════════ --}}
                <main class="flex-1 min-w-0">

                    {{-- En-tête section --}}
                    <div class="flex items-center justify-between mb-6 fade-up" style="animation-delay:.1s">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                <span class="font-semibold text-indigo-500">{{ $accounts->count() }}</span>
                                compte{{ $accounts->count() > 1 ? 's' : '' }} enregistré{{ $accounts->count() > 1 ? 's' : '' }}
                            </p>
                        </div>
                        {{-- Sort rapide --}}
                        <div class="flex items-center gap-2 text-xs text-gray-400">
                            <span>Trier par</span>
                            <button wire:click="sortBy('name')"
                                class="px-2.5 py-1 rounded-lg border border-gray-200 dark:border-gray-700
                                       bg-white/70 dark:bg-gray-800/70 hover:border-indigo-400
                                       transition font-medium text-gray-600 dark:text-gray-300">
                                Nom
                            </button>
                            <button wire:click="sortBy('updated_at')"
                                class="px-2.5 py-1 rounded-lg border border-gray-200 dark:border-gray-700
                                       bg-white/70 dark:bg-gray-800/70 hover:border-indigo-400
                                       transition font-medium text-gray-600 dark:text-gray-300">
                                Date
                            </button>
                        </div>
                    </div>

                    {{-- ── GRILLE DES CARDS ──
                     grid-cols-1          → mobile (1 col)
                     md:grid-cols-2       → tablette (sidebar au-dessus, 2 cols)
                     xl:grid-cols-3       → desktop large (sidebar à gauche, 3 cols)
                     Note : sur lg (1024–1279px) avec sidebar 288px, la zone
                     disponible est ≈ 668px → 2 cols à 304px chacune = confortable.
                     xl (1280px+) → zone ≈ 930px → 3 cols à 290px = parfait.
                ──────────────────────────────────────────── --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">

                        @forelse($accounts as $i => $account)

                        {{-- Card individuelle --}}
                        <div x-data="{ showPassword: false }"
                            class="account-card relative group rounded-3xl p-[1px]
                                bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500
                                hover:from-pink-500 hover:via-purple-500 hover:to-indigo-500
                                transition-all duration-500 fade-up"
                            style="animation-delay:{{ 0.1 + $i * 0.06 }}s">

                            <div class="rounded-3xl bg-white/90 dark:bg-gray-900/90 backdrop-blur-xl
                                    p-6 h-full shadow-xl group-hover:shadow-2xl
                                    transition-all duration-500">

                                {{-- HEADER card --}}
                                
                                <div class="flex items-center gap-4 mb-4">
                                    {{-- Conteneur de l'icône --}}
                                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 
                flex items-center justify-center shadow-lg text-white font-bold text-lg 
                group-hover:scale-110 transition duration-300 overflow-hidden relative">

                                        @if($account->favicon_url)
                                        <img src="{{ $account->favicon_url }}"
                                            alt="{{ $account->name }}"
                                            class="w-full h-full object-contain p-2 bg-white/10 transition-opacity duration-300"
                                            onload="this.style.opacity='1'"
                                            style="opacity: 0;"
                                            onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                        @endif

                                        {{-- Fallback : Initiale (affichée si pas de favicon_url OU si l'image onerror est déclenché) --}}
                                        <span class="flex items-center justify-center w-full h-full {{ $account->favicon_url ? 'hidden' : '' }}">
                                            {{ strtoupper(substr($account->name, 0, 1)) }}
                                        </span>
                                    </div>

                                    {{-- Titre et Lien --}}
                                    <div>
                                        <h3 class="font-bold text-lg text-gray-800 dark:text-white leading-tight">
                                            {{ $account->name }}
                                        </h3>
                                        @if($account->url)
                                        <a href="{{ $account->url }}" target="_blank"
                                            class="text-xs text-indigo-500 hover:text-pink-500 transition">
                                            {{ parse_url($account->url, PHP_URL_HOST) ?? $account->url }}
                                        </a>
                                        @endif
                                    </div>
                                </div>

                                {{-- CATÉGORIE --}}
                                @if($account->category)
                                <div class="mt-4">
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full
                                        bg-gradient-to-r from-indigo-500 to-purple-500
                                        text-white shadow-md">
                                        {{ $account->category->name }}
                                    </span>
                                </div>
                                @endif

                                {{-- IDENTIFIANT --}}
                                <div class="mt-4">
                                    <span class="text-xs uppercase tracking-wider text-gray-400">Identifiant</span>
                                    <div class="flex justify-between items-center mt-1.5
                                            bg-gray-100 dark:bg-gray-800 rounded-xl px-3 py-2">
                                        <span class="text-sm text-gray-700 dark:text-gray-300 truncate">
                                            {{ $account->identifiant }}
                                        </span>
                                        <button onclick="
                                        navigator.clipboard.writeText('{{ addslashes($account->identifiant) }}');
                                        this.textContent='✓Copié';
                                        setTimeout(()=>this.textContent='Copier',1500)"
                                            class="text-indigo-500 hover:text-pink-500 transition text-xs font-medium flex-shrink-0 ml-2">
                    Copier
                </button>
                                    </div>
                                </div>

                                {{-- MOT DE PASSE --}}
                                <div class="mt-3">
                                    <span class="text-xs uppercase tracking-wider text-gray-400">Mot de passe</span>
                                    <div class="flex justify-between items-center mt-1.5
                                            bg-gray-100 dark:bg-gray-800 rounded-xl px-3 py-2">
                                        <span class="text-sm text-gray-700 dark:text-gray-300 truncate">
                                            @if($account->password)
                                            <span x-show="!showPassword">••••••••</span>
                                            <span x-show="showPassword" x-cloak>{{ $account->password }}</span>
                                            @else
                                            <span class="text-rose-500 text-xs font-medium">Non défini</span>
                                            @endif
                                        </span>
                                        @if($account->password)
                                        <div class="flex gap-2 flex-shrink-0 ml-2">
                                            <button @click="showPassword = !showPassword"
                                                class="text-purple-500 hover:text-pink-500 transition text-xs font-medium"
                                                x-text="showPassword ? 'Cacher' : 'Afficher'">
                                                Afficher
                                            </button>
                                            <button onclick="
                                            navigator.clipboard.writeText('{{ addslashes($account->password) }}');
                                            this.textContent='✓Copié';
                                            setTimeout(()=>this.textContent='Copier',1500)"
                                                class="text-indigo-500 hover:text-pink-500 transition text-xs font-medium">
                    Copier
                </button>
                                        </div>
                                        @endif
                                    </div>
                                </div>

                                {{-- FOOTER card --}}
                                <div class="mt-5 pt-4 border-t border-gray-200 dark:border-gray-700
                                        flex justify-between items-center text-xs text-gray-400">
                                    <span>Créé {{ $account->created_at->format('d/m/Y') }}</span>
                                    <div class="flex items-center gap-2">
                                        <span>Maj {{ $account->updated_at->format('d/m/Y') }}</span>
                                        <button
                                            wire:click="$dispatch('editAccount', { id: {{ $account->id }} })"
                                            class="px-3 py-1 rounded-lg text-xs font-semibold
                                               bg-yellow-100 text-yellow-700
                                               hover:bg-yellow-500 hover:text-white
                                               transition duration-300">
                                            Modifier
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </div>
                        {{-- FIN CARD --}}

                        @empty

                        <div class="col-span-full flex flex-col items-center justify-center
                                py-20 text-center fade-up">
                            <div class="text-6xl mb-4">🔐</div>
                            <p class="text-xl font-semibold text-gray-500 dark:text-gray-400">
                                Aucun compte trouvé
                            </p>
                            <p class="text-sm text-gray-400 dark:text-gray-500 mt-1">
                                Commencez par ajouter votre premier compte.
                            </p>
                        </div>

                        @endforelse

                    </div>
                    {{-- FIN GRILLE --}}

                </main>
                {{-- FIN MAIN --}}

            </div>
            {{-- FIN WRAPPER flex --}}

        </div>
    </div>

</x-app-layout>