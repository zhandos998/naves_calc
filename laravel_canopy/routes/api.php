<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AiConsultantController;
use App\Http\Controllers\CrmLeadController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::post('/ai/chat', [AiConsultantController::class, 'chat']);

Route::post('/crm/leads', [CrmLeadController::class, 'store']);