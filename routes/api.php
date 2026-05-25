<?php

use App\Http\Controllers\AiCallLeadController;
use Illuminate\Support\Facades\Route;

Route::post('/ai-call-leads', [AiCallLeadController::class, 'store'])
    ->middleware('throttle:ai-call-leads')
    ->name('api.ai-call-leads.store');
