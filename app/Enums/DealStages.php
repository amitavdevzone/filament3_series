<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Mokhosh\FilamentKanban\Concerns\IsKanbanStatus;

enum DealStages: string implements HasColor, HasIcon, HasLabel
{
    use BaseEnum, IsKanbanStatus;

    case DEAL_INITIATED = 'deal_initiated';
    case APPOINTMENT_SCHEDULED = 'appointment_scheduled';
    case MEETING_DONE = 'meeting_done';
    case REQUIREMENTS_RECEIVED = 'requirement_received';
    case SCOPING_COMPLETED = 'scoping_completed';
    case PROPOSAL_SENT = 'proposal_sent';
    case CLOSED_WON = 'closed_won';
    case CLOSED_LOST = 'closed_lost';

    public function getLabel(): string
    {
        return match ($this) {
            self::DEAL_INITIATED => 'Deal Initiated',
            self::APPOINTMENT_SCHEDULED => 'Appointment Scheduled',
            self::MEETING_DONE => 'Meeting Done',
            self::REQUIREMENTS_RECEIVED => 'Requirement Received',
            self::SCOPING_COMPLETED => 'Scoping Completed',
            self::PROPOSAL_SENT => 'Proposal Sent',
            self::CLOSED_WON => 'Closed Won',
            self::CLOSED_LOST => 'Closed Lost',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::DEAL_INITIATED => 'info',
            self::APPOINTMENT_SCHEDULED => 'info',
            self::MEETING_DONE => 'info',
            self::REQUIREMENTS_RECEIVED => 'warning',
            self::SCOPING_COMPLETED => 'warning',
            self::PROPOSAL_SENT => 'warning',
            self::CLOSED_WON => 'success',
            self::CLOSED_LOST => 'danger',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::DEAL_INITIATED => 'heroicon-m-sparkles',
            self::APPOINTMENT_SCHEDULED => 'heroicon-m-sparkles',
            self::MEETING_DONE => 'heroicon-m-sparkles',
            self::REQUIREMENTS_RECEIVED => 'heroicon-m-arrow-path',
            self::SCOPING_COMPLETED => 'heroicon-m-check-badge',
            self::PROPOSAL_SENT => 'heroicon-m-check-badge',
            self::CLOSED_WON => 'heroicon-m-check-badge',
            self::CLOSED_LOST => 'heroicon-m-x-circle',
        };
    }
}
