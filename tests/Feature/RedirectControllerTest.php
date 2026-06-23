<?php

use Illuminate\Support\Facades\Storage;
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

it('rejects an unsigned redirect url', function () {
    $agent = WhatsappAgent::factory()->create();

    $this->get('/whatsapp-widget/redirect/'.$agent->id)->assertForbidden();
});

it('renders redirect view when agent text is null', function () {
    $this->withoutVite();

    $agent = WhatsappAgent::factory()->create(['text' => null]);

    $url = URL::signedRoute('whatsapp-widget.redirect', [
        'whatsapp_agent' => $agent->id,
        'agent' => $agent->id,
        'number' => $agent->phone,
        'ref' => 'http://localhost',
    ]);

    $this->get($url)
        ->assertOk()
        ->assertSee('?text=', false);
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

it('renders the agent image url when agent has an image', function () {
    $this->withoutVite();
    Storage::fake('local');
    config()->set('whatsapp-widget.disk', 'local');

    $agent = WhatsappAgent::factory()->withImage('agents/photo.png')->create();

    $url = URL::signedRoute('whatsapp-widget.redirect', [
        'whatsapp_agent' => $agent->id,
        'agent' => $agent->id,
        'number' => $agent->phone,
        'ref' => 'http://localhost',
    ]);

    $this->get($url)
        ->assertOk()
        ->assertSee('agents/photo.png', false);
});
