<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-bold bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 bg-clip-text text-transparent">
            🔐 Mes Comptes
        </h2>

    </x-slot>
    {{-- BOUTON + MODAL --}}
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4 flex justify-end">
    <livewire:create-account-modal />
</div>
    <div class="min-h-screen bg-gradient-to-br from-gray-100 via-indigo-50 to-purple-100 
                dark:from-gray-950 dark:via-gray-900 dark:to-gray-950 py-10">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

                @forelse($accounts as $account)

                <div x-data="{ showPassword: false }"
                    class="relative group rounded-3xl p-[1px] 
                            bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500
                            hover:from-pink-500 hover:via-purple-500 hover:to-indigo-500
                            transition-all duration-500">

                    <div class="rounded-3xl bg-white/90 dark:bg-gray-900/90 backdrop-blur-xl 
                                p-6 h-full shadow-xl group-hover:shadow-2xl 
                                transition-all duration-500">

                        {{-- HEADER --}}
                        <div class="flex justify-between items-start">

                            <div class="flex items-center gap-4">

                                <div class="w-14 h-14 rounded-2xl 
                                            bg-gradient-to-br from-indigo-500 to-purple-600 
                                            flex items-center justify-center 
                                            shadow-lg text-white font-bold text-lg
                                            group-hover:scale-110 transition duration-300">
                                    {{ strtoupper(substr($account->name, 0, 1)) }}
                                </div>

                                <div>
                                    <h3 class="font-bold text-lg text-gray-800 dark:text-white">
                                        {{ $account->name }}
                                    </h3>

                                    @if($account->url)
                                    <a href="{{ $account->url }}" target="_blank"
                                        class="text-xs text-indigo-500 hover:text-pink-500 transition">
                                        {{ parse_url($account->url, PHP_URL_HOST) ?? $account->url }}
                                    </a>
                                    @endif
                                </div>

                            </div>

                        </div>

                        {{-- CATÉGORIE --}}
                        @if($account->category)
                        <div class="mt-5">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full
                                    bg-gradient-to-r from-indigo-500 to-purple-500
                                    text-white shadow-md">
                                {{ $account->category->name }}
                            </span>
                        </div>
                        @endif

                        {{-- IDENTIFIANT --}}
                        <div class="mt-5">
                            <span class="text-xs uppercase tracking-wider text-gray-400">Identifiant</span>

                            <div class="flex justify-between items-center mt-2 
                                        bg-gray-100 dark:bg-gray-800 rounded-xl px-3 py-2">
                                <span class="text-sm text-gray-700 dark:text-gray-300 truncate">
                                    {{ $account->identifiant }}
                                </span>

                                <button onclick="navigator.clipboard.writeText('{{ $account->identifiant }}')"
                                    class="text-indigo-500 hover:text-pink-500 transition text-xs font-medium">
                                    Copier
                                </button>
                            </div>
                        </div>

                        {{-- MOT DE PASSE --}}
                        <div class="mt-5">
                            <span class="text-xs uppercase tracking-wider text-gray-400">Mot de passe</span>

                            <div class="flex justify-between items-center mt-2 
                                        bg-gray-100 dark:bg-gray-800 rounded-xl px-3 py-2">
                                <span class="text-sm text-gray-700 dark:text-gray-300 truncate">
                                    @if($account->password)
                                    <span x-show="!showPassword">••••••••</span>
                                    <span x-show="showPassword">{{ $account->password }}</span>
                                    @else
                                    <span class="text-red-500 text-xs font-medium">Non défini</span>
                                    @endif
                                </span>

                                @if($account->password)
                                <div class="flex gap-3">
                                    <button @click="showPassword = !showPassword"
                                        class="text-purple-500 hover:text-pink-500 transition text-xs font-medium">
                                        Afficher
                                    </button>

                                    <button onclick="navigator.clipboard.writeText('{{ $account->password }}')"
                                        class="text-indigo-500 hover:text-pink-500 transition text-xs font-medium">
                                        Copier
                                    </button>
                                </div>
                                @endif
                            </div>
                        </div>

                        {{-- NOTES --}}
                        <!-- @if($account->notes)
                        <div class="mt-5">
                            <span class="text-xs uppercase tracking-wider text-gray-400">Notes</span>
                            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400 line-clamp-2">
                                {{ $account->notes }}
                            </p>
                        </div>
                        @endif -->

                        {{-- FOOTER --}}
                        <div class="mt-6 pt-4 border-t border-gray-200 dark:border-gray-700 
                                    flex justify-between items-center text-xs text-gray-400">

                            <div>
                                Créé le {{ $account->created_at->format('d/m/Y') }}
                            </div>

                            <div class="flex items-center gap-2">
                                <span>Maj {{ $account->updated_at->format('d/m/Y') }}</span>

                                
                            </div>

                        </div>

                    </div>
                </div>

                @empty

                <div class="col-span-full text-center text-gray-500 text-lg">
                    Aucun compte trouvé.
                </div>

                @endforelse

            </div>

        </div>

    </div>
</x-app-layout>