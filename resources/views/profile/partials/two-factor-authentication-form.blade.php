@php
    $user = auth()->user();
    $enabled = ! is_null($user->two_factor_secret);
    $confirmed = $enabled && ! is_null($user->two_factor_confirmed_at);
@endphp

<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Authentification à deux facteurs (2FA)</h2>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            Ajoutez une couche de sécurité supplémentaire. Scannez le QR code avec Google Authenticator ou Authy.
        </p>
    </header>

    @if (! $enabled)
        {{-- ❌ 2FA DÉSACTIVÉE --}}
        <form method="POST" action="{{ route('two-factor.enable') }}">
            @csrf
            <x-primary-button type="submit">Activer la 2FA</x-primary-button>
        </form>

    @elseif (! $confirmed)
        {{-- ⏳ EN COURS D'ACTIVATION (QR Code + confirmation) --}}
        <form method="POST" action="{{ route('two-factor.confirm') }}">
            @csrf
            <div class="mt-4 p-4 bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">
                    Scannez ce QR code avec votre app, puis entrez le code généré.
                </p>
                
                <div class="flex flex-col sm:flex-row gap-6 items-start">
                    <div class="bg-white p-3 rounded-lg border dark:border-gray-700">
                        {!! $user->twoFactorQrCodeSvg() !!}
                    </div>
                    <div class="w-full sm:w-auto">
                        <x-input-label for="code" value="Code de vérification" />
                        <x-text-input id="code" type="text" name="code" inputmode="numeric" class="mt-1 block w-full" autofocus autocomplete="one-time-code" placeholder="123456" />
                        <x-input-error :messages="$errors->get('code')" class="mt-2" />
                    </div>
                </div>
            </div>

            <div class="mt-4 flex items-center gap-3">
                <x-primary-button type="submit">Confirmer & Activer</x-primary-button>
                
                {{-- Bouton Annuler --}}
                <button type="button" onclick="document.getElementById('disable-2fa-form').submit();" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150">
                    Annuler
                </button>
            </div>
        </form>
        
        {{-- Formulaire caché pour désactiver --}}
        <form id="disable-2fa-form" method="POST" action="{{ route('two-factor.disable') }}" class="hidden">
            @csrf
            @method('DELETE')
        </form>

    @else
        {{-- ✅ 2FA ACTIVÉE & CONFIRMÉE --}}
        <div class="rounded-lg border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50 p-4 mb-4">
            <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Codes de secours</h3>
            <p class="text-xs text-gray-500 dark:text-gray-400 mb-3">
                Stockez-les en sécurité. Ils servent si vous perdez votre téléphone.
            </p>
            
            <div class="grid grid-cols-2 gap-2 font-mono text-xs text-gray-600 dark:text-gray-300 bg-white dark:bg-gray-900 p-3 rounded border dark:border-gray-700">
                @foreach (json_decode(decrypt($user->two_factor_recovery_codes), true) as $code)
                    <div>{{ $code }}</div>
                @endforeach
            </div>
            
            <form method="POST" action="{{ route('two-factor.recovery-codes') }}" class="mt-3">
                @csrf
                <x-secondary-button type="submit">Régénérer les codes</x-secondary-button>
            </form>
        </div>

        <form method="POST" action="{{ route('two-factor.disable') }}">
            @csrf
            @method('DELETE')
            <x-danger-button type="submit">Désactiver la 2FA</x-danger-button>
        </form>
    @endif
</section>