<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GenerateDocument;
use App\Http\Controllers\KasusController;
use App\Http\Controllers\LimpahPoldaController;
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
    Route::get('/', function () {
        return view('pages.dashboard.index');
    });

    Route::get('data-kasus', [KasusController::class, 'index'])->name('kasus.index');
    Route::post('data-kasus/data', [KasusController::class, 'data'])->name('kasus.data');
    Route::post('data-kasus/update', [KasusController::class, 'updateData'])->name('kasus.update');
    Route::get('data-kasus/detail/{id}', [KasusController::class, 'detail'])->name('kasus.detail');
    Route::post('data-kasus/status/update', [KasusController::class, 'updateStatus'])->name('kasus.update.status');

    // View Kasus
    Route::get('data-kasus/view/{kasus_id}/{id}', [KasusController::class, 'viewProcess'])->name('kasus.proses.view');

    // End View Kasus

    // Generate
    Route::post('/lembar-disposisi', [GenerateDocument::class, 'generateDisposisi']);
    Route::get('/download-file/{filename}', [GenerateDocument::class, 'downloadFile']);
    Route::get('/surat-perintah/{id}/{generated}', [GenerateDocument::class, 'SuratPerintah']);
    Route::get('/surat-perintah-pengantar/{id}', [GenerateDocument::class, 'SuratPerintahPengantar']);
    Route::get('/print/uuk/{id}/{process_id}/{subprocess}', [GenerateDocument::class, 'printUUK']);
    Route::get('/surat-sp2hp2-awal/{id}/{generated}', [GenerateDocument::class, 'sp2hp_awal']);
    Route::get('/print/sp2hp2_akhir/{id}/{process_id}/{subprocess}', [GenerateDocument::class, 'sp2hp2_akhir']);
    Route::get('/print/bai-sipil/{id}/{process_id}/{subprocess}', [GenerateDocument::class, 'bai_sipil']);
    Route::get('/print/bai-anggota/{id}/{process_id}/{subprocess}', [GenerateDocument::class, 'bai_anggota']);
    Route::get('/print/laporan_hasil_penyelidikan/{id}/{process_id}/{subprocess}', [GenerateDocument::class, 'laporanHasilPenyelidikan']);
    Route::get('/print/nd_permohonan_gelar_perkara/{id}/{process_id}/{subprocess}', [GenerateDocument::class, 'nd_permohonan_gelar_perkara']);
    Route::get('/print/undangan_klarifikasi/{id}/{process_id}/{subprocess}', [GenerateDocument::class, 'undangan_klarifikasi']);

    // Route::group(['middleware' => ['role:super-admin']], function () {
    //     Route::get('/user',[UserController::class, 'index'])->name('user-index');
    //     Route::get('/role',[RoleController::class, 'index'])->name('role-index');
    // });
});
