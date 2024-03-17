<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Models\Customer;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = "heroicon-o-users";

    public static function form(Form $form): Form
    {
        return $form->schema(self::getForm())->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make("name"),
                TextColumn::make("email"),
                TextColumn::make("phone_number"),
                TextColumn::make("owner.name")->hidden(
                    fn(Customer $customer): bool => $customer->user_id !==
                        auth()->user()->id
                ),
                TextColumn::make("created_at"),
                TextColumn::make("updated_at"),
            ])
            ->filters([
                //
            ])
            ->actions([Tables\Actions\EditAction::make()])
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
            "index" => Pages\ListCustomers::route("/"),
            "create" => Pages\CreateCustomer::route("/create"),
            "edit" => Pages\EditCustomer::route("/{record}/edit"),
        ];
    }

    public static function getForm(): array
    {
        return [
            Section::make("Personal information")
                ->description("The personal information of a Customer")
                ->schema([
                    TextInput::make("name")->required(),
                    TextInput::make("email")->required()->email(),
                    TextInput::make("phone_number"),
                ])
                ->columnSpan(2),
            Section::make("Meta data")
                ->schema([
                    Placeholder::make("user_id")
                        ->label("Owner")
                        ->content(
                            fn(Customer $customer): ?string => $customer?->owner
                                ?->name
                        )
                        ->hidden(
                            fn(?Customer $customer) => $customer->id === null
                        ),
                    Placeholder::make("created_at")
                        ->label("Created at")
                        ->content(
                            fn(
                                Customer $customer
                            ): ?string => $customer->created_at?->diffForHumans()
                        )
                        ->hidden(
                            fn(?Customer $customer) => $customer->id === null
                        ),
                    Placeholder::make("updated_at")
                        ->label("Last upated")
                        ->content(
                            fn(
                                Customer $customer
                            ): ?string => $customer->updated_at?->diffForHumans()
                        )
                        ->hidden(
                            fn(?Customer $customer) => $customer->id === null
                        ),
                ])
                ->columnSpan(1),
        ];
    }
}
