<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VideogamesController;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------|
| Web Routes
|--------------------------------------------------------------------------|
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard',[
        'platforms' => App\Models\Platforms::with('videogames:name')->get(),
        'videogames' => App\Models\Videogames::count(),
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/about', fn () => Inertia::render('About'))->name('about');

    Route::get('users', [UserController::class, 'index'])->name('users.index');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('platforms', App\Http\Controllers\PlatformsController::class);
    Route::resource('videogames', VideogamesController::class);
    Route::post('updateVideoGame', [App\Http\Controllers\VideogamesController::class, 'updateVideoGame'])->name('updateVideoGame');
});

require __DIR__.'/auth.php';
