{{-- resources/views/livewire/share-accounts-modal.blade.php --}}
<div>
    {{-- Bouton déclencheur global --}}
    <button type="button"
            wire:click="openModal"
            class="group relative inline-flex items-center gap-2 px-5 py-2.5 font-bold text-white
               rounded-2xl transition-all duration-300 active:scale-95
               bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500
               hover:from-indigo-600 hover:via-purple-600 hover:to-pink-600
               shadow-lg hover:shadow-indigo-500/40 hover:shadow-xl ml-4">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
        </svg>
        Partager des accès
    </button>

    @if($showModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm"
         wire:click.self="closeModal">

        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-2xl w-full max-w-2xl mx-4 overflow-hidden">

            {{-- Header --}}
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Partage temporaire</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Donnez accès à vos comptes à un collègue</p>
                </div>
                <button type="button"
                        wire:click="closeModal"
                        class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <div class="px-6 py-5 space-y-6">

                {{-- Étape 1 : Sélection des comptes --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        1. Sélectionnez les comptes à partager
                    </label>
                    <div class="space-y-2 max-h-52 overflow-y-auto rounded-lg border border-gray-200 dark:border-gray-700 p-2">
                        @forelse($myAccounts as $account)
                            <label class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 cursor-pointer">
                                <input type="checkbox"
                                       wire:model="selectedAccountIds"
                                       value="{{ $account->id }}"
                                       class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                <div class="flex-1 min-w-0">
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $account->name }}</span>
                                    @if($account->url)
                                        <span class="ml-2 text-xs text-gray-400 truncate">{{ $account->url }}</span>
                                    @endif
                                </div>
                                @if($account->category)
                                    <span class="text-xs px-2 py-0.5 rounded-full bg-indigo-100 dark:bg-indigo-900 text-indigo-700 dark:text-indigo-300">
                                        {{ $account->category->name }}
                                    </span>
                                @endif
                            </label>
                        @empty
                            <p class="text-sm text-gray-400 text-center py-4">Aucun compte disponible.</p>
                        @endforelse
                    </div>
                    @error('selectedAccountIds')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Étape 2 : Destinataire --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        2. Destinataire
                    </label>
                    <select wire:model="recipient_id"
                            class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500">
                        <option value="">-- Choisir un collègue --</option>
                        @foreach($colleagues as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                        @endforeach
                    </select>
                    @error('recipient_id')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Étape 3 : Durée --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        3. Durée d'accès
                    </label>

                    {{-- Toggle preset / custom --}}
                    <div class="flex gap-2 mb-3">
                        <button type="button"
                                wire:click="$set('durationType', 'preset')"
                                class="px-3 py-1.5 text-sm rounded-lg border transition
                                    {{ $durationType === 'preset'
                                        ? 'bg-indigo-600 text-white border-indigo-600'
                                        : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border-gray-300 dark:border-gray-600' }}">
                            Durée prédéfinie
                        </button>
                        <button type="button"
                                wire:click="$set('durationType', 'custom')"
                                class="px-3 py-1.5 text-sm rounded-lg border transition
                                    {{ $durationType === 'custom'
                                        ? 'bg-indigo-600 text-white border-indigo-600'
                                        : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border-gray-300 dark:border-gray-600' }}">
                            Date personnalisée
                        </button>
                    </div>

                    @if($durationType === 'preset')
                        <div class="grid grid-cols-3 gap-2">
                            @foreach(['1h' => '1 heure', '24h' => '24 heures', '7d' => '7 jours'] as $value => $label)
                                <button type="button"
                                        wire:click="$set('presetDuration', '{{ $value }}')"
                                        class="py-2 rounded-lg border text-sm font-medium transition
                                            {{ $presetDuration === $value
                                                ? 'bg-indigo-50 dark:bg-indigo-900/40 border-indigo-400 text-indigo-700 dark:text-indigo-300'
                                                : 'border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-400 hover:border-indigo-300' }}">
                                    {{ $label }}
                                </button>
                            @endforeach
                        </div>
                    @else
                        <input type="datetime-local"
                               wire:model="customExpiresAt"
                               min="{{ now()->format('Y-m-d\TH:i') }}"
                               class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500">
                        @error('customExpiresAt')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    @endif
                </div>
            </div>

            {{-- Footer --}}
            <div class="flex items-center justify-end gap-3 px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">

                <button type="button"
                        wire:click="closeModal"
                        class="px-4 py-2 text-sm text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 transition">
                    Annuler
                </button>

                <button type="button"
                        wire:click="share"
                        wire:loading.attr="disabled"
                        wire:target="share"
                        class="px-5 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 disabled:opacity-60 transition flex items-center gap-2">
                    <span wire:loading.remove wire:target="share">Partager l'accès</span>
                    <span wire:loading wire:target="share">Partage en cours...</span>
                </button>

            </div>
        </div>
    </div>
    @endif

</div>
