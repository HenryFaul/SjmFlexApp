<?php

use App\Http\Controllers\DataImports\DataImportController;
use App\Http\Controllers\InterlockDefectController;
use App\Http\Controllers\InterlockDownTimeController;
use App\Http\Controllers\InterlockLineController;
use App\Http\Controllers\LineShiftController;
use App\Http\Controllers\ProductionModelController;
use App\Http\Controllers\StaffMemberController;
use App\Models\ProductionModel;
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
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');


    //Data import route

    Route::get('/import', [DataImportController::class, 'index'])->middleware('auth')->name('import.index');
    Route::post('/import', [DataImportController::class, 'import'])->middleware('auth')->name('import.process');


    //Staff

    Route::resource('staff_member', StaffMemberController::class)->middleware('auth')
        ->only(['index','show']);

    //Transport Trans modal Props

    Route::get('/props/line_shift_modal', [LineShiftController::class, 'getProps'])->middleware('auth')->name('props.line_shift_modal');

    //Interlock Downtime Modal Props

    Route::get('/props/interlock_down_time_modal', [InterlockDownTimeController::class, 'getProps'])->middleware('auth')->name('props.interlock_down_time_modal');

    //Interlock Defect Props

    Route::get('/props/interlock_defect_modal', [InterlockDefectController::class, 'getProps'])->middleware('auth')->name('props.interlock_defect_modal');



    //LineShift

    Route::resource('line_shift', LineShiftController::class)->middleware('auth')
        ->only(['index','store']);

    //InterlockLine

    Route::resource('interlock_line', InterlockLineController::class)->middleware('auth')
        ->only(['index','store','show','create','update']);

    Route::get('/interlock_line_graph/month_to_date', [InterlockLineController::class, 'monthToDate'])->middleware('auth')->name('interlock_line_graph.month_to_date');


    //Interlock DownTime

    Route::resource('interlock_down_time', InterlockDownTimeController::class)->middleware('auth')
        ->only(['index','store']);

    //Interlock Defect

    Route::resource('interlock_defect', InterlockDefectController::class)->middleware('auth')
        ->only(['index','store']);


});


