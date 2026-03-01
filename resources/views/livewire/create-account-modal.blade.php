<div>
    <x-filament::button
        color="primary"
        icon="heroicon-o-plus"
        wire:click="$set('showModal', true)"
    >
        Ajouter un compte
    </x-filament::button>

    @if($showModal)
        <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl p-6 w-full max-w-md">

                <h2 class="text-lg font-bold mb-4">
                    Créer un nouveau compte
                </h2>

                <form wire:submit.prevent="save">

                    <div class="space-y-4">

                        <input
                            type="text"
                            wire:model="name"
                            placeholder="Nom"
                            class="w-full rounded-lg border-gray-300"
                        />

                        <input
                            type="url"
                            wire:model="url"
                            placeholder="URL"
                            class="w-full rounded-lg border-gray-300"
                        />

                        <input
                            type="text"
                            wire:model="identifiant"
                            placeholder="Identifiant"
                            class="w-full rounded-lg border-gray-300"
                        />

                        <input
                            type="password"
                            wire:model="password"
                            placeholder="Mot de passe"
                            class="w-full rounded-lg border-gray-300"
                        />

                        <select wire:model="category_id" class="w-full rounded-lg border-gray-300">
                            <option value="">-- Catégorie --</option>
                            @foreach(\App\Models\Category::where('organisation_id', auth()->user()->organisations()->first()->id)->get() as $category)
                                <option value="{{ $category->id }}">
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>

                    </div>

                    <div class="mt-6 flex justify-end gap-2">
                        <button type="button"
                                wire:click="$set('showModal', false)"
                                class="px-4 py-2 text-sm">
                            Annuler
                        </button>

                        <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm">
                            Créer
                        </button>
                    </div>

                </form>

            </div>
        </div>
    @endif
</div>