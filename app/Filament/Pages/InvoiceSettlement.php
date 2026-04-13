<?php

namespace App\Filament\Pages;

use App\Models\Invoice;
use App\Models\User;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Collection;

class InvoiceSettlement extends Page
{
    protected string $view = 'filament.pages.invoice-settlement';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedScale;

    public static function getNavigationLabel(): string
    {
        return __('Settlement');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('Finance');
    }

    public function getTitle(): string
    {
        return __('Expense Settlement');
    }

    /**
     * @return Collection<int, array{id: int, name: string, paid: float, share: float, balance: float}>
     */
    public function getBalances(): Collection
    {
        $admins = User::query()->where('is_admin', true)->orderBy('name')->get(['id', 'name']);

        if ($admins->isEmpty()) {
            return collect();
        }

        $total = (float) Invoice::sum('amount');
        $share = $total / $admins->count();

        $paid = Invoice::query()
            ->selectRaw('paid_by_user_id, SUM(amount) as total')
            ->groupBy('paid_by_user_id')
            ->pluck('total', 'paid_by_user_id')
            ->map(fn ($v) => (float) $v);

        return $admins->map(fn (User $admin) => [
            'id' => $admin->id,
            'name' => $admin->name,
            'paid' => $paid->get($admin->id, 0.0),
            'share' => $share,
            'balance' => $paid->get($admin->id, 0.0) - $share,
        ]);
    }

    /**
     * @return array<int, array{from: string, to: string, amount: float}>
     */
    public function getTransfers(): array
    {
        $balances = $this->getBalances();

        // Build mutable debtors/creditors lists
        $debtors = $balances
            ->filter(fn ($b) => $b['balance'] < -0.005)
            ->map(fn ($b) => ['name' => $b['name'], 'amount' => -$b['balance']])
            ->values()
            ->toArray();

        $creditors = $balances
            ->filter(fn ($b) => $b['balance'] > 0.005)
            ->map(fn ($b) => ['name' => $b['name'], 'amount' => $b['balance']])
            ->values()
            ->toArray();

        $transfers = [];

        $i = 0;
        $j = 0;

        while ($i < count($debtors) && $j < count($creditors)) {
            $amount = round(min($debtors[$i]['amount'], $creditors[$j]['amount']), 2);

            $transfers[] = [
                'from' => $debtors[$i]['name'],
                'to' => $creditors[$j]['name'],
                'amount' => $amount,
            ];

            $debtors[$i]['amount'] = round($debtors[$i]['amount'] - $amount, 2);
            $creditors[$j]['amount'] = round($creditors[$j]['amount'] - $amount, 2);

            if ($debtors[$i]['amount'] < 0.005) {
                $i++;
            }

            if ($creditors[$j]['amount'] < 0.005) {
                $j++;
            }
        }

        return $transfers;
    }

    public function getTotalExpenses(): float
    {
        return (float) Invoice::sum('amount');
    }
}
