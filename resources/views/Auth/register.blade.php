@extends('layouts.login')
@section('content')
@include('partials.session')
@include('countries-drop-down.countries-style')
@include('partials.js-error')
<div class="mt-0 lg:mt-2 p-2 pt-0  ">
    <div class="mt-5 md:col-span-2 md:mt-0">

        <form id="registerForm" enctype="multipart/form-data">
            @csrf
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
                    <div class="border border-slite-50 border-dashed w-full mb-5"></div>
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
                    </div>

                    <form id="validateOtpForm" class="flex justify-end">
                        <div id="otp-container" style="position: relative;display: none;" class="col-span-4 mt-2 sm:w-full lg:w-36">
                            <input oninput="this.value = this.value.replace(/[^\d]/g, '');" minlength="6" maxlength="6"
                                autocomplete="off" id="otp" type="text" name="otp"
                                class="sm:w-full lg:w-36 mt-5 block w-full rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-gray-500 focus:outline-none focus:ring-gray-200 sm:text-sm"
                                placeholder="OTP" />
                            <div onclick="otpResend()" title="resend otp" id="resend-otp-btn"
                                style="display:none;position: absolute;cursor: pointer;font-size: 20px;color: #a2afbe;top: 7px;right: 13px;">
                                <i class="fa-solid fa-rotate"></i>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="lg:w-3/5 flex justify-end w-full bg-gray-100 px-4 py-3 text-right sm:px-6">
                    <a href="{{ route('login_page') }}"
                        class="bg-gray-200 mr-4 text-black inline-flex justify-center rounded-md border border-transparent  py-2 px-10 text-sm font-medium  shadow-sm hover:bg-gray-300 cursor-pointer focus:outline-none focus:ring-2 focus:ring-gray-200 focus:ring-offset-2">Back</a>
                    <button id="submit"
                        class="app-bg-color  justify-center rounded-md border border-transparent  py-2 px-10 text-sm font-medium text-white shadow-sm  focus:outline-none focus:ring-2 focus:ring-gray-200 focus:ring-offset-2">CREATE</button>
                    <button style="display: none" id="verify-otp-btn"
                        class="app-bg-color inline-flex justify-center rounded-md border border-transparent  py-2 px-10 text-sm font-medium text-white shadow-sm hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-gray-200 focus:ring-offset-2">Verify
                        OTP</button>
                    <button type="button" onclick="validateEmail()"
                        style="display: none;background-color: rgb(170, 130, 100);" id="create-btn"
                        class="app-bg-color inline-flex justify-center rounded-md border border-transparent  py-2 px-10 text-sm font-medium text-white shadow-sm hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-gray-200 focus:ring-offset-2">CREATE
                    </button>
                </div>
        </form>
    </div>
</div>
</div>
@include('Auth.js.password-validations')
@include('Auth.js.show-hide-password')
@include('Auth.js.email-mobile-validation')
@include('countries-drop-down.countries-js')
@include('Auth.js.js')
@include('loader.loader')
@include('Auth.ajax-requests.signup-ajax')

@endsection