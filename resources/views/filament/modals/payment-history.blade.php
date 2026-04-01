{{-- resources/views/filament/modals/payment-history.blade.php --}}
<div class="space-y-4 py-2">

    @forelse($payments as $payment)
    <div class="flex items-start gap-4 p-4 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">

        {{-- Icône mode de paiement --}}
        <div class="w-10 h-10 rounded-full flex items-center justify-center text-lg flex-shrink-0
                    {{ $payment->payment_method === 'cash' ? 'bg-green-100 dark:bg-green-900/40' : 'bg-blue-100 dark:bg-blue-900/40' }}">
            {{ $payment->payment_method === 'cash' ? '💵' : '🏦' }}
        </div>

        {{-- Infos --}}
        <div class="flex-1 min-w-0">
            <div class="flex items-center justify-between gap-2 flex-wrap">
                <span class="font-semibold text-gray-900 dark:text-white text-sm">
                    {{ $payment->planLabel() }}
                    <span class="text-gray-400 font-normal">· {{ $payment->duration_months }} mois</span>
                </span>
                <span class="font-bold text-green-600 dark:text-green-400 text-sm">
                    {{ $payment->formattedAmount() }}
                </span>
            </div>

            <div class="mt-1 text-xs text-gray-500 dark:text-gray-400 space-y-0.5">
                <div>
                    📅 Payé le <strong>{{ $payment->paid_at->format('d/m/Y à H:i') }}</strong>
                    · par {{ $payment->paymentMethodLabel() }}
                </div>
                <div>
                    🔄 Période : {{ $payment->period_start->format('d/m/Y') }} → {{ $payment->period_end->format('d/m/Y') }}
                </div>
                @if($payment->recordedBy)
                <div>👤 Enregistré par : <strong>{{ $payment->recordedBy->name }}</strong></div>
                @endif
                @if($payment->notes)
                <div class="mt-1 italic text-gray-400">"{{ $payment->notes }}"</div>
                @endif
            </div>
        </div>
    </div>

    @empty
    <div class="text-center py-10 text-gray-400">
        <div class="text-4xl mb-3">💳</div>
        <p class="text-sm">Aucun paiement enregistré pour cette organisation.</p>
    </div>
    @endforelse

</div>