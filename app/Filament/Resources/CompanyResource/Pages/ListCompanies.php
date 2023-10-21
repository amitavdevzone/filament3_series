<?php

namespace App\Filament\Resources\CompanyResource\Pages;

use App\Filament\Resources\CompanyResource;
use App\Models\Company;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ListRecords\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListCompanies extends ListRecords
{
    protected static string $resource = CompanyResource::class;

    protected function getTableQuery(): Builder
    {
        return parent::getTableQuery()->orderByDesc('id');
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All Companies')
                ->icon('heroicon-m-user-group')
                ->badge(Company::count()),
            'me' => Tab::make('My Companies')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('owner_id', auth()->user()->id))
                ->icon('heroicon-m-user')
                ->badge(Company::where('owner_id', auth()->user()->id)->count()),
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
