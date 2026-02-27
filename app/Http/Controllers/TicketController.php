<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Inertia\Inertia;
use App\Http\Requests\StoreTicketRequest;

class TicketController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $tickets = $user->isAdmin()
            ? Ticket::with('user')->latest()->get()
            : $user->tickets()->latest()->get();

        return Inertia::render('Tickets/Index', [
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
}
