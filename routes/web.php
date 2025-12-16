<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UploadController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChallengeController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\BadgeController;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;


Route::get('/', [ChallengeController::class, 'dashboard'])->name('dashboard');
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/challenges', [ChallengeController::class, 'allChallenges'])->name('challenges.all');
    Route::get('/challenge/{challenge}', [ChallengeController::class, 'show'])->name('challenges.show');
    Route::get('/upload/{challenge}', [UploadController::class, 'show']);
    Route::post('/upload/{challenge}', [UploadController::class, 'store'])
        ->name('upload.store');
});

Route::get('/testmail', function () {
    Mail::to('jordi1030@outlook.com')->send(new TestMail());
});

Route::get('/submission/approve/{id}/{token}', [UploadController::class, 'approve'])
    ->name('submission.approve');

Route::get('/submission/reject/{id}/{token}', [UploadController::class, 'reject'])
    ->name('submission.reject');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/badges/library', [BadgeController::class, 'index'])
        ->name('badges.library');
    Route::get('/badges/{badge}', [BadgeController::class, 'show'])->name('badges.show');


});

Route::get('/user/create', [ChallengeController::class, 'create'])->name('user.create');
Route::post('/user/create', [ChallengeController::class, 'store'])->name('user.store');
Route::get('/submit', [UploadController::class, 'index']);


Route::middleware(['auth', AdminMiddleware::class])->group(function () {
    Route::get('/admin/challenges/create', [ChallengeController::class, 'create'])->name('challenges.create');
    Route::post('/admin/challenges', [ChallengeController::class, 'store'])->name('challenges.store');
    Route::post('/admin/badges', [BadgeController::class, 'store'])->name('badges.store');
    Route::get('/admin/badges', [BadgeController::class, 'create'])->name('badges.create');
    Route::get('/admin', [AdminController::class, 'admin'])->name('admin.dashboard');
    Route::patch('/admin/{challenge}/authenticate', [AdminController::class, 'authenticate'])->name('admin.authenticate');
    Route::get('admin/{challenge}/edit', [AdminController::class, 'edit'])->name('admin.edit');
    Route::patch('admin/{challenge}/update', [AdminController::class, 'update'])->name('admin.update');
});


Route::resource('upload', UploadController::class);

require __DIR__ . '/auth.php';
Route::post('/admin/submissions/{id}/approve', [\App\Http\Controllers\AdminSubmissionController::class, 'approve'])->name('submission.approve');
Route::post('/admin/submissions/{id}/decline', [\App\Http\Controllers\AdminSubmissionController::class, 'decline'])->name('submission.decline');
Route::post('/admin/submissions/{id}/edit', [\App\Http\Controllers\AdminSubmissionController::class, 'edit'])->name('submission.edit');
Route::delete('/admin/submissions/{id}/delete', [\App\Http\Controllers\AdminSubmissionController::class, 'delete'])->name('submission.delete');

require __DIR__ . '/auth.php';
