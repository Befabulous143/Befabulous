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
        if(!empty(request()->header('user-id')))
        {
            $user = User::where('user_id',request()->header('user-id'))->first();
            if ($user != null) {
                Auth::login($user);
            }
        }
        return view('Dashboard.home');
    }

    public function pointHistory(Request $request)
    {
        return view('PointHistory.index');
    }

    public function throwLogin($errMsg = '')
    {
        Auth::logout();
        Session::flush();
        return to_route('login_page')->with('false', $errMsg != '' ? $errMsg : 'Something went wrong!');
    }
}
