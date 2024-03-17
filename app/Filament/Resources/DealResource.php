<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DealResource\Pages;
use App\Filament\Resources\DealResource\RelationManagers;
use App\Models\Customer;
use App\Models\Deal;
use Filament\Forms;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Arr;

class DealResource extends Resource
{
    protected static ?string $model = Deal::class;

    protected static ?string $navigationIcon = "heroicon-o-rectangle-stack";

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make("name")->required(),
            Select::make("status")
                ->options(
                    collect(Deal::status)->mapWithKeys(function ($item) {
                        return [$item => ucwords(str_replace("-", " ", $item))];
                    })
                )
                ->default(Arr::first(Deal::status))
                ->native(false)
                ->required(),
            Select::make("customer_id")
                ->relationship(name: "customer", titleAttribute: "name")
                ->createOptionForm(CustomerResource::getForm())
                ->createOptionUsing(function (array $data): int {
                    return auth()
                        ->user()
                        ->customers()
                        ->create(
                            array_merge($data, ["user_id" => auth()->id()])
                        )
                        ->getKey();
                })
                ->label("Customer")
                ->loadingMessage("Loading customers...")
                ->searchable()
                ->required(),
            TextInput::make("value")->numeric()->required(),
            RichEditor::make("description")
                ->disableToolbarButtons(["codeBlock"])
                ->columnSpanFull()
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make("name"),
                TextColumn::make("value"),
                TextColumn::make("status")->badge(),
                TextColumn::make("customer.name"),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
                //
            ];
    }

    public static function getPages(): array
    {
        return [
            "index" => Pages\ListDeals::route("/"),
            "create" => Pages\CreateDeal::route("/create"),
            "edit" => Pages\EditDeal::route("/{record}/edit"),
        ];
    }
}
