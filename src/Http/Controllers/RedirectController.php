<?php

namespace JeffersonGoncalves\WhatsappWidget\Http\Controllers;

use Illuminate\Contracts\View\View;
use JeffersonGoncalves\WhatsappWidget\Models\WhatsappAgent;

class RedirectController
{
    public function __invoke(string $whatsapp_agent): View
    {
        $whatsappAgent = WhatsappAgent::query()->where('id', $whatsapp_agent)->firstOrFail();

        return view('whatsapp-widget::whatsapp-redirect', compact('whatsappAgent'));
    }
}
