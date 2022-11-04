<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PurchasesController;
use App\Http\Controllers\SettingsController;
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
    return view('auth.login');
});
Route::get('/t', function () {
    event(new \App\Events\SendMessage());
    dd('Event Run Successfully.');
});
Auth::routes();

Route::get('/dashboard', [HomeController::class, 'index'])->name('home');

Route::get('/dashboard/profile', [profileController::class, 'index'])->name('profile');
Route::put('/dashboard/profile', [profileController::class, 'updateProfile'])->name('updateProfile');

Route::group(['middleware' => ['auth']], function() {
    Route::resource('/dashboard/roles', RoleController::class);
    Route::resource('/dashboard/users', UserController::class);
    Route::resource('/dashboard/projects', ProjectController::class);
    Route::get('/dashboard/purchases/{purchases}', [PurchasesController::class, 'show'])->name('purchases.show_order');
    Route::put('/dashboard/purchases/{purchases}', [PurchasesController::class, 'update_order'])->name('purchases.update_order');
    Route::put('/dashboard/purchases', [PurchasesController::class, 'index'])->name('purchases.index_order');
    Route::resource('/dashboard/purchases', PurchasesController::class);
    Route::get('/dashboard/msgtest', [HomeController::class,'msgtest']);
    Route::post('/dashboard/purchases/{id}', [PurchasesController::class, 'getPurchase'])->name('purchase.getPurchase');
    Route::post('/dashboard/projects/{id}', [ProjectController::class, 'PDFDownload'])->name('projects.PDFDownload');
    Route::delete('/dashboard/dmotitem/{id}', [ProjectController::class, 'destroy_motor']);
    Route::delete('/dashboard/dmetitem/{id}', [ProjectController::class, 'destroy_metal']);
    Route::delete('/dashboard/dothitem/{id}', [ProjectController::class, 'destroy_other']);
    Route::put('/dashboard/comment', [ProjectController::class, 'addComment']);
    Route::delete('/dashboard/poitem/{id}', [PurchasesController::class, 'destroy_Item']);
    Route::delete('/dashboard/comment/{id}', [ProjectController::class, 'destroyComment']);
    Route::get('/dashboard/projects/{project}/assembling', [ProjectController::class, 'assembling']);
    Route::get('/dashboard/purchases/{project}/create', [PurchasesController::class, 'create']);
    Route::get('/dashboard/purchases/{purchases}/progress', [PurchasesController::class, 'edit']);
    Route::resource('/dashboard/settings', SettingsController::class);
    Route::delete('/dashboard/projects/{id}', [ProjectController::class, 'destroy']);
    Route::post('/dashboard/PDFDownload/{id}', [ProjectController::class, 'PDFDownload']);
    Route::delete('/dashboard/users/{id}', [UserController::class, 'destroy']);
    Route::patch('/fcm-token', [HomeController::class, 'updateToken'])->name('fcmToken');
    Route::post('/notifications',[HomeController::class,'notifications'])->name('notifications');
});
