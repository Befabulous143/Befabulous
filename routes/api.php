<?php

use App\MicroSite\Auth\Controllers\AjaxAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/redirect-to-dashboard', [AjaxAuthController::class, 'redirectToDashborad'])->name('redirect-to-dashboard');

