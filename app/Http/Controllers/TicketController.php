<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index(Request $request)
{
    $userId = auth()->id();

    $allowedStatuses = ['new', 'in_progress', 'done', 'rejected'];

    $status = $request->query('status');

    $tickets = Ticket::query()
        ->where('author_id', $userId)
        ->when($status && in_array($status, $allowedStatuses, true), function ($q) use ($status) {
            $q->where('status', $status);
        })
        ->latest()
        ->paginate(10)
        ->withQueryString(); 

    return view('tickets.index', compact('tickets'));
}

    public function create()
    {if (auth()->user()->role === 'admin') {
        return redirect()->route('admin.tickets.index');}
        return view('tickets.create');
    }


    public function store(Request $request)
    {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.tickets.index');
        }
        $data = $request->validate([
            'title' => ['required','string','max:255'],
            'category' => ['required','string','max:100'],
            'priority' => ['required','in:low,medium,high'],
            'description' => ['required','string'],
            'due_date' => ['nullable','date'],
        ]);

        $data['author_id'] = auth()->id();
        $data['status'] = 'new';

        Ticket::create($data);

        return redirect()->route('tickets.index');
    }
}