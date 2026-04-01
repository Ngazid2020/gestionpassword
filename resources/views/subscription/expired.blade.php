{{-- resources/views/subscription/expired.blade.php --}}
<x-guest-layout>
    <x-slot name="title">Abonnement expiré</x-slot>

    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-slate-50 to-slate-100 dark:from-gray-900 dark:to-gray-800 p-6">
        <div class="w-full max-w-md text-center">

            {{-- Icône --}}
            <div class="mx-auto mb-6 w-20 h-20 rounded-full bg-red-100 dark:bg-red-900/30 flex items-center justify-center">
                <svg class="w-10 h-10 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>

            {{-- Titre --}}
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                Abonnement expiré
            </h1>
            <p class="text-gray-500 dark:text-gray-400 mb-8 leading-relaxed">
                L'accès à <strong class="text-gray-700 dark:text-gray-200">Lakile</strong> pour votre organisation
                a expiré ou a été suspendu.<br>
                Contactez votre administrateur pour renouveler votre abonnement.
            </p>

            {{-- Infos de contact --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-6 mb-6 text-left space-y-3">
                <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">Pour renouveler :</p>
                <div class="flex items-center gap-3 text-sm text-gray-600 dark:text-gray-400">
                    <span>📧</span>
                    <a href="mailto:support@azzhy.com" class="text-emerald-600 hover:underline">support@azzhy.com</a>
                </div>
                <div class="flex items-center gap-3 text-sm text-gray-600 dark:text-gray-400">
                    <span>💵</span>
                    <span>Paiement en espèces ou virement bancaire accepté</span>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex flex-col gap-3">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full px-6 py-3 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200
                               font-semibold rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                        Se déconnecter
                    </button>
                </form>
            </div>

        </div>
    </div>
</x-guest-layout>