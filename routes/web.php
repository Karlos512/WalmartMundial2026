<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\AdminController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/', function () {
//     return view('userviews.registro');
// });

Route::get('/',[Controller::class,'HomeView'])->name('/');

Route::get('registro',[Controller::class,'RegistroView'])->name('registro');

Route::get('login',[Controller::class,'LoginView'])->name('login');

Route::get('dashboard',[Controller::class,'dashboardView'])->middleware('auth')->name('dashboard');

Route::post('logout',[Controller::class,'logout'])->name('logout');

Route::get('admin',[AdminController::class,'LoginView'])->name('admin');

Route::get('/admin/dashboard',[AdminController::class,'DashboardView'])->name('admin-dashboard');

Route::get('/admin/settings',[AdminController::class,'SettingsView'])->name('settings');