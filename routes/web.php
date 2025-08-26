<?php

use App\Http\Controllers\ThemeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;


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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('todos', [TodoController::class, 'index'])->name('todos.index'); // main page
    Route::get('todos/list', [TodoController::class, 'list'])->name('todos.list'); // JSON for AJAX table
    Route::post('todos', [TodoController::class, 'store'])->name('todos.store'); // add todo
    Route::get('todos/{id}', [TodoController::class, 'show'])->name('todos.show'); // optional
    Route::put('todos/{id}', [TodoController::class, 'update'])->name('todos.update'); // edit todo
    Route::delete('todos/{id}', [TodoController::class, 'destroy'])->name('todos.destroy'); // delete todo

    Route::post('/todos/{todo}/toggle', [TodoController::class, 'toggle'])->name('todos.toggle');

    Route::post('/cookie/create/update', [ThemeController::class,'createAndUpdate'])->name('create-update');
});