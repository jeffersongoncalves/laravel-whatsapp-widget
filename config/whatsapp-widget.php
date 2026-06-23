<?php

return [
    // Enable or disable audio notification
    'audio' => true,

    // Play audio notification once per day or on every page load
    'play_audio_daily' => true,

    // Filesystem disk for storing agent images
    'disk' => env('FILESYSTEM_DISK', 'local'),

    // Application URL (used for redirection)
    'url' => env('APP_URL', 'http://localhost'),

    // Application name (displayed in the widget)
    'name' => env('APP_NAME', 'Laravel App'),

    // WhatsApp API key (if needed)
    'key' => env('WHATSAPP_KEY'),

    // Widget position on the screen (left or right)
    'position' => 'right',

    // Colors for the floating button and the modal that opens
    'colors' => [
        // Floating button, modal header and base accents
        'primary' => '#03cc0b',

        // Text / icon color shown on top of the primary color
        'primary_text' => '#ffffff',

        // Notification badge background
        'badge' => '#ff0000',

        // Modal (popup) background
        'modal_bg' => '#ffffff',

        // Agent name / main text inside the modal
        'modal_text' => '#000000',

        // Secondary / muted text inside the modal
        'modal_muted' => '#bababa',

        // Online status dot and label
        'online' => '#03cc0b',
    ],

    // Colors for the redirect (loading) screen
    'redirect' => [
        // Page background
        'background' => '#f1f1f1',

        // Base text color
        'text' => '#7e7e7e',

        // Agent name heading color
        'name' => '#333333',

        // Accent color (badge, progress bar, chat button)
        'accent' => '#03cc0b',

        // Loading spinner color
        'spinner' => '#92d1c3',
    ],

    // Custom icons. Set a public URL/path to override the bundled defaults,
    // or leave null to use the icons shipped with the package.
    'icons' => [
        // Floating button + modal header icon
        'trigger' => null,

        // Fallback agent avatar (when an agent has no image)
        'avatar' => null,

        // Small icon shown on the redirect screen
        'redirect' => null,
    ],
];
