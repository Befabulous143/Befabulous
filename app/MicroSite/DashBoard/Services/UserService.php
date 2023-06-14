<?php

namespace App\MicroSite\DashBoard\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class UserService
{
    public function getUserDetails()
    {
        try {
            $response = Http::microsite()->withHeaders([
                'cap_authorization' => request()->header('cap-authorization'),
                'cap_brand' => request()->header('cap-brand'),
                'cap_device_id' => request()->header('cap-device-id'),
                'cap_mobile' => request()->header('cap-mobile'),
            ])->get('/mobile/v2/api/customer/get', [
                'subscriptions' => 'true',
                'mlp' => 'true',
                'user_id' => 'true',
                'optin_status' => 'true',
                'slab_history' => 'true',
                'expired_points' => 'true',
                'points_summary' => 'true',
                'membership_retention_criteria' => 'true',
            ]);
            $json = $response->json();
            if ($json['status']['success'] == false) {
                return ['success' => false, 'data' => $json['status']['message']];
            } else {
                $customer = $json['customers']['customer'][0] ?? [];
                return ['success' => true, 'data' => $customer];
            }
        } catch (\Exception $e) {
            Log::info($e);
            return ['success' => false, 'data' => 'Something went wrong!'];
        }

    }

    public function getUserCoupons($status_value = '')
    {
        try {
            $response = Http::microsite()->withHeaders([
                'cap_authorization' => request()->header('cap-authorization'),
                'cap_brand' => request()->header('cap-brand'),
                'cap_device_id' => request()->header('cap-device-id'),
                'cap_mobile' => request()->header('cap-mobile'),
            ])->get('/mobile/v2/api/customer/coupon', [
                'status' => 'active',
            ]);
            $json = $response->json()['response'];
            if ($json['status']['success'] == false) {
                if ($json['status']['code'] == 302) {
                    return ['success' => false, 'data' => 'Session has been expired!'];
                }
                if ($json['status']['code'] == 401) {
                    return abort(404);
                }
                return ['success' => false, 'data' => 'Something went wrong!'];
            }
            $coupons = $json['customers']['customer'][0]['coupons']['coupon'] ?? [];
            return ['success' => true, 'data' => $coupons];
        } catch (\Exception $e) {
            Log::info($e);
            return ['success' => false, 'data' => 'Something went wrong!'];
        }

    }

    public function getUserPointHistory($start_date = '', $end_date = '')
    {
        try {
            $response = Http::microsite()->withHeaders([
                'cap_authorization' => request()->header('cap-authorization'),
                'cap_brand' => request()->header('cap-brand'),
                'cap_device_id' => request()->header('cap-device-id'),
                'cap_mobile' => request()->header('cap-mobile'),
            ])->get('/mobile/v2/api/points/history', [
                'start_date' => $start_date,
                'end_date' => $end_date,
            ]);
            $json = $response->json();
            if ($json['status']['success'] == false) {
                if ($json['status']['code'] == 302) {
                    return ['success' => false, 'data' => 'Session has been expired!'];
                }
                if ($json['status']['code'] == 401) {
                    return ['success' => false, 'data' => 'Session has been expired!'];
                }
                return ['success' => false, 'data' => 'Something went wrong!'];
            }

            $customer_points = $json['customer'] ?? [];
            return ['success' => true, 'data' => $customer_points];
        } catch (\Exception $e) {
            Log::info($e);
            return ['success' => false, 'data' => 'Something went wrong!'];
        }

    }

