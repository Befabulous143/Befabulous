<?php

namespace App\MicroSite\Auth\Controllers;

use App\Helpers\DeviceHelper;
use App\Http\Controllers\Controller;
use App\MicroSite\Auth\Services\AuthService;
use App\MicroSite\DashBoard\Services\UserService;
use App\MicroSite\Token\GenerateTokenService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    protected $brand;
    protected $service;
    protected $auth_service;
    protected $token_service;
    protected $device_type;

    public function __construct()
    {
        $this->brand = config('app.brand');
        $this->device_type = "MOBILE";
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
        $data = [
            "identifierType" => $this->device_type,
            "identifierValue" => $plus_removed_mobile_number,
            // "deviceId" => $request->header('User-Agent'),
            "brand" => $this->brand,
            "password" => $request->password,
            "confirmPassword" => $request->password_confirmation,
        ];
        $token = $this->token_service->tokenGenerate($data);
        if (isset($token['user']['userRegisteredForPassword']) && $token['user']['userRegisteredForPassword']) {
            return to_route('login_page')->with('false', 'User already exists! Please sign in to continue.');
        }
        $email_already_exits = $this->emailVerify();
        // $mobile_already_exits = $this->mobileVerify();
        if (!$email_already_exits['success']) {
            return redirect()->back()->withInput()->with('false', 'Email is already taken!Please try some other email.');
        }
        // if (!$mobile_already_exits['success']) {
        //     return redirect()->back()->withInput()->with('false', 'Mobile number is already taken!Please try some other mobile.');
        // }
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
                "identifierType" => $this->device_type,
                "identifierValue" => $mobile,
                // "deviceId" => $device_id,
                "brand" => $this->brand,
                "password" => $form_data['password'],
                "confirmPassword" => $form_data['password_confirmation'],
            ];
            $token = $this->token_service->tokenGenerate($data);
            $data['sessionId'] = $token['user']['sessionId'] ?? '';
            if ($data['sessionId'] != '') {
                unset($data['password']);
                unset($data['confirmPassword']);
                Session::push('validateOtpPayload', $data);
                $res = $this->auth_service->generateOtp($data);
                if (isset($res['status']['success']) && $res['status']['success'] == true) {
                    return to_route('otp-index')->with('true', 'OTP sent successfully to your mobile number.');
                } else {
                    return redirect()->back()->with('false','OTP generation failed! please try again.');
                }
            }
        } catch (\Exception $e) {
            Log::info($e);
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
            $formSession = Session::get('formData');
            if (is_array($formSession) && count($formSession) > 0) {
                $formData = $formSession[0];
            } else {
                $this->throwLogin('Something Went wrong! Please contact our support.');
            }
            $postSession = Session::get('validateOtpPayload');
            if (is_array($postSession) && count($postSession) > 0) {
                $postData = $postSession[0];
            } else {
                $this->throwLogin('Something Went wrong! Please contact our support.');
            }
            $postData['otp'] = $request->otp_number;
            $verify_otp = $this->auth_service->validateOtp($postData);
            if ($verify_otp['status']['success'] == false) {
                return redirect()->back()->with('false', 'Please enter a valid verification code sent');
            }
            if ($verify_otp['status']['success'] == true && $verify_otp['user']['userRegisteredForPassword'] == true) {
                $postData['authToken'] = $verify_otp['auth']['token'];
                $customer = $this->auth_service->createCustomer($formData, $postData, $verify_otp);
                if ($customer == []) {
                    return redirect()->back()->with('false', 'User creation failed! please try again.');
                } else {
                    $response_data = [
                        'token' => $postData['authToken'],
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
        $phone = str_replace('+', '', $request->phone);
        $device_id = $request->header('User-Agent');
        $data = [
            "identifierType" => $this->device_type,
            "identifierValue" => $phone,
            // "deviceId" => $device_id,
            "brand" => $this->brand,
            "password" => $request->password,
            "confirmPassword" => $request->password,
        ];
        $token = $this->token_service->tokenGenerate($data);
        if (isset($token['user']['userRegisteredForPassword']) && $token['user']['userRegisteredForPassword'] == true) {
            $data['sessionId'] = $token['user']['sessionId'];

            $login = $this->auth_service->login(collect($data)->except('confirmPassword'));
            if(!isset($login['status']['success'])){
                return redirect()->back()->with('false', 'Something went wrong! please contact our support')->withInput();
            }
            if ($login['status']['success'] == false) {
                return redirect()->back()->with('false', $login['status']['message'])->withInput();
            }
            if ($login['status']['success'] == true) {
                $response_data = [
                    'token' => $login['auth']['token'],
                    'cap_mobile' => $phone,
                ];
                $user = $this->auth_service->getUserDetails($login['auth']['token'], $phone, $this->brand, $device_id);

                if (isset($user['status']['success_count']) && $user['status']['success_count'] == 1) {
                    $first_name = $user['customers']['customer'][0]['firstname'] ?? '';
                    $last_name = $user['customers']['customer'][0]['lastname'] ?? '';
                    Session::push('response_data', $response_data);
                    return to_route('dashboard')->with('true', "Welcome $first_name $last_name");
                }
                return redirect()->back()->with('false', "You don't have an account!")->withInput();
            }
        } else {
            return redirect()->back()->with('false', "You don't have an account!")->withInput();
        }
    }

    public function forgetPassword()
    {
        return view('Auth.forget-password');
    }

    public function emailVerify()
    {
        $res = $this->auth_service->oAuthToken();
        $token = $res['data']['accessToken'] ?? '';
        $email = request()->email;
        if ($token != '' && $email != '') {
            $email = $this->auth_service->isEmailorMobileAlready('email', $email, $token);

            if (isset($email['errors'][0]['status']) && $email['errors'][0]['status'] == false) {
                return ['success' => true];
            } else {
                return ['success' => false];
            }
        }
        return ['success' => false];
    }

    public function mobileVerify()
    {
        $res = $this->auth_service->oAuthToken();
        $token = $res['data']['accessToken'] ?? '';
        $mobile = str_replace('+', '', request()->mobile);
        if ($token != '' && $mobile != '') {
            $mobile = $this->auth_service->isEmailorMobileAlready('mobile', $mobile, $token);
            if (isset($mobile['errors'][0]['status']) && $mobile['errors'][0]['status'] == false) {
                return ['success' => true];
            } else {
                return ['success' => false];
            }
        }
    }

    public function updateForgetPassword(Request $request)
    {
        Session::flush();
        $request->validate([
            'phone' => 'required|min:8|max:15',
            'password' => 'required|confirmed|different:old_password',
            'password_confirmation' => 'required',
        ]);
        $phone = str_replace('+', '', $request->phone);
        $data = [
            "identifierType" => $this->device_type,
            "identifierValue" => $phone,
            // "deviceId" => $request->header('User-Agent'),
            "brand" => $this->brand,
            "password" => $request->password,
            "confirmPassword" => $request->password_confirmation,
        ];
        $generatedToken = $this->token_service->tokenGenerate($data);

        if (isset($generatedToken['user']['sessionId'])) {
            $data['sessionId'] = $generatedToken['user']['sessionId'];
            $updated = $this->auth_service->updateForgetPassword($data);

            if ($updated['status']['success'] == true) {
                unset($data['password']);
                unset($data['confirmPassword']);
                Session::push('forget_password', $data);
                $res = $this->auth_service->generateOtp($data);
                if (isset($res['status']['success']) && $res['status']['success'] == true) {
                    return to_route('forget_password_otp_page')->with('true', 'Please verify your mobile first!');
                } else {
                   return redirect()->back()->with('false','OTP generation failed! please try again.');
                }
            } else {
                return redirect()->back()->withInput()->with('false', $updated['status']['message'] ?? 'Something Went wrong!');
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
        $validateData = Session::get('forget_password');
        if (is_array($validateData) && count($validateData) > 0) {
            $validateData = $validateData[0];
        } else {
            $this->throwLogin('Something Went wrong! Please contact our support.');
        }
        $validateData['otp'] = $request->otp;
        $verify_otp = $this->auth_service->validateOtp($validateData);
        if (isset($verify_otp['status']['success']) && $verify_otp['status']['success'] == false) {
            return redirect()->back()->with('false', "Please enter a valid verification code sent");
        }
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
        Cache::clear();
        return to_route('login_page')->with('true', 'Logout Successfully! Please visit again.');
    }

    public function __destruct()
    {
        Session::flush();
    }

}
