<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware('auth')->group(function () {

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/tahun-json', 'TahunAjaranController@json');
Route::get('/tahunajaran', 'TahunAjaranController@index');
Route::post('/tambahtahun', 'TahunAjaranController@store');
Route::post('/edittahun', 'TahunAjaranController@update');
Route::get('/editstatustahun/{id}', 'TahunAjaranController@setactive');

Route::get('/kelas-json', 'KelasController@json');
Route::get('/kelas', 'KelasController@index');
Route::post('/tambahkelas', 'KelasController@store');
Route::post('/editkelas', 'KelasController@update');
Route::get('/hapuskelas/{id}', 'KelasController@destroy');

Route::get('/siswa-json', 'SiswaController@json');
Route::get('/siswa', 'SiswaController@index');
Route::get('/tambahsiswa', 'SiswaController@create');
Route::post('/simpansiswa', 'SiswaController@store');
Route::get('/editsiswa/{id}', 'SiswaController@edit');
Route::post('/updatesiswa', 'SiswaController@update');
Route::get('/hapussiswa/{id}', 'SiswaController@destroy');
Route::get('/siswa-export', 'SiswaController@export');
Route::post('/siswa-import', 'SiswaController@import');

Route::get('/jenispembayaran-json', 'JenisPembayaranController@json');
Route::get('/jenispembayaran', 'JenisPembayaranController@index');
Route::post('/tambahjenispembayaran', 'JenisPembayaranController@store');
Route::post('/editjenispembayaran', 'JenisPembayaranController@update');
Route::get('/hapusjenispembayaran/{id}', 'JenisPembayaranController@destroy');

Route::get('/setpembayarankelas/{id}', 'SetPembayaranKelasController@index');
Route::get('/setpembayarankelas-json', 'SetPembayaranKelasController@json');
Route::post('/tambahpembayarankelas', 'SetPembayaranKelasController@store');
Route::post('/editpembayarankelas', 'SetPembayaranKelasController@update');
Route::get('/hapuspembayarankelas/{id}', 'SetPembayaranKelasController@destroy');

Route::get('/jeniskeringanan-json', 'JenisKeringananController@json');
Route::get('/jeniskeringanan', 'JenisKeringananController@index');
Route::post('/tambahkeringanan', 'JenisKeringananController@store');
Route::post('/editkeringanan', 'JenisKeringananController@update');
Route::get('/hapuskeringanan/{id}', 'JenisKeringananController@destroy');

Route::get('/rombel', 'RombelController@index'); //direct database
Route::get('/detailrombel', 'RombelController@detail'); //with json
Route::post('/tambahdetailrombel', 'RombelController@store');
Route::post('/editdetailrombel', 'RombelController@update');
Route::get('/hapusdetailrombel/{id}', 'RombelController@destroy');
Route::get('/exportrombel/{id}', 'RombelController@export');

Route::get('/penerimakeringanan', 'PenerimaKeringananController@index');
Route::get('/detailpenerimakeringanan', 'PenerimaKeringananController@detail');
Route::get('/tambahpenerimakeringanan', 'PenerimaKeringananController@create');
Route::post('/simpanpenerimakeringanan', 'PenerimaKeringananController@store');
Route::get('/editpenerimakeringanan', 'PenerimaKeringananController@edit');
Route::post('/updatepenerimakeringanan', 'PenerimaKeringananController@update');
Route::get('/hapuspenerimakeringanan/{id}', 'PenerimaKeringananController@destroy');
Route::get('/penerimakeringanan-export/{id}', 'PenerimaKeringananController@export');

Route::get('/transaksi', 'TransaksiController@index');
Route::get('/transaksi-json', 'TransaksiController@json');
Route::get('/tambah-transaksi', 'TransaksiController@create');
Route::post('/simpan-transaksi', 'TransaksiController@store');
Route::get('/detail-transaksi/{id}', 'TransaksiController@edit');
Route::post('/update-transaksi', 'TransaksiController@update');
Route::get('/nota/{id}', 'TransaksiController@nota');


//laporan pemasukan
Route::get('/rekappemasukan', 'RekapPemasukanController@index');
Route::get('/rekappemasukan-json', 'RekapPemasukanController@json');
Route::get('/rekappemasukan-export', 'RekapPemasukanController@export');

//laporan tunggakan
Route::get('/laporantunggakan', 'LaporanTunggakanController@index');
Route::get('/laporantunggakan-json', 'LaporanTunggakanController@json');
Route::get('/laporantunggakan-export/{id}', 'LaporanTunggakanController@export');
Route::get('surat-tunggakan/{id}', 'LaporanTunggakanController@surat');

});
