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

Route::middleware(['auth', 'verified'])->group(function () {
    // Task Routes
    Route::get('tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::get('tasks/create', [TaskController::class, 'create'])->name('tasks.create');
    Route::post('tasks/create', [TaskController::class, 'store'])->name('tasks.store');
    Route::get('tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
    Route::put('tasks/{task}/edit', [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
