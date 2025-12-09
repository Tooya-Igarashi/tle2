<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UploadController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChallengeController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\BadgeController;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;

Route::get('/', [RegisteredUserController::class, 'create'])
    ->name('register');
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/index', [ChallengeController::class, 'dashboard'])->name('dashboard');
    Route::get('/challenges', [ChallengeController::class, 'allChallenges'])->name('challenges.all');
    Route::get('/challenge/{challenge}', [ChallengeController::class, 'show'])->name('challenges.show');
});

Route::get('/testmail', function () {
    Mail::to('jordi1030@outlook.com')->send(new TestMail());
});

Route::get('/submission/approve/{id}/{token}', [UploadController::class, 'approve'])
    ->name('submission.approve');

Route::get('/submission/reject/{id}/{token}', [UploadController::class, 'reject'])
    ->name('submission.reject');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/submit', [UploadController::class, 'index']);
Route::get('/upload/{challenge}', [UploadController::class, 'show']);
Route::post('/upload/{challenge}', [UploadController::class, 'store'])
    ->name('upload.store');


Route::middleware(['auth', AdminMiddleware::class])->group(function () {
    Route::get('/admin/challenges/create', [ChallengeController::class, 'create'])->name('challenges.create');
    Route::post('/admin/challenges', [ChallengeController::class, 'store'])->name('challenges.store');
    Route::post('/admin/badges', [BadgeController::class, 'store'])->name('badges.store');
    Route::get('/admin/badges', [BadgeController::class, 'create'])->name('badges.create');
});


Route::resource('upload', UploadController::class);

require __DIR__ . '/auth.php';
