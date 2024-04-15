<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/cursos', [WelcomeController::class, 'getCursos'])->name('cursos');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/dashboard/cursos', [DashboardController::class, 'getCursos'])->name('dashboard.cursos');
    Route::delete('/dashboard/cursos/delete/{id}', [DashboardController::class, 'deleteCurso'])->name('dashboard.cursos.delete');
    Route::delete('/dashboard/recursos/delete/{id}', [DashboardController::class, 'deleteRecurso'])->name('dashboard.recursos.delete');
    Route::post('/dashboard/recursos/add', [DashboardController::class, 'addRecurso'])->name('dashboard.recursos.add');
    Route::post('/dashboard/cursos/add', [DashboardController::class, 'addCurso'])->name('dashboard.cursos.add');
    Route::post('/dashboard/cursos/edit', [DashboardController::class, 'editCurso'])->name('dashboard.cursos.edit');
    Route::post('/dashboard/recursos/edit', [DashboardController::class, 'editRecurso'])->name('dashboard.recursos.edit');
});

require __DIR__.'/auth.php';
