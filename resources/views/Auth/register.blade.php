@extends('layouts.login')
@section('content')
@include('partials.session')
@include('countries-drop-down.countries-style')
@include('partials.js-error')
<div class="mt-0 lg:mt-2 p-2 pt-0  ">
    <div class="mt-5 md:col-span-2 md:mt-0">
        <form id="registerForm" enctype="multipart/form-data">
            <div class="grid grid-cols-1 place-items-center  overflow-hidden  rounded ">
                <div class="lg:w-3/5 w-full app-bg-color  px-4 py-3 text-left sm:px-6 rounded-t-lg">
                    <h1 class="text-xl font-semibold text-white">CREATE YOUR ACCOUNT</h1>
                </div>
                <div class="lg:w-3/5 w-full bg-white px-4 py-5  sm:p-6">
                    <div class="grid grid-cols-1 place-items-center mb-8">
                        <label for="upload_profile" style='width: 150px;height: 150px;position: relative;'
                            class='rounded-full border border cursor-pointer border-slite-200 shadow'>
                            <div id="img_preview">
                                <span
                                    style="position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);opacity:0.7"
                                    class="w-full   text-center font-normal text-gray-400 text-4xl">
                                    <i class="fa-solid fa-user"></i>
                                </span>
                            </div>
                        </label>
                        <input type="file" name="profile" accept="image/*" id="upload_profile"
                            onchange="preview_image1()" multiple class="hidden w-full" value="{{  old('profile') }}" />
                        <span id="error1" class="text-xs text-red-500 mt-2"></span>
                        <label for="upload_profile" class="block text-sm font-medium text-gray-700">Upload
                            Profile</label>
                        @error('profile')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="border border-slite-50 border-dashed	  w-full mb-5">

                    </div>
                    <div class="grid grid-cols-6 gap-6">
                        <div class="col-span-6 sm:col-span-3">
                            <label for="firstname" class="block text-sm font-medium text-gray-700">First
                                name <span class="text-red-500">*</span></label>
                            <input oninput="validateNameInput(this)" required type="text" name="firstname"
                                value="{{ old('firstname') ?? '' }}" id="firstname" autocomplete="given-name"
                                class="mt-1.5 block w-full rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-gray-500 focus:outline-none focus:ring-gray-200 sm:text-sm">
                            @error('firstname')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-span-6 sm:col-span-3">
                            <label for="lastname" class="block text-sm font-medium text-gray-700">Last name <span
                                    class="text-red-500">*</span></label>
                            <input oninput="validateNameInput(this)" required type="text" name="lastname"
                                value="{{ old('lastname') ?? '' }}" id="lastname" autocomplete="family-name"
                                class="mt-1.5 block w-full rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-gray-500 focus:outline-none focus:ring-gray-200 sm:text-sm">
                            @error('lastname')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-span-6 sm:col-span-3">
                            <label for="email" class="block text-sm font-medium text-gray-700">Email address <span
                                    class="text-red-500">*</span></label>
                            <input required onkeyup="emailCheck(this.value)" type="email" name="email"
                                value="{{ old('email') ?? '' }}" id="email" autocomplete="email"
                                class="mt-1.5 block w-full rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-gray-500 focus:outline-none focus:ring-gray-200 sm:text-sm">
                            @error('email')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                            <p id="email-error" class="text-red-500 text-xs mt-2"></p>
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <label for="mobile" class="block mb-1.5 text-sm font-medium text-gray-700">Mobile <span
                                    class="text-red-500">*</span></label>
                            <input onkeyup="mobileCheck(this.value)"
                                value="{{ old('mobile') ?? request()->header('cap_mobile') }}" type="text" name="mobile"
                                id="phone" autocomplete="mobile" minlength="6"
                                class=" mt-1.5 block w-full rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-gray-500 focus:outline-none focus:ring-gray-200 sm:text-sm">
                            @error('mobile')
                            <p id="mobile-error" class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                            <p id="mobile-error" class="text-red-500 text-xs mt-2"></p>
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <label for="password" class="block text-sm font-medium text-gray-700">Password <span
                                    class="text-red-500">*</span></label>
                            <div class="relative">
                                <input onkeyup="isPasswordValid(this.value)" type="password" required name="password"
                                    value="{{ old('password') }}" id="password" autocomplete="password"
                                    class="mt-1.5 block w-full rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-gray-500 focus:outline-none focus:ring-gray-200 sm:text-sm">
                                <span class="absolute top-2 right-4">
                                    <i class="fa-solid fa-eye app-text-color" onclick="showPassword(1)"></i>
                                </span>
                            </div>
                            @error('password')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                            <p id="password-error" class="text-red-500 text-xs mt-2"></p>
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm
                                Password <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <input onkeyup="isConfirmPasswordValid(this.value)" type="password" required
                                    name="password_confirmation" value="{{ old('password_confirmation') ?? '' }}"
                                    id="password_confirmation" autocomplete="password_confirmation"
                                    class="mt-1.5 block w-full rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-gray-500 focus:outline-none focus:ring-gray-200 sm:text-sm">
                                <span class="absolute top-2 right-4">
                                    <i class="fa-solid fa-eye app-text-color" onclick="showPassword(2)"></i>
                                </span>
                            </div>
                            @error('password_confirmation')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                            <p id="cpassword-error" class="text-red-500 text-xs mt-2"></p>
                        </div>
                        {{-- <div class="col-span-6 sm:col-span-2">
                            <label for="dob" class="block text-sm font-medium text-gray-700">Date of birth</label>
                            <input max="{{ date('Y-m-d') }}" onchange="_calculateAge(this.value)" type="date"
                                value="{{ old('dob') }}" name="dob" id="dob" autocomplete="city"
                                class="cursor-pointer mt-1.5 block w-full rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-gray-500 focus:outline-none focus:ring-gray-200 sm:text-sm">
                            @error('dob')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-span-6 sm:col-span-2">
                            <label for="age" class="block text-sm font-medium text-gray-700">Age</label>
                            <input type="text" value="{{ old('age') ?? '' }}" name="age" id="age"
                                autocomplete="address-level2"
                                class="mt-1.5 block w-full rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-gray-500 focus:outline-none focus:ring-gray-200 sm:text-sm"
                                readonly>
                            @error('age')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                            <label for="area" class="block text-sm font-medium text-gray-700">Street Address</label>
                            <input type="text" value="{{ old('area') ?? '' }}" name="area" id="area"
                                autocomplete="address-level2"
                                class="mt-1.5 block w-full rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-gray-500 focus:outline-none focus:ring-gray-200 sm:text-sm">
                            @error('area')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                            <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                            <input oninput="validateNameInput(this)" type="text" value="{{ old('city') ?? '' }}"
                                name="city" id="city" autocomplete="address-level2"
                                class="mt-1.5 block w-full rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-gray-500 focus:outline-none focus:ring-gray-200 sm:text-sm">
                            @error('city')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                            <label for="State" class="block text-sm font-medium text-gray-700">State</label>
                            <input oninput="validateNameInput(this)" type="text" value="{{ old('state') ?? '' }}"
                                name="state" id="State" autocomplete="address-level1"
                                class="mt-1.5 block w-full rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-gray-500 focus:outline-none focus:ring-gray-200 sm:text-sm">
                            @error('state')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                            <label for="zip" class="block text-sm font-medium text-gray-700">ZIP / Postal
                                code</label>
                            <input type="text" value="{{ old('zip') ?? '' }}" name="zip" id="zip" autocomplete="zip"
                                class="mt-1.5 block w-full rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-gray-500 focus:outline-none focus:ring-gray-200 sm:text-sm"
                                onkeypress="return event.charCode >= 48 && event.charCode <= 57" maxlength="10">
                            @error('zip')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                            <label for="country_of_residence"
                                class="block text-sm font-medium text-gray-700">Country</label>
                            <input oninput="validateNameInput(this)" type="text"
                                value="{{ old('country_of_residence') ?? '' }}" name="country_of_residence"
                                id="country_of_residence" autocomplete="address-level1"
                                class="mt-1.5 block w-full rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-gray-500 focus:outline-none focus:ring-gray-200 sm:text-sm">
                            @error('country_of_residence')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div> --}}
                        {{--
                        <div class="col-span-6 sm:col-span-2">
                            <label for="gender" class="block text-sm font-medium text-gray-700">Gender</label>
                            <select name="gender"
                                class="mt-1.5 block w-full rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-gray-500 focus:outline-none focus:ring-gray-200 sm:text-sm">
                                <option value="Not Applicable" {{ old('gender')=='Not Applicable' ? 'selected' : '' }}
                                    selected>Not Applicable
                                </option>
                                <option value="Male" {{ old('gender')=='Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ old('gender')=='Female' ? 'selected' : '' }}>Female
                            </select>
                            @error('gender')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-span-6 sm:col-span-2">
                            <label for="wedding_date" class="block text-sm font-medium text-gray-700">Wedding
                                Date</label>
                            <input max="{{ date('Y-m-d') }}" value="{{ old('wedding_date') }}" type="date"
                                name="wedding_date" id="wedding_date" autocomplete="wedding_date"
                                class="cursor-pointer mt-1.5 block w-full rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-gray-500 focus:outline-none focus:ring-gray-200 sm:text-sm">
                            @error('wedding_date')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-span-6 sm:col-span-2">
                            <label for="marital_status" class="block text-sm font-medium text-gray-700">Marital
                                Status</label>
                            <select name="marital_status"
                                class="mt-1.5 block w-full rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-gray-500 focus:outline-none focus:ring-gray-200 sm:text-sm">
                                <option value="">Select</option>
                                <option {{ old('marital_status')=='Single' ? 'selected' : '' }} value="Single">
                                    Single</option>
                                <option {{ old('marital_status')=='Married' ? 'selected' : '' }} value="Married">
                                    Married</option>
                                <option {{ old('marital_status')=='Divorced' ? 'selected' : '' }} value="Divorced">
                                    Divorced</option>
                                <option {{ old('marital_status')=='Widowed' ? 'selected' : '' }} value="Widowed">
                                    Widowed</option>
                            </select>
                            @error('marital_status')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-span-6 sm:col-span-2 relative">
                            <label for="nationality" class="block text-sm font-medium text-gray-700">Nationality</label>
                            <input autocomplete="off" role="combobox" list="" id="countries" type="text"
                                value="{{ old('nationality') ?? '' }}" name="nationality"
                                class="mt-1.5 block w-full  rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-gray-500 focus:outline-none focus:ring-gray-200 sm:text-sm">


                            @include('countries-drop-down.countries')
                            @error('nationality')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div> --}}
                        {{-- currently we don't need --}}
                        {{-- <div class="col-span-6 sm:col-span-2">
                            <label for="religion" class="block text-sm font-medium text-gray-700">Religion</label>
                            <select name="religion"
                                class="mt-1.5 block w-full rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-gray-500 focus:outline-none focus:ring-gray-200 sm:text-sm">
                                <option value="">Select</option>
                                <option {{ old('religion')=='Hinduism' ? 'selected' : '' }} value="Hinduism">
                                    Hinduism</option>
                                <option {{ old('religion')=='Christianity' ? 'selected' : '' }} value="Christianity">
                                    Christianity</option>
                                <option {{ old('religion')=='Islam' ? 'selected' : '' }} value="Islam">
                                    Islam</option>
                                <option {{ old('religion')=='Judaism' ? 'selected' : '' }} value="Judaism">
                                    Judaism</option>
                                <option {{ old('religion')=='Buddhism ' ? 'selected' : '' }} value="Buddhism">
                                    Buddhism</option>
                            </select>
                            @error('religion')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div> --}}
                    </div>
                </div>
                <div class="lg:w-3/5 w-full bg-gray-100 px-4 py-3 text-right sm:px-6">
                    <a href="{{ route('login_page') }}"
                        class="bg-gray-200 mr-4 text-black inline-flex justify-center rounded-md border border-transparent  py-2 px-10 text-sm font-medium  shadow-sm hover:bg-gray-300 cursor-pointer focus:outline-none focus:ring-2 focus:ring-gray-200 focus:ring-offset-2">Back</a>
                    <button id="submit"
                        class="app-bg-color  justify-center rounded-md border border-transparent  py-2 px-10 text-sm font-medium text-white shadow-sm  focus:outline-none focus:ring-2 focus:ring-gray-200 focus:ring-offset-2">CREATE</button>
                </div>
            </div>
        </form>
    </div>
</div>
@include('Auth.js.password-validations')
@include('Auth.js.show-hide-password')
@include('Auth.js.email-mobile-validation')
@include('countries-drop-down.countries-js')
@include('Auth.js.js')
@include('loader.loader')

<?php
$url = 'https://eu.api.capillarytech.com/v3/oauth/token/generate';
$payload = json_encode([
  'key' => 'e6ZZNqcVrASowmSrwXOdFqTg7',
  'secret' => 'vuEk0UM4rRWNr3VfYxKBqfj0YihS8Tf95i0ycXZO'
]);

$options = [
  'http' => [
    'header' => "Content-Type: application/json\r\n",
    'method' => 'POST',
    'content' => $payload
  ]
];

$context = stream_context_create($options);
$response = file_get_contents($url, false, $context);

if ($response === false) {
  http_response_code(500);
} else {
  header('Content-Type: application/json');
 $accessToken = $response;
}
?>





{{-- user create ajax start --}}
<script>
    var errorContainer =  document.getElementById('js-error-container');
    var errorMessage =  document.getElementById('js-error-msg');
    var successContainer =  document.getElementById('js-success-container');
    var successMessage =  document.getElementById('js-success-msg');
    var submitBtn =  document.getElementById('submit');
    var loaderAnim = document.getElementById("loader");
    var sessionId = '';
    $(document).ready(function() {
            $('#registerForm').submit(function(e) {
                e.preventDefault();
                submitBtn.disabled  = true;
                // loaderAnim.style.display = 'block';
                const password = $('#password').val();
                const confirmPassword = $('#password_confirmation').val();
                const phone = $('#phone').val().replace('+','');
                const firstName = $('#firstname').val();
                const lastName = $('#lastname').val();

                var formData = {
                    identifierType : "MOBILE",
                    identifierValue : phone,
                    brand : "{{ config('app.brand') }}",
                    password : password,
                    confirmPassword : password,
                };
                
                $.ajax({
                    url: '{{ config('app.api_base_url') }}/auth/v1/web/token/generate',
                    method: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify(formData),
                    success: function(res) {
                        submitBtn.disabled  = false;
                        loaderAnim.style.display = 'none';
                        errorContainer.style.display = "none";
                        if (res && res.user && res.user.userRegisteredForPassword && res.user.userRegisteredForPassword  === true) {
                            errorContainer.style.display = "block";
                            errorMessage.innerHTML  = "User Already Exist!";
                        } else{
                            sessionId = res.user.sessionId;
                            return oAuthTokenGenerate();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseJSON.message);
                        // Handle login error
                    }
                });
            });

            function oAuthTokenGenerate() {
                $.ajax({
                    url: 'https://eu.api.capillarytech.com/v3/oauth/token/generate',
                    method: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({
                        key: 'e6ZZNqcVrASowmSrwXOdFqTg7',
                        secret: 'vuEk0UM4rRWNr3VfYxKBqfj0YihS8Tf95i0ycXZO'
                    }),
                    success: function(response) {
                        console.log(response);
                        // Handle the response
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                        // Handle the error
                    }
                });
            }
            function emailVerify(params) {
                
            }

            function MobileVerify(params) {
                
            }


            function changePassword(formData){
                $.ajax({
                    url: '{{ config('app.api_base_url') }}/auth/v1/web/password/change',
                    method: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify(formData),
                    success: function(res) {
                        console.log(res.status.success);
                        if (res.status.success) {
                            window.location.href = "{{ route('dashboard') }}?password_changed";
                            return;
                        } else{
                            submitBtn.disabled  = false;
                            loaderAnim.style.display = 'none';
                            errorContainer.style.display = "block";
                            errorMessage.innerHTML  = 'Something went wrong! Please contact our support';
                            if(res.status.message){
                                errorMessage.innerHTML  = res.status.message;
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseJSON.message);
                        loaderAnim.style.display = 'none';
                        submitBtn.disabled  = false;
                    }
                });
            }
  
            setTimeout(function() {
                errorContainer.style.display = "none";
                successContainer.style.display = "none";
            }, 10000);
          });
</script>
{{-- user create ajax end --}}

@endsection