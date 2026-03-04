---
name: whatsapp-widget-development
description: Development guide for the Laravel WhatsApp Widget package - floating WhatsApp contact widget with agent management, audio notifications, and signed URL redirects
---

## When to use this skill

- Adding new WhatsApp agents to the database
- Customizing the widget appearance or position
- Adding new translations
- Modifying the redirect behavior or WhatsApp message template
- Writing tests for the controllers and model
- Integrating the widget into a Laravel or Filament application

## Setup

### Requirements

- PHP 8.2 or 8.3
- Laravel 11, 12, or 13
- spatie/laravel-package-tools ^1.14.0

### Installation

```bash
composer require jeffersongoncalves/laravel-whatsapp-widget
```

### Publish and Run Migration

```bash
php artisan vendor:publish --tag=whatsapp-widget-migrations
php artisan migrate
```

### Publish Config (Optional)

```bash
php artisan vendor:publish --tag=whatsapp-widget-config
```

### Publish Views (Optional)

```bash
php artisan vendor:publish --tag=whatsapp-widget-views
```

### Environment Variables

```env
WHATSAPP_KEY=your-secret-api-key
FILESYSTEM_DISK=public
```

## Architecture

### Namespace Structure

```
JeffersonGoncalves\WhatsappWidget\
    WhatsappWidgetServiceProvider     # Registers config, views, migrations, routes, assets, translations
    Models\
        WhatsappAgent                 # Eloquent model for whatsapp_agents table
    Http\
        Controllers\
            WhatsappsController       # JSON API endpoint for listing active agents
            RedirectController        # Redirect page to wa.me link
```

### Service Provider

```php
class WhatsappWidgetServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package->name('whatsapp-widget')
            ->hasMigration('create_whatsapp_agents_table')
            ->hasConfigFile('whatsapp-widget')
            ->hasAssets()
            ->hasViews()
            ->hasTranslations()
            ->hasRoute('whatsapp-widget');
    }
}
```

## Features

### WhatsappAgent Model

The model represents a support agent with a WhatsApp number:

```php
// Table: whatsapp_agents
// Columns: id, active (bool), name, phone, text (nullable), image (nullable), timestamps

use JeffersonGoncalves\WhatsappWidget\Models\WhatsappAgent;

// Create an agent
WhatsappAgent::create([
    'active' => true,
    'name' => 'Support Team',
    'phone' => '+5511999999999',
    'text' => 'Hello, I need help with...',
    'image' => 'agents/avatar.jpg',  // Path on configured storage disk
]);

// Get image URL (uses configured disk)
$agent->image_url; // Storage::disk(config('whatsapp-widget.disk'))->url($agent->image)

// Generate signed redirect URL
$agent->getLinkByWhatsappAgent($agent, config('whatsapp-widget.url'));
```

### Adding the Widget to Your Layout

Include two Blade partials in your layout:

```html
<head>
    <!-- Loads Vite CSS and JS assets -->
    @include('whatsapp-widget::whatsapp-widget-head')
</head>
<body>
    <!-- Your content -->

    <!-- Renders the floating widget -->
    @include('whatsapp-widget::whatsapp-widget-body')
</body>
```

The widget only renders if there are active `WhatsappAgent` records in the database.

### Widget Behavior

- Displays a floating WhatsApp icon (configurable left/right position)
- Clicking opens a panel listing all active agents
- Each agent shows their name, avatar, and "Online" status
- Clicking an agent opens a signed redirect URL
- The redirect page shows agent info then forwards to `wa.me/{phone}?text={text}`
- Optional audio notification plays after 3 seconds (cookie-based daily limit)

### Routes

```php
// routes/whatsapp-widget.php
// JSON API - requires WHATSAPP_KEY token for authentication
GET /api/whatsapps?token={key}
// Returns: [{id, name, image_url, phone, link}, ...]

// Redirect page - uses signed URLs for security
GET /whatsapp-widget/redirect/{whatsapp_agent}
// Named: whatsapp-widget.redirect
```

### JSON API Controller

```php
// WhatsappsController - returns active agents as JSON
class WhatsappsController
{
    public function __invoke(Request $request): JsonResponse
    {
        abort_if($request->token !== config('whatsapp-widget.key'), 403);
        $whatsappAgents = WhatsappAgent::query()->where('active', true)->get();
        // Returns id, name, image_url, phone, signed link for each agent
    }
}
```

