<?php

namespace JeffersonGoncalves\WhatsappWidget\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use JeffersonGoncalves\WhatsappWidget\Http\Requests\WhatsappLogRequest;
use JeffersonGoncalves\WhatsappWidget\Models\WhatsappLog;

class WhatsappLogController
{
    public function __invoke(WhatsappLogRequest $request): Response
    {
        WhatsappLog::createByRequest($request->validated());

        return response()->noContent();
    }
}
