<?php

namespace App\MicroSite\Token;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GenerateTokenService
{
    public function tokenGenerate($data)
    {
        Log::info(['message' => 'generateOTP', 'payload' => $data]);
       return Http::microsite()->post('/auth/v1/token/generate', $data)->json();
    }
}
