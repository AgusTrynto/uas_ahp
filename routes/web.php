<?php

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

Route::get('/home', function () {
    return view('home',['title' => 'Home']);
});

Route::get('/kriteria', function () {
    return view('kriteria', ['title' => 'Kriteria']);
});

Route::get('/alternatif', function () {
    return view('alternatif', ['title' => 'Alternatif']);
});

Route::get('/perbandingankriteria', function () {
    return view('PerbandinganKriteria', ['title' => 'Perbandingan Kriteria']);
});

Route::get('/perbandinganalternatif', function () {
    return view('PerbandinganAlternatif', ['title' => 'Perbandingan Alternatif']);
});

Route::get('/ranking', function () {
    return view('ranking', ['title' => 'Ranking']);
});