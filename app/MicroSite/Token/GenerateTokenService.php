<?php

namespace App\MicroSite\Token;

use Illuminate\Support\Facades\Http;

class GenerateTokenService
{
    public function tokenGenerate($data)
    {
       return Http::microsite()->post('/auth/v1/token/generate', $data)->json();
    }
}
