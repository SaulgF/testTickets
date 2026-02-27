<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Inertia\Inertia;
use App\Http\Requests\StoreTicketRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TicketController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        $user = auth()->user();

        $query = Ticket::with('user')->latest();

        if (!$user->isAdmin()) {
            $query->where('user_id', $user->id);
        }

        $tickets = $query->get();

        return Inertia::render('User/Dashboard', [
            'tickets' => $tickets
        ]);
    }

    public function create()
    {
        return Inertia::render('Tickets/Create');
    }

    public function store(StoreTicketRequest $request)
    {
        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')
                ->store('tickets', 'public');
        }

        $ticket = Ticket::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority,
            'status' => 'open',
            'image_path' => $imagePath,
        ]);

        return back()->with('success', true);
    }

    public function close(Ticket $ticket)
    {
        $this->authorize('update', $ticket);

        $ticket->update([
            'status' => 'closed'
        ]);

        return back()->with('success', true);
    }
}
