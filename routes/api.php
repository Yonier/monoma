<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CandidatoController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/auth', [AuthController::class, 'index']);

Route::post('/lead', [CandidatoController::class, 'add']);
Route::get('/lead/{id}', [CandidatoController::class, 'id', ['id' => '[0-9]+']]);
Route::get('/leads', [CandidatoController::class, 'all']);