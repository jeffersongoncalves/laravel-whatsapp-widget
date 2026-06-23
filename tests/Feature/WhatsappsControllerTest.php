<?php

use JeffersonGoncalves\WhatsappWidget\Models\WhatsappAgent;

beforeEach(function () {
    config()->set('whatsapp-widget.key', 'secret-key');
    config()->set('whatsapp-widget.url', 'http://localhost');
    config()->set('whatsapp-widget.disk', 'local');
});

it('returns 403 when token is missing', function () {
    WhatsappAgent::factory()->create();

    $this->getJson('/api/whatsapps')->assertForbidden();
});

it('returns 403 when token is invalid', function () {
    WhatsappAgent::factory()->create();

    $this->getJson('/api/whatsapps?token=wrong')->assertForbidden();
});

it('returns 403 when key is not configured even if token matches null', function () {
    config()->set('whatsapp-widget.key', null);

    WhatsappAgent::factory()->create();

    $this->getJson('/api/whatsapps')->assertForbidden();
    $this->getJson('/api/whatsapps?token=')->assertForbidden();
});

it('lists only active agents when token is valid', function () {
    WhatsappAgent::factory()->create(['name' => 'Active Agent']);
    WhatsappAgent::factory()->inactive()->create(['name' => 'Hidden Agent']);

    $response = $this->getJson('/api/whatsapps?token=secret-key');

    $response->assertOk()
        ->assertJsonCount(1)
        ->assertJsonFragment(['name' => 'Active Agent'])
        ->assertJsonMissing(['name' => 'Hidden Agent']);
});

it('returns expected JSON shape per agent', function () {
    $agent = WhatsappAgent::factory()->create();

    $response = $this->getJson('/api/whatsapps?token=secret-key');

    $response->assertOk()
        ->assertJsonStructure([
            ['id', 'name', 'image_url', 'phone', 'link'],
        ]);

    expect($response->json('0.id'))->toBe($agent->id);
    expect($response->json('0.link'))->toContain('/whatsapp-widget/redirect/'.$agent->id);
});
