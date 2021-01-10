<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\TestController;

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

//link поставщика данных
Route::get('services/first/{inn}', [ServiceController::class, 'getFirstCompanyInfo']);
Route::get('services/second/{inn}', [ServiceController::class, 'getSecondCompanyInfo']);
Route::get('services/third/{inn}', [ServiceController::class, 'getThirdCompanyInfo']);


//REST API
Route::get('companies', [CompanyController::class, 'getCompanyByInn']);

