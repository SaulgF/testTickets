<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Ticket;

class TicketPolicy
{
    public function update(User $user, Ticket $ticket): bool
    {
        return $user->isAdmin();
    }
}
