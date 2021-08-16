<?php

use App\Http\Controllers\Auth\LoginController as AuthLoginController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\TicketController;
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

Route::get('/', [LoginController::class, 'index'])->name('login');
Route::middleware(['guest'])->group(function () {
  Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
  Route::post('login', [AuthLoginController::class, 'login']);
  Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
  Route::post('register', [RegisterController::class, 'register']);
});
Route::middleware(['auth'])->group(function () {
  Route::post('logout', [AuthLoginController::class, 'logout'])->name('logout');
  Route::resource('projects', ProjectController::class);
  Route::resource('projects/{project}/histories', HistoryController::class);
  Route::resource('projects/{project}/histories/{history}/tickets', TicketController::class);
  Route::get('home', [HomeController::class, 'index']);
});
