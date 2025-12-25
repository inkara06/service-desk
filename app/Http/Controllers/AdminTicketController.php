<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;

class AdminTicketController extends Controller
{
    public function index(Request $request)
{
    $query = Ticket::with(['author','assignee'])->latest();

    if ($request->filled('search')) {
        $s = trim($request->search);

        // если ввели только число — ищем по ID
        if (ctype_digit($s)) {
            $query->where('id', (int) $s);
        } else {
            $query->where(function ($q) use ($s) {
                $q->where('title', 'like', "%{$s}%")
                  ->orWhere('description', 'like', "%{$s}%")
                  ->orWhere('category', 'like', "%{$s}%")
                  ->orWhere('priority', 'like', "%{$s}%")
                  ->orWhere('status', 'like', "%{$s}%")
                  ->orWhereHas('author', fn($a) => $a->where('email', 'like', "%{$s}%")
                                                  ->orWhere('name', 'like', "%{$s}%"))
                  ->orWhereHas('assignee', fn($a) => $a->where('name', 'like', "%{$s}%")
                                                       ->orWhere('email', 'like', "%{$s}%"));
            });
        }
    }

    $tickets = $query->paginate(15)->withQueryString();
    $users = User::where('role','user')->orderBy('name')->get();

    return view('admin.tickets.index', compact('tickets','users'));
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