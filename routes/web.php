<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\AdminTicketController;
use App\Models\Ticket;

Route::get('/', fn () => redirect()->route('dashboard'));


Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user->role === 'admin') {
        $stats = [
            'total' => Ticket::count(),
            'in_progress' => Ticket::where('status', 'in_progress')->count(),
            'done' => Ticket::where('status', 'done')->count(),
        ];
    } else {
        $stats = [
            'total' => Ticket::where('author_id', $user->id)->count(),
            'in_progress' => Ticket::where('author_id', $user->id)->where('status', 'in_progress')->count(),
            'done' => Ticket::where('author_id', $user->id)->where('status', 'done')->count(),
        ];
    }

    return view('dashboard', compact('stats'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
    Route::get('/tickets/create', [TicketController::class, 'create'])->name('tickets.create');
    Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/tickets', [AdminTicketController::class, 'index'])->name('tickets.index');
    Route::patch('/tickets/{ticket}/status', [AdminTicketController::class, 'updateStatus'])->name('tickets.status');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';