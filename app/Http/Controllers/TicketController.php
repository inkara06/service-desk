<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::where('author_id', auth()->id())
            ->latest()
            ->paginate(10);

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