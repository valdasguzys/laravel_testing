<?php

use App\Http\Controllers\BooksController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::post('/books', [ BooksController::class, 'store']);
Route::put('/books/{book}/', [ BooksController::class, 'update']);
Route::delete('/books/{book}', [BooksController::class, 'destroy']);

