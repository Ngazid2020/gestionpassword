<x-filament::page>

    {{-- RECHERCHE + FILTRE --}}
    <div class="flex flex-col md:flex-row gap-3 mb-6">

        {{-- RECHERCHE --}}
        <input type="text" wire:model.live="search" placeholder="Rechercher..." class="flex-1 rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900" />
        {{-- FILTRE CATÉGORIE --}}
        <select wire:model.live="categoryId" class="w-full md:w-64 rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900">
            <option value="">-- Toutes les catégories --</option>

            @foreach(\App\Models\Category::where('organisation_id', filament()->getTenant()->id)->get() as $category)
            <option value="{{ $category->id }}">
                {{ $category->name }}
            </option>
            @endforeach
        </select>

    </div>

    {{-- GRILLE (4 par ligne) --}}
    <div class="grid grid-cols-4 md:grid-cols-3 lg:grid-cols-4 gap-2">

        @foreach($this->accounts as $account)
        <div x-data="{ showPassword: false }" class="bg-white dark:bg-gray-900 rounded-2xl shadow-xl hover:shadow-2xl transition duration-200 p-6">

            {{-- HEADER --}}
            <div class="flex justify-between items-start mb-3">
                <h3 class="font-semibold text-lg truncate">
                    {{ $account->name }}
                </h3>

                <button wire:click="openEdit({{ $account->id }})" class="text-xs text-primary-600 hover:underline">
                    Modifier
                </button>
            </div>

            {{-- URL --}}
            @if($account->url)
            <p class="text-sm text-gray-500 mb-3 truncate">
                {{ $account->url }}
            </p>
            @endif

            {{-- IDENTIFIANT --}}
            <div class="mb-3">
                <span class="text-xs text-gray-400">Identifiant</span>

                <div class="flex justify-between items-center bg-gray-100 dark:bg-gray-800 rounded-lg px-3 py-2 mt-1">
                    <span class="text-sm truncate">
                        {{ $account->identifiant }}
                    </span>

                    <button x-on:click="navigator.clipboard.writeText('{{ $account->identifiant }}')" class="text-xs text-primary-600 hover:underline">
                        Copier
                    </button>
                </div>
            </div>

            {{-- MOT DE PASSE --}}
            <div class="mb-3" x-data="{ showPassword: false }">
                <span class="text-xs text-gray-400">Mot de passe</span>

                <div class="flex justify-between items-center bg-gray-100 dark:bg-gray-800 rounded-lg px-3 py-2 mt-1">

                    <span class="text-sm truncate">
                        <span x-show="!showPassword">••••••••</span>
                        <span x-show="showPassword">{{ $account->password }}</span>
                    </span>

                    <div class="flex gap-2">
                        <button x-on:click="showPassword = !showPassword" class="text-xs text-primary-600 hover:underline">
                            <span x-show="!showPassword">Afficher</span>
                            <span x-show="showPassword">Masquer</span>
                        </button>

                        <button x-on:click="navigator.clipboard.writeText('{{ $account->password }}')" class="text-xs text-primary-600 hover:underline">
                            Copier
                        </button>
                    </div>
                </div>
            </div>

            {{-- CATÉGORIE --}}
            @if($account->category)
            <div class="mt-3">
                <span class="inline-block text-xs bg-primary-100 text-primary-700 px-3 py-1 rounded-full">
                    {{ $account->category->name }}
                </span>
            </div>
            @endif

            {{-- DATE --}}
            <div class="mt-4 text-xs text-gray-400 border-t border-gray-200 dark:border-gray-800 pt-3">
                Créé le {{ $account->created_at->format('d/m/Y') }}
            </div>

        </div>
        @endforeach

        @if($this->accounts->isEmpty())
        <div class="col-span-full text-center text-gray-500">
            Aucun compte trouvé.
        </div>
        @endif

    </div>

    {{-- MODAL EDIT --}}
    <x-filament::modal id="edit-account">
        <x-slot name="heading">
            Modifier le compte
        </x-slot>

        <form wire:submit.prevent="saveEdit">

            <div class="space-y-4">

                <x-filament::input.wrapper>
                    <x-filament::input type="text" wire:model="editForm.name" placeholder="Nom" />
                </x-filament::input.wrapper>

                <x-filament::input.wrapper>
                    <x-filament::input type="text" wire:model="editForm.url" placeholder="URL" />
                </x-filament::input.wrapper>

                <x-filament::input.wrapper>
                    <x-filament::input type="text" wire:model="editForm.identifiant" placeholder="Identifiant" />
                </x-filament::input.wrapper>

                <x-filament::input.wrapper>
                    <x-filament::input type="text" wire:model="editForm.password" placeholder="Mot de passe" />
                </x-filament::input.wrapper>

                <x-filament::input.wrapper>
                    <textarea wire:model.defer="editForm.notes" rows="4" class="block w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900" placeholder="Notes"></textarea>
                </x-filament::input.wrapper>

                <x-filament::input.wrapper>
                    <select wire:model="editForm.category_id" class="w-full border-none bg-transparent focus:ring-0 text-sm">
                        <option value="">-- Choisir une catégorie --</option>

                        @foreach(\App\Models\Category::where('organisation_id', filament()->getTenant()->id)->get() as $category)
                        <option value="{{ $category->id }}">
                            {{ $category->name }}
                        </option>
                        @endforeach
                    </select>
                </x-filament::input.wrapper>

            </div>

            <div class="mt-6 flex justify-end">
                <x-filament::button type="submit">
                    Enregistrer
                </x-filament::button>
            </div>

        </form>
    </x-filament::modal>

</x-filament::page>
