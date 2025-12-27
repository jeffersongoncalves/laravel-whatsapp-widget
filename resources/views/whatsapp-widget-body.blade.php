@php use Illuminate\Support\Facades\URL;use JeffersonGoncalves\WhatsappWidget\Models\WhatsappAgent; @endphp
@php $whatsappAgents = WhatsappAgent::query()->where('active', true)->get(); @endphp
@if($whatsappAgents->count())
    <div
        class="ww-container ww-floating {{ config('whatsapp-widget.position', 'right') === 'left' ? 'bottom-left' : 'bottom-right' }}">
        <span id="contact-trigger" class="ww-whatsapp-icon-only">
            <img class="icon" alt="{{ __('whatsapp-widget::whatsapp-widget.icon_alt') }}"
                 src="{{ Vite::asset('resources/images/whatsapp-icon-a.svg', "vendor/whatsapp-widget") }}">
        </span>
        <div id="notification-badge">{{ $whatsappAgents->count() }}</div>
        <ul class="ww-whatsapp-content">
            <li class="ww-content-header">
                <a class="close-chat" title="{{ __('whatsapp-widget::whatsapp-widget.close_title') }}">
                    {{ __('whatsapp-widget::whatsapp-widget.close') }}
                </a>
                <img class="icon" alt="{{ __('whatsapp-widget::whatsapp-widget.icon_alt') }}"
                     src="{{ Vite::asset('resources/images/whatsapp-icon-a.svg', "vendor/whatsapp-widget") }}">
                <h5>
                    {{ config('whatsapp-widget.name') }}
                    <span>{{ __('whatsapp-widget::whatsapp-widget.we_are_available') }}</span>
                </h5>
            </li>
            @foreach($whatsappAgents as $whatsappAgent)
                <li class="available">
                    <a class="ww-whatsapp-button" target="_blank" data-agent="{{ $whatsappAgent->id }}"
                       data-number="{{ $whatsappAgent->phone }}" rel="nofollow"
                       href="{{ URL::signedRoute('whatsapp-widget.redirect', ['whatsapp_agent' => $whatsappAgent->id, 'agent' => $whatsappAgent->id, 'number' => $whatsappAgent->phone, 'ref' => config('whatsapp-widget.url')]) }}">
                        <img width="60" height="60" class="ww-whatsapp-avatar ww-image"
                             alt="{{ $whatsappAgent->name }}"
                             src="{{ $whatsappAgent->image_url ?? Vite::asset('resources/images/whatsapp-icon-logo.svg', "vendor/whatsapp-widget") }}"/>
                        <span class="ww-whatsapp-text">
                            <span class="ww-whatsapp-label">
                                <span class="status">{{ __('whatsapp-widget::whatsapp-widget.online') }}</span>
                            </span>
                            {{ $whatsappAgent->name }}
                        </span>
                    </a>
                </li>
            @endforeach
            <li class="ww-content-footer">
                <p></p>
            </li>
        </ul>
        @if(config('whatsapp-widget.audio'))
            <audio id="ww-whatsapp-audio" preload="auto">
                <source src="{{ Vite::asset('resources/midia/alert.mp3', "vendor/whatsapp-widget") }}"
                        type="audio/mpeg"/>
            </audio>
            <script type="text/javascript">
                var playSingleDay = {{ json_encode(config('whatsapp-widget.play_audio_daily')) }};
                var date = new Date();
                date.setTime(+date + (24 * 60 * 60 * 1000));

                function getCookie(name) {
                    // getCookie function by Chirp Internet: www.chirp.com.au
                    var re = new RegExp(name + "=([^;]+)");
                    var value = re.exec(document.cookie);
                    return value != null ? unescape(value[1]) : null;
                }

                setTimeout(function () {
                    if (document.cookie.indexOf("play=") == -1) {
                        document.cookie = "play=" + true + ";expires=" + date.toGMTString() + "; path=/";
                        const promise = document.getElementById('ww-whatsapp-audio').play();
                        if (promise !== undefined) {
                            promise.then(() => {
                                // Autoplay started
                            }).catch(error => {
                            });
                        }
                    } else if (!playSingleDay) {
                        document.getElementById('ww-whatsapp-audio').play();
                        const promise = document.getElementById('ww-whatsapp-audio').play();
                        if (promise !== undefined) {
                            promise.then(() => {
                                // Autoplay started
                            }).catch(error => {
                            });
                        }
                    }
                }, 3000)
            </script>
        @endif
    </div>
@endif
