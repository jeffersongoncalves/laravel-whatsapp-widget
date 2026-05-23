<?php

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use JeffersonGoncalves\WhatsappWidget\Models\WhatsappAgent;

it('casts active as boolean', function () {
    $agent = WhatsappAgent::factory()->create(['active' => 1]);

    expect($agent->active)->toBeBool()->toBeTrue();
});

it('returns null image_url when image is empty', function () {
    $agent = WhatsappAgent::factory()->create(['image' => null]);

    expect($agent->image_url)->toBeNull();
});

it('returns image_url from configured disk when image is set', function () {
    Storage::fake('local');
    config()->set('whatsapp-widget.disk', 'local');

    $agent = WhatsappAgent::factory()->withImage('agents/photo.png')->create();

    expect($agent->image_url)->toContain('agents/photo.png');
});

it('builds a signed redirect link via getLinkByWhatsappAgent', function () {
    URL::forceRootUrl('http://localhost');

    $agent = WhatsappAgent::factory()->create();

    $link = $agent->getLinkByWhatsappAgent($agent, 'http://referrer.test');

    expect($link)
        ->toContain('/whatsapp-widget/redirect/'.$agent->id)
        ->toContain('signature=')
        ->toContain('agent='.$agent->id)
        ->toContain('number='.urlencode($agent->phone));
});
