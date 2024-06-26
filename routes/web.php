<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AHPController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('/setup', [AHPController::class, 'setup'])->name('setup');
Route::post('/save_kriteria', [AHPController::class, 'saveKriteria'])->name('save_kriteria');
Route::post('/save_matrix', [AHPController::class, 'saveMatrix'])->name('save_matrix');

Route::get('/home', [AHPController::class, 'index'])->middleware(['auth', 'verified'])->name('home');

Route::get('/input_kriteria', [AHPController::class, 'inputKriteria'])->middleware(['auth', 'verified'])->name('input_kriteria');

Route::get('/kriteria', [AHPController::class, 'kriteria'])->middleware(['auth', 'verified'])->name('kriteria');

Route::get('/alternatif', function () {
    return view('alternatif', ['title' => 'Alternatif']);
})->middleware(['auth', 'verified']);

Route::get('/normalisasikriteria', function () {
    return view('normalisasikriteria', ['title' => 'Normalisasi Kriteria']);
})->middleware(['auth', 'verified']);

Route::get('/nilai', function () {
    return view('nilai', ['title' => 'Nilai']);
})->middleware(['auth', 'verified']);

Route::get('/perbandingankriteria', function () {
    return view('PerbandinganKriteria', ['title' => 'Perbandingan Kriteria']);
})->middleware(['auth', 'verified']);

Route::get('/perbandinganalternatif', function () {
    return view('PerbandinganAlternatif', ['title' => 'Perbandingan Alternatif']);
})->middleware(['auth', 'verified']);

Route::get('/ranking', function () {
    return view('ranking', ['title' => 'Ranking']);
})->middleware(['auth', 'verified']);

Route::get('/dashboard', [AHPController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
