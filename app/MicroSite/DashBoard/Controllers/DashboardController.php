<?php

namespace App\MicroSite\DashBoard\Controllers;

use App\Http\Controllers\Controller;
use App\MicroSite\DashBoard\Services\UserService;
use App\Models\User;
use Carbon\Carbon;
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
    public function dashboardView()
    {
        try {
            $user_data = $this->service->getUserDetails();
            $loyality_point = $user_data['data']['group_points_summaries']['group_points_summary'][0]['loyalty_points'] ?? 0;
            $currency_value = 0;
            if($loyality_point != 0){
                $currency_value = $this->service->getCurrencyValue($loyality_point)['response']['points']['redeemable']['points_redeem_local_value'] ?? 0;
            }
            $currency_symbol = $this->service->currencySymbol();
            
            if ($user_data['success'] == false) {
                    return $this->throwLogin($user_data['data']);
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
                $points_summary = $this->pointSummary($user_data['data']['points_summaries']['points_summary']);
                return view('Dashboard.home',['data'=>$user_data['data'],'coupons' =>  $mapped_data,'points' => $points_summary,'currency_value' => $currency_value,'currency_symbol' => $currency_symbol]);
            }
        } catch (\Exception $e) {
            Log::info($e);
           return $this->throwLogin();
        }
    }

    public function pointSummary($data)
    {
        $redeemed = 0;
        $expired = 0;
        $returned = 0;
        $adjusted = 0;
        foreach ($data as $key => $value) {
                $redeemed+=$value['redeemed'];       
                $expired+=$value['expired'];       
                $returned+=$value['returned'];       
                $adjusted+=$value['adjusted'];       
        }
       return [
        'redeemed' => $redeemed,
        'expired' => $expired,
        'returned' => $returned,
        'adjusted' => $adjusted
       ];
    }

    public function pointHistory(Request $request)
    {
        $start_date = '2004-04-09';
        $end_date = Carbon::parse(now())->addDay(1)->format('Y-m-d');
        if($request->has('daterange'))
        {
           $date = explode('-',$request->daterange);
           if(is_array($date)){
               $start_date = Carbon::parse($date[0])->subDay(1)->format('Y-m-d');
               $end_date = Carbon::parse($date[1])->addDay(1)->format('Y-m-d');
           }
        }
        $points_summary = $this->service->getUserPointHistory($start_date,$end_date);
        if($points_summary['success'] == false){
            if($points_summary['data'] == "Session has been expired!"){
                return $this->throwLogin('Session has been expired!');
            }
            return  redirect()->back()->with('false','Something went wrong!');
        }
        $currency_symbol = $this->service->currencySymbol();
        $start_date = Carbon::parse($start_date)->addDay(1)->format('Y-m-d');
        $end_date = Carbon::parse($end_date)->subDay(1)->format('Y-m-d');
        return view('PointHistory.index',['data' => $points_summary['data'],'start_date' => $start_date,'end_date' => $end_date,'currency_symbol' => $currency_symbol ]);
    }

    public function mapCouponsDetails($coupons = [])
    {
       $result = [];
       foreach ($coupons as $k => $v) {
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
        return $result;
    }

    public function getCurrencyValue()
    {

    }

    public function throwLogin($errMsg = '')
    {
        Auth::logout();
        Session::flush();
        return to_route('login_page')->with('false', $errMsg != '' ? $errMsg : 'Something went wrong!');
    }
}
