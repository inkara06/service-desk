<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;

class AdminTicketController extends Controller
{
    public function index(Request $request)
{
    $q = trim((string) $request->get('q', ''));

    $ticketsQuery = Ticket::with(['author', 'assignee']);

    // Поиск (ID / title / description / автор)
    if ($q !== '') {
        $ticketsQuery->where(function ($qq) use ($q) {
            if (ctype_digit($q)) {
                $qq->orWhere('id', (int) $q);
            }

            $qq->orWhere('title', 'like', "%{$q}%")
               ->orWhere('description', 'like', "%{$q}%")
               ->orWhereHas('author', function ($u) use ($q) {
                   $u->where('email', 'like', "%{$q}%")
                     ->orWhere('name', 'like', "%{$q}%");
               });
        });
    }

    // Статус
    if ($request->filled('status')) {
        $ticketsQuery->where('status', $request->status);
    }

    // Категория
    if ($request->filled('category')) {
        $ticketsQuery->where('category', $request->category);
    }

    // Приоритет
    if ($request->filled('priority')) {
        $ticketsQuery->where('priority', $request->priority);
    }

    // Исполнитель
    if ($request->filled('assignee_id')) {
        $ticketsQuery->where('assignee_id', $request->assignee_id);
    }

    // Даты (создания заявки)
    if ($request->filled('from')) {
        $ticketsQuery->whereDate('created_at', '>=', $request->from);
    }
    if ($request->filled('to')) {
        $ticketsQuery->whereDate('created_at', '<=', $request->to);
    }

    $tickets = $ticketsQuery
        ->latest()
        ->paginate(15)
        ->appends($request->query()); // важно: сохраняет фильтры в пагинации

    // Исполнители (логично фильтровать по админам)
    $assignees = User::where('role', 'admin')->orderBy('name')->get();

    // Списки для фильтров
    $categories = Ticket::query()
        ->select('category')->whereNotNull('category')
        ->distinct()->orderBy('category')->pluck('category');

    $priorities = Ticket::query()
        ->select('priority')->whereNotNull('priority')
        ->distinct()->orderBy('priority')->pluck('priority');

    return view('admin.tickets.index', compact('tickets', 'assignees', 'categories', 'priorities'));
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