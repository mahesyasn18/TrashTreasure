<?php

use App\Http\Controllers\AkunController;
use App\Http\Controllers\DropPointController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JenisSampahController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PenukaranPoinController;
use App\Http\Controllers\PenukaranSampahController;
use App\Http\Controllers\ProsesPenukaranPoinController;
use App\Http\Controllers\ProsesPenukaranSampah;
use App\Http\Controllers\TagsController;
use App\Http\Controllers\UserHistorySampahController;
use App\Http\Controllers\UsersDashboardController;
use App\Models\JenisSampah;
use App\Models\PenukaranPoin;

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

Route::get('/penukaran/sampah',  [ProsesPenukaranSampah::class, 'create'])->name('login.penukaran');
Route::get('/penukaran/sampah/form',  [ProsesPenukaranSampah::class, 'createPenukaran']);
Route::post('/penukaran/sampah',  [ProsesPenukaranSampah::class, 'login'])->name('process.login');
Route::post('/penukaran/sampah/form',  [ProsesPenukaranSampah::class, 'store'])->name('penukaran.stores');

// Route::get('/penukaran/poin',  [ProsesPenukaranPoinController::class, 'create'])->name('login.penukaran');
// Route::get('/penukaran/poin/form',  [ProsesPenukaranPoinController::class, 'createPenukaran']);
// Route::post('/penukaran/poin',  [ProsesPenukaranPoinController::class, 'login'])->name('process.login');
Route::get('/penukaran/poin',  [ProsesPenukaranPoinController::class, 'getPoin'])->name('poin');
Route::post('/penukaran/poin/form',  [ProsesPenukaranPoinController::class, 'store'])->name('poin.stores');

Route::group(['prefix' => 'dashboard/admin', 'middleware' => ['checkUserRole']], function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::group(['prefix' => 'profile'], function () {
        Route::get('/', [HomeController::class, 'profile'])->name('profile');
        Route::post('update', [HomeController::class, 'updateprofile'])->name('profile.update');
    });

    Route::resource('users', AkunController::class);
    Route::post('/users-list', [AkunController::class, 'getUsersData'])->name('users-list');

    Route::resource('news', NewsController::class);
    Route::post('/news-list', [NewsController::class, 'getNewsData'])->name('news-list');
    Route::get('/export-news', [NewsController::class, 'exportNews'])->name('export-news');
    Route::post('/import-news', [NewsController::class, 'importNews'])->name('import-news');

    Route::resource('jenis/sampah', JenisSampahController::class);
    Route::post('/jenis/sampah-list', [JenisSampahController::class, 'getJenisSampah'])->name('sampah-list');

    Route::resource('drop-point', DropPointController::class);
    Route::post('/drop-point-list', [DropPointController::class, 'getDropPoint'])->name('drop-point-list');
    Route::get('/drop/export', [DropPointController::class, 'export'])->name('export.drop');

    Route::resource('riwayat-penukaran-poin', PenukaranPoinController::class);
    Route::post('/riwayat-penukaran-poin-list', [PenukaranPoinController::class, 'getPenukaranPoin'])->name('penukaran-poin-list');
    Route::get('/point/export', [PenukaranPoinController::class, 'export'])->name('export.point');

    Route::resource('news-category', TagsController::class);
    Route::post('/news-category-list', [TagsController::class, 'getNewsCategory'])->name('news-category-list');

    Route::resource('riwayat-penukaran-sampah', PenukaranSampahController::class);
    Route::post('/riwayat-penukaran-sampah-list', [PenukaranSampahController::class, 'getPenukaranSampah'])->name('penukaran-sampah-list');
    Route::get('/sampah/export', [PenukaranSampahController::class, 'export'])->name('export.sampah');
});


Route::resource('/users/dashboard', UsersDashboardController::class);
Route::get('/users/riwayat-penukaran-sampah', [UserHistorySampahController::class, 'index'])->name('users.sampah.history');
Route::post('/users/dashboard/riwayat-penukaran-sampah-list', [UserHistorySampahController::class, 'getPenukaranSampah'])->name('users-penukaran-sampah-list');
