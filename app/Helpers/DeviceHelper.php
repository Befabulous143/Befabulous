<?php

namespace App\Helpers;

class DeviceHelper
{
    public static function getDeviceType($userAgent)
    {
        $mobileKeywords = [
            'android', 'iphone', 'ipod', 'ipad', 'windows phone', 'blackberry', 'symbian', 'webos', 'opera mini',
        ];

        foreach ($mobileKeywords as $keyword) {
            if (stripos($userAgent, $keyword) !== false) {
                return true;
            }
        }

        return false;
    }
}

