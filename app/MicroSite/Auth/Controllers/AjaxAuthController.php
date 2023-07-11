<?php

namespace App\MicroSite\Auth\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    public function couponsView(Request $request)
    {
        if(isset($request->coupons)){
           $mapped_coupons = $this->mapCouponsDetails($request->coupons);
           return view('offers.index',['coupons' => $mapped_coupons])->render();
        }
    }

    public function mapCouponsDetails($coupons = [])
    {
       $result = [];
       foreach ($coupons as $k => $v) {
        if(isset($v['redemption_count']) && $v['redemption_count'] == 0 && !empty($v['valid_till']) && !Carbon::parse($v['valid_till'])->isPast()){
            $result[$k]['series_name'] = $v['series_name'] ?? '';
            $result[$k]['code'] = $v['code'] ?? '';
            $result[$k]['created_date'] = isset($v['created_date']) && !empty($v['created_date']) ? Carbon::parse($v['created_date'])->format('d/m/Y') : '';
            $result[$k]['valid_till'] = isset($v['valid_till']) && !empty($v['valid_till']) ? Carbon::parse($v['valid_till'])->format('d/m/Y') : '';;
            if (isset($v['custom_properties']['custom_property'])) {
                foreach ($v['custom_properties']['custom_property'] as $property) {
                    if(isset($property['name']) && isset($property['value']))
                    {
                        $result[$k][$property['name']] = $property['value'];
                    }
                }
            }
        }
        
       }
        return $result;
    }

    public function transactionHistory(Request $request)
    {
        if($request->transactions){
            $data = json_decode($request->transactions,true);
            return view('PointHistory.transaction_list',['data' => $data])->render();
        }
    }
}
