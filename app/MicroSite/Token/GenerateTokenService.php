<?php

namespace App\MicroSite\Token;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GenerateTokenService
{
    public function tokenGenerate($data)
    {
        $res = Http::microsite()->post('/auth/v1/token/generate', $data)->json();
        Log::info(['message' => '/auth/v1/token/generate', 'payload' => $data, 'response' => $res]);
        return $res;
    }
}
