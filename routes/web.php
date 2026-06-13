<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;

// Temporary route to add sample event (remove later)
Route::get('/add-event', function () {
    $event = App\Models\Event::create([
        'organiser_id' => 1,
        'title' => 'IIUM Tech Conference 2026',
        'description' => 'A conference about web development.',
        'venue' => 'IIUM Main Hall',
        'event_date' => '2026-07-15',
        'category' => 'Technology',
        'max_slots' => 100
    ]);
    return 'Event created: ' . $event->title;
});

// Role selection page
Route::get('/', function () {
    if (auth()->check()) {
        return redirect('/dashboard');
    }
    return view('role-select');
});

Route::get('/role-select', function () {
    auth()->logout();
    return view('role-select');
})->name('role.select');

// Separate login pages for student and organizer
Route::get('/login/student', function () {
    return view('auth.student-login');
})->name('student.login');

Route::get('/login/organizer', function () {
    return view('auth.organizer-login');
})->name('organizer.login');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/events', [EventController::class, 'index'])->middleware(['auth'])->name('events');
Route::post('/events/register/{id}', [EventController::class, 'register'])->middleware(['auth'])->name('events.register');

Route::get('/my-registrations', function () {
    $registrations = App\Models\Registration::where('user_id', auth()->id())->with('event')->get();
    return view('my-registrations', compact('registrations'));
})->middleware(['auth'])->name('my-registrations');

Route::delete('/events/cancel/{id}', [EventController::class, 'cancel'])->middleware(['auth'])->name('events.cancel');

// Organizer routes
Route::middleware(['auth'])->group(function () {
    Route::get('/organizer/dashboard', [EventController::class, 'organizerDashboard'])->name('organizer.dashboard');
    Route::get('/organizer/events/create', [EventController::class, 'create'])->name('organizer.events.create');
    Route::post('/organizer/events', [EventController::class, 'store'])->name('organizer.events.store');
    Route::get('/organizer/events/{id}/edit', [EventController::class, 'edit'])->name('organizer.events.edit');
    Route::put('/organizer/events/{id}', [EventController::class, 'update'])->name('organizer.events.update');
    Route::delete('/organizer/events/{id}', [EventController::class, 'destroy'])->name('organizer.events.destroy');
    Route::get('/organizer/events/{id}/registrations', [EventController::class, 'viewRegistrations'])->name('organizer.events.registrations');
});