<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessageController;

Route::get('/messages', [MessageController::class, 'index']);
Route::get('/messages/create', [MessageController::class, 'create']);
Route::post('/messages', [MessageController::class, 'store']); 
Route::get('/messages/{id}/edit', [MessageController::class, 'edit']); 
Route::put('/messages/{id}', [MessageController::class, 'update']);
Route::delete('/messages/{id}', [MessageController::class, 'destroy']); 
