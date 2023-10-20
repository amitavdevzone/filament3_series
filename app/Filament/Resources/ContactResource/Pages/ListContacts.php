<?php

namespace App\Filament\Resources\ContactResource\Pages;

use App\Filament\Resources\ContactResource;
use App\Models\Contact;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ListRecords\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListContacts extends ListRecords
{
    protected static string $resource = ContactResource::class;

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
            'all' => Tab::make('All contacts')
                ->icon('heroicon-m-user-group'),
            'me' => Tab::make('My contacts')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('user_id', auth()->user()->id))
                ->icon('heroicon-m-user')
                ->badge(Contact::where('user_id', auth()->user()->id)->count()),
        ];
    }

    public function getDefaultActiveTab(): string|int|null
    {
        return 'me';
    }
}
