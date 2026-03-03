<div>
    <button 
        wire:click="$set('showModal', true)"
        class="group relative inline-flex items-center gap-2 px-6 py-3 font-bold text-white transition-all duration-300 rounded-2xl bg-gradient-to-r from-indigo-600 to-violet-600 hover:shadow-[0_0_20px_rgba(79,70,229,0.4)] active:scale-95"
    >
        <x-heroicon-o-plus class="w-5 h-5 transition-transform group-hover:rotate-90" />
        <span>Ajouter un compte</span>
    </button>

    @if($showModal)
        <div 
            x-data="{ show: false }" 
            x-init="setTimeout(() => show = true, 50)"
            class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-0"
        >
            <div 
                x-show="show"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                wire:click="$set('showModal', false)" 
                class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm"
            ></div>

            <div 
                x-show="show"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                class="relative w-full max-w-lg overflow-hidden bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-3xl shadow-2xl"
            >
                <div class="px-8 py-6">
                    <h2 class="text-2xl font-extrabold text-gray-800 dark:text-white">
                        Nouveau compte
                    </h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Sécurisez vos accès en un clic.</p>

                    <form wire:submit.prevent="save" class="mt-8 space-y-5">
                        <div class="relative">
                            <label class="text-xs font-semibold uppercase tracking-wider text-gray-400 ml-1">Nom du service</label>
                            <div class="mt-1 relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                    <x-heroicon-o-identification class="w-5 h-5" />
                                </span>
                                <input type="text" wire:model="name" placeholder="Ex: Netflix, AWS..." 
                                    class="w-full pl-10 pr-4 py-3 bg-gray-50 dark:bg-gray-800 border-none rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all dark:text-white" />
                            </div>
                        </div>

                        <div class="relative">
                            <label class="text-xs font-semibold uppercase tracking-wider text-gray-400 ml-1">URL du site</label>
                            <div class="mt-1 relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                    <x-heroicon-o-link class="w-5 h-5" />
                                </span>
                                <input type="url" wire:model="url" placeholder="https://..." 
                                    class="w-full pl-10 pr-4 py-3 bg-gray-50 dark:bg-gray-800 border-none rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all dark:text-white" />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="text-xs font-semibold uppercase tracking-wider text-gray-400 ml-1">Identifiant</label>
                                <input type="text" wire:model="identifiant" 
                                    class="w-full mt-1 px-4 py-3 bg-gray-50 dark:bg-gray-800 border-none rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all dark:text-white" />
                            </div>
                            <div>
                                <label class="text-xs font-semibold uppercase tracking-wider text-gray-400 ml-1">Mot de passe</label>
                                <input type="password" wire:model="password" 
                                    class="w-full mt-1 px-4 py-3 bg-gray-50 dark:bg-gray-800 border-none rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all dark:text-white" />
                            </div>
                        </div>

                        <div>
                            <label class="text-xs font-semibold uppercase tracking-wider text-gray-400 ml-1">Catégorie</label>
                            <select wire:model="category_id" 
                                class="w-full mt-1 px-4 py-3 bg-gray-50 dark:bg-gray-800 border-none rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all dark:text-white">
                                <option value="">Choisir une catégorie</option>
                                @foreach(\App\Models\Category::where('organisation_id', auth()->user()->organisations()->first()->id)->get() as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mt-8 flex items-center justify-end gap-4">
                            <button type="button" wire:click="$set('showModal', false)" 
                                class="px-6 py-3 text-sm font-bold text-gray-500 hover:text-gray-700 dark:hover:text-white transition-colors">
                                Annuler
                            </button>

                            <button type="submit" wire:loading.attr="disabled"
                                class="flex items-center gap-2 px-8 py-3 bg-gray-900 dark:bg-white dark:text-gray-900 text-white rounded-xl font-bold hover:bg-black dark:hover:bg-gray-200 transition-all disabled:opacity-50">
                                <span wire:loading.remove>Enregistrer</span>
                                <span wire:loading>Traitement...</span>
                                <x-heroicon-o-check wire:loading.remove class="w-5 h-5" />
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>