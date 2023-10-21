<?php

namespace App\Filament\Resources\CompanyResource\Pages;

use App\Filament\Resources\CompanyResource;
use App\Traits\OwnedDataMutation;
use Filament\Resources\Pages\CreateRecord;

class CreateCompany extends CreateRecord
{
    use OwnedDataMutation;

    protected static string $resource = CompanyResource::class;
}
