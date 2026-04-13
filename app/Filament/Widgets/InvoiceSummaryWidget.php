<?php

namespace App\Filament\Widgets;

use App\Models\Invoice;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class InvoiceSummaryWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $total = Invoice::sum('amount');

        $perPayer = Invoice::query()
            ->with('paidBy:id,name')
            ->get()
            ->groupBy('paid_by_user_id')
            ->map(fn ($invoices) => [
                'name' => $invoices->first()->paidBy?->name ?? __('Unknown'),
                'total' => $invoices->sum('amount'),
            ]);

        $stats = [
            Stat::make(__('Total expenses'), '€'.number_format($total, 2, '.', ','))
                ->icon('heroicon-o-banknotes'),
        ];

        foreach ($perPayer as $payer) {
            $stats[] = Stat::make(
                __(':name paid', ['name' => $payer['name']]),
                '€'.number_format($payer['total'], 2, '.', ',')
            )->icon('heroicon-o-user');
        }

        return $stats;
    }
}
