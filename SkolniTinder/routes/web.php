<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\IdeaController;
use App\Models\Idea;


Route::get('/', function () {
    return view('welcome');
});
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register/school', [RegisterController::class, 'registerSchool'])->name('register.school');
Route::post('/register/user', [RegisterController::class, 'registerUser'])->name('register.user');

Route::get('/autors', function () {
    return view('pages.autors');
})->name('autors');

Route::middleware(['auth'])->group(function () {
    Route::get('/school/manage', [SchoolController::class, 'manage'])->name('school.manage');
    Route::patch('/user/{user}/status', [SchoolController::class, 'updateStatus'])->name('user.update-status');
    Route::patch('/school/{school}/update-code', [SchoolController::class, 'updateCode'])->name('school.update-code');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [IdeaController::class, 'dashboard'])->name('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

Route::middleware(['auth'])->group(function () {
    Route::get('ideas/create', [IdeaController::class, 'create'])->name('pages.ideas.create');
    Route::post('/ideas', [IdeaController::class, 'store'])->name('ideas.store');
    Route::get('/user-ideas', [IdeaController::class, 'userIdeas'])->name('user-ideas');
    Route::post('/ideas/{idea}/vote', [IdeaController::class, 'vote'])->name('ideas.vote');
});
Route::middleware(['auth'])->group(function () {
    Route::get('/school/manage', [SchoolController::class, 'manage'])->name('school.manage');

    // Změněno na {id}, aby to přesně odpovídalo metodám v Controlleru:
    Route::patch('/user/{id}/status', [SchoolController::class, 'updateStatus'])->name('user.update-status');
    Route::patch('/school/{id}/update-code', [SchoolController::class, 'updateCode'])->name('school.update-code');
    Route::patch('/ideas/{id}/status', [SchoolController::class, 'updateIdeaStatus'])->name('ideas.update-status');
});


// Místo té složité funkce tam necháš jen tohle:
Route::get('/voting', [IdeaController::class, 'voting'])->name('voting');
