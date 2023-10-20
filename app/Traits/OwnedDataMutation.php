<?php

namespace App\Traits;

trait OwnedDataMutation
{
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['owner_id'] = auth()->user()->id;
        return $data;
    }
}
