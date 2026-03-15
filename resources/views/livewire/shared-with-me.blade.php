{{-- resources/views/livewire/shared-with-me.blade.php --}}
<div>
    <div class="space-y-4">

        <h3 class="text-base font-semibold text-gray-900 dark:text-white flex items-center gap-2">
            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
            </svg>
            Partagés avec moi
            @if($shares->count() > 0)
                <span class="text-xs font-medium px-2 py-0.5 rounded-full bg-indigo-100 dark:bg-indigo-900 text-indigo-700 dark:text-indigo-300">
                    {{ $shares->count() }}
                </span>
            @endif
        </h3>

        @forelse($shares as $share)
        <div class="rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">

            {{-- Header du partage --}}
            <button type="button"
                    wire:click="toggleShare({{ $share->id }})"
                    class="w-full flex items-center justify-between px-4 py-3 bg-gray-50 dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-750 transition text-left">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center text-indigo-700 dark:text-indigo-300 text-xs font-bold">
                        {{ strtoupper(substr($share->owner->name, 0, 2)) }}
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-900 dark:text-white">
                            {{ $share->owner->name }}
                        </p>
                        <p class="text-xs text-gray-500">
                            {{ $share->accounts->count() }} compte(s)
                        </p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-xs px-2 py-1 rounded-full
                        {{ $share->expires_at->diffInHours() < 2
                            ? 'bg-red-100 dark:bg-red-900/40 text-red-700 dark:text-red-300'
                            : 'bg-green-100 dark:bg-green-900/40 text-green-700 dark:text-green-300' }}">
                        ⏱ {{ $share->timeRemainingLabel() }}
                    </span>
                    <svg class="w-4 h-4 text-gray-400 transition-transform {{ $openShareId === $share->id ? 'rotate-180' : '' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>
            </button>

            {{-- Liste des comptes (accordion) --}}
            @if($openShareId === $share->id)
            <div class="divide-y divide-gray-100 dark:divide-gray-700/50">
                @foreach($share->accounts as $account)

                {{-- ⚠️ Le mot de passe n'est JAMAIS dans le HTML source.
                     Il arrive uniquement via l'événement Livewire `revealPassword`
                     et est stocké dans Alpine (JS) — même approche que le dashboard. --}}
                <div x-data="{ showPassword: false, revealedPassword: null }"
                     x-on:shared-password-revealed-{{ $account->id }}.window="
                         revealedPassword = $event.detail.password;
                         showPassword = true
                     "
                     class="px-4 py-3 bg-white dark:bg-gray-900 flex items-center gap-4">

                    {{-- Infos compte --}}
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                            {{ $account->name }}
                        </p>
                        <p class="text-xs text-gray-400 truncate">{{ $account->identifiant }}</p>
                        @if($account->url)
                            <a href="{{ $account->url }}" target="_blank"
                               class="text-xs text-indigo-500 hover:underline truncate block">
                                {{ $account->url }}
                            </a>
                        @endif
                    </div>

                    {{-- Mot de passe --}}
                    <div class="flex items-center gap-2 shrink-0">

                        {{-- Affiché uniquement après fetch Livewire --}}
                        <span x-show="showPassword" x-cloak
                              class="text-xs font-mono bg-gray-100 dark:bg-gray-800 px-2 py-1 rounded text-gray-800 dark:text-gray-200 max-w-[120px] truncate"
                              x-text="revealedPassword">
                        </span>

                        {{-- Masqué par défaut --}}
                        <span x-show="!showPassword"
                              class="text-xs text-gray-400 font-mono tracking-widest">
                            ••••••••
                        </span>

                        {{-- Bouton Voir / Cacher --}}
                        <button type="button"
                                @click="
                                    if (showPassword) {
                                        showPassword = false;
                                    } else if (revealedPassword) {
                                        showPassword = true;
                                    } else {
                                        $wire.revealPassword({{ $account->id }});
                                    }
                                "
                                class="p-1.5 text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition"
                                :title="showPassword ? 'Masquer' : 'Voir le mot de passe'">
                            <svg x-show="!showPassword" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg x-show="showPassword" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 4.411m0 0L21 21" />
                            </svg>
                        </button>

                        {{-- Bouton Copier --}}
                        <button type="button"
                                @click="
                                    if (!revealedPassword) {
                                        $wire.revealPassword({{ $account->id }});
                                        $watch('revealedPassword', val => {
                                            if (val) navigator.clipboard.writeText(val);
                                        });
                                    } else {
                                        navigator.clipboard.writeText(revealedPassword);
                                    }
                                    $el.innerHTML = '✓';
                                    setTimeout(() => $el.innerHTML = '<svg class=\'w-4 h-4\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z\'/></svg>', 1500)
                                "
                                title="Copier le mot de passe"
                                class="p-1.5 text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                            </svg>
                        </button>

                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>

        @empty
        <div class="text-center py-8 text-gray-400 text-sm">
            <svg class="w-10 h-10 mx-auto mb-2 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316" />
            </svg>
            Aucun accès partagé avec vous pour le moment.
        </div>
        @endforelse

    </div>
</div>
