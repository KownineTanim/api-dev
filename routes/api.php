<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\TagController;


Route::post('register', [AuthController::class, 'register'])->name('register');
Route::post('login', [AuthController::class, 'login'])->name('login');

Route::middleware(['auth:api'])->group(function () {
    Route::get('/category', [CategoryController::class, 'index'])->name('category.index');
    Route::post('/category', [CategoryController::class, 'store'])->name('category.store');
    Route::post('/category/search', [CategoryController::class, 'search'])->name('category.search');
    Route::get('/category/{id}', [CategoryController::class, 'edit'])->name('category.edit');
    Route::put('/category/{id}', [CategoryController::class, 'update'])->name('category.put');
    Route::patch('/category/{id}', [CategoryController::class, 'update'])->name('category.patch');
    Route::delete('/category/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');

    Route::get('/note', [NoteController::class, 'index'])->name('note.index');
    Route::post('/note', [NoteController::class, 'store'])->name('note.store');
    Route::post('/note/search', [NoteController::class, 'search'])->name('category.search');
    Route::get('/note/{id}', [NoteController::class, 'edit'])->name('note.edit');
    Route::put('/note/{id}', [NoteController::class, 'update'])->name('note.put');
    Route::patch('/note/{id}', [NoteController::class, 'update'])->name('note.patch');
    Route::delete('/note/{id}', [NoteController::class, 'destroy'])->name('note.destroy');

    Route::get('/tag', [TagController::class, 'index'])->name('tag.index');
    Route::post('/tag', [TagController::class, 'store'])->name('tag.store');
    Route::post('/tag/search', [TagController::class, 'search'])->name('tag.search');
    Route::get('/tag/{id}', [TagController::class, 'edit'])->name('tag.edit');
    Route::put('/tag/{id}', [TagController::class, 'update'])->name('tag.put');
    Route::patch('/tag/{id}', [TagController::class, 'update'])->name('tag.patch');
    Route::delete('/tag/{id}', [TagController::class, 'destroy'])->name('tag.destroy');
});
