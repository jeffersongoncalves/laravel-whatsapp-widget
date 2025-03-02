<?php

namespace JeffersonGoncalves\WhatsappWidget\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class WhatsappAgent extends Model
{
    protected $fillable = [
        'active',
        'name',
        'phone',
        'text',
        'image',
    ];

    protected $casts = [
        'active' => 'bool',
    ];

    public function getImageUrlAttribute(): ?string
    {
        if (empty($this->image)) {
            return null;
        }

        return Storage::disk(config('whatsapp-widget.disk'))->url($this->image);
    }

    public function getLinkByWhatsappAgent($whatsappAgent, $ref): string
    {
        return URL::signedRoute('whatsapp-widget.redirect', [
            'whatsapp_agent' => $whatsappAgent->id,
            'agent' => $whatsappAgent->id,
            'number' => $whatsappAgent->phone,
            'ref' => $ref,
        ]);
    }
}
