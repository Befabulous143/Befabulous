<?php

namespace App\MicroSite\Auth\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class AjaxAuthController extends Controller
{
    public function redirectToDashborad(Request $request)
    {
        try {
            $response_data = [
                'token' => $request->authToken,
                'cap_mobile' => $request->cap_mobile,
            ];
            $user_id = $request->user_id ?? '';
            if (!empty($user_id)) {
                $user = User::where('user_id', $user_id)->first();
                if ($user) {
                    Auth::login($user);
                }
            }
            Cache::put('response_data', $response_data);
            return response()->json(['success' => true]);
        } catch (\Throwable $th) {
            return response()->json(['success' => false]);
        }
    }
}
