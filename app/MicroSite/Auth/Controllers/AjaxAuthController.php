<?php

namespace App\MicroSite\Auth\Controllers;

use App\Http\Controllers\Controller;
use App\MicroSite\Auth\Services\AuthService;
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
            $user_id = $request->user_id ?? '';
            $response_data = [
                'token' => $request->authToken,
                'cap_mobile' => $request->cap_mobile,
                'user_id' => $user_id,
            ];
            if (!empty($user_id)) {
                $user = User::where('user_id', $user_id)->first();
                if ($user) {
                    Auth::login($user);
                }
            }
            Session::push("response_data", $response_data);
            return response()->json(['success' => true]);
        } catch (\Throwable $th) {
            return response()->json(['success' => false]);
        }
    }

    public function uploadImage(Request $request)
    {   
        if(isset($request->user_id)){
            $user_id = $request->user_id;
            $profile_path = $this->imgStore($request->file('profile'));
    
            $user = User::where('user_id', $user_id);
            if ($user->first()) {
                if (\File::exists(public_path($user->first()->profile))) {
                    \File::delete(public_path($user->first()->profile));
                }
                $user->update(['profile' => $profile_path]);
            } else {
                $user = new User();
                $user->user_id = $user_id;
                $user->profile = $profile_path;
                $user->save();
                if ($user) {
                    Auth::login($user);
                }
            }
            return response()->json(['success' => true]);
        }       
        return response()->json(['success' => true]);
    }

    public function imgStore($image)
    {
        $extension = $image->getClientOriginalExtension();
        $fileName = 'image_' . time() . '.' . $extension;
        $image->move(public_path('profile'), $fileName);
        return 'profile/' . $fileName;
    }
}
