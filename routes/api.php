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

// get detail resource
Route::get('/patients/{id}', [PatientsController::class, 'show']);

// edit resource
Route::put('/patients/{id}', [PatientsController::class, 'update']);

// delete resource
Route::delete('/patients/{id}', [PatientsController::class, 'destroy']);

// search resource by name
Route::get('/patients/search/{name}', [PatientsController::class, 'search']);
