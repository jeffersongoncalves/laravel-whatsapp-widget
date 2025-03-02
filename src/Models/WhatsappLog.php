<?php

namespace JeffersonGoncalves\WhatsappWidget\Models;

use Illuminate\Database\Eloquent\Model;

class WhatsappLog extends Model
{
    protected $casts = [
        'agent' => 'json',
        'number' => 'json',
        'geo' => 'json',
    ];
    protected $table = 'whatsapp_logs';
    protected $fillable = [
        'agent',
        'number',
        'type',
        'ref',
        'geo',
    ];

    public static function createByRequest(array $data): void
    {
        self::create([
            'agent' => [$data['agent']],
            'number' => [$data['number']],
            'type' => $data['type'],
            'ref' => $data['ref'],
            'geo' => $data['geo'] ?? [],
        ]);
    }
}
