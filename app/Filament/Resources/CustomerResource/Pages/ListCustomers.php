<?php

namespace App\Filament\Resources\CustomerResource\Pages;

use App\Filament\Resources\CustomerResource;
use App\Models\Customer;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ListRecords\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListCustomers extends ListRecords
{
    protected static string $resource = CustomerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getTableQuery(): Builder
    {
        return parent::getTableQuery()->orderByDesc('id');
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All customer')
                ->icon('heroicon-m-user-group'),
            'me' => Tab::make('My customers')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('user_id', auth()->user()->id))
                ->icon('heroicon-m-user')
                ->badge(Customer::where('user_id', auth()->user()->id)->count()),
        ];
    }

    public function getDefaultActiveTab(): string|int|null
    {
        return 'me';
    }
}