### Redirect Controller

```php
// RedirectController - renders redirect page
class RedirectController
{
    public function __invoke(string $whatsapp_agent): View
    {
        $whatsappAgent = WhatsappAgent::query()->where('id', $whatsapp_agent)->firstOrFail();
        return view('whatsapp-widget::whatsapp-redirect', compact('whatsappAgent'));
    }
}
```

The redirect page sets a JavaScript variable and auto-redirects:

```javascript
var ww_whatsapp_chat_redirect = "https://wa.me/{phone}?text={encoded_text}";
```

### Audio Notification

Controlled by two config options:

```php
'audio' => true,            // Enable/disable audio
'play_audio_daily' => true, // true = once per day (cookie), false = every page load
```

The audio plays after a 3-second delay. A cookie named `play` is set with a 24-hour
expiration to prevent repeated playback.

### Translations

17+ languages supported. Translation keys use the `whatsapp-widget::whatsapp-widget.*` prefix:

```php
// Available keys:
'redirecting_to'  => 'Redirecting to',
'close'           => 'Close',
'close_title'     => 'Close Support',
'we_are_available' => 'We are available',
'online'          => 'Online',
'icon_alt'        => 'WhatsApp icon',
```

Supported locales: en, pt_BR, pt_PT, pt, es, fr, de, it, nl, pl, ar, cs, fa, he, id, ja, sk, tr.

## Configuration

```php
// config/whatsapp-widget.php
return [
    'audio' => true,                                    // Audio notification toggle
    'play_audio_daily' => true,                         // Once per day or every load
    'disk' => env('FILESYSTEM_DISK', 'local'),          // Storage disk for agent images
    'url' => env('APP_URL', 'http://localhost'),        // Used in redirect ref param
    'name' => env('APP_NAME', 'Laravel App'),           // Displayed in widget header
    'key' => env('WHATSAPP_KEY'),                       // API authentication key
    'position' => 'right',                              // 'left' or 'right'
];
```

## Testing Patterns

### Testing the API Endpoint

```php
use JeffersonGoncalves\WhatsappWidget\Models\WhatsappAgent;

it('returns active agents as JSON', function () {
    config(['whatsapp-widget.key' => 'test-key']);

    WhatsappAgent::create([
        'active' => true,
        'name' => 'Agent 1',
        'phone' => '+5511999999999',
    ]);

    $this->get('/api/whatsapps?token=test-key')
        ->assertOk()
        ->assertJsonCount(1)
        ->assertJsonFragment(['name' => 'Agent 1']);
});

it('rejects requests without valid token', function () {
    $this->get('/api/whatsapps?token=wrong-key')
        ->assertForbidden();
});
```

### Testing the Redirect

```php
it('redirects to agent page with signed URL', function () {
    $agent = WhatsappAgent::create([
        'active' => true,
        'name' => 'Test Agent',
        'phone' => '+5511999999999',
        'text' => 'Hello',
    ]);

    $url = URL::signedRoute('whatsapp-widget.redirect', [
        'whatsapp_agent' => $agent->id,
        'agent' => $agent->id,
        'number' => $agent->phone,
        'ref' => config('whatsapp-widget.url'),
    ]);

    $this->get($url)->assertOk()->assertSee('Test Agent');
});
```

### Testing the Model

```php
it('generates image URL from storage disk', function () {
    config(['whatsapp-widget.disk' => 'public']);

    $agent = WhatsappAgent::create([
        'active' => true,
        'name' => 'Agent',
        'phone' => '+5511999999999',
        'image' => 'agents/photo.jpg',
    ]);

    expect($agent->image_url)->toContain('agents/photo.jpg');
});

it('returns null image URL when no image', function () {
    $agent = WhatsappAgent::create([
        'active' => true,
        'name' => 'Agent',
        'phone' => '+5511999999999',
    ]);

    expect($agent->image_url)->toBeNull();
});
```

### Dev Commands

```bash
# Run tests
vendor/bin/pest

# Run static analysis
vendor/bin/phpstan analyse

# Format code
vendor/bin/pint
```
