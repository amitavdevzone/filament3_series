<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactResource\Pages;
use App\Filament\Resources\ContactResource\RelationManagers\CompaniesRelationManager;
use App\Filament\Resources\ContactResource\RelationManagers\DealsRelationManager;
use App\Models\Contact;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Personal information')
                    ->description('The personal information of a Contact')
                    ->schema([
                        TextInput::make('name')
                            ->required(),
                        TextInput::make('email')
                            ->required()
                            ->email(),
                        TextInput::make('phone_number'),
                    ])->columnSpan(2),
                Section::make('Meta data')
                    ->schema([
                        Toggle::make('is_active')->default(1),
                        Placeholder::make('owner_id')
                            ->label('Owner')
                            ->content(fn (Contact $contact): ?string => $contact?->owner?->name)
                            ->hiddenOn('create'),
                        Placeholder::make('created_at')
                            ->label('Created at')
                            ->content(fn (Contact $contact): ?string => $contact->created_at?->diffForHumans())
                            ->hiddenOn('create'),
                        Placeholder::make('updated_at')
                            ->label('Last updated')
                            ->content(fn (Contact $contact): ?string => $contact->updated_at?->diffForHumans())
                            ->hiddenOn('create'),
                    ])
                    ->columnSpan(1),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('email'),
                TextColumn::make('phone_number'),
                Tables\Columns\ToggleColumn::make('is_active'),
                TextColumn::make('owner.name')
                    ->hidden(fn (Contact $contact): bool => $contact->owner_id !== auth()->user()->id),
                TextColumn::make('created_at'),
                TextColumn::make('updated_at')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->button(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            DealsRelationManager::class,
            CompaniesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContacts::route('/'),
            'create' => Pages\CreateContact::route('/create'),
            'edit' => Pages\EditContact::route('/{record}/edit'),
        ];
    }
}
