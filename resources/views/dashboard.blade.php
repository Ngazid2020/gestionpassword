<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            🔐 Mes Comptes
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-12xl mx-auto sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

                @forelse($accounts as $account)

                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md hover:shadow-2xl transition duration-300 p-6 border border-gray-100 dark:border-gray-700">

                        {{-- HEADER --}}
                        <div class="flex items-center gap-3">

                            <div class="w-12 h-12 rounded-full 
                                bg-gradient-to-br from-indigo-500 to-purple-600 
                                flex items-center justify-center shadow-md">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="w-6 h-6 text-white"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2h-1V9a5 5 0 00-10 0v2H6a2 2 0 00-2 2v6a2 2 0 002 2z" />
                                </svg>
                            </div>

                            <div class="truncate">
                                <h3 class="font-semibold text-lg text-gray-900 dark:text-white truncate">
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

                        </div>

                        {{-- IDENTIFIANT --}}
                        <div class="mt-4">
                            <span class="text-xs text-gray-400 uppercase tracking-wide">
                                Identifiant
                            </span>

                            <div class="mt-1 text-sm font-medium text-gray-700 dark:text-gray-300 truncate">
                                {{ $account->identifiant }}
                            </div>
                        </div>
                        
                        {{-- PASSWORD --}}
                        <div class="mt-4">
                            <span class="text-xs text-gray-400 uppercase tracking-wide">
                                Mot de passe
                            </span>

                            <div class="mt-1 text-sm font-medium text-gray-700 dark:text-gray-300 truncate">
                                {{ $account->password }}
                            </div>
                        </div>

                        {{-- FOOTER GRADIENT --}}
                        <div class="mt-6 h-1 w-full rounded-full 
                            bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500">
                        </div>

                    </div>

                @empty

                    <div class="col-span-full text-center text-gray-500">
                        Aucun compte trouvé.
                    </div>

                @endforelse

            </div>

        </div>
    </div>
</x-app-layout>