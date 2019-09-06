<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/','HomeController@index');
Route::resource('/master/karyawan','KaryawanController');
Route::resource('/master/kriteria','KriteriaController');
Route::get('/transaksi/nilai','NilaiController@index')->name('nilai.index');
Route::get('/transaksi/nilai/periode/','NilaiController@index2')->name('nilai.index2');
Route::get('/transaksi/nilai/create','NilaiController@create')->name('nilai.create');
Route::get('/transaksi/nilai/get/{id}','NilaiController@karyawan');
Route::post('/transaksi/nilai','NilaiController@store')->name('nilai.store');
Route::get('/transaksi/perhitungan','PerhitunganController@index')->name('perhitungan.index');
Route::post('/transaksi/perhitungan','PerhitunganController@store')->name('perhitungan.store');
Route::get('/transaksi/keputusan','KeputusanController@index')->name('keputusan.index');
Route::get('/transaksi/keputusan/periode/','KeputusanController@index2')->name('keputusan.index2');
Route::get('/transaksi/keputusan/cetak/{id}','KeputusanController@cetak')->name('keputusan.cetak');
Route::post('/transaksi/cetak/no_surat','KeputusanController@no_surat')->name('keputusan.no_surat');
Route::get('/laporan/kinerja', 'LaporanController@index_kinerja')->name('laporan.kinerja.index');
Route::post('/laporan/kinerja', 'LaporanController@LaporanKinerja')->name('laporan.kinerja.store');
Route::get('/laporan/kinerja/cetak', 'LaporanController@cetak_kinerja')->name('laporan.kinerja.cetak');
Route::get('/laporan/penilaian', 'LaporanController@index_penilaian')->name('laporan.penilaian.index');
Route::post('/laporan/penilaian', 'LaporanController@LaporanPenilaian')->name('laporan.penilaian.store');
Route::get('/laporan/penilaian/cetak', 'LaporanController@cetak_penilaian')->name('laporan.penilaian.cetak');
