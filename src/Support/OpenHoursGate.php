<?php

namespace JeffersonGoncalves\WhatsappWidget\Support;

/**
 * Optional integration with jeffersongoncalves/laravel-open-hours: decides what the widget does while the business
 * is closed. Without that package (or with `when_closed` null) the widget behaves as always.
 */
class OpenHoursGate
{
    public const OPEN_HOURS = 'JeffersonGoncalves\OpenHours\OpenHours';

    /** null = render normally, 'hide' = render nothing, 'closed' = render with the closed status. */
    public static function closedMode(): ?string
    {
        $mode = config('whatsapp-widget.when_closed');

        if (! in_array($mode, ['hide', 'closed'], true) || ! class_exists(self::OPEN_HOURS)) {
            return null;
        }

        return app(self::OPEN_HOURS)->isOpen() ? null : $mode;
    }

    /** "Closed · opens Monday at 09:00", in the app locale. */
    public static function statusText(): string
    {
        return app(self::OPEN_HOURS)->statusText();
    }
}
