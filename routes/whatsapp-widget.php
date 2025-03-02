<?php

use Illuminate\Support\Facades\Route;
use JeffersonGoncalves\WhatsappWidget\Http\Controllers\RedirectController;
use JeffersonGoncalves\WhatsappWidget\Http\Controllers\WhatsappsController;

Route::get('/api/whatsapps', WhatsappsController::class);
Route::get('/whatsapp-widget/redirect/{whatsapp_agent}', RedirectController::class)
    ->name('whatsapp-widget.redirect');
