<?php

use Illuminate\Support\Facades\URL;
use JeffersonGoncalves\WhatsappWidget\Models\WhatsappAgent;

it('returns 404 when agent does not exist', function () {
    $url = URL::signedRoute('whatsapp-widget.redirect', [
        'whatsapp_agent' => 999,
        'agent' => 999,
        'number' => '+5511999999999',
        'ref' => 'http://localhost',
    ]);

    $this->get($url)->assertNotFound();
});

it('renders redirect view for a valid agent', function () {
    $this->withoutVite();

    $agent = WhatsappAgent::factory()->create();

    $url = URL::signedRoute('whatsapp-widget.redirect', [
        'whatsapp_agent' => $agent->id,
        'agent' => $agent->id,
        'number' => $agent->phone,
        'ref' => 'http://localhost',
    ]);

    $this->get($url)
        ->assertOk()
        ->assertViewIs('whatsapp-widget::whatsapp-redirect')
        ->assertViewHas('whatsappAgent', fn ($value) => $value->is($agent));
});
