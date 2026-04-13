<x-filament-panels::page>

    @php
        $balances = $this->getBalances();
        $transfers = $this->getTransfers();
        $total = $this->getTotalExpenses();
        $border = 'border-bottom:1px solid rgba(128,128,128,0.15);';
        $borderThick = 'border-bottom:2px solid rgba(128,128,128,0.25);';
        $thStyle = 'padding:0.5rem 0.75rem;text-align:left;font-size:0.75rem;font-weight:600;text-transform:uppercase;letter-spacing:0.05em;';
        $thStyleR = 'padding:0.5rem 0.75rem;text-align:right;font-size:0.75rem;font-weight:600;text-transform:uppercase;letter-spacing:0.05em;';
    @endphp

    @if ($balances->isEmpty())
        <x-filament::section>
            <p style="text-align:center;padding:2rem 0;" class="text-sm text-gray-500 dark:text-gray-400">
                {{ __('No invoices recorded yet.') }}
            </p>
        </x-filament::section>
    @else

        {{-- Summary stats --}}
        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:1rem;">
            <x-filament::section>
                <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-500">{{ __('Total expenses') }}</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white" style="margin-top:0.25rem;">€{{ number_format($total, 2, '.', ',') }}</p>
            </x-filament::section>
            <x-filament::section>
                <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-500">{{ __('Administrators') }}</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white" style="margin-top:0.25rem;">{{ $balances->count() }}</p>
            </x-filament::section>
            <x-filament::section>
                <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-500">{{ __('Fair share per person') }}</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white" style="margin-top:0.25rem;">€{{ $balances->count() > 0 ? number_format($total / $balances->count(), 2, '.', ',') : '0.00' }}</p>
            </x-filament::section>
        </div>

        {{-- Per-person balances --}}
        <x-filament::section :heading="__('Balance per administrator')">
            <table style="width:100%;border-collapse:collapse;font-size:0.875rem;">
                <thead>
                    <tr>
                        <th style="{{ $thStyle . $borderThick }}" class="text-gray-400 dark:text-gray-500">{{ __('Name') }}</th>
                        <th style="{{ $thStyleR . $borderThick }}" class="text-gray-400 dark:text-gray-500">{{ __('Paid') }}</th>
                        <th style="{{ $thStyleR . $borderThick }}" class="text-gray-400 dark:text-gray-500">{{ __('Share') }}</th>
                        <th style="{{ $thStyleR . $borderThick }}" class="text-gray-400 dark:text-gray-500">{{ __('Balance') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($balances as $b)
                        <tr>
                            <td style="padding:0.75rem;font-weight:500;{{ $border }}" class="text-gray-900 dark:text-white">{{ $b['name'] }}</td>
                            <td style="padding:0.75rem;text-align:right;{{ $border }}" class="text-gray-700 dark:text-gray-300">€{{ number_format($b['paid'], 2, '.', ',') }}</td>
                            <td style="padding:0.75rem;text-align:right;{{ $border }}" class="text-gray-700 dark:text-gray-300">€{{ number_format($b['share'], 2, '.', ',') }}</td>
                            <td style="padding:0.75rem;text-align:right;font-weight:600;{{ $border }}">
                                @if ($b['balance'] > 0.005)
                                    <span class="text-emerald-600 dark:text-emerald-400">+€{{ number_format($b['balance'], 2, '.', ',') }}</span>
                                @elseif ($b['balance'] < -0.005)
                                    <span class="text-red-600 dark:text-red-400">−€{{ number_format(abs($b['balance']), 2, '.', ',') }}</span>
                                @else
                                    <span class="text-gray-400 dark:text-gray-500">{{ __('Even') }}</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </x-filament::section>

        {{-- Suggested transfers --}}
        <x-filament::section :heading="__('Suggested transfers')">
            @if (empty($transfers))
                <p style="text-align:center;padding:1rem 0;" class="text-sm text-gray-400 dark:text-gray-500">
                    {{ __('Everyone is even — no transfers needed.') }}
                </p>
            @else
                <table style="width:100%;border-collapse:collapse;font-size:0.875rem;">
                    <thead>
                        <tr>
                            <th style="{{ $thStyle . $borderThick }}" class="text-gray-400 dark:text-gray-500">{{ __('From') }}</th>
                            <th style="{{ $thStyle . $borderThick }}" class="text-gray-400 dark:text-gray-500">{{ __('To') }}</th>
                            <th style="{{ $thStyleR . $borderThick }}" class="text-gray-400 dark:text-gray-500">{{ __('Amount') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transfers as $t)
                            <tr>
                                <td style="padding:0.75rem;font-weight:500;{{ $border }}" class="text-red-600 dark:text-red-400">{{ $t['from'] }}</td>
                                <td style="padding:0.75rem;font-weight:500;{{ $border }}" class="text-emerald-600 dark:text-emerald-400">{{ $t['to'] }}</td>
                                <td style="padding:0.75rem;text-align:right;font-weight:600;{{ $border }}" class="text-gray-900 dark:text-white">€{{ number_format($t['amount'], 2, '.', ',') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </x-filament::section>

    @endif

</x-filament-panels::page>
