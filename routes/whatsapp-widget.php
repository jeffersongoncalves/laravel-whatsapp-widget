<?php

use Illuminate\Support\Facades\Route;
use JeffersonGoncalves\WhatsappWidget\Http\Controllers\RedirectController;
use JeffersonGoncalves\WhatsappWidget\Http\Controllers\WhatsappLogController;
use JeffersonGoncalves\WhatsappWidget\Http\Controllers\WhatsappLogFrontendController;
use JeffersonGoncalves\WhatsappWidget\Http\Controllers\WhatsappsController;

Route::get('/api/whatsapps', WhatsappsController::class);
Route::post('/api/whatsapp-frontend-widget', WhatsappLogFrontendController::class)
    ->name('whatsapp-widget.api-frontend');
Route::post('/api/whatsapp-widget', WhatsappLogController::class)
    ->name('whatsapp-widget.api');
Route::get('/whatsapp-widget/redirect/{whatsapp_agent}', RedirectController::class)
    ->name('whatsapp-widget.redirect');
