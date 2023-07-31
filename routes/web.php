<?php

use App\Models\ReportModel;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EJController;
use App\Http\Controllers\ILSController;
use App\Http\Controllers\KPIController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReportController5;
use App\Http\Controllers\AnalisysController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ReportController34;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CorrectiveController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\KPIControllerInst;
use App\Http\Controllers\KPIControllerMech;
use App\Http\Controllers\PreventiveController;
use App\Http\Controllers\WrenchTimeController;
use App\Http\Controllers\PDFCOntroller;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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
})->middleware('auth');

Route::controller(AuthController::class)->group(function () {
    Route::get('login', 'login')->name('login');
    Route::post('login', 'action');
    Route::get('logout', 'logout');
});

Route::get('dashboard', [DashboardController::class, 'Index'])->middleware('auth');
Route::post('dashboardAjax', [DashboardController::class, 'ajax']);

Route::get('preventiveclosed', [PreventiveController::class, 'PreventiveClosed'])->middleware('auth');
Route::get('preventivenotclosed', [PreventiveController::class, 'PreventiveNotClosed'])->middleware('auth');

Route::get('correctiveclosed', [CorrectiveController::class, 'CorrectiveClosed'])->middleware('auth');
Route::get('correctivenotclosed', [CorrectiveController::class, 'CorrectiveNotClosed'])->middleware('auth');

Route::get('ejclosed', [EJController::class, 'EJClosed'])->middleware('auth');
Route::get('ejnotclosed', [EJController::class, 'EJNotClosed'])->middleware('auth');

Route::get('ilstoday', [ILSController::class, 'ILSToday'])->middleware('auth');
Route::get('ilsurgent', [ILSController::class, 'ILSUrgent'])->middleware('auth');
Route::get('ilsclosed', [ILSController::class, 'ILSClosed'])->middleware('auth');
Route::get('ilsopen', [ILSController::class, 'ILSOpen'])->middleware('auth');

Route::controller(KPIController::class)->group(function () {
    Route::get('pmcompliancedashboard', 'Index')->middleware('auth');
    Route::get('reactiveworkdashboard', 'IndexReactiveWork')->middleware('auth');
    Route::get('reworkdashboard', 'IndexReWork')->middleware('auth');

    Route::get('pmcompliance', 'PMCompliance')->middleware('auth');
    Route::get('pmcompliance34', 'PMCompliance34')->middleware('auth');
    Route::get('pmcompliance5', 'PMCompliance5')->middleware('auth');

    Route::get('reactivework', 'ReactiveWork')->middleware('auth');
    Route::get('reactivework34', 'ReactiveWork34')->middleware('auth');
    Route::get('reactivework5', 'ReactiveWork5')->middleware('auth');

    Route::get('rework', 'Rework')->middleware('auth');
    Route::get('rework34', 'Rework34')->middleware('auth');
    Route::get('rework5', 'Rework5')->middleware('auth');
});

Route::controller(AnalisysController::class)->group(function () {
    Route::get('corrective', 'CorrectiveAnalisys')->middleware('auth');
    Route::get('ils-analisis', 'ILSAnalisys')->middleware('auth');
    //Route::get('generator-analyze', 'generator');
    Route::get('pltgu', 'pltguindex')->middleware('auth');
    route::get('motor', 'motorindex')->middleware('auth');
    route::post('motor-import', 'importcooler')->name('analisis/motor.import')->middleware('auth');
    route::get('pku-online', 'pkuindex')->middleware('auth');
    Route::get('weibull-reliability', 'weibullIndex')->middleware('auth');
    Route::get('notification-pltgu', 'notificationIndex')->middleware('auth');
});

// Blok 1
Route::get('report-pekerjaan', [ReportController::class, 'index'])->name('reportpekerjaan/reportpekerjaan.index')->middleware('auth');
Route::post('report-pekerjaan/store', [ReportController::class, 'store'])->name('reportpekerjaan/reportpekerjaan.store')->middleware('auth');
Route::post('report-pekerjaan/update', [ReportController::class, 'update'])->name('reportpekerjaan/reportpekerjaan.update')->middleware('auth');
Route::get('report-pekerjaan/edit/{id}', [ReportController::class, 'edit'])->middleware('auth');
Route::get('report-pekerjaan/destroy/{id}/', [ReportController::class, 'destroy'])->middleware('auth');
Route::get('report-analyze', [ReportController::class, 'analyze'])->middleware('auth');

