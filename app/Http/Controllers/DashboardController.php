<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Inertia\Inertia;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        $query = Ticket::with('user')->latest();

        if (!$user->isAdmin()) {
            $query->where('user_id', $user->id);
        }

        if ($request->status && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $tickets = $query->get();

        return Inertia::render(
            $user->isAdmin() ? 'Admin/Dashboard' : 'User/Dashboard',
            [
                'tickets' => $tickets,
                'filters' => [
                    'status' => $request->status ?? 'all'
                ]
            ]
        );
    }
}