    public function updateUserDetails($request)
    {
        DB::beginTransaction();
        try {

            $user_data = [
                "root" => [
                    "customer" => [
                        [
                            "firstname" => $request->firstname,
                            "lastname" => $request->lastname,
                            "email" => $request->email,
                            "extended_fields" => [
                                "field" => [
                                    [
                                        "name" => "city",
                                        "value" => $request->city,
                                    ],
                                    [
                                        "name" => "State",
                                        "value" => $request->State,
                                    ],
                                    [
                                        "name" => "country_of_residence",
                                        "value" => $request->country_of_residence,
                                    ],
                                    [
                                        "name" => "gender",
                                        "value" => $request->gender,
                                    ],
                                    [
                                        "name" => "zip",
                                        "value" => $request->zip,
                                    ],
                                    [
                                        "name" => "dob",
                                        "value" => $request->dob,
                                    ],
                                    [
                                        "name" => "wedding_date",
                                        "value" => $request->wedding_date,
                                    ],
                                    [
                                        "name" => "marital_status",
                                        "value" => $request->marital_status,
                                    ],
                                    [
                                        "name" => "age",
                                        "value" => $request->age,
                                    ],
                                    [
                                        "name" => "area",
                                        "value" => $request->area,
                                    ],
                                    [
                                        "name" => "nationality",
                                        "value" => $request->nationality,
                                    ],
                                    [
                                        "name" => "religion",
                                        "value" => $request->religion,
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ];
            $response = Http::microsite()->withHeaders([
                'cap_authorization' => request()->header('cap-authorization'),
                'cap_brand' => request()->header('cap-brand'),
                'cap_device_id' => request()->header('cap-device-id'),
                'cap_mobile' => $request->mobile ?? request()->header('cap-mobile'),
            ])->post('/mobile/v2/api/customer/update', $user_data);
            $json = $response->json();
            if ($json['status']['success'] == false) {
                if ($json['status']['code'] == 401) {
                    return ['success' => false, 'data' => 'Session has been Expired!'];
                }
                return ['success' => false, 'data' => 'Something went wrong!'];
            }
            if ($request->image_removed == 'image_removed' && isset($json['customers']['customer'][0]['user_id'])) {
                $user_id = $json['customers']['customer'][0]['user_id'];
                $user = User::where('user_id', $user_id);
                if ($user->first() != null) {
                    $profile = $user->first()->profile;
                    if ($profile != null && \File::exists(public_path($profile))) {
                        \File::delete(public_path($profile));
                    }
                }
                $user->delete();
                Auth::logout();
            }
            if ($request->hasFile('profile') && isset($json['customers']['customer'][0]['user_id'])) {
                $user_id = $json['customers']['customer'][0]['user_id'];
                $user = User::where('user_id', $user_id);
                if ($user->first() != null) {
                    if (\File::exists(public_path($user->first()->profile))) {
                        \File::delete(public_path($user->first()->profile));
                    }
                    $profile_path = $this->imgStore(request()->file('profile'), $user_id);
                    $user->update(['profile' => $profile_path]);
                } else {
                    $profile_path = $this->imgStore(request()->file('profile'), $user_id);
                    $user = new User();
                    $user->user_id = $user_id;
                    $user->profile = $profile_path;
                    $user->save();
                    if (auth()->user() == null) {
                        Auth::login($user);
                    }
                }
            }
            $customer = $json['customers']['customer'][0] ?? [];
            DB::commit();
            return ['success' => true, 'data' => $customer];
        } catch (\Exception $e) {
            Log::info($e);
            DB::rollBack();
            return ['success' => false, 'data' => 'Something went wrong!'];
        }
    }

    public function imgStore($image, $user_id)
    {
        $extension = $image->getClientOriginalExtension();
        $fileName = 'image_' . time() . $user_id . '.' . $extension;
        $image->move(public_path('profile'), $fileName);
        return 'profile/' . $fileName;
    }

    public function validate()
    {
        $attributes = request()->validate([
            "firstname" => 'required',
            "lastname" => 'required',
            "email" => 'required',
            "mobile" => 'required|min:8|max:15',
            "password" => 'required|confirmed',
            'password_confirmation' => 'required',
            "dob" => "nullable|date",
            "age" => 'nullable|numeric',
            "area" => 'nullable',
            "city" => 'nullable',
            "state" => 'nullable',
            "zip" => 'nullable',
            "country_of_residence" => 'nullable',
            "gender" => "nullable",
            "wedding_date" => "nullable|date",
            "marital_status" => "nullable",
            "nationality" => 'nullable',
            "religion" => 'nullable',
        ]);
        
        return $attributes;
    }

    public function updateValidate()
    {
        $attributes = request()->validate([
            "firstname" => 'required',
            "lastname" => 'required',
            "email" => 'required',
            "mobile" => 'required',
            "dob" => "nullable|date",
            "age" => 'nullable|numeric',
            "area" => 'nullable',
            "city" => 'nullable',
            "state" => 'nullable',
            "zip" => 'nullable',
            "country_of_residence" => 'nullable',
            "gender" => "nullable",
            "wedding_date" => "nullable|date",
            "marital_status" => "nullable",
            "nationality" => 'nullable',
            "religion" => 'nullable',
        ]);

        return $attributes;
    }

    public function getCurrencyValue($point)
    {
        $headers = [
            'cap_authorization' => request()->header('cap-authorization'),
            'cap_brand' => request()->header('cap-brand'),
            'cap_device_id' => request()->header('cap-device-id'),
            'cap_mobile' => request()->header('cap-mobile'),
        ];
        $country_code = $this->countryCode();
        return Http::microsite()->withHeaders($headers)->get("/mobile/v2/api/points/value/$country_code", ['points' => $point])->json();
    }

    public function countryCode()
    {
        $mobile = substr(request()->header('cap-mobile'), 0, 3);
        switch ($mobile) {
            case '962':
                $value = 'jordinar';
                break;
            case '971':
                $value = 'uae';
                break;
            case '968':
                $value = 'oman';
                break;
            case '973':
                $value = 'bahrain';
                break;
            case '974':
                $value = 'qatar';
                break;
            case '966':
                $value = 'ksa';
                break;
            default:
                $value = 'jordinar';
                break;
        }
        return $value;
    }

    public function currencySymbol()
    {
        $mobile = substr(request()->header('cap-mobile'), 0, 3);
        switch ($mobile) {
            case '962':
                $value = "JOD";
                break;
            case '971':
                $value = "AED";
                break;
            case '968':
                $value = 'OMR';
                break;
            case '973':
                $value = 'BHD';
                break;
            case '974':
                $value = 'QAR';
                break;
            case '966':
                $value = 'SAR';
                break;
            default:
                $value = 'JOD';
                break;
        }
        return $value;
    }
}
