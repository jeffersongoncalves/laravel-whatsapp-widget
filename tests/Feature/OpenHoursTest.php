<?php

use Carbon\CarbonImmutable;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use JeffersonGoncalves\OpenHours\OpenHoursServiceProvider;
use JeffersonGoncalves\WhatsappWidget\Models\WhatsappAgent;
use JeffersonGoncalves\WhatsappWidget\Support\OpenHoursGate;
use Spatie\LaravelSettings\LaravelSettingsServiceProvider;

beforeEach(function () {
    $this->app->register(LaravelSettingsServiceProvider::class);
    $this->app->register(OpenHoursServiceProvider::class);
    config()->set('app.timezone', 'America/Sao_Paulo');

    // Without settings the open-hours package falls back to its config default: Monday-Friday 09:00-18:00.
    Schema::create('settings', function (Blueprint $table) {
        $table->id();
        $table->string('group');
        $table->string('name');
        $table->boolean('locked')->default(false);
        $table->json('payload');
        $table->timestamps();
    });

    $this->withoutVite();
    WhatsappAgent::factory()->create(['active' => true, 'name' => 'Ana']);
});

function widget(): string
{
    return view('whatsapp-widget::whatsapp-widget-body')->render();
}

it('ignores opening hours unless when_closed is set', function () {
    $this->travelTo(CarbonImmutable::parse('2026-10-11 10:00', 'America/Sao_Paulo')); // Sunday

    expect(OpenHoursGate::closedMode())->toBeNull()
        ->and(widget())->toContain('Ana')->toContain('Online');
});

it('hides the widget while closed', function () {
    config()->set('whatsapp-widget.when_closed', 'hide');
    $this->travelTo(CarbonImmutable::parse('2026-10-11 10:00', 'America/Sao_Paulo'));

    expect(OpenHoursGate::closedMode())->toBe('hide')
        ->and(trim(widget()))->toBe('');
});

it('shows the closed status and offline agents while closed', function () {
    config()->set('whatsapp-widget.when_closed', 'closed');
    $this->travelTo(CarbonImmutable::parse('2026-10-11 10:00', 'America/Sao_Paulo'));

    expect(widget())
        ->toContain('Closed · opens Monday at 09:00')
        ->toContain('class="unavailable"')
        ->toContain('Offline')
        ->not->toContain('ww-whatsapp-audio');
});

it('renders normally during opening hours', function () {
    config()->set('whatsapp-widget.when_closed', 'hide');
    $this->travelTo(CarbonImmutable::parse('2026-10-07 10:00', 'America/Sao_Paulo')); // Wednesday

    expect(OpenHoursGate::closedMode())->toBeNull()
        ->and(widget())->toContain('class="available"')->toContain('We are available');
});

it('ignores an unknown when_closed value', function () {
    config()->set('whatsapp-widget.when_closed', 'whatever');
    $this->travelTo(CarbonImmutable::parse('2026-10-11 10:00', 'America/Sao_Paulo'));

    expect(OpenHoursGate::closedMode())->toBeNull();
});
