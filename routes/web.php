<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use function Pest\Laravel\get;
use App\Http\Controllers\TaskController;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('vital', function () {
    return Inertia::render('Vital');
})->middleware(['auth', 'verified'])->name('vital');

Route::get('tasks', function () {
    return Inertia::render('Task');
})->middleware(['auth', 'verified'])->name('tasks');

Route::get('tasks/create', [TaskController::class, 'create'])->name('tasks.create');
Route::post('tasks/create', [TaskController::class, 'store'])->name('tasks.store');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
