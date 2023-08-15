<?php

use App\Http\Controllers\PostsController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('blog')->group(function () {
    Route::get('/', [PostsController::class, 'index'])->name('blog.index');
    Route::get('/create', [PostsController::class, 'create'])->name('blog.create');
    Route::get('/{id}', [PostsController::class, 'show'])->name('blog.show');
    Route::get('/edit/{id}', [PostsController::class, 'edit'])->name('blog.edit');

    Route::post('/', [PostsController::class, 'store'])->name('blog.store');
    Route::patch('/{id}', [PostsController::class, 'update'])->name('blog.update');
    Route::delete('/{id}', [PostsController::class, 'destroy'])->name('blog.destroy');
});

require __DIR__.'/auth.php';
