<div>
    {{-- ══════════════════════════════════════════
         BOUTON DÉCLENCHEUR
    ══════════════════════════════════════════ --}}
    <button
        wire:click="$set('showModal', true)"
        class="group relative inline-flex items-center gap-2 px-5 py-2.5 font-bold text-white
               rounded-2xl transition-all duration-300 active:scale-95
               bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500
               hover:from-indigo-600 hover:via-purple-600 hover:to-pink-600
               shadow-lg hover:shadow-indigo-500/40 hover:shadow-xl">
        <x-heroicon-o-plus class="w-5 h-5 transition-transform group-hover:rotate-90 duration-300" />
        <span>Ajouter un compte</span>
    </button>

    @if($showModal)
    <div
        x-data="{ show: false }"
        x-init="setTimeout(() => show = true, 50)"
        class="fixed inset-0 z-[150] flex items-center justify-center p-4"
        x-on:keydown.escape.window="show = false; setTimeout(() => $wire.set('showModal', false), 200)"
    >
        {{-- Fond --}}
        <div
            x-show="show"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            wire:click="$set('showModal', false)"
            class="absolute inset-0 bg-gray-950/50 backdrop-blur-sm">
        </div>

        {{-- Modal --}}
        <div
            x-show="show"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 scale-95"
            class="relative w-full max-w-lg rounded-3xl overflow-hidden shadow-2xl
                   bg-white/90 dark:bg-gray-900/90 backdrop-blur-xl
                   border border-gray-200/60 dark:border-gray-700/60">

            {{-- Barre dégradée décorative --}}
            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500"></div>

            {{-- Bouton fermer --}}
            <button
                wire:click="$set('showModal', false)"
                class="absolute top-4 right-4 z-10 p-1.5 rounded-lg
                       text-gray-400 hover:text-gray-600 dark:hover:text-white
                       hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            <div class="px-7 pt-8 pb-7">

                {{-- TITRE --}}
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600
                                flex items-center justify-center shadow-lg flex-shrink-0">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-black text-gray-800 dark:text-white leading-tight">Nouveau compte</h2>
                        <p class="text-xs text-gray-400 dark:text-gray-500">Sécurisez vos accès en un clic.</p>
                    </div>
                </div>

                <form wire:submit.prevent="save" class="space-y-4">

                    {{-- Nom du service --}}
                    <div class="relative group">
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500 mb-1.5 pl-1">
                            Nom du service
                        </label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-400 group-focus-within:text-indigo-500 transition">
                                <x-heroicon-o-identification class="w-4 h-4" />
                            </div>
                            <input type="text" wire:model="name" placeholder="Ex: Netflix, AWS..."
                                class="w-full pl-10 pr-4 py-2.5 rounded-xl text-sm
                                       bg-gray-50 dark:bg-gray-800/60
                                       border border-gray-200 dark:border-gray-700
                                       text-gray-900 dark:text-white placeholder-gray-400
                                       focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500
                                       transition duration-200" />
                        </div>
                        @error('name') <span class="text-rose-500 text-xs italic pl-1">{{ $message }}</span> @enderror
                    </div>

                    {{-- URL --}}
                    <div class="relative group">
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500 mb-1.5 pl-1">
                            URL du site <span class="text-gray-300 dark:text-gray-600 font-normal normal-case">(optionnel)</span>
                        </label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-400 group-focus-within:text-purple-500 transition">
                                <x-heroicon-o-link class="w-4 h-4" />
                            </div>
                            <input type="text" wire:model="url" placeholder="https://..."
                                class="w-full pl-10 pr-4 py-2.5 rounded-xl text-sm
                                       bg-gray-50 dark:bg-gray-800/60
                                       border border-gray-200 dark:border-gray-700
                                       text-gray-900 dark:text-white placeholder-gray-400
                                       focus:outline-none focus:ring-2 focus:ring-purple-500/50 focus:border-purple-500
                                       transition duration-200" />
                        </div>
                        @error('url') <span class="text-rose-500 text-xs italic pl-1">{{ $message }}</span> @enderror
                    </div>

                    {{-- Identifiant + Mot de passe --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                        <div class="relative group">
                            <label class="block text-xs font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500 mb-1.5 pl-1">
                                Identifiant
                            </label>
                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-400 group-focus-within:text-pink-500 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <input type="text" wire:model="identifiant" placeholder="email@..."
                                    class="w-full pl-10 pr-4 py-2.5 rounded-xl text-sm
                                           bg-gray-50 dark:bg-gray-800/60
                                           border border-gray-200 dark:border-gray-700
                                           text-gray-900 dark:text-white placeholder-gray-400
                                           focus:outline-none focus:ring-2 focus:ring-pink-500/50 focus:border-pink-500
                                           transition duration-200" />
                            </div>
                            @error('identifiant') <span class="text-rose-500 text-xs italic pl-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="relative group" x-data="{ show: false }">
                            <label class="block text-xs font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500 mb-1.5 pl-1">
                                Mot de passe
                            </label>
                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-400 group-focus-within:text-emerald-500 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                </div>
                                <input :type="show ? 'text' : 'password'" wire:model="password" placeholder="••••••••"
                                    class="w-full pl-10 pr-10 py-2.5 rounded-xl text-sm
                                           bg-gray-50 dark:bg-gray-800/60
                                           border border-gray-200 dark:border-gray-700
                                           text-gray-900 dark:text-white placeholder-gray-400
                                           focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500
                                           transition duration-200" />
                                <button type="button" @click="show = !show"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-emerald-500 transition">
                                    <svg x-show="!show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    <svg x-show="show" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.025 10.025 0 014.132-5.411m0 0L21 21m-21-21l21 21"/>
                                    </svg>
                                </button>
                            </div>
                            @error('password') <span class="text-rose-500 text-xs italic pl-1">{{ $message }}</span> @enderror
                        </div>

                    </div>

                    {{-- Catégorie --}}
                    <div class="relative group">
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500 mb-1.5 pl-1">
                            Catégorie <span class="text-gray-300 dark:text-gray-600 font-normal normal-case">(optionnel)</span>
                        </label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-400 group-focus-within:text-indigo-500 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                            </div>
                            <select wire:model="category_id"
                                class="w-full pl-10 pr-4 py-2.5 rounded-xl text-sm appearance-none
                                       bg-gray-50 dark:bg-gray-800/60
                                       border border-gray-200 dark:border-gray-700
                                       text-gray-900 dark:text-white
                                       focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500
                                       transition duration-200">
                                <option value="">Choisir une catégorie</option>
                                @foreach(\App\Models\Category::where('organisation_id', auth()->user()->organisations()->first()->id)->get() as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </div>
                        @error('category_id') <span class="text-rose-500 text-xs italic pl-1">{{ $message }}</span> @enderror
                    </div>

                    {{-- Notes --}}
                    <div class="relative group">
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500 mb-1.5 pl-1">
                            Notes <span class="text-gray-300 dark:text-gray-600 font-normal normal-case">(optionnel)</span>
                        </label>
                        <div class="relative">
                            <div class="pointer-events-none absolute top-3 left-0 flex items-start pl-3.5 text-gray-400 group-focus-within:text-indigo-500 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </div>
                            <textarea wire:model="notes" rows="3"
                                placeholder="Informations complémentaires, contexte, questions de sécurité..."
                                class="w-full pl-10 pr-4 py-2.5 rounded-xl text-sm resize-none
                                       bg-gray-50 dark:bg-gray-800/60
                                       border border-gray-200 dark:border-gray-700
                                       text-gray-900 dark:text-white placeholder-gray-400
                                       focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500
                                       transition duration-200"></textarea>
                        </div>
                        @error('notes') <span class="text-rose-500 text-xs italic pl-1">{{ $message }}</span> @enderror
                    </div>

                    {{-- ACTIONS --}}
                    <div class="pt-4 border-t border-gray-100 dark:border-gray-800 flex items-center justify-end gap-3">
                        <button type="button" wire:click="$set('showModal', false)"
                            class="px-5 py-2.5 text-sm font-semibold rounded-xl
                                   text-gray-500 dark:text-gray-400
                                   hover:text-gray-700 dark:hover:text-white
                                   hover:bg-gray-100 dark:hover:bg-gray-800
                                   transition duration-200">
                            Annuler
                        </button>

                        <button type="submit" wire:loading.attr="disabled"
                            class="relative inline-flex items-center gap-2 px-6 py-2.5 text-sm font-bold text-white
                                   rounded-xl overflow-hidden transition-all duration-300 active:scale-95
                                   bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500
                                   hover:from-indigo-600 hover:via-purple-600 hover:to-pink-600
                                   shadow-lg hover:shadow-indigo-500/40
                                   disabled:opacity-50 disabled:cursor-not-allowed">
                            <span wire:loading.remove wire:target="save" class="flex items-center gap-2">
                                <x-heroicon-o-check class="w-4 h-4" />
                                Enregistrer
                            </span>
                            <span wire:loading wire:target="save" class="flex items-center gap-2">
                                <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"/>
                                </svg>
                                Traitement...
                            </span>
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
    @endif
</div>
