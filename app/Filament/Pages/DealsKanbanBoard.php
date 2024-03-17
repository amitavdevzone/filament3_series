<?php

namespace App\Filament\Pages;

use App\Enums\DealStages;
use App\Models\Deal;
use Illuminate\Support\Collection;
use Mokhosh\FilamentKanban\Pages\KanbanBoard;

class DealsKanbanBoard extends KanbanBoard
{
    protected static string $model = Deal::class;

    protected static string $statusEnum = DealStages::class;

    protected static string $recordTitleAttribute = 'name';

    protected static string $recordStatusAttribute = 'stage';

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
}
