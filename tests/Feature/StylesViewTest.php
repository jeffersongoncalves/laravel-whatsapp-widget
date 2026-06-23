<?php

it('renders widget color variables from config', function () {
    config()->set('whatsapp-widget.colors.primary', '#123456');
    config()->set('whatsapp-widget.colors.primary_text', '#abcdef');
    config()->set('whatsapp-widget.colors.badge', '#ff00ff');
    config()->set('whatsapp-widget.colors.modal_bg', '#101010');
    config()->set('whatsapp-widget.colors.modal_text', '#202020');
    config()->set('whatsapp-widget.colors.modal_muted', '#303030');
    config()->set('whatsapp-widget.colors.online', '#00ff00');

    $html = view('whatsapp-widget::whatsapp-widget-styles')->render();

    expect($html)
        ->toContain('--ww-primary: #123456;')
        ->toContain('--ww-primary-text: #abcdef;')
        ->toContain('--ww-badge: #ff00ff;')
        ->toContain('--ww-modal-bg: #101010;')
        ->toContain('--ww-modal-text: #202020;')
        ->toContain('--ww-modal-muted: #303030;')
        ->toContain('--ww-online: #00ff00;');
});

it('renders redirect color variables from config', function () {
    config()->set('whatsapp-widget.redirect.background', '#f0f0f0');
    config()->set('whatsapp-widget.redirect.text', '#0a0a0a');
    config()->set('whatsapp-widget.redirect.name', '#0b0b0b');
    config()->set('whatsapp-widget.redirect.accent', '#0c0c0c');
    config()->set('whatsapp-widget.redirect.spinner', '#0d0d0d');

    $html = view('whatsapp-widget::whatsapp-widget-styles')->render();

    expect($html)
        ->toContain('--ww-redirect-bg: #f0f0f0;')
        ->toContain('--ww-redirect-text: #0a0a0a;')
        ->toContain('--ww-redirect-name: #0b0b0b;')
        ->toContain('--ww-redirect-accent: #0c0c0c;')
        ->toContain('--ww-redirect-spinner: #0d0d0d;');
});

it('falls back to default colors when config is missing', function () {
    config()->set('whatsapp-widget.colors', null);
    config()->set('whatsapp-widget.redirect', null);

    $html = view('whatsapp-widget::whatsapp-widget-styles')->render();

    expect($html)
        ->toContain('--ww-primary: #03cc0b;')
        ->toContain('--ww-redirect-bg: #f1f1f1;');
});
