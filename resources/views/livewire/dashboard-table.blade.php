<div class="min-h-screen bg-gradient-to-br from-gray-100 via-indigo-50 to-purple-100
            dark:from-gray-950 dark:via-gray-900 dark:to-gray-950 py-4 sm:py-6 lg:py-8">

    <div class="max-w-screen-2xl mx-auto px-3 sm:px-4 lg:px-8">

        {{-- ──────────────────────────────────────────────
             WRAPPER : flex sur lg+, colonne sur mobile
        ────────────────────────────────────────────── --}}
        <div class="flex flex-col lg:flex-row gap-4 sm:gap-6 lg:gap-7 items-start">

            {{-- ══════════════════════════════════════════
                 SIDEBAR GAUCHE — collapsible sur mobile
            ══════════════════════════════════════════ --}}
            <aside x-data="{ sidebarOpen: false }"
                class="w-full lg:w-72 xl:w-80 flex-shrink-0 fade-up"
                style="animation-delay:.05s">

                {{-- Toggle button pour mobile uniquement --}}
                <button @click="sidebarOpen = !sidebarOpen"
                    class="w-full mb-3 px-4 py-3 rounded-xl
                           bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl
                           border border-white/60 dark:border-gray-700/60
                           shadow-lg flex items-center justify-between
                           text-gray-700 dark:text-gray-200 font-semibold">
                    <span class="flex items-center gap-2">
                        <span class="text-lg">📊</span>
                        <span>Tableau de bord</span>
                    </span>
                    <svg class="w-5 h-5 transition-transform duration-300"
                        :class="sidebarOpen ? 'rotate-180' : ''"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                {{-- Contenu de la sidebar --}}
                <div class="sidebar-sticky"
                    :class="sidebarOpen ? 'sidebar-expanded' : 'sidebar-collapsed lg:sidebar-expanded'">

                    {{-- ── Widget 1 : Score de sécurité ── --}}
                    <div class="rounded-2xl bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl
                                border border-white/60 dark:border-gray-700/60
                                shadow-lg p-4 sm:p-5 mb-3 sm:mb-4">

                        <div class="flex items-center gap-2 mb-3 sm:mb-4">
                            <span class="text-base sm:text-lg">🛡️</span>
                            <h3 class="font-bold text-gray-800 dark:text-white text-xs sm:text-sm tracking-wide uppercase">
                                Score de sécurité
                            </h3>
                        </div>

                        {{-- Jauge circulaire SVG --}}
                        <div class="flex items-center justify-center mb-3 sm:mb-4">
                            <div class="relative w-28 h-28 sm:w-32 sm:h-32">
                                <svg viewBox="0 0 80 80" class="w-full h-full" aria-hidden="true">
                                    <circle cx="40" cy="40" r="35"
                                        fill="none" stroke="currentColor"
                                        stroke-width="6"
                                        class="text-gray-200 dark:text-gray-700" />
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
                                    <span class="text-2xl sm:text-3xl font-black text-gray-800 dark:text-white leading-none">78</span>
                                    <span class="text-xs text-gray-400 font-medium mt-0.5">/ 100</span>
                                </div>
                            </div>
                        </div>

                        {{-- Barres indicatrices --}}
                        <div class="space-y-2 sm:space-y-2.5">
                            @php
                            $health = [
                                ['label' => 'Mots de passe forts', 'pct' => 72, 'color' => 'from-indigo-500 to-purple-500'],
                                ['label' => 'Comptes avec URL',    'pct' => 60, 'color' => 'from-purple-500 to-pink-500'],
                                ['label' => 'Catégorisés',         'pct' => 90, 'color' => 'from-pink-500 to-rose-400'],
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
                                shadow-lg p-4 sm:p-5 mb-3 sm:mb-4">

                        <div class="flex items-center gap-2 mb-3 sm:mb-4">
                            <span class="text-base sm:text-lg">📊</span>
                            <h3 class="font-bold text-gray-800 dark:text-white text-xs sm:text-sm tracking-wide uppercase">
                                Statistiques
                            </h3>
                        </div>

                        <div class="grid grid-cols-2 gap-2 sm:gap-3">
                            @php
                            $stats = [
                                ['icon' => '🔑', 'val' => $accounts->count(),                                          'label' => 'Comptes',    'grad' => 'from-indigo-500 to-purple-500'],
                                ['icon' => '🗂️', 'val' => $accounts->unique('category_id')->count(),                   'label' => 'Catégories', 'grad' => 'from-purple-500 to-pink-500'],
                                ['icon' => '📅', 'val' => $accounts->where('created_at', '>=', now()->startOfMonth())->count(), 'label' => 'Ce mois',    'grad' => 'from-pink-500 to-rose-400'],
                                ['icon' => '✅', 'val' => $accounts->whereNotNull('url')->count(),                     'label' => 'Avec URL',   'grad' => 'from-emerald-400 to-teal-500'],
                            ];
                            @endphp
                            @foreach($stats as $s)
                            <div class="rounded-xl p-2.5 sm:p-3
                                        bg-gradient-to-br {{ $s['grad'] }} bg-opacity-10
                                        border border-white/40 dark:border-gray-700/50">
                                <div class="text-lg sm:text-xl mb-1">{{ $s['icon'] }}</div>
                                <div class="text-xl sm:text-2xl font-black text-gray-800 dark:text-white leading-none">
                                    {{ $s['val'] }}
                                </div>
                                <div class="text-xs text-gray-500 dark:text-white mt-0.5">{{ $s['label'] }}</div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- ── Widget 3 : Activité récente ── --}}
                    <div class="rounded-2xl bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl
                                border border-white/60 dark:border-gray-700/60
                                shadow-lg p-4 sm:p-5 mb-3 sm:mb-4">

                        <div class="flex items-center gap-2 mb-3 sm:mb-4">
                            <span class="text-base sm:text-lg">⚡</span>
                            <h3 class="font-bold text-gray-800 dark:text-white text-xs sm:text-sm tracking-wide uppercase">
                                Activité récente
                            </h3>
                        </div>

                        <div class="space-y-2.5 sm:space-y-3">
                            @forelse($accounts->sortByDesc('updated_at')->take(4) as $recent)
                            <div class="flex items-center gap-2.5 sm:gap-3">
                                <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-xl flex-shrink-0
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
                                <div class="w-1.5 h-1.5 rounded-full pulse-dot bg-indigo-500 flex-shrink-0"></div>
                            </div>
                            @empty
                            <p class="text-xs text-gray-400 text-center py-2">Aucune activité</p>
                            @endforelse
                        </div>
                    </div>

                    {{-- ── Widget 4 : Alertes sécurité ── --}}
                    <div class="rounded-2xl p-[1px]
                                bg-gradient-to-br from-amber-400 via-orange-500 to-rose-500
                                shadow-lg mb-3 sm:mb-4">
                        <div class="rounded-2xl bg-white/90 dark:bg-gray-900/90 backdrop-blur-xl p-4 sm:p-5">

                            <div class="flex items-center gap-2 mb-3">
                                <span class="text-base sm:text-lg">⚠️</span>
                                <h3 class="font-bold text-gray-800 dark:text-white text-xs sm:text-sm tracking-wide uppercase">
                                    Alertes
                                </h3>
                            </div>

                            <div class="space-y-2">
                                @php
                                $noPass = $accounts->whereNull('password')->count();
                                $noUrl  = $accounts->whereNull('url')->count();
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

                    {{-- ── Widget 5 : Filtres catégorie ── --}}
                    @if(isset($categories) && $categories->isNotEmpty())
                    <div class="rounded-2xl bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl
                                border border-white/60 dark:border-gray-700/60
                                shadow-lg p-4 sm:p-5">

                        <div class="flex items-center gap-2 mb-3">
                            <span class="text-base sm:text-lg">🗂️</span>
                            <h3 class="font-bold text-gray-800 dark:text-white text-xs sm:text-sm tracking-wide uppercase">
                                Catégories
                            </h3>
                        </div>

                        <div class="flex flex-wrap gap-1.5">
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
                    </div>
                    @endif

                </div>
                {{-- FIN contenu sidebar --}}

            </aside>
            {{-- FIN SIDEBAR --}}


            {{-- ══════════════════════════════════════════
                 CONTENU PRINCIPAL — grille responsive
            ══════════════════════════════════════════ --}}
            <main class="flex-1 min-w-0">

                {{-- ── BARRE DE RECHERCHE PRINCIPALE ── --}}
                <div class="mb-6 fade-up" style="animation-delay:.05s">
                    <div class="relative group">
                        <div class="absolute -inset-0.5 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-2xl blur opacity-20 group-focus-within:opacity-50 transition duration-300"></div>
                        <div class="relative flex items-center">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                                <svg class="h-5 w-5 text-gray-400 group-focus-within:text-indigo-500 transition-colors" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input
                                wire:model.live.debounce.300ms="search"
                                type="text"
                                class="block w-full rounded-2xl border-0 py-3.5 pl-11 pr-4
                                       text-gray-900 dark:text-white
                                       bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl
                                       ring-1 ring-inset ring-gray-300/50 dark:ring-gray-700/50
                                       placeholder:text-gray-400
                                       focus:ring-2 focus:ring-inset focus:ring-indigo-600
                                       sm:text-sm shadow-sm transition-all"
                                placeholder="Rechercher un compte, une URL ou un identifiant...">

                            <div wire:loading wire:target="search" class="absolute right-4">
                                <svg class="animate-spin h-5 w-5 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ── EN-TÊTE SECTION ── --}}
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 sm:gap-0 mb-6 fade-up"
                    style="animation-delay:.1s">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            <span class="font-semibold text-indigo-500">{{ $accounts->count() }}</span>
                            compte{{ $accounts->count() > 1 ? 's' : '' }} enregistré{{ $accounts->count() > 1 ? 's' : '' }}
                        </p>
                    </div>
                    <div class="flex items-center gap-2 text-xs text-gray-400">
                        <span class="hidden sm:inline">Trier par</span>
                        <button wire:click="sortBy('name')"
                            class="px-2.5 py-1.5 sm:py-1 rounded-lg border border-gray-200 dark:border-gray-700
                                   bg-white/70 dark:bg-gray-800/70 hover:border-indigo-400
                                   transition font-medium text-gray-600 dark:text-gray-300">
                            Nom
                        </button>
                        <button wire:click="sortBy('updated_at')"
                            class="px-2.5 py-1.5 sm:py-1 rounded-lg border border-gray-200 dark:border-gray-700
                                   bg-white/70 dark:bg-gray-800/70 hover:border-indigo-400
                                   transition font-medium text-gray-600 dark:text-gray-300">
                            Date
                        </button>
                    </div>
                </div>

                {{-- ── GRILLE DES CARDS ── --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4 sm:gap-5 lg:gap-6">

                    @forelse($accounts as $i => $account)

                    {{-- revealedPassword : null par défaut, jamais dans le HTML source --}}
                    <div x-data="{ showPassword: false, revealedPassword: null }"
                        x-on:password-revealed-{{ $account->id }}.window="
                            revealedPassword = $event.detail.password;
                            showPassword = true
                        "
                        class="account-card relative group rounded-2xl sm:rounded-3xl p-[1px]
                               bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500
                               hover:from-pink-500 hover:via-purple-500 hover:to-indigo-500
                               transition-all duration-500 fade-up"
                        style="animation-delay:{{ 0.1 + $i * 0.06 }}s">

                        <div class="rounded-2xl sm:rounded-3xl bg-white/90 dark:bg-gray-900/90 backdrop-blur-xl
                                    p-4 sm:p-5 lg:p-6 h-full shadow-xl group-hover:shadow-2xl
                                    transition-all duration-500">

                            {{-- HEADER card --}}
                            <div class="flex items-start gap-3 sm:gap-4 mb-3 sm:mb-4">

                                {{-- Icône / Favicon --}}
                                <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-xl sm:rounded-2xl
                                            bg-gradient-to-br from-indigo-500 to-purple-600
                                            flex items-center justify-center shadow-lg text-white
                                            font-bold text-base sm:text-lg
                                            group-hover:scale-110 transition duration-300
                                            overflow-hidden relative flex-shrink-0">

                                    @if($account->favicon_url)
                                    <img src="{{ $account->favicon_url }}"
                                        alt="{{ $account->name }}"
                                        class="w-full h-full object-contain p-2 bg-white/10 transition-opacity duration-300"
                                        onload="this.style.opacity='1'"
                                        style="opacity: 0;"
                                        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    @endif

                                    <span class="flex items-center justify-center w-full h-full {{ $account->favicon_url ? 'hidden' : '' }}">
                                        {{ strtoupper(substr($account->name, 0, 1)) }}
                                    </span>
                                </div>

                                {{-- Titre et lien --}}
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-bold text-base sm:text-lg text-gray-800 dark:text-white leading-tight truncate">
                                        {{ $account->name }}
                                    </h3>
                                    @if($account->url)
                                    <a href="{{ $account->url }}" target="_blank"
                                        class="text-xs text-indigo-500 hover:text-pink-500 transition truncate block">
                                        {{ parse_url($account->url, PHP_URL_HOST) ?? $account->url }}
                                    </a>
                                    @endif
                                </div>

                                {{-- Bouton Edit — dispatch sur window, pas d'aller-retour serveur --}}
                                <button
                                    @click="window.dispatchEvent(new CustomEvent('openEditModal', { detail: { account: {{ $account->id }} } }))"
                                    class="p-2 rounded-lg sm:rounded-xl bg-gray-100/50 dark:bg-gray-800/50
                                           text-gray-400 hover:text-indigo-500 hover:bg-indigo-50
                                           dark:hover:bg-indigo-900/30 transition-all duration-200
                                           border border-transparent hover:border-indigo-200/50 flex-shrink-0"
                                    title="Modifier">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                            </div>

                            {{-- CATÉGORIE --}}
                            @if($account->category)
                            <div class="mt-3 sm:mt-4">
                                <span class="inline-block px-2.5 sm:px-3 py-1 text-xs font-semibold rounded-full
                                             bg-gradient-to-r from-indigo-500 to-purple-500
                                             text-white shadow-md">
                                    {{ $account->category->name }}
                                </span>
                            </div>
                            @endif

                            {{-- IDENTIFIANT --}}
                            <div class="mt-3 sm:mt-4">
                                <span class="text-xs uppercase tracking-wider text-gray-400">Identifiant</span>
                                <div class="flex justify-between items-center gap-2 mt-1.5
                                            bg-gray-100 dark:bg-gray-800 rounded-lg sm:rounded-xl px-3 py-2">
                                    <span class="text-sm text-gray-700 dark:text-gray-300 truncate flex-1 min-w-0">
                                        {{ $account->identifiant }}
                                    </span>
                                    <button onclick="
                                            navigator.clipboard.writeText('{{ addslashes($account->identifiant) }}');
                                            this.textContent='✓';
                                            setTimeout(()=>this.textContent='Copier',1500)"
                                        class="text-indigo-500 hover:text-pink-500 transition text-xs
                                               font-medium flex-shrink-0 whitespace-nowrap">
                                        Copier
                                    </button>
                                </div>
                            </div>

                            {{-- MOT DE PASSE
                                 ⚠️  Aucune valeur PHP ici — le mot de passe n'est JAMAIS
                                 dans le HTML source. Il arrive uniquement via l'event
                                 Livewire `revealPassword` et est stocké dans Alpine (JS).
                            --}}
                            <div class="mt-3">
                                <span class="text-xs uppercase tracking-wider text-gray-400">Mot de passe</span>
                                <div class="flex justify-between items-center gap-2 mt-1.5
                                            bg-gray-100 dark:bg-gray-800 rounded-lg sm:rounded-xl px-3 py-2">
                                    <span class="text-sm text-gray-700 dark:text-gray-300 truncate flex-1 min-w-0">
                                        {{-- Masqué par défaut --}}
                                        <span x-show="!showPassword">••••••••</span>
                                        {{-- Affiché uniquement après fetch Livewire --}}
                                        <span x-show="showPassword" x-cloak
                                              x-text="revealedPassword"
                                              class="break-all"></span>
                                    </span>
                                    <div class="flex gap-1.5 sm:gap-2 flex-shrink-0 whitespace-nowrap">
                                        {{-- Voir : appelle le serveur la 1ère fois, bascule ensuite --}}
                                        <button
                                            @click="
                                                if (showPassword) {
                                                    showPassword = false;
                                                } else if (revealedPassword) {
                                                    showPassword = true;
                                                } else {
                                                    $wire.revealPassword({{ $account->id }});
                                                }
                                            "
                                            class="text-purple-500 hover:text-pink-500 transition text-xs font-medium"
                                            x-text="showPassword ? 'Cacher' : 'Voir'">
                                            Voir
                                        </button>
                                        {{-- Copier : utilise la variable Alpine, jamais le DOM --}}
                                        <button
                                            @click="
                                                if (!revealedPassword) {
                                                    $wire.revealPassword({{ $account->id }});
                                                    $watch('revealedPassword', val => {
                                                        if (val) navigator.clipboard.writeText(val);
                                                    });
                                                } else {
                                                    navigator.clipboard.writeText(revealedPassword);
                                                }
                                                $el.textContent = '✓';
                                                setTimeout(() => $el.textContent = 'Copier', 1500)
                                            "
                                            class="text-indigo-500 hover:text-pink-500 transition text-xs font-medium">
                                            Copier
                                        </button>
                                    </div>
                                </div>
                            </div>

                            {{-- FOOTER card --}}
                            <div class="mt-4 sm:mt-5 pt-3 sm:pt-4 border-t border-gray-200 dark:border-gray-700
                                        flex flex-col sm:flex-row justify-between gap-2 sm:gap-0 sm:items-center
                                        text-xs text-gray-400">
                                <span>Créé {{ $account->created_at->format('d/m/Y') }}</span>
                                <span>Maj {{ $account->updated_at->format('d/m/Y') }}</span>
                            </div>

                        </div>
                    </div>
                    {{-- FIN CARD --}}

                    @empty
                    <div class="col-span-full flex flex-col items-center justify-center
                                py-16 sm:py-20 text-center fade-up">
                        <div class="text-5xl sm:text-6xl mb-4">🔐</div>
                        <p class="text-lg sm:text-xl font-semibold text-gray-500 dark:text-gray-400">
                            Aucun compte trouvé
                        </p>
                        <p class="text-sm text-gray-400 dark:text-gray-500 mt-1">
                            Commencez par ajouter votre premier compte.
                        </p>
                    </div>
                    @endforelse

                </div>
                {{-- FIN GRILLE --}}

                <div class="mt-8">
                    {{ $accounts->links() }}
                </div>

            </main>
            {{-- FIN MAIN --}}

        </div>
        {{-- FIN WRAPPER flex --}}

    </div>
</div>
