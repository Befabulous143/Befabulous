<?php

namespace App\MicroSite\Auth\Services;

use App\Models\User;
use Illuminate\Support\Facades\Http;

class AuthService
{
    public function generateOtp($data)
    {
        return Http::microsite()->post('/auth/v1/otp/generate', $data);
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
        if ($formData['profile_path']) {
            $user_id = $response['customers']['customer'][0]['user_id'] ?? 0;

            $user = User::where('user_id', $user_id);
            if ($user->first()) {
                if (\File::exists(public_path($user->first()->profile))) {
                    \File::delete(public_path($user->first()->profile));
                }
                $profile_path = $this->imgStore(request()->file('profile'), $user_id);
                $user->update(['profile' => $profile_path]);
            } else {
                $user = new User();
                $user->user_id = $user_id;
                $user->profile = $formData['profile_path'];
                $user->save();
            }
        }

        return $response['customers']['customer'][0] ?? [];

    }

    public function imgStore($image, $user_id)
    {
        $extension = $image->getClientOriginalExtension();
        $fileName = 'image_' . time() . $user_id . '.' . $extension;
        $image->move(public_path('profile'), $fileName);
        return 'profile/' . $fileName;
    }
}
