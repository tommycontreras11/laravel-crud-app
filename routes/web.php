<?php

use App\Http\Controllers\FallBackController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostsController;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Support\Facades\Route;

/*
    GET - Request a resource
    POST - Create a new resource
    PUT - Update a resource
    PATCH - Modify a resource
    DELETE - Delete a resource
    OPTIONS - Ask the server wich verbs are allowed
*/

Route::prefix('blog')->group(function () {
    // GET
    Route::get('/', [PostsController::class, 'index'])->name('blog.index');
    Route::get('/create', [PostsController::class, 'create'])->name('blog.create');
    Route::get('/{id}', [PostsController::class, 'show'])->name('blog.show');
    Route::get('edit/{id}', [PostsController::class, 'edit'])->name('blog.edit');

    Route::post('/', [PostsController::class, 'store'])->name('blog.store');
    Route::patch('/{id}', [PostsController::class, 'update'])->name('blog.update');
    Route::delete('/{id}', [PostsController::class, 'destroy'])->name('blog.destroy');
});

// Route for invoke method
Route::get('/', HomeController::class);

// Fallback Route
Route::fallback(FallBackController::class);