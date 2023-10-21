<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CompanyResource\Pages;
use App\Filament\Resources\CompanyResource\RelationManagers\ContactsRelationManager;
use App\Models\Company;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class CompanyResource extends Resource
{
    protected static ?string $model = Company::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Company information')
                    ->description('The Company information with details')
                    ->schema([
                        TextInput::make('name')
                            ->autocomplete(false)
                            ->unique(ignoreRecord: true)
                            ->required(),
                        TextInput::make('industry')
                            ->autocomplete(false)
                            ->required(),
                        TextInput::make('website')
                            ->autocomplete(false)
                            ->unique(ignoreRecord: true),
                    ])->columnSpan(2),
                Section::make('Meta data')
                    ->schema([
                        Placeholder::make('owner_id')
                            ->label('Owner')
                            ->content(fn (Company $company): ?string => $company?->owner?->name)
                            ->hiddenOn('create'),
                        Placeholder::make('created_at')
                            ->label('Created')
                            ->content(fn (Company $company): ?string => $company->created_at?->diffForHumans())
                            ->hiddenOn('create'),
                        Placeholder::make('updated_at')
                            ->label('Last upated')
                            ->content(fn (Company $company): ?string => $company->updated_at?->diffForHumans())
                            ->hiddenOn('create'),
                    ])
                    ->columnSpan(1)
                    ->hiddenOn(CompaniesRelationManager::class),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('industry'),
                TextColumn::make('website'),
                ToggleColumn::make('status'),
                TextColumn::make('created_at'),
                TextColumn::make('updated_at')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->button(),
                Tables\Actions\DeleteAction::make()
                    ->hidden(fn (Company $company): bool => $company->contacts()->count() != 0)
                    ->button(),
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
            ContactsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCompanies::route('/'),
            'create' => Pages\CreateCompany::route('/create'),
            'edit' => Pages\EditCompany::route('/{record}/edit'),
        ];
    }
}
