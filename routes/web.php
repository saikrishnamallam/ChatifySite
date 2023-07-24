<?php

use App\Http\Controllers\EmbeddingController;
use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PdfFileController;

Route::view("/", "welcome");
Route::post("/embedding", [EmbeddingController::class, 'store']);
Route::get("/chat", [MessageController::class, 'index'])->name('chat.index');
Route::post("/chat", [MessageController::class, 'store'])->name('chat.store');
Route::get("/chat/{id}", [MessageController::class, 'show'])->name('chat.show');
Route::post('/upload-pdf', 'PdfFileController@upload');
Route::get('/read-pdf/{id}', 'PdfFileController@readData');
Route::post('/upload-pdf', [PdfFileController::class, 'upload']);
Route::get('/upload', function () {
    return view('upload');
});
