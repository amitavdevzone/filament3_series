<?php

namespace App\Enums;

use Mokhosh\FilamentKanban\Concerns\IsKanbanStatus;

enum DealStages: string
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
}
