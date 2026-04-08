<x-guest-layout>
    <x-slot name="title">Vérification à deux facteurs</x-slot>

    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-slate-50 to-slate-100 dark:from-gray-900 dark:to-gray-800 p-6">
        <div class="w-full max-w-md bg-white dark:bg-gray-800 rounded-2xl shadow-2xl border border-gray-100 dark:border-gray-700 p-8">
            <div class="text-center mb-6">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Vérification de sécurité</h2>
                <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Entrez le code à 6 chiffres de votre application.</p>
            </div>

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('two-factor.login') }}" class="space-y-4">
                @csrf

                <div>
                    <x-input-label for="code" :value="__('Code TOTP')" />
                    <x-text-input id="code" class="block mt-1 w-full" type="text" inputmode="numeric" name="code" autofocus x-ref="code" autocomplete="one-time-code" placeholder="123 456" />
                    <x-input-error :messages="$errors->get('code')" class="mt-2" />
                </div>

                <div class="flex items-center gap-2">
                    <input id="recovery_code" type="checkbox" x-on:click="$refs.code.value = ''; $refs.code.placeholder = 'Code de secours'; $refs.code.focus()" class="w-4 h-4 rounded border-gray-300 dark:border-gray-600 text-emerald-600 focus:ring-emerald-500 focus:ring-2" />
                    <label for="recovery_code" class="text-sm text-gray-600 dark:text-gray-400 cursor-pointer select-none">Utiliser un code de secours</label>
                </div>

                <button type="submit" class="w-full btn-lakile text-white font-semibold py-3 rounded-xl shadow-lg flex items-center justify-center gap-2 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <span>Vérifier et accéder</span>
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>