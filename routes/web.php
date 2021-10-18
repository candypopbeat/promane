<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\MembersController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\WikiController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\OptionController;

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
Route::middleware(['auth:sanctum', 'verified'])->group(function () {

	Route::get('/', function () {
		return view('index');
	})->name("index");

	Route::get('/dashboard', [OptionController::class, 'index'])->name("dashboard");
	Route::post('/option/update/title', [OptionController::class, 'updateTitle']);
	Route::post('/option/update/themeColors', [OptionController::class, 'updateThemeColors']);
	Route::post('/option/update/viewContributor', [OptionController::class, 'updateViewContributor']);

	Route::get('/members', [MembersController::class, 'show'])->name("members");

	Route::post('/task', [TaskController::class, 'update']);
	Route::post('/task/add', [TaskController::class, 'add']);
	Route::post('/task/edit', [TaskController::class, 'edit']);
	Route::post('/task/follow', [TaskController::class, 'follow']);
	Route::post('/task/delete', [TaskController::class, 'delete']);
	Route::get('/task/{task}', [TaskController::class, 'show']);
	// Route::post('/task/{task}', [TaskController::class, 'show']);

	Route::get('/wiki', [WikiController::class, 'index'])->name("wiki");
	Route::get('/wiki/{wiki}', [WikiController::class, 'show']);
	Route::post('/wiki/listup', [WikiController::class, 'listup']);
	Route::post('/wiki/edit', [WikiController::class, 'edit']);
	Route::post('/wiki/add', [WikiController::class, 'add']);
	Route::post('/wiki/delete', [WikiController::class, 'delete']);

	// Route::group(['middleware' => 'can:editor'], function () {
		Route::get('/chart', [ChartController::class, 'index'])->name("chart");
		Route::post('/chart/upschedule', [ChartController::class, 'upschedule']);
		Route::post('/chart/upprogress', [ChartController::class, 'upprogress']);
	// });

	Route::get('/schedule', [ScheduleController::class, 'index'])->name("schedule");
	// Route::post('/schedule/update', [ScheduleController::class, 'update']);
	Route::post('/schedule/sort', [ScheduleController::class, 'sort']);
	Route::post('/schedule/edit', [ScheduleController::class, 'edit']);
	Route::post('/schedule/add', [ScheduleController::class, 'add']);
	Route::post('/schedule/delete', [ScheduleController::class, 'delete']);

	Route::post('/search', [SearchController::class, 'index'])->name("search");

});

Route::get('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');