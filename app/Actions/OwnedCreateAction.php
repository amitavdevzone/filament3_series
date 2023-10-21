<?php

namespace App\Actions;

use Filament\Tables\Actions\CreateAction;

class OwnedCreateAction
{
    public static function make()
    {
        return CreateAction::make()
            ->mutateFormDataUsing(function (array $data): array {
                $data['owner_id'] = auth()->id();

                return $data;
            });
    }
}
