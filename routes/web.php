<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MainController;
use App\Http\Middleware\CheckIsLogged;
use App\Http\Middleware\CheckIsNotLogged;
use Illuminate\Support\Facades\Route;

# Auth routes - user not logged
Route::middleware([CheckIsNotLogged::class])->group(function () {

    # Login App
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/loginSubmit', [AuthController::class, 'loginSubmit'])->name('loginSubmit');
});

# App routes - user logged
Route::middleware([CheckIsLogged::class])->group(function () {

    # Home Page
    Route::get('/', [MainController::class, 'index'])->name('home');

    # Logout App
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    # New Note
    Route::get('/newNote', [MainController::class, 'newNote'])->name('new');
    Route::post('newNoteSubmit', [MainController::class, 'newNoteSubmit'])->name('newNoteSubmit');

    # Edit Note
    Route::get('/editNote/{id}', [MainController::class, 'editNote'])->name('edit');
    Route::post('/editNoteSubmit', [MainController::class, 'editNoteSubmit'])->name('editNoteSubmit');

    # Delete Note
    Route::get('/deleteNote/{id}', [MainController::class, 'deleteNote'])->name('delete');
    Route::get('/deleteNoteConfirm/{id}', [MainController::class, 'deleteNoteConfirm'])->name("deleteConfirm");
});