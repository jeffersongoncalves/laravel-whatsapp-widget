<?php

namespace JeffersonGoncalves\WhatsappWidget\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use JeffersonGoncalves\WhatsappWidget\Models\WhatsappAgent;

class WhatsappsController
{
    public function __invoke(Request $request): JsonResponse
    {
        abort_if($request->token !== config('whatsapp-widget.key'), 403);
        $whatsappAgents = WhatsappAgent::query()->where('active', true)->get();
        $ref = config('whatsapp-widget.url');
        $data = [];
        foreach ($whatsappAgents as $whatsappAgent) {
            $data[] = [
                'id' => $whatsappAgent->id,
                'name' => $whatsappAgent->name,
                'image_url' => $whatsappAgent->image_url ?? null,
                'phone' => $whatsappAgent->phone,
                'link' => $whatsappAgent->getLinkByWhatsappAgent($whatsappAgent, $ref),
            ];
        }

        return response()->json($data);
    }
}
