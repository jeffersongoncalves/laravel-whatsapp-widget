<!DOCTYPE html>
@php use Illuminate\Support\Facades\URL; @endphp
<html xmlns="http://www.w3.org/1999/xhtml" lang="pt-BR" prefix="og: http://ogp.me/ns#">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('whatsapp-widget::whatsapp-widget.redirecting_to') }} {{ $whatsappAgent->name }}...</title>
    <meta name="robots" content="noindex, nofollow">
    <script type='text/javascript'>
        /* <![CDATA[ */
        var ww_whatsapp_chat_redirect = "https://wa.me/{{ str_replace('+', '', $whatsappAgent->phone) }}?text={{ urlencode($whatsappAgent->text) }}";
        /* ]]> */
    </script>
    @vite('resources/css/wa-redirect.css', "vendor/whatsapp-widget")
    @vite('resources/js/wa-redirect.js', "vendor/whatsapp-widget")
</head>
<body>
<div class="agent-forward">
    <p class="ww-whatsapp-chat-loading-connect"></p>
    <div class="agent-avatar">
        <img width="150" height="150" class="avatar ww-image" alt="{{ $whatsappAgent->name }}"
             src="{{ $whatsappAgent->image_url ?? Vite::asset('resources/images/whatsapp-icon-logo.svg', "vendor/whatsapp-widget") }}"/>
    </div>
    <h1>{{ $whatsappAgent->name }}</h1>
    <div class="number">
        <img class="wa-icon" alt="+{{ $whatsappAgent->phone }}"
             src="{{ Vite::asset('resources/images/whatsapp-icon-redirect.png', "vendor/whatsapp-widget") }}"/>
        <label>{{ $whatsappAgent->phone }}</label>
    </div>
    <div class="lds-spinner">
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
    </div>
</div>
</body>
</html>
