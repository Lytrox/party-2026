<?php

namespace App\Filament\Resources\Rsvps\Pages;

use App\Filament\Resources\Rsvps\RsvpResource;
use App\Models\Rsvp;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRsvps extends ListRecords
{
    protected static string $resource = RsvpResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('download_badge_names')
                ->label(__('Download badge names'))
                ->icon('heroicon-o-arrow-down-tray')
                ->color('gray')
                ->action(function () {
                    $rows = Rsvp::query()
                        ->whereNotNull('badge_name')
                        ->where('badge_name', '!=', '')
                        ->where('attending', true)
                        ->with('user:id,name')
                        ->orderBy('badge_name')
                        ->get(['badge_name', 'user_id']);

                    $csv = implode(',', [__('Badge name'), __('User')])."\n";

                    foreach ($rows as $rsvp) {
                        $csv .= implode(',', [
                            '"'.str_replace('"', '""', $rsvp->badge_name).'"',
                            '"'.str_replace('"', '""', $rsvp->user?->name ?? '').'"',
                        ])."\n";
                    }

                    return response()->streamDownload(
                        fn () => print ($csv),
                        'badge-names.csv',
                        ['Content-Type' => 'text/csv'],
                    );
                }),

            CreateAction::make(),
        ];
    }
}
