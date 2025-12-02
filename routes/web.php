<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('/admin/submissions/{id}/approve', [\App\Http\Controllers\AdminSubmissionController::class, 'approve'])->name('submission.approve');
Route::post('/admin/submissions/{id}/decline', [\App\Http\Controllers\AdminSubmissionController::class, 'decline'])->name('submission.decline');
Route::post('/admin/submissions/{id}/approve', [\App\Http\Controllers\AdminSubmissionController::class, 'edit'])->name('submission.edit');

require __DIR__.'/auth.php';
