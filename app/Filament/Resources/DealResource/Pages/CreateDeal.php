<?php

namespace App\Filament\Resources\DealResource\Pages;

use App\Filament\Resources\DealResource;
use App\Traits\OwnedDataMutation;
use Filament\Resources\Pages\CreateRecord;

class CreateDeal extends CreateRecord
{
    use OwnedDataMutation;

    protected static string $resource = DealResource::class;
}
