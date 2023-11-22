<?php

namespace App\Filament\Resources\DealResource\Pages;

use App\Filament\Resources\DealResource;
use App\Models\Deal;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ListRecords\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListDeals extends ListRecords
{
    protected static string $resource = DealResource::class;

    protected function getTableQuery(): Builder
    {
        return parent::getTableQuery()->orderByDesc('id');
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All Deals')
                ->icon('heroicon-m-user-group')
                ->badge(Deal::count()),
            'me' => Tab::make('My Deals')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('owner_id', auth()->user()->id))
                ->icon('heroicon-m-user')
                ->badge(Deal::where('owner_id', auth()->user()->id)->count()),
        ];
    }

    public function getDefaultActiveTab(): string|int|null
    {
        return 'me';
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
