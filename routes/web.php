<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AHPController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\SocialiteController;
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


Route::middleware('guest')->group(function () {
    Route::get('/auth/{provider}', [SocialiteController::class, 'redirectToProvider'])->name('socialite.redirect');
    Route::get('/auth/{provider}/callback', [SocialiteController::class, 'handleProviderCallback'])->name('socialite.callback');
});
Route::post('/setup', [AHPController::class, 'setup'])->name('setup');
Route::get('/input_kriteria', [AHPController::class, 'inputKriteria'])->name('input_kriteria');
Route::get('/input_alternatif', [AHPController::class, 'inputAlternatif'])->name('input_alternatif');
Route::post('/save_kriteria', [AHPController::class, 'saveKriteria'])->name('save_kriteria');
Route::post('/save_alternatif', [AHPController::class, 'saveAlternatif'])->name('save_alternatif');
Route::post('/save_matrix', [AHPController::class, 'saveMatrix'])->name('save_matrix');
Route::post('/calculate_alternatif', [AHPController::class, 'calculateAlternatif'])->name('calculate_alternatif');
Route::get('/ranking', [AHPController::class, 'showRanking'])->name('ranking');
Route::get('/home', [AHPController::class, 'index'])->middleware(['auth', 'verified'])->name('home');
Route::get('/kriteria', [AHPController::class, 'kriteria'])->middleware(['auth', 'verified'])->name('kriteria');
Route::get('/alternatif', [AHPController::class, 'getKriteriaAndAlternatif'])->middleware(['auth', 'verified'])->name('alternatif');
Route::get('/normalisasikriteria', function () {
    return view('normalisasikriteria', ['title' => 'Normalisasi Kriteria']);
})->middleware(['auth', 'verified']);
Route::get('/nilai', [AHPController::class, 'calculateAHP'])->name('nilai')->middleware(['auth', 'verified']);
Route::get('/perbandingankriteria', function () {
    return view('PerbandinganKriteria', ['title' => 'Perbandingan Kriteria']);
})->middleware(['auth', 'verified']);

Route::get('/perbandinganalternatif', function () {
    return view('PerbandinganAlternatif', ['title' => 'Perbandingan Alternatif']);
})->middleware(['auth', 'verified']);



Route::get('/dashboard', [AHPController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
