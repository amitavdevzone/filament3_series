<?php

namespace App\Filament\Pages;

use App\Enums\DealStages;
use App\Filament\Resources\DealResource;
use App\Models\Deal;
use Filament\Pages\Actions\CreateAction;
use Illuminate\Support\Collection;
use Mokhosh\FilamentKanban\Pages\KanbanBoard;

class DealsKanbanBoard extends KanbanBoard
{
    protected static string $model = Deal::class;

    protected static string $statusEnum = DealStages::class;

    protected static string $recordTitleAttribute = 'name';

    protected static string $recordStatusAttribute = 'stage';

    protected string $editModalWidth = '5xl';

    protected function records(): Collection
    {
        return Deal::query()->where('owner_id', auth()->id())->get();
    }

    public function onStatusChanged(
        int $recordId,
        string $status,
        array $fromOrderedIds,
        array $toOrderedIds
    ): void {
        Deal::find($recordId)->update(['stage' => $status]);
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make('Create Deal')
                ->model(Deal::class)
                ->form(DealResource::getFormSchema())->slideOver(),
        ];
    }

    protected function getEditModalFormSchema(?int $recordId): array
    {
        return DealResource::getFormSchema();
    }
}
