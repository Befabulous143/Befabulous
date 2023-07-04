<?php

namespace App\MicroSite\Token;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GenerateTokenService
{
    public function tokenGenerate($data)
    {
        $userAgent = request()->header('User-Agent');

        $url = '/auth/v1/web/token/generate';
        if ($this->isMobileDevice($userAgent)) {
            $url = '/auth/v1/web/token/generate';
        }
        $res = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Client-IP' => request()->ip()
        ])->connectTimeout(30)->timeout(30)->post(config('app.api_base_url').$url, $data)->json();
        Log::info(['message' => $url, 'payload' => $data, 'response' => $res]);
        return $res;
    }

    private function isMobileDevice($userAgent)
    {
        $regex = "/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i";
        return preg_match($regex, $userAgent);
    }
}
