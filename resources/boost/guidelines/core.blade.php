## Laravel WhatsApp Widget

### Overview

A Laravel package that provides a floating WhatsApp widget for websites. It manages
WhatsApp agents via a database model, renders a Blade-based widget with audio notifications,
and provides a redirect page that forwards visitors to `wa.me` links.

### Key Concepts

- **WhatsappAgent model**: Eloquent model with fields: active, name, phone, text, image
- **Floating widget**: Blade views included in layouts via `@include` directives
- **Signed URL redirect**: Secure redirect to WhatsApp via `URL::signedRoute()`
- **Multi-language**: Translations for 17+ languages (en, pt_BR, es, fr, de, etc.)
- **Vite assets**: CSS, JS, images, and audio bundled with Vite

### Blade Views

@verbatim
<code-snippet name="blade-includes" lang="php">
// In your layout <head>
@include('whatsapp-widget::whatsapp-widget-head')

// Before closing </body>
@include('whatsapp-widget::whatsapp-widget-body')
</code-snippet>
@endverbatim

### WhatsappAgent Model

@verbatim
<code-snippet name="model" lang="php">
// JeffersonGoncalves\WhatsappWidget\Models\WhatsappAgent
// Table: whatsapp_agents
// Fillable: active (bool), name (string), phone (string), text (?string), image (?string)
// Accessor: $agent->image_url (uses Storage disk from config)
// Method: $agent->getLinkByWhatsappAgent($agent, $ref) -> signed redirect URL
</code-snippet>
@endverbatim

### Routes

@verbatim
<code-snippet name="routes" lang="php">
// API endpoint - returns JSON list of active agents (requires token)
GET /api/whatsapps?token={WHATSAPP_KEY}

// Redirect page - shows agent info then redirects to wa.me
GET /whatsapp-widget/redirect/{whatsapp_agent}  (signed URL)
</code-snippet>
@endverbatim

### Configuration

@verbatim
<code-snippet name="config" lang="php">
// config/whatsapp-widget.php
'audio'            => true,           // Enable audio notification
'play_audio_daily' => true,           // Play once per day (cookie-based)
'disk'             => env('FILESYSTEM_DISK', 'local'),  // Storage disk for images
'url'              => env('APP_URL', 'http://localhost'),
'name'             => env('APP_NAME', 'Laravel App'),
'key'              => env('WHATSAPP_KEY'),   // API auth token
'position'         => 'right',               // Widget position: 'left' or 'right'
</code-snippet>
@endverbatim

### Database Migration

@verbatim
<code-snippet name="migration" lang="php">
// whatsapp_agents table
Schema::create('whatsapp_agents', function (Blueprint $table) {
    $table->id();
    $table->boolean('active');
    $table->string('name');
    $table->string('phone');
    $table->string('text')->nullable();
    $table->string('image')->nullable();
    $table->timestamps();
});
</code-snippet>
@endverbatim

### Conventions

- PHP 8.2+ required, Laravel 11/12/13 compatible
- Uses `spatie/laravel-package-tools` for service provider
- Assets published to `vendor/whatsapp-widget` via Vite
- Widget only renders when active WhatsappAgent records exist
- Redirect uses `URL::signedRoute()` for security (prevents URL tampering)
- Audio plays after 3-second delay; cookie controls daily playback limit
- Translations use `whatsapp-widget::whatsapp-widget.*` key prefix
