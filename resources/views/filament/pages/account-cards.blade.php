<x-filament::page>

    {{-- HEADER SECTION --}}
    {{-- <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Gestionnaire de mots de passe</h2>
        <p class="text-gray-500 dark:text-gray-400">Gérez vos accès sécurisés par catégorie</p>
    </div> --}}

    {{-- RECHERCHE + FILTRE --}}
    <div class="flex flex-col md:flex-row gap-4 mb-8 p-4 bg-secondary-700 dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">

        {{-- RECHERCHE 65% --}}
        <div class="w-full md:w-[65%] relative">
            <div class="absolute inset-y-0 left-0 pl-10 flex items-center pointer-events-none" style="padding-right: 12px">
                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input type="text" wire:model.live="search" placeholder="Rechercher un compte..." style="padding-left: 20px" class="w-full pl-14 pr-4 py-3.5 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all duration-200" />
        </div>

        {{-- FILTRE CATÉGORIE 35% --}}
        <div class="w-full md:w-[35%] relative">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                </svg>
            </div>
            <select wire:model.live="categoryId" class="w-full pl-12 pr-10 py-3.5 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl text-sm appearance-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all duration-200 cursor-pointer">
                <option value="">Toutes les catégories</option>
                @foreach(\App\Models\Category::where('organisation_id', filament()->getTenant()->id)->get() as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </div>
        </div>

    </div>

    {{-- GRILLE (responsive) --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

        @foreach($this->accounts as $account)
        <div x-data="{ showPassword: false, copiedId: null, copiedPass: null }" class="group bg-white dark:bg-gray-800 rounded-2xl shadow-sm hover:shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden transition-all duration-300 hover:-translate-y-1">
            {{-- HEADER avec gradient subtil --}}
            <div class="relative px-6 py-5 bg-gradient-to-br from-gray-50 to-white dark:from-gray-800 dark:to-gray-900 border-b border-gray-100 dark:border-gray-700">
                <div class="flex justify-between items-start">
                    <div class="flex-1 min-w-0 pr-4">
                        <h3 class="font-bold text-gray-900 dark:text-white text-lg truncate leading-tight">
                            {{ $account->name }}
                        </h3>
                        @if($account->url)
                        <a href="{{ $account->url }}" target="_blank" class="inline-flex items-center mt-1 text-xs text-primary-600 hover:text-primary-700 dark:text-primary-400 truncate max-w-full">
                            <svg class="w-3 h-3 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                            </svg>
                            {{ parse_url($account->url, PHP_URL_HOST) ?? $account->url }}
                        </a>
                        @endif
                    </div>

                    {{-- Menu actions --}}
                    <div class="flex items-center gap-1">
                        <button wire:click="openEdit({{ $account->id }})" class="p-2 text-gray-400 hover:text-primary-600 hover:bg-primary-50 dark:hover:bg-primary-900/20 rounded-lg transition-all duration-200" title="Modifier">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Badge catégorie positionné absolument --}}
                @if($account->category)
                <div class="absolute -bottom-3 left-6 mb-16">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-primary-100 text-primary-700 dark:bg-primary-900/30 dark:text-primary-300 border border-primary-200 dark:border-primary-800 shadow-sm">
                        {{ $account->category->name }}
                    </span>
                </div>
                @endif
            </div>

            {{-- CORPS --}}
            <div class="px-6 pt-8 pb-6 space-y-4">

                {{-- IDENTIFIANT --}}
                <div class="space-y-1.5">
                    <label class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Identifiant</label>
                    <div class="flex items-center gap-2 bg-gray-50 dark:bg-gray-900/50 rounded-xl p-1 border border-gray-200 dark:border-gray-700 group/input hover:border-primary-300 dark:hover:border-primary-700 transition-colors">
                        <div class="flex-1 px-3 py-2 min-w-0">
                            <span class="text-sm text-gray-800 dark:text-gray-200 font-medium truncate block">
                                {{ $account->identifiant }}
                            </span>
                        </div>
                        <button x-on:click="
                                navigator.clipboard.writeText('{{ $account->identifiant }}');
                                copiedId = {{ $account->id }};
                                setTimeout(() => copiedId = null, 2000);
                            " class="flex items-center gap-1.5 px-3 py-2 text-xs font-medium rounded-lg transition-all duration-200" :class="copiedId === {{ $account->id }} ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400' : 'text-gray-500 hover:text-primary-600 hover:bg-primary-50 dark:hover:bg-primary-900/20'">
                            <svg x-show="copiedId !== {{ $account->id }}" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                            </svg>
                            <svg x-show="copiedId === {{ $account->id }}" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span x-text="copiedId === {{ $account->id }} ? 'Copié!' : 'Copier'"></span>
                        </button>
                    </div>
                </div>

                {{-- MOT DE PASSE --}}
                <div class="space-y-1.5">
                    <label class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Mot de passe</label>
                    <div class="flex items-center gap-2 bg-gray-50 dark:bg-gray-900/50 rounded-xl p-1 border border-gray-200 dark:border-gray-700 group/input hover:border-primary-300 dark:hover:border-primary-700 transition-colors">
                        <div class="flex-1 px-3 py-2 min-w-0">
                            <span class="text-sm font-mono text-gray-800 dark:text-gray-200 truncate block">
                                <span x-show="!showPassword" class="select-none">••••••••••••</span>
                                <span x-show="showPassword" x-transition>{{ $account->password }}</span>
                            </span>
                        </div>

                        <div class="flex items-center gap-1 pr-1">
                            {{-- Toggle visibility --}}
                            <button x-on:click="showPassword = !showPassword" class="p-2 text-gray-400 hover:text-primary-600 hover:bg-primary-50 dark:hover:bg-primary-900/20 rounded-lg transition-all" :title="showPassword ? 'Masquer' : 'Afficher'">
                                <svg x-show="!showPassword" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg x-show="showPassword" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </button>

                            {{-- Copy password --}}
                            <button x-on:click="
                                    navigator.clipboard.writeText('{{ $account->password }}');
                                    copiedPass = {{ $account->id }};
                                    setTimeout(() => copiedPass = null, 2000);
                                " class="flex items-center gap-1.5 px-3 py-2 text-xs font-medium rounded-lg transition-all duration-200" :class="copiedPass === {{ $account->id }} ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400' : 'text-gray-500 hover:text-primary-600 hover:bg-primary-50 dark:hover:bg-primary-900/20'">
                                <svg x-show="copiedPass !== {{ $account->id }}" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                                </svg>
                                <svg x-show="copiedPass === {{ $account->id }}" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span x-text="copiedPass === {{ $account->id }} ? 'Copié!' : 'Copier'"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- FOOTER --}}
            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-900/30 border-t border-gray-100 dark:border-gray-700 flex items-center justify-between">
                <div class="flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ $account->created_at->diffForHumans() }}</span>
                </div>

                {{-- Indicateur de sécurité (optionnel) --}}
                <div class="flex items-center gap-1" title="Sécurisé">
                    <div class="w-2 h-2 rounded-full bg-emerald-500"></div>
                    <span class="text-xs text-gray-500 dark:text-gray-400">Actif</span>
                </div>
            </div>
        </div>
        @endforeach

    </div>

    {{-- ÉTAT VIDE --}}
    @if($this->accounts->isEmpty())
    <div class="text-center py-16">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 dark:bg-gray-800 mb-4">
            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
        </div>
        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-1">Aucun compte trouvé</h3>
        <p class="text-gray-500 dark:text-gray-400">Essayez de modifier vos critères de recherche</p>
    </div>
    @endif

    {{-- MODAL EDIT --}}
    <x-filament::modal id="edit-account" width="2xl">
        <x-slot name="heading">
            <div class="flex items-center gap-2">
                <div class="p-2 bg-primary-100 dark:bg-primary-900/30 rounded-lg">
                    <svg class="w-5 h-5 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </div>
                <span>Modifier le compte</span>
            </div>
        </x-slot>

        <form wire:submit.prevent="saveEdit" class="space-y-6">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- Nom --}}
                <div class="space-y-2">
                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Nom du compte</label>
                    <x-filament::input.wrapper>
                        <x-filament::input type="text" wire:model="editForm.name" placeholder="ex: Gmail Pro" />
                    </x-filament::input.wrapper>
                </div>

                {{-- URL --}}
                <div class="space-y-2">
                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300">URL du site</label>
                    <x-filament::input.wrapper>
                        <x-slot name="prefix">
                            <span class="text-gray-500 pl-3">https://</span>
                        </x-slot>
                        <x-filament::input type="text" wire:model="editForm.url" placeholder="ex: gmail.com" />
                    </x-filament::input.wrapper>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- Identifiant --}}
                <div class="space-y-2">
                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Identifiant</label>
                    <x-filament::input.wrapper>
                        <x-slot name="prefix">
                            <svg class="w-5 h-5 text-gray-400 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </x-slot>
                        <x-filament::input type="text" wire:model="editForm.identifiant" placeholder="email@exemple.com" />
                    </x-filament::input.wrapper>
                </div>

                {{-- Mot de passe --}}
                <div class="space-y-2">
                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Mot de passe</label>
                    <x-filament::input.wrapper>
                        <x-slot name="prefix">
                            <svg class="w-5 h-5 text-gray-400 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </x-slot>
                        <x-filament::input type="text" wire:model="editForm.password" />
                        <x-slot name="suffix">
                            <button type="button" onclick="generatePasswordForEdit()" class="mr-2 text-xs text-primary-600 hover:text-primary-700 font-medium">
                                Générer
                            </button>
                        </x-slot>
                    </x-filament::input.wrapper>
                </div>
            </div>

            {{-- Catégorie --}}
            <div class="space-y-2">
                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Catégorie</label>
                <x-filament::input.wrapper>
                    <x-slot name="prefix">
                        <svg class="w-5 h-5 text-gray-400 ml-3" fill="none" color="secondary" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                    </x-slot>
                    <select wire:model="editForm.category_id" class="w-full border-none bg-transparent text-sm focus:ring-0 py-2 pl-2 pr-8">
                        <option value="">Sans catégorie</option>
                        @foreach(\App\Models\Category::where('organisation_id', filament()->getTenant()->id)->get() as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </x-filament::input.wrapper>
            </div>

            {{-- Notes --}}
            <div class="space-y-2">
                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Notes</label>
                <textarea wire:model.defer="editForm.notes" rows="3" class="block w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 focus:border-primary-500 focus:ring-primary-500 text-sm" placeholder="Informations complémentaires..."></textarea>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100 dark:border-gray-700">
                <x-filament::button type="button" color="gray" wire:click="$dispatch('close-modal', { id: 'edit-account' })">
                    Annuler
                </x-filament::button>
                <x-filament::button type="submit" icon="heroicon-m-check">
                    Enregistrer les modifications
                </x-filament::button>
            </div>
        </form>
    </x-filament::modal>

    <script>
        function generatePasswordForEdit() {
            const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*';
            let password = '';
            for (let i = 0; i < 16; i++) {
                password += chars.charAt(Math.floor(Math.random() * chars.length));
            }
            // Mettre à jour le champ Livewire
            @this.set('editForm.password', password);
        }

    </script>

</x-filament::page>
