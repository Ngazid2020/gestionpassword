<x-app-layout>
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
    </div>

    {{-- ══════════════════════════════════════════════════════
     PAGE PRINCIPALE
══════════════════════════════════════════════════════ --}}
    <livewire:dashboard-table />
    <livewire:edit-account-modal />
</x-app-layout>