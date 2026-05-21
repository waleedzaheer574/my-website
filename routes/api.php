<?php

use App\Http\Controllers\AiCallLeadController;
use Illuminate\Support\Facades\Route;

Route::post('/ai-call-leads', [AiCallLeadController::class, 'store'])
    ->middleware('throttle:30,1')
    ->name('api.ai-call-leads.store');
