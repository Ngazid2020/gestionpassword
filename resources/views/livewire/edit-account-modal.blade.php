{{-- resources/views/livewire/edit-account-modal.blade.php --}}
<div>
<div x-data="{ 
        open: @entangle('isOpen'),
        // Ajout d'une variable pour gérer l'animation de sortie
        showContent: false 
     }" 
     x-show="open" 
     x-cloak
     {{-- On synchronise showContent avec open pour les animations --}}
     x-init="$watch('open', value => setTimeout(() => showContent = value, 10))"
     x-on:keydown.escape.window="open = false"
     class="fixed inset-0 z-[150] overflow-y-auto" 
     aria-labelledby="modal-title" role="dialog" aria-modal="true">
    
    <div x-show="open"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-gray-950/40 dark:bg-black/60 backdrop-blur-sm transition-opacity" 
         @click="open = false"
         aria-hidden="true"></div>

    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        
        {{-- Le Modal lui-même --}}
        <div x-show="showContent"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             class="relative transform overflow-hidden rounded-3xl 
                    bg-white/90 dark:bg-gray-900/90 backdrop-blur-xl
                    text-left shadow-2xl transition-all 
                    sm:my-8 sm:w-full sm:max-w-lg
                    border border-gray-200 dark:border-gray-700/50">
            
            {{-- Dégradé décoratif subtil en haut --}}
            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500"></div>

            {{-- Bouton Fermer (X) --}}
            <div class="absolute right-0 top-0 pr-4 pt-4 z-10">
                <button @click="open = false" 
                        class="rounded-lg text-gray-400 hover:text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-purple-500 p-1 transition">
                    <span class="sr-only">Fermer</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="px-6 pt-8 pb-6">
                <div class="sm:flex sm:items-start">
                    <div class="w-full text-center sm:text-left">
                        
                        {{-- TITRE --}}
                        <div class="flex items-center gap-3 mb-6 justify-center sm:justify-start">
                            <span class="text-2xl">📝</span>
                            <h3 class="text-2xl font-black text-gray-800 dark:text-white leading-none tracking-tight" id="modal-title">
                                Modifier le compte
                            </h3>
                        </div>
                        
                        {{-- FORMULAIRE --}}
                        <form wire:submit.prevent="update" class="space-y-5">
                            
                            {{-- Input : Nom du site --}}
                            <div class="relative group">
                                <label class="block text-xs font-bold uppercase text-gray-500 dark:text-gray-400 tracking-wider mb-1.5 pl-1">
                                    Nom du site ou service
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-indigo-500 transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                                    </div>
                                    <input type="text" wire:model="name" placeholder="Ex: Netflix, GitHub..."
                                           class="w-full pl-11 pr-4 py-3 rounded-xl
                                                  bg-gray-100 dark:bg-gray-800/50
                                                  border border-gray-200 dark:border-gray-700
                                                  text-gray-900 dark:text-white placeholder-gray-400
                                                  focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500
                                                  transition duration-200">
                                </div>
                                @error('name') <span class="text-rose-500 text-xs italic pl-1">{{ $message }}</span> @enderror
                            </div>

                            {{-- Input : Identifiant --}}
                            <div class="relative group">
                                <label class="block text-xs font-bold uppercase text-gray-500 dark:text-gray-400 tracking-wider mb-1.5 pl-1">
                                    Identifiant / Email
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-purple-500 transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    </div>
                                    <input type="text" wire:model="identifiant" placeholder="Ex: jean.dupont@email.com"
                                           class="w-full pl-11 pr-4 py-3 rounded-xl
                                                  bg-gray-100 dark:bg-gray-800/50
                                                  border border-gray-200 dark:border-gray-700
                                                  text-gray-900 dark:text-white placeholder-gray-400
                                                  focus:ring-2 focus:ring-purple-500/50 focus:border-purple-500
                                                  transition duration-200">
                                </div>
                                @error('identifiant') <span class="text-rose-500 text-xs italic pl-1">{{ $message }}</span> @enderror
                            </div>

                            {{-- Input : Mot de passe --}}
                            <div class="relative group" x-data="{ show: false }">
                                <label class="block text-xs font-bold uppercase text-gray-500 dark:text-gray-400 tracking-wider mb-1.5 pl-1">
                                    Mot de passe
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-pink-500 transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                    </div>
                                    <input :type="show ? 'text' : 'password'" wire:model="password" placeholder="••••••••"
                                           class="w-full pl-11 pr-12 py-3 rounded-xl
                                                  bg-gray-100 dark:bg-gray-800/50
                                                  border border-gray-200 dark:border-gray-700
                                                  text-gray-900 dark:text-white placeholder-gray-400
                                                  focus:ring-2 focus:ring-pink-500/50 focus:border-pink-500
                                                  transition duration-200">
                                    {{-- Bouton Masquer/Afficher --}}
                                    <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-pink-500 transition">
                                        <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        <svg x-show="show" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.025 10.025 0 014.132-5.411m0 0L21 21m-21-21l21 21m-8.508-6.852A3 3 0 0010 10m3.875 3.875A3 3 0 0110 10z"></path></svg>
                                    </button>
                                </div>
                            </div>

                            {{-- Input : URL (Optionnel) --}}
                            <div class="relative group">
                                <label class="block text-xs font-bold uppercase text-gray-500 dark:text-gray-400 tracking-wider mb-1.5 pl-1">
                                    Site Internet (URL) <span class="text-gray-400 dark:text-gray-600 font-medium">(Optionnel)</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-emerald-500 transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.812a4 4 0 005.656 0l4-4a4 4 0 10-5.656-5.656l-1.1 1.1"></path></svg>
                                    </div>
                                    <input type="text" wire:model="url" placeholder="Ex: https://netflix.com"
                                           class="w-full pl-11 pr-4 py-3 rounded-xl
                                                  bg-gray-100 dark:bg-gray-800/50
                                                  border border-gray-200 dark:border-gray-700
                                                  text-gray-900 dark:text-white placeholder-gray-400
                                                  focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500
                                                  transition duration-200">
                                </div>
                                @error('url') <span class="text-rose-500 text-xs italic pl-1">{{ $message }}</span> @enderror
                            </div>

                            {{-- BOUTONS D'ACTION --}}
                            <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700/50 sm:flex sm:flex-row-reverse gap-3">
                                <button type="submit" 
                                        wire:loading.attr="disabled"
                                        class="inline-flex w-full items-center justify-center rounded-xl px-6 py-3 text-sm font-bold text-white shadow-lg sm:w-auto
                                               bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500
                                               hover:from-indigo-600 hover:via-purple-600 hover:to-pink-600
                                               focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600
                                               transition-all duration-300 relative group overflow-hidden">
                                    
                                    {{-- Effet de brillance au survol --}}
                                    <span class="absolute inset-0 w-full h-full bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover:animate-shimmer"></span>

                                    {{-- Texte normal --}}
                                    <span wire:loading.remove wire:target="update" class="flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                                        Sauvegarder les modifications
                                    </span>

                                    {{-- Texte chargement --}}
                                    <span wire:loading wire:target="update" class="flex items-center gap-2">
                                        <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        Mise à jour...
                                    </span>
                                </button>
                                
                                <button type="button" 
                                        @click="open = false" 
                                        class="mt-3 inline-flex w-full justify-center rounded-xl px-6 py-3 text-sm font-semibold sm:mt-0 sm:w-auto
                                               bg-gray-100 dark:bg-gray-800
                                               text-gray-700 dark:text-gray-300
                                               border border-gray-200 dark:border-gray-700
                                               hover:bg-gray-200 dark:hover:bg-gray-700
                                               transition duration-200">
                                    Annuler
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Ajout d'une petite animation CSS pour le bouton --}}
<style>
    @keyframes shimmer {
        100% { transform: translateX(100%); }
    }
    .group-hover\:animate-shimmer:hover {
        animation: shimmer 1.5s infinite;
    }
</style>
</div>