<?php

namespace App\Filament\Resources\CompanyResource\RelationManagers;

use App\Actions\OwnedCreateAction;
use App\Filament\Resources\ContactResource;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class ContactsRelationManager extends RelationManager
{
    protected static string $relationship = 'contacts';

    public function form(Form $form): Form
    {
        return ContactResource::form($form);
    }

    public function table(Table $table): Table
    {
        return ContactResource::table($table)
            ->recordTitleAttribute('name')
            ->filters([
                //
            ])
            ->headerActions([
                OwnedCreateAction::make(),
                Tables\Actions\AttachAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->button(),
                Tables\Actions\DetachAction::make()->button(),
                Tables\Actions\DeleteAction::make()->button(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make(),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
