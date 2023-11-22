<?php

namespace App\Filament\Resources;

use App\Enums\DealStages;
use App\Filament\Resources\DealResource\Pages;
use App\Models\Deal;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class DealResource extends Resource
{
    protected static ?string $model = Deal::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->minLength(3)
                    ->maxLength(255),
                Select::make('stage')
                    ->required()
                    ->options(DealStages::class),
                Select::make('company_id')
                    ->live()
                    ->searchable()
                    ->preload()
                    ->relationship(
                        name: 'company',
                        titleAttribute: 'name',
                    ),
                Select::make('contact_id')
                    ->searchable()
                    ->preload()
                    ->relationship(
                        name: 'contact',
                        titleAttribute: 'name',
                        modifyQueryUsing: fn (Builder $query, Get $get) => $query
                            ->when($get('company_id') != '', function (Builder $query) use ($get) {
                                $query->whereHas('companies', fn (Builder $query) => $query
                                    ->where('companies.id', $get('company_id')));
                            })
                            ->active(),
                    ),
                TextInput::make('deal_value')
                    ->required(),
                RichEditor::make('description')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('company.name'),
                Tables\Columns\TextColumn::make('contact.name'),
                Tables\Columns\TextColumn::make('deal_value'),
                Tables\Columns\SelectColumn::make('stage')
                    ->options(DealStages::class),
                Tables\Columns\TextColumn::make('owner.name'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()->button(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make()
                    ->columns([
                        'sm' => 4,
                    ])
                    ->schema([
                        Section::make()->schema([])->columnSpan(1),
                        Section::make()
                            ->columnSpan(2)
                            ->schema([
                                TextEntry::make('name')
                                    ->label('Deal name'),
                                TextEntry::make('description')
                                    ->html(),
                                TextEntry::make('stage'),
                            ]),
                        Section::make()->schema([])->columnSpan(1),
                    ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDeals::route('/'),
            'create' => Pages\CreateDeal::route('/create'),
            'view' => Pages\ViewDeal::route('/{record}/view'),
            'edit' => Pages\EditDeal::route('/{record}/edit'),
        ];
    }
}
