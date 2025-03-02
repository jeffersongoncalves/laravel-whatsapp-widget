<?php

namespace JeffersonGoncalves\WhatsappWidget\Http\Controllers;

use Illuminate\Http\Response;
use JeffersonGoncalves\WhatsappWidget\Http\Requests\WhatsappLogRequest;
use JeffersonGoncalves\WhatsappWidget\Models\WhatsappLog;

use function abort_if;
use function config;

class WhatsappLogFrontendController
{
    public function __invoke(WhatsappLogRequest $request): Response
    {
        abort_if($request->token !== config('whatsapp-widget.key'), 403);
        WhatsappLog::createByRequest($request->validated());

        return response()->noContent();
    }
}
