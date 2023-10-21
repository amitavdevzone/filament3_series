<?php

namespace App\Filament\Resources\ContactResource\Pages;

use App\Filament\Resources\ContactResource;
use App\Traits\OwnedDataMutation;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateContact extends CreateRecord
{
    use OwnedDataMutation;

    protected static string $resource = ContactResource::class;

    protected function getRedirectUrl(): string
    {
        return ContactResource::getUrl('index');
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->title('A new contact was added. Horray!!!')
            ->success()
            ->body('A new contact got added. Let us try and add more')
            ->duration(3000)
            ->send();
    }
}
