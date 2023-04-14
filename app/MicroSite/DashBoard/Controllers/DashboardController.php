<?php

namespace App\MicroSite\DashBoard\Controllers;

use App\Http\Controllers\Controller;
use App\MicroSite\DashBoard\Services\UserService;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Stevebauman\Location\Facades\Location;


class DashboardController extends Controller
{
    protected $service;
    public function __construct()
    {
        $this->service = new UserService();
    }
    public function index()
    {
        $ip = request()->ip();
        $currentUserInfo = Location::get($ip);
        try {
            $user_data = $this->service->getUserDetails();
            if ($user_data instanceof Response) {
                if($user_data->getStatusCode() == 302){
                    return $this->throwLogin('This page not found! Please try again.');
                }
            } else{

                if(isset($user_data['data']['user_id']) && !empty($user_data['data']['user_id']) && auth()->user() == null)
                {
                    $user = User::where('user_id',$user_data['data']['user_id'])->first();
                    if ($user != null) {
                        Auth::login($user);
                    }
                }
                $coupons = $this->service->getUserCoupons();
                $mapped_data = $this->mapCouponsDetails($coupons['data']);
                if($user_data['success'] == false){
                    return  $this->throwLogin();
                }
                if(isset($user_data['data']['item_status']['success']) && $user_data['data']['item_status']['success'] == "false")
                {
                    return  $this->throwLogin();
                }
                return view('Dashboard.home',['data'=>$user_data['data'],'coupons' =>  $mapped_data]);
            }
        } catch (\Exception $e) {
            Log::info($e);
           return $this->throwLogin();
        }
    }

    public function pointHistory(Request $request)
    {
        $start_date = '04/09/2005';
        $end_date = '04/09/2023';
        if($request->has('daterange'))
        {
           $date = explode('-',$request->daterange);
           if(is_array($date)){
               $start_date = Carbon::parse($date[0])->format('Y-m-d');
               $end_date = Carbon::parse($date[1])->format('Y-m-d');
           }
        }
        $points_summary = $this->service->getUserPointHistory($start_date,$end_date);
        if($points_summary['success'] == false){
            if($points_summary['data'] == "Session has been expired!"){
                return $this->throwLogin('Session has been expired!');
            }
            return  redirect()->back()->with('false','Something went wrong!');
        }
        return view('PointHistory.index',['data' => $points_summary['data'],'start_date' => $start_date,'end_date' => $end_date]);
    }

    public function mapCouponsDetails($coupons = [])
    {
       $result = [];
       foreach ($coupons as $k => $v) {
        $result[$k]['series_name'] = $v['series_name'] ?? '';
        $result[$k]['code'] = $v['code'] ?? '';
        if (isset($v['custom_properties']['custom_property'])) {
            foreach ($v['custom_properties']['custom_property'] as $property) {
                if(isset($property['name']) && isset($property['value']))
                {
                    $result[$k][$property['name']] = $property['value'];
                }
            }
        }
        
       }
        return $result;
    }
    public function throwLogin($errMsg = '')
    {
        Auth::logout();
        Session::flush();
        return to_route('login_page')->with('false', $errMsg != '' ? $errMsg : 'Something went wrong!');
    }
}
