<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StockController;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

Auth::routes();
Route::middleware(['auth'])->group(function () {

    // === Accueil ===
    Route::get('/', [HomeController::class, 'index'])->name('home');

    // === Gestion des utilisateurs ===
    Route::get("/users", [HomeController::class, 'usersManage'])->name("users");

    // === TDB Reports ===
    Route::get("/reports.{name}", [HomeController::class, "getReports"])->name("report.{name}");

    // === Suppression de données ===
    Route::post('/data.delete', [\App\Http\Controllers\PublicController::class, 'triggerDelete']);


    // === Listing ===
    Route::get('/agents', [AdminController::class, 'listAgents']);
    Route::get('/sites', [AdminController::class, 'listSites']);
    Route::get('/activities', [AdminController::class, 'listActivities']);
    Route::get('/taches', [AdminController::class, 'listTaches']);
    Route::get('/activity-reports', [AdminController::class, 'listActivityReports']);

    // === CRUD ===
    Route::post('/agent.create', [AdminController::class, 'saveAgent']);
    Route::post('/site.create', [AdminController::class, 'saveSite']);
    Route::post('/activity.create', [AdminController::class, 'createActivity']);
    Route::post('/tache.create', [AdminController::class, 'createTache']);

});
