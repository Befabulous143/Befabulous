<?php

namespace App\MicroSite\Auth\Controllers;

use App\Http\Controllers\Controller;
use App\MicroSite\Auth\Services\AuthService;
use App\MicroSite\DashBoard\Services\UserService;
use App\MicroSite\Token\GenerateTokenService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    protected $brand;
    protected $service;
    protected $auth_service;
    protected $token_service;

    public function __construct()
    {
        $this->brand = config('app.brand');
        $this->service = new UserService();
        $this->auth_service = new AuthService();
        $this->token_service = new GenerateTokenService();
    }
    /** Login Index page */
    public function index()
    {
        return view('Auth.login_with_password');
    }

    /** Register view page */
    public function register()
    {
        return view('Auth.register');
    }

    /** create customer*/
    public function create(Request $request)
    {
        Session::flush();
        $this->service->validate();
        $plus_removed_mobile_number = str_replace('+', '', $request->mobile);
        $request->merge(['mobile' => $plus_removed_mobile_number]);
        if (request()->hasFile('profile')) {
            $profile_path = $this->imgStore(request()->file('profile'));
            $request->merge(['profile_path' => $profile_path]);
        }
        Session::push('formData', $request->except('profile'));
        return to_route('mobile_verification');
    }

    /** OTP Verification Page */
    public function mobileVerification()
    {
        $form_data = Session::get('formData');
        return view('Auth.verify-mobile', ['mobile' => $form_data[0]['mobile'] ?? '']);
    }

    /** Send OTP to the registered mobile number */
    public function sendOtpToMobile(Request $request)
    {
        set_time_limit(0);
        if ($request->mobile == null) {
            return redirect()->back()->with('false', 'Mobile number is required!');
        }
        if (strlen($request->mobile) > 15) {
            return redirect()->back()->with('false', 'Mobile number maximum length is 15');
        }
        if (strlen($request->mobile) < 8) {
            return redirect()->back()->with('false', 'Mobile number minmum length is 8');
        }

        $mobile = str_replace('+', '', $request->mobile);

        try {
            $device_id = $request->header('User-Agent');
            $form_data = Session::get('formData')[0];
            $data = [
                "identifierType" => "MOBILE",
                "identifierValue" => $mobile,
                "deviceId" => $device_id,
                "brand" => $this->brand,
                "password" => $form_data['password'],
                "confirmPassword" => $form_data['password_confirmation'],
            ];
            $token = $this->token_service->tokenGenerate($data);
            $data['sessionId'] = $token['user']['sessionId'] ?? '';
            if ($data['sessionId'] != '') {
                $otpGeneratePostData = collect($data)->except(['password', 'confirmPassword']);
                Session::push('validateOtpPayload', $otpGeneratePostData);
                $this->auth_service->generateOtp($otpGeneratePostData);
                return to_route('otp-index')->with('true', 'OTP sent successfully to your mobile number.');
            }
        } catch (\Exception $e) {
            $this->throwLogin($e);
        }
    }

    /** OTP index page */
    public function otpIndex()
    {
        return view('Auth.verify-otp');
    }

    public function verifyOtp(Request $request)
    {
        if ($request->otp_number == null) {
            return redirect()->back()->with('false', 'OTP number is required!');
        }
        if (strlen($request->otp_number) != 6) {
            return redirect()->back()->with('false', 'OTP number length atleast 6 digits required!');
        }
        try {
            $formData = Session::get('formData')[0];
            $postData = Session::get('validateOtpPayload')[0];
            $postData['otp'] = $request->otp_number;
            $verify_otp = $this->auth_service->validateOtp($postData);
            if ($verify_otp['status']['success'] == false) {
                return redirect()->back()->with('false', $verify_otp['status']['message']);
            }
            if ($verify_otp['status']['success'] == true && $verify_otp['user']['userRegisteredForPassword'] == true) {
                $postData['authToken'] = $verify_otp['auth']['token'];
                $customer = $this->auth_service->createCustomer($formData, $postData, $verify_otp);
                if ($customer == []) {
                    return redirect()->back()->with('false', 'User creation failed! please try again.');
                } else {
                    $response_data = [
                        'token' => $verify_otp['auth']['token'],
                        'cap_mobile' => $customer['mobile'],
                    ];
                    if (isset($customer['user_id'])) {
                        $user_id = $customer['user_id'];
                        $user = User::where('user_id', $user_id)->first();
                        if ($user != null) {
                            Auth::login($user);
                        }
                    }
                    $first_name = $formData['firstname'] ?? '';
                    $last_name = $formData['lastname'] ?? '';
                    Session::push('response_data', $response_data);
                    return redirect()->route('dashboard')->with('true', "Welcome $first_name $last_name");
                }

            }
        } catch (\Exception $e) {
            Log::info($e);
            $this->throwLogin($e);
        }
    }

    public function login(Request $request)
    {
        Session::flush();
        set_time_limit(0);
        if ($request->phone == null) {
            return redirect()->back()->with('false', 'Mobile number is required!');
        }
        $phone = str_replace('+','',$request->phone);
        $device_id = $request->header('User-Agent');

        $data = [
            "identifierType" => "MOBILE",
            "identifierValue" => $phone,
            "deviceId" => $device_id,
            "brand" => $this->brand,
            "password" => $request->password,
            "confirmPassword" => $request->password,
        ];
        $token = $this->token_service->tokenGenerate($data);
        if (isset($token['user']['userRegisteredForPassword']) && $token['user']['userRegisteredForPassword'] == true) {
            $data['sessionId'] = $token['user']['sessionId'];
            $login = $this->auth_service->login(collect($data)->except('confirmPassword'));
            if ($login['status']['success'] == false) {
                return redirect()->back()->with('false', $login['status']['message'])->withInput();
            }
            if ($login['status']['success'] == true) {
                $response_data = [
                    'token' => $login['auth']['token'],
                    'cap_mobile' => $phone,
                ];
                $user = $this->auth_service->getUserDetails($login['auth']['token'],$phone,$this->brand,$device_id);
                $first_name = $user['customers']['customer'][0]['firstname'] ?? '';
                $last_name = $user['customers']['customer'][0]['lastname'] ?? '';
                Session::push('response_data', $response_data);
                return to_route('dashboard')->with('true',"Welcome $first_name $last_name");
            }
        } else {
            return redirect()->back()->with('false', "You don't have an account!")->withInput();
        }
    }

    public function forgetPassword()
    {
        return view('Auth.forget-password');
    }

    public function updateForgetPassword(Request $request)
    {
        Session::flush();
        $request->validate([
            'phone' => 'required|min:8|max:15',
            'password' => 'required|confirmed|different:old_password',
            'password_confirmation' => 'required',
        ]);
        $phone = str_replace('+','',$request->phone);
        $data = [
            "identifierType" => "MOBILE",
            "identifierValue" => $phone,
            "deviceId" => $request->header('User-Agent'),
            "brand" => $this->brand,
            "password" => $request->password,
            "confirmPassword" => $request->password_confirmation,
        ];
        $generatedToken = $this->token_service->tokenGenerate($data);
        if (isset($generatedToken['user']['sessionId'])) {
            $data['sessionId'] = $generatedToken['user']['sessionId'];
            $updated = $this->auth_service->updateForgetPassword($data);
            if ($updated['status']['success'] == true) {
                $otpGeneratePostData = collect($data)->except(['password', 'confirmPassword']);
                Session::push('forget_password', $otpGeneratePostData);
                $this->auth_service->generateOtp($otpGeneratePostData);
                return to_route('forget_password_otp_page')->with('true', 'Please verify your mobile first!');
            } else {
                return redirect()->back()->withInput()->with('false', $updated['status']['message']?? 'Something Went wrong!');
            }
        }
        return redirect()->back()->withInput()->with('false', 'Something went wrong!');
    }

    public function forgetPasswordOtpPage()
    {
        return view('Auth.forget-password-otp');
    }

    public function validateOtpForForgetPassword(Request $request)
    {
        $validateData = Session::get('forget_password')[0];
        $validateData['otp'] = $request->otp;
        $verify_otp = $this->auth_service->validateOtp($validateData);
        if (isset($verify_otp['user']['userRegisteredForPassword']) && $verify_otp['user']['userRegisteredForPassword'] == true) {
            return to_route('login_page')->with('true', 'Password reset successfully!');
        }
        return to_route('login_page')->with('false', 'Something went wrong! Please try again or contact our support.');
    }

    public function imgStore($image)
    {
        $extension = $image->getClientOriginalExtension();
        $fileName = 'image_' . time() . '.' . $extension;
        $image->move(public_path('profile'), $fileName);
        return 'profile/' . $fileName;
    }

    public function throwLogin($errmsg = '')
    {

        return to_route('login_page')->with('false', ($errmsg != '' ? $errmsg : 'Something went wrong!'));
    }

    public function logout()
    {
        Session::flush();
        return to_route('login_page')->with('true', 'Logout Successfully! Please visit again.');
    }

    public function __destruct()
    {
        Session::flush();
    }

}
