<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\ProfileController;

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
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/voting', function () {
        return view('pages.voting');
    })->name('voting');

    Route::get('/ideas', function () {
        return view('pages.ideas');
    })->name('ideas');

    Route::get('/create', function () {
        return view('pages.ideas.create');
    })->name('create');

    Route::get('/user-ideas', function () {
        return view('pages.ideas.user-ideas');
    })->name('user-ideas');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});
