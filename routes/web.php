<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MitraController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('login', [LoginController::class, 'index'])->name('login');
Route::get('daftar', [LoginController::class, 'daftar'])->name('daftar');
Route::post('/daftar', [LoginController::class, 'register']);
Route::get('logout', [LoginController::class, 'logout'])->name('logout');
Route::post('login', [LoginController::class, 'login']);

// Route untuk admin dashboard
Route::get('admin/dashboard', [LoginController::class, 'admin_dashboard'])->name('admin.dashboard');
Route::get('admin/akun', [AdminController::class, 'admin_akun'])->name('admin.akun');
// Route untuk Delete User
Route::delete('/admin/user/delete/{id}', [AdminController::class, 'admin_akundestroy'])->name('delete-user');
Route::put('/admin/user/update/{id}', [AdminController::class, 'admin_akunupdate'])->name('update-user');
Route::post('/admin/user/store', [AdminController::class, 'admin_akunstore'])->name('store-user');

Route::get('admin/mitra', [AdminController::class, 'admin_mitra'])->name('admin.mitra');
// Route untuk Delete User
Route::delete('/admin/mitra/delete/{id}', [AdminController::class, 'admin_mitradestroy'])->name('delete-mitra');
Route::put('/admin/mitra/update/verifikasi/{id}', [AdminController::class, 'admin_mitraupdatev'])->name('update-verifikasi');
Route::put('/admin/mitra/update/{id}', [AdminController::class, 'admin_mitraupdate'])->name('update-mitra');
Route::post('/admin/mitra/store', [AdminController::class, 'admin_mitrastore'])->name('store-mitra');

Route::get('admin/kerjasama', [AdminController::class, 'admin_kerjasama'])->name('admin.kerjasama');
// Route untuk Delete User
Route::delete('/admin/kerjasama/delete/{id}', [AdminController::class, 'admin_kerjasamadestroy'])->name('delete-kerjasama');
Route::put('/admin/kerjasama/update/{id}', [AdminController::class, 'admin_kerjasamaupdate'])->name('update-kerjasama');
Route::post('/admin/kerjasama/store', [AdminController::class, 'admin_kerjasamastore'])->name('store-kerjasama');

Route::get('admin/profil', [AdminController::class, 'admin_profil'])->name('admin.profil');
Route::put('/profile/update', [AdminController::class, 'admin_profilupdate'])->name('profile.update');

Route::get('admin/dokumentasi', [AdminController::class, 'admin_dokumentasi'])->name('admin.dokumentasi');
// Route untuk Delete User
Route::delete('/admin/dokumentasi/delete/{id}', [AdminController::class, 'admin_dokumentasidestroy'])->name('delete-dokumentasi');
Route::put('/admin/dokumentasi/update/{id}', [AdminController::class, 'admin_dokumentasiupdate'])->name('update-dokumentasi');
Route::post('/admin/dokumentasi/store', [AdminController::class, 'admin_dokumentasistore'])->name('store-dokumentasi');

Route::get('admin/acara', [AdminController::class, 'admin_acara'])->name('admin.acara');
// Route untuk Delete User
Route::delete('/admin/acara/delete/{id}', [AdminController::class, 'admin_acaradestroy'])->name('delete-acara');
Route::put('/admin/acara/update/{id}', [AdminController::class, 'admin_acaraupdate'])->name('update-acara');
Route::post('/admin/acara/store', [AdminController::class, 'admin_acarastore'])->name('store-acara');

Route::get('admin/dokumentasia', [AdminController::class, 'admin_dokumentasia'])->name('admin.dokumentasia');
// Route untuk Delete User
Route::delete('/admin/dokumentasia/delete/{id}', [AdminController::class, 'admin_dokumentasiadestroy'])->name('delete-dokumentasia');
Route::put('/admin/dokumentasia/update/{id}', [AdminController::class, 'admin_dokumentasiaupdate'])->name('update-dokumentasia');
Route::post('/admin/dokumentasia/store', [AdminController::class, 'admin_dokumentasiastore'])->name('store-dokumentasia');



// Route untuk mitra dashboard
Route::get('mitra/dashboard', [LoginController::class, 'mitra_dashboard'])->name('mitra.dashboard');

Route::get('mitra/mitra', [MitraController::class, 'mitra_mitra'])->name('mitra.mitra');
Route::put('/mitra/mitra/update/{id}', [MitraController::class, 'mitra_mitraupdate'])->name('update-mitram');
Route::post('/mitra/mitra/store', [MitraController::class, 'mitra_mitrastore'])->name('store-mitram');

Route::get('mitra/profil', [MitraController::class, 'mitra_profil'])->name('mitra.profil');
Route::put('/profile/update/mitra', [MitraController::class, 'mitra_profilupdate'])->name('profile.updatem');

Route::get('mitra/kerjasama', [MitraController::class, 'mitra_kerjasama'])->name('mitra.kerjasama');
Route::put('/mitra/kerjasama/update/{id}', [MitraController::class, 'mitra_kerjasamaupdate'])->name('update-kerjasamam');
Route::post('/mitra/kerjasama/store', [MitraController::class, 'mitra_kerjasamastore'])->name('store-kerjasamam');

Route::get('mitra/dokumentasi', [MitraController::class, 'mitra_dokumentasi'])->name('mitra.dokumentasi');
Route::put('/mitra/dokumentasi/update/{id}', [MitraController::class, 'mitra_dokumentasiupdate'])->name('update-dokumentasim');
Route::post('/mitra/dokumentasi/store', [MitraController::class, 'mitra_dokumentasistore'])->name('store-dokumentasim');

Route::get('mitra/acara', [MitraController::class, 'mitra_acara'])->name('mitra.acara');
Route::put('/mitra/acara/update/{id}', [MitraController::class, 'mitra_acaraupdate'])->name('update-acaram');
Route::post('/mitra/acara/store', [MitraController::class, 'mitra_acarastore'])->name('store-acaram');

Route::get('mitra/dokumentasia', [MitraController::class, 'mitra_dokumentasia'])->name('mitra.dokumentasia');
Route::put('/mitra/dokumentasia/update/{id}', [MitraController::class, 'mitra_dokumentasiaupdate'])->name('update-dokumentasiam');
Route::post('/mitra/dokumentasia/store', [MitraController::class, 'mitra_dokumentasiastore'])->name('store-dokumentasiam');