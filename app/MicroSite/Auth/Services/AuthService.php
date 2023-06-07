<?php

namespace App\MicroSite\Auth\Services;

use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AuthService
{
    public function generateOtp($data)
    {
        return Http::microsite()->post('/auth/v1/otp/generate', $data)->json();
    }

    public function validateOtp($data)
    {
        return Http::microsite()->post('/auth/v1/otp/validate', $data)->json();
    }

    public function create($headers, $data)
    {
        return Http::microsite()->withHeaders($headers)->post('/mobile/v2/api/customer/add', $data)->json();
    }

    public function delete($headers)
    {
        return Http::microsite()->withHeaders($headers) ->withBody('{}', 'application/json')->post('/mobile/v2/api/PII/delete')->json();
    }

    public function login($data)
    {
        return Http::microsite()->post('/auth/v1/password/validate', $data)->json();
    }

    public function updatePassword($data)
    {
        return Http::microsite()->post('/auth/v1/password/change', $data)->json();
    }

    public function updateForgetPassword($data)
    {
        return Http::microsite()->post('/auth/v1/password/forget', $data)->json();
    }

    public function oAuthToken()
    {
        return Http::post('https://eu.api.capillarytech.com/v3/oauth/token/generate?=null', ['key' => "e6ZZNqcVrASowmSrwXOdFqTg7","secret" => 'vuEk0UM4rRWNr3VfYxKBqfj0YihS8Tf95i0ycXZO'])->json();
    }

    public function isEmailorMobileAlready($type,$value,$token)
    {
        return Http::withHeaders(['X-CAP-API-OAUTH-TOKEN' => $token])
                    ->get("https://eu.api.capillarytech.com/v2/customers/lookup?source=INSTORE&identifierName=$type&identifierValue=$value")
                    ->json();
    }

    public function createCustomer($formData, $postData)
    {
        $user_data = [
            "root" => [
                "customer" => [
                    [
                        "firstname" => $formData['firstname'] ?? '',
                        "lastname" => $formData['lastname'] ?? '',
                        "email" => $formData['email'] ?? '',
                        "extended_fields" => [
                            "field" => [
                                [
                                    "name" => "city",
                                    "value" => $formData['city'] ?? '',
                                ],
                                [
                                    "name" => "State",
                                    "value" => $formData['state'] ?? '',
                                ],
                                [
                                    "name" => "country_of_residence",
                                    "value" => $formData['country_of_residence'] ?? '',
                                ],
                                [
                                    "name" => "gender",
                                    "value" => $formData['gender'] ?? '',
                                ],
                                [
                                    "name" => "zip",
                                    "value" => $formData['zip'] ?? '',
                                ],
                                [
                                    "name" => "dob",
                                    "value" => $formData['dob'] ?? '',
                                ],
                                [
                                    "name" => "wedding_date",
                                    "value" => $formData['wedding_date'] ?? '',
                                ],
                                [
                                    "name" => "marital_status",
                                    "value" => $formData['marital_status'] ?? '',
                                ],
                                [
                                    "name" => "age",
                                    "value" => $formData['age'] ?? '',
                                ],
                                [
                                    "name" => "area",
                                    "value" => $formData['area'] ?? '',
                                ],
                                [
                                    "name" => "nationality",
                                    "value" => $formData['nationality'] ?? '',
                                ],
                                [
                                    "name" => "religion",
                                    "value" => $formData['religion'] ?? '',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];
        $headers = [
            'cap_authorization' => $postData['authToken'],
            'cap_brand' => $postData['brand'],
            'cap_device_id' => $postData['deviceId'],
            'cap_mobile' => $postData['identifierValue'],
        ];
        $response = $this->create($headers, $user_data);
        if (isset($formData['profile_path'])) {
            $user_id = $response['customers']['customer'][0]['user_id'] ?? 0;

            $user = User::where('user_id', $user_id);
            if ($user->first()) {
                if (\File::exists(public_path($user->first()->profile))) {
                    \File::delete(public_path($user->first()->profile));
                }
                $user->update(['profile' => $formData['profile_path']]);
            } else {
                $user = new User();
                $user->user_id = $user_id;
                $user->profile = $formData['profile_path'];
                $user->save();
            }
        }

        return $response['customers']['customer'][0] ?? [];

    }

    public function getUserDetails($token,$mobile,$brand,$device)
    {
            return Http::microsite()->withHeaders([
                'cap_authorization' => $token,
                'cap_brand' => $brand,
                'cap_device_id' => $device,
                'cap_mobile' => $mobile,
            ])->get('/mobile/v2/api/customer/get', [
                'subscriptions' => 'true',
                'mlp' => 'true',
                'user_id' => 'true',
                'optin_status' => 'true',
                'slab_history' => 'true',
                'expired_points' => 'true',
                'points_summary' => 'true',
                'membership_retention_criteria' => 'true',
            ])->json();
    }

  
}
