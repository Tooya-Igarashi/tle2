<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UploadController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChallengeController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\BadgeController;

Route::get('/', function () {
    return view('welcome');
});
//
//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [ChallengeController::class, 'dashboard'])->name('dashboard');
    Route::get('/challenges', [ChallengeController::class, 'allChallenges'])->name('challenges.all');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', AdminMiddleware::class])->group(function () {
    Route::get('/admin/challenges/create', [ChallengeController::class, 'create'])->name('challenges.create');
    Route::post('/admin/challenges', [ChallengeController::class, 'store'])->name('challenges.store');
    Route::post('/admin/badges', [BadgeController::class, 'store'])->name('badges.store');
    Route::get('/admin/badges', [BadgeController::class, 'create'])->name('badges.create');
});


require __DIR__ . '/auth.php';
Route::get('/submit', function () {
    return view('upload');
})->name('submit');

Route::resource('upload', UploadController::class);

require __DIR__ . '/auth.php';
