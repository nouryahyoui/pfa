<?php

use App\Http\Controllers\AnnonceController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\AiController;
use App\Http\Controllers\NotificationController;

Route::get('/', [AnnonceController::class, 'index'])->name('home');
Route::get('/search', [AnnonceController::class, 'search'])->name('annonces.search');
Route::get('/annonces', [AnnonceController::class, 'index'])->name('annonces.index');

Route::post('/ai/chatbot', [AiController::class, 'chatbot'])->name('ai.chatbot');

Route::middleware(['auth'])->group(function () {
    Route::get('/annonces/create', [AnnonceController::class, 'create'])->name('annonces.create');
    Route::post('/annonces', [AnnonceController::class, 'store'])->name('annonces.store');
    Route::get('/annonces/{annonce}/edit', [AnnonceController::class, 'edit'])->name('annonces.edit');
    Route::put('/annonces/{annonce}', [AnnonceController::class, 'update'])->name('annonces.update');
    Route::delete('/annonces/{annonce}', [AnnonceController::class, 'destroy'])->name('annonces.destroy');
    Route::get('/mes-annonces', [AnnonceController::class, 'mesAnnonces'])->name('annonces.mesAnnonces');
    Route::post('/ai/traduire', [AiController::class, 'traduire'])->name('ai.traduire');
    Route::post('/annonces/{annonce}/messages', [MessageController::class, 'store'])->name('messages.store');
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{annonce}', [MessageController::class, 'conversation'])->name('messages.conversation');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
});

Route::get('/annonces/{annonce}', [AnnonceController::class, 'show'])->name('annonces.show');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/annonces', [AdminController::class, 'annonces'])->name('annonces');
    Route::put('/annonces/{annonce}/approuver', [AdminController::class, 'approuver'])->name('approuver');
    Route::put('/annonces/{annonce}/rejeter', [AdminController::class, 'rejeter'])->name('rejeter');
    Route::get('/annonces/{annonce}/edit', [AdminController::class, 'editAnnonce'])->name('annonces.edit');
    Route::put('/annonces/{annonce}/update', [AdminController::class, 'updateAnnonce'])->name('annonces.update');
    Route::delete('/annonces/{annonce}/delete', [AdminController::class, 'deleteAnnonce'])->name('annonces.delete');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.delete');
    Route::get('/categories', [CategorieController::class, 'index'])->name('categories.index');
    Route::post('/categories', [CategorieController::class, 'store'])->name('categories.store');
    Route::put('/categories/{categorie}', [CategorieController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{categorie}', [CategorieController::class, 'destroy'])->name('categories.destroy');
});

require __DIR__.'/auth.php';