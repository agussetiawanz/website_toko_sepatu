<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Beranda;
use App\Livewire\User;
use App\Livewire\Laporan;
use App\Livewire\Produk;
use App\Livewire\Transaksi;
use App\Http\Controllers\HomeController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['register' => false]);

Route::get(uri: '/home', action: Beranda::class)->middleware(middleware: ['auth'])->name(name: 'home');
Route::get(uri: '/beranda', action: Beranda::class)->middleware(middleware: ['auth'])->name(name: 'beranda');
Route::get(uri: '/user', action: User::class)->middleware(middleware: ['auth'])->name(name: 'user');
Route::get(uri: '/laporan', action: Laporan::class)->middleware(middleware: ['auth'])->name(name: 'laporan');
Route::get(uri: '/produk', action: Produk::class)->middleware(middleware: ['auth'])->name( 'produk');
Route::get(uri: '/transaksi', action: Transaksi::class)->middleware(middleware: ['auth'])->name('transaksi');
Route::get('/cetak', [App\Http\Controllers\HomeController::class, 'cetak']);