//Blok 34
Route::get('report-pekerjaan34', [ReportController34::class, 'index'])->name('reportpekerjaan/reportpekerjaan34.index')->middleware('auth');
Route::post('report-pekerjaan34/store', [ReportController34::class, 'store'])->name('reportpekerjaan/reportpekerjaan34.store')->middleware('auth');
Route::post('report-pekerjaan34/update', [ReportController34::class, 'update'])->name('reportpekerjaan/reportpekerjaan34.update')->middleware('auth');
Route::get('report-pekerjaan34/edit/{id}', [ReportController34::class, 'edit'])->middleware('auth');
Route::get('report-pekerjaan34/destroy/{id}/', [ReportController34::class, 'destroy'])->middleware('auth');
Route::get('report-analyze34', [ReportController34::class, 'analyze'])->middleware('auth');

//Blok 5
Route::get('report-pekerjaan5', [ReportController5::class, 'index'])->name('reportpekerjaan/reportpekerjaan5.index')->middleware('auth');
Route::post('report-pekerjaan5/store', [ReportController5::class, 'store'])->name('reportpekerjaan/reportpekerjaan5.store')->middleware('auth');
Route::post('report-pekerjaan5/update', [ReportController5::class, 'update'])->name('reportpekerjaan/reportpekerjaan5.update')->middleware('auth');
Route::get('report-pekerjaan5/edit/{id}', [ReportController5::class, 'edit'])->middleware('auth');
Route::get('report-pekerjaan5/destroy/{id}/', [ReportController5::class, 'destroy'])->middleware('auth');
Route::get('report-analyze5', [ReportController5::class, 'analyze'])->middleware('auth');

Route::get('wrench-time', [WrenchTimeController::class, 'index'])->middleware('auth');
Route::get('wrench-time-mech', [WrenchTimeController::class, 'indexMech'])->middleware('auth');
Route::get('wrench-time-inst', [WrenchTimeController::class, 'indexInst'])->middleware('auth');
Route::post('wrench-time-import', [WrenchTimeController::class, 'import'])->name('kpi/wrenchtime.import')->middleware('auth');

Route::get('calendarlistrik', [CalendarController::class, 'indexcalendar'])->middleware('auth');
Route::get('calendarmekanik', [CalendarController::class, 'indexcalendarmech'])->middleware('auth');
Route::get('calendarinstrumen', [CalendarController::class, 'indexcalendarinst'])->middleware('auth');

Route::controller(KPIControllerMech::class)->group(function () {
    Route::get('pmcompliancemech', 'PMCompliance')->middleware('auth');
    Route::get('reactiveworkmech', 'Reactivework')->middleware('auth');
    Route::get('reworkmech', 'ReWork')->middleware('auth');
    Route::get('wrenchtimemech', 'WrenchTime')->middleware('auth');
    Route::post('wrenchtimemech-import', 'import')->name('kpi/wrenchtimemech.import')->middleware('auth');
});

Route::controller(KPIControllerInst::class)->group(function () {
    Route::get('pmcomplianceinst', 'PMCompliance')->middleware('auth');
    Route::get('reactiveworkinst', 'Reactivework')->middleware('auth');
    Route::get('reworkinst', 'ReWork')->middleware('auth');
    Route::get('wrenchtimeinst', 'WrenchTime')->middleware('auth');
    Route::post('wrenchtimeinst-import', 'import')->name('kpi/wrenchtimeinst.import')->middleware('auth');
});

Route::controller(PDFCOntroller::class)->group(function () {
    Route::get('pmcompliancepdf', 'PMCompliancePrintIndex')->middleware('auth');
    Route::get('pmcompliancepdf/print_report', 'Print')->middleware('auth');

    Route::get('pmcompliancepdf34', 'PMCompliancePrintIndexListrik34')->middleware('auth');
    Route::get('pmcompliancepdf34/print_report', 'PrintListrik34')->middleware('auth');

    Route::get('pmcompliancepdfmech12', 'PMCompliancePrintIndexMech12')->middleware('auth');
    Route::get('pmcompliancepdfmech12/print_report', 'PrintMech12')->middleware('auth');

    Route::get('pmcompliancepdfmech34', 'PMCompliancePrintIndexMech34')->middleware('auth');
    Route::get('pmcompliancepdfmech34/print_report', 'PrintMech34')->middleware('auth');

    Route::get('pmcompliancepdftinst12', 'PMCompliancePrintIndexInst12')->middleware('auth');
    Route::get('pmcompliancepdftinst12/print_report', 'PrintInst12')->middleware('auth');

    Route::get('pmcompliancepdftinst34', 'PMCompliancePrintIndexInst34')->middleware('auth');
    Route::get('pmcompliancepdftinst34/print_report', 'PrintInst34')->middleware('auth');
});

Route::controller(FeedbackController::class)->group(function () {
    Route::get('feedback', 'index')->middleware('auth');
    Route::get('testpage', 'testpage')->middleware('auth');
});
