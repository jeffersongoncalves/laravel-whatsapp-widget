<?php

namespace JeffersonGoncalves\WhatsappWidget\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WhatsappLogRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'agent' => 'required',
            'number' => 'required',
            'type' => 'nullable',
            'ref' => 'nullable',
            'geo' => 'nullable',
            'token' => 'exclude',
        ];
    }
}
