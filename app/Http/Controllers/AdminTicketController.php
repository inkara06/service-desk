<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;

class AdminTicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::with(['author', 'assignee'])->latest()->paginate(15);
        $users = User::where('role', 'user')->orderBy('name')->get();

        return view('admin.tickets.index', compact('tickets', 'users'));
    }

    public function updateStatus(Request $request, Ticket $ticket)
    {
        $request->validate([
            'status' => ['required', 'in:new,in_progress,done,rejected'],
            'assignee_id' => ['nullable', 'exists:users,id'],
            'due_date' => ['nullable', 'date'],
        ]);

        $ticket->update([
            'status' => $request->status,
            'assignee_id' => $request->assignee_id,
            'due_date' => $request->due_date,
        ]);

        return back();
    }
}