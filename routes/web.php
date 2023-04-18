<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GenerateDocument;
use App\Http\Controllers\KasusController;
use App\Http\Controllers\LimpahPoldaController;
use App\Http\Controllers\RenderViewController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
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

// Route::get('/', function () {
//     return view('partials.master');
// });

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/pdf-test', [LimpahPoldaController::class, 'generateDocumen']);
// Route::get('/lembar-disposisi', [LimpahPoldaController::class, 'generateDisposisi']);
Route::post('login', [AuthController::class, 'loginAction'])->name('login-action');


Route::middleware(['auth'])->group(function (){
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');

    // User Management
    Route::get('user', [UserController::class, 'index']);
    Route::post('user/save', [UserController::class, 'store']);
    Route::get('role', [RoleController::class, 'index']);
    Route::get('role/permission/{id}', [RoleController::class, 'permission']);
    Route::get('role/permission/{id}/save', [RoleController::class, 'savePermission']);

    // CRUD Kasus
    Route::get('data-kasus', [KasusController::class, 'index'])->name('kasus.index');
    Route::post('data-kasus/data', [KasusController::class, 'data'])->name('kasus.data');
    Route::post('data-kasus/update', [KasusController::class, 'updateData'])->name('kasus.update');
    Route::get('data-kasus/detail/{id}', [KasusController::class, 'detail'])->name('kasus.detail');
    Route::post('data-kasus/status/update', [KasusController::class, 'updateStatus'])->name('kasus.update.status');

    // View Kasus
    Route::get('data-kasus/view/{kasus_id}/{id}', [RenderViewController::class, 'viewProcess'])->name('kasus.proses.view');
    Route::get('data-penyidik/{kasus_id}', [KasusController::class, 'getDataPenyidik']);
    Route::get('data-penyidik-riksa/{kasus_id}', [KasusController::class, 'getDataPenyidikRiksa']);
    // End View Kasus

    // Create Kasus
    Route::get('input-data-kasus', [KasusController::class, 'inputKasus'])->name('kasus.input');
    Route::post('input-data-kasus/store', [KasusController::class, 'storeKasus'])->name('kasus.store.kasus');

    // Download From Ajax
    Route::get('/download-file/{filename}', [GenerateDocument::class, 'downloadFile']);

    // Generate Disposisi
    Route::post('/lembar-disposisi', [GenerateDocument::class, 'generateDisposisi']);
    Route::post('/lembar-disposisi-karo', [GenerateDocument::class, 'generateDisposisiKaro']);
    Route::post('/lembar-disposisi-sesro', [GenerateDocument::class, 'generateDisposisiSesro']);
    Route::get('/print/disposisi_kabag_gakkum/{id}/{process_id}/{subprocess}', [GenerateDocument::class, 'generateDisposisiKabag']);

    // Generate Pulbaket
    Route::get('/surat-perintah/{id}/generated', [GenerateDocument::class, 'SuratPerintah']);
    Route::post('/surat-perintah/{id}/not_generated', [GenerateDocument::class, 'SuratPerintah']);
    Route::get('/surat-perintah-pengantar/{id}', [GenerateDocument::class, 'SuratPerintahPengantar']);
    Route::get('/print/sp2hp2/{id}/{process_id}/{subprocess}', [GenerateDocument::class, 'sp2hp']);
    Route::post('/print/bai/{id}', [GenerateDocument::class, 'bai']);
    // Route::get('/print/bai-anggota/{id}/{process_id}/{subprocess}', [GenerateDocument::class, 'bai_anggota']);
    Route::get('/print/laporan_hasil_penyelidikan/{id}/{process_id}/{subprocess}', [GenerateDocument::class, 'laporanHasilPenyelidikan']);
    Route::POST('/print/nd_permohonan_gelar_perkara/{id}', [GenerateDocument::class, 'nd_permohonan_gelar_perkara']);
    Route::post('/print/undangan_klarifikasi/{id}', [GenerateDocument::class, 'undangan_klarifikasi']);

    // Generate Gelar Lidik
    Route::POST('/print/sprin_gelar/{id}/not-generated', [GenerateDocument::class, 'sprin_gelar']);
    Route::GET('/print/sprin_gelar/{id}/generated', [GenerateDocument::class, 'sprin_gelar']);
    Route::POST('/print/undangan_gelar/{id}', [GenerateDocument::class, 'berkas_undangan_gelar']);
    Route::get('/print/notulen_hasil_gelar/{id}/{process_id}/{subprocess}', [GenerateDocument::class, 'notulen_hasil_gelar']);
    Route::POST('/print/laporan_hasil_gelar/{id}', [GenerateDocument::class, 'laporan_hasil_gelar']);

    Route::post('/limpah-polda', [GenerateDocument::class, 'limpah_polda']);

    // Generate Sidik / LPA
    Route::POST('/print/lpa/{id}/not-generated', [GenerateDocument::class, 'lpa']);
    Route::GET('/print/lpa/{id}/generated', [GenerateDocument::class, 'lpa']);
    Route::POST('/print/sprin_riksa/{id}/not_generated', [GenerateDocument::class, 'sprin_riksa']);
    Route::GET('/print/sprin_riksa/{id}/generated', [GenerateDocument::class, 'sprin_riksa']);
    Route::POST('/print/surat_panggilan_saksi/{id}', [GenerateDocument::class, 'surat_panggilan_saksi']);
    Route::get('/print/surat_panggilan_terduga/{id}/{process_id}/{subprocess}', [GenerateDocument::class, 'surat_panggilan_terduga']);
    Route::get('/print/bap/{id}/{process_id}/{subprocess}', [GenerateDocument::class, 'bap']);
    Route::get('/print/dp3d/{id}/{process_id}/{subprocess}', [GenerateDocument::class, 'dp3d']);
    Route::get('/print/surat_pelimpahan_ke_ankum/{id}/{process_id}/{subprocess}', [GenerateDocument::class, 'pelimpahan_ankum']);

    // Sidang Disiplin
    Route::get('/print/nota_dina_perangkat_sidang/{id}/{process_id}/{subprocess}', [GenerateDocument::class, 'nota_dina_perangkat_sidang']);
    Route::get('/print/sprin_perangkat_sidang/{id}/{process_id}/{subprocess}', [GenerateDocument::class, 'sprin_perangkat_sidang']);
    Route::get('/print/undangan_sidang_disiplin/{id}/{process_id}/{subprocess}', [GenerateDocument::class, 'undangan_sidang_disiplin']);
    Route::get('/print/hasil_putusan_sidang_disiplin/{id}/{process_id}/{subprocess}', [GenerateDocument::class, 'hasil_putusan_sidang_disiplin']);
    Route::get('/print/nota_hasil_putusan/{id}/{process_id}/{subprocess}', [GenerateDocument::class, 'nota_hasil_putusan']);
});
