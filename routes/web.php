<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [TaskController::class, 'index'])->name('task');
Route::post('/task', [TaskController::class, 'store'])->name('task.store');
Route::put('/task/{id}', [TaskController::class, 'update'])->name('task.update');
Route::delete('/task/{id}', [TaskController::class, 'destroy'])->name('task.destroy');
