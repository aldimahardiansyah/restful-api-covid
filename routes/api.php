<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientsController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// get all resource
Route::get('/patients', [PatientsController::class, 'index']);

// add resource
Route::post('/patients', [PatientsController::class, 'store']);

// edit resource
Route::put('/patients/{id}', [PatientsController::class, 'update']);

// delete resource
Route::delete('/patients/{id}', [PatientsController::class, 'destroy']);

// search resource by name
Route::get('/patients/search/{name}', [PatientsController::class, 'search']);

// get positive resource
Route::get('/patients/status/{status}', [PatientsController::class, 'search_by_status']);

// get recovered resource
Route::get('/patients/status/{status}', [PatientsController::class, 'search_by_status']);

// get dead resource
Route::get('/patients/status/{status}', [PatientsController::class, 'search_by_status']);

// get detail resource
Route::get('/patients/{id}', [PatientsController::class, 'search_by_status']);
