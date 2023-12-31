<?php

namespace App\Filament\Resources\ContactResource\RelationManagers;

use App\Actions\OwnedCreateAction;
use App\Filament\Resources\DealResource;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class DealsRelationManager extends RelationManager
{
    protected static string $relationship = 'deals';

    public function form(Form $form): Form
    {
        return DealResource::form($form);
    }

    public function table(Table $table): Table
    {
        return DealResource::table($table)
            ->headerActions([
                OwnedCreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->button(),
                Tables\Actions\DeleteAction::make()->button(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
