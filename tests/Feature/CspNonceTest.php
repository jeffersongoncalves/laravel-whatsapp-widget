<?php

use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Vite;
use JeffersonGoncalves\WhatsappWidget\Models\WhatsappAgent;

/** @return list<string> */
function scriptTags(string $html): array
{
    preg_match_all('/<script\b[^>]*>/', $html, $tags);

    return $tags[0];
}

it('stamps the CSP nonce on the widget audio script', function () {
    $this->withoutVite();
    Vite::useCspNonce('test-nonce');
    config()->set('whatsapp-widget.audio', true);
    WhatsappAgent::factory()->create(['active' => true]);

    $tags = scriptTags(view('whatsapp-widget::whatsapp-widget-body')->render());

    expect($tags)->not->toBeEmpty()->each->toContain('nonce="test-nonce"');
});

it('stamps the CSP nonce on the redirect page script', function () {
    $this->withoutVite();
    Vite::useCspNonce('test-nonce');
    $agent = WhatsappAgent::factory()->create();

    $url = URL::signedRoute('whatsapp-widget.redirect', [
        'whatsapp_agent' => $agent->id,
        'agent' => $agent->id,
        'number' => $agent->phone,
        'ref' => 'http://localhost',
    ]);

    $tags = scriptTags((string) $this->get($url)->assertOk()->getContent());

    expect($tags)->not->toBeEmpty()->each->toContain('nonce="test-nonce"');
});

it('renders no nonce attribute when the app uses none', function () {
    $this->withoutVite();
    config()->set('whatsapp-widget.audio', true);
    WhatsappAgent::factory()->create(['active' => true]);

    expect(view('whatsapp-widget::whatsapp-widget-body')->render())
        ->toContain('<script')->not->toContain('nonce=');
});
