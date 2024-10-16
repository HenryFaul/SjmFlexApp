<?php

use App\Http\Controllers\DataImports\DataImportController;
use App\Http\Controllers\DefectController;
use App\Http\Controllers\DownTimeController;
use App\Http\Controllers\LineController;
use App\Http\Controllers\LineShiftController;
use App\Http\Controllers\StaffMemberController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
        Route::get('/dashboard', [LineController::class, 'monthToDate'])->name('dashboard');
        Route::get('/import', [DataImportController::class, 'index'])->middleware('auth')->name('import.index');
        Route::post('/import', [DataImportController::class, 'import'])->middleware('auth')->name('import.process');
        Route::resource('staff_member', StaffMemberController::class)->middleware('auth')
        ->only(['index','show']);
        Route::get('/props/line_shift_modal', [LineShiftController::class, 'getProps'])->middleware('auth')->name('props.line_shift_modal');
        Route::get('/props/interlock_down_time_modal', [DownTimeController::class, 'getProps'])->middleware('auth')->name('props.interlock_down_time_modal');
        Route::get('/props/interlock_defect_modal', [DefectController::class, 'getProps'])->middleware('auth')->name('props.interlock_defect_modal');
        Route::resource('line_shift', LineShiftController::class)->middleware('auth')
        ->only(['index','show','store']);
        Route::get('/component_line/create', [LineController::class, 'create']);
        Route::get('/component_line/{component}', [LineController::class, 'index'])->name('component_line.index');
        Route::post('/component_line/{component}', [LineController::class, 'store']);
        Route::get('/component_line/{component}/{id}', [LineController::class, 'show']);
        Route::put('/component_line/{component}/{id}', [LineController::class, 'update']);
        Route::post('/component_line/add_defect/{component}', [DefectController::class, 'store']);
        Route::post('/component_line/delete_defect/{defect_id}', [DefectController::class, 'destroy'])->name('defects.destroy');
        Route::get('/component_line/month_to_date', [LineController::class, 'monthToDate'])->middleware('auth')->name('interlock_line_graph.month_to_date');
        Route::resource('interlock_down_time', DownTimeController::class)->middleware('auth')
            ->only(['index','store']);
});


