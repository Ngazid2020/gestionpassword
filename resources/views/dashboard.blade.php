<x-app-layout>
    {{-- BANNIÈRE ABONNEMENT --}}
@php
    $org = auth()->user()->organisations()->first();
@endphp

@if($org)
    {{-- Essai gratuit --}}
    @if($org->isOnTrial())
        <div class="max-w-screen-2xl mx-auto px-3 sm:px-4 lg:px-8 mt-4">
            <div class="flex items-center gap-3 px-5 py-3 rounded-2xl
                        bg-amber-50 dark:bg-amber-900/20
                        border border-amber-300 dark:border-amber-700 text-amber-800 dark:text-amber-300">
                <span class="text-xl">⏳</span>
                <div class="flex-1 text-sm">
                    <span class="font-bold">Période d'essai</span> —
                    @if($org->daysRemaining() === 0)
                        Votre essai expire <strong>aujourd'hui</strong>.
                    @else
                        Il vous reste <strong>{{ $org->daysRemaining() }} jour{{ $org->daysRemaining() > 1 ? 's' : '' }}</strong> d'essai gratuit.
                    @endif
                </div>
                <a href="mailto:support@azzhy.com"
                   class="text-xs font-semibold px-3 py-1.5 rounded-lg
                          bg-amber-200 dark:bg-amber-800 hover:bg-amber-300 dark:hover:bg-amber-700 transition">
                    Passer au Pro →
                </a>
            </div>
        </div>

    {{-- Abonnement actif --}}
    @elseif($org->subscription_status === 'active')
        @if($org->daysRemaining() <= 7)
        <div class="max-w-screen-2xl mx-auto px-3 sm:px-4 lg:px-8 mt-4">
            <div class="flex items-center gap-3 px-5 py-3 rounded-2xl
                        bg-orange-50 dark:bg-orange-900/20
                        border border-orange-300 dark:border-orange-700 text-orange-800 dark:text-orange-300">
                <span class="text-xl">🔔</span>
                <div class="flex-1 text-sm">
                    <span class="font-bold">Abonnement</span> —
                    Il vous reste <strong>{{ $org->daysRemaining() }} jour{{ $org->daysRemaining() > 1 ? 's' : '' }}</strong> avant expiration.
                    Contactez votre administrateur pour renouveler.
                </div>
            </div>
        </div>
        @else
        <div class="max-w-screen-2xl mx-auto px-3 sm:px-4 lg:px-8 mt-4">
            <div class="flex items-center gap-3 px-5 py-3 rounded-2xl
                        bg-emerald-50 dark:bg-emerald-900/20
                        border border-emerald-300 dark:border-emerald-700 text-emerald-800 dark:text-emerald-300">
                <span class="text-xl">✅</span>
                <div class="flex-1 text-sm">
                    <span class="font-bold">Abonnement actif</span> —
                    Il vous reste <strong>{{ $org->daysRemaining() }} jour{{ $org->daysRemaining() > 1 ? 's' : '' }}</strong>
                    ({{ ucfirst($org->plan) }}).
                </div>
            </div>
        </div>
        @endif

    {{-- Expiré --}}
    @elseif($org->isExpired())
        <div class="max-w-screen-2xl mx-auto px-3 sm:px-4 lg:px-8 mt-4">
            <div class="flex items-center gap-3 px-5 py-3 rounded-2xl
                        bg-red-50 dark:bg-red-900/20
                        border border-red-300 dark:border-red-700 text-red-800 dark:text-red-300">
                <span class="text-xl">❌</span>
                <div class="flex-1 text-sm">
                    <span class="font-bold">Abonnement expiré</span> —
                    Contactez votre administrateur pour renouveler votre accès.
                </div>
                <a href="mailto:support@azzhy.com"
                   class="text-xs font-semibold px-3 py-1.5 rounded-lg
                          bg-red-200 dark:bg-red-800 hover:bg-red-300 dark:hover:bg-red-700 transition">
                    Renouveler
                </a>
            </div>
        </div>
    @endif
@endif
    <x-slot name="title">Tableau de bord</x-slot>
    <x-slot name="header">
        <h2 class="text-2xl sm:text-3xl font-bold bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 bg-clip-text text-transparent">
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

        @media (max-width: 1023px) {
            .sidebar-sticky {
                position: relative;
                max-height: none;
            }
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

        @media (min-width: 1024px) {
            .account-card:hover {
                transform: translateY(-4px) scale(1.01);
            }
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

        /* Sidebar collapse sur mobile */
        .sidebar-collapsed {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
        }

        .sidebar-expanded {
            max-height: 2000px;
            transition: max-height 0.5s ease-in;
        }
    </style>

    {{-- ══════════════════════════════════════════════════════
     BOUTON CRÉATION
══════════════════════════════════════════════════════ --}}
    <div class="max-w-screen-2xl mx-auto px-3 sm:px-4 lg:px-8 mt-3 sm:mt-4 flex justify-end">
        <livewire:create-account-modal wire:key="accountModal" />
        <livewire:share-accounts-modal />
    </div>

    {{-- ══════════════════════════════════════════════════════
     PAGE PRINCIPALE
══════════════════════════════════════════════════════ --}}
    <livewire:dashboard-table />
    <livewire:edit-account-modal />
    
</x-app-layout>