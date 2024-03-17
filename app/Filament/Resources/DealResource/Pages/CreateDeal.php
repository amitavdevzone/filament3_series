<?php

namespace App\Filament\Resources\DealResource\Pages;

use App\Filament\Resources\DealResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateDeal extends CreateRecord
{
    protected static string $resource = DealResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data["owner_id"] = auth()->user()->id;

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return DealResource::getUrl("index");
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->title("A new deal was added. Horray!!!")
            ->success()
            ->body("A new deal got added. Let us try and add more")
            ->duration(3000)
            ->send();
    }
}
