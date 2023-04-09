@extends('layouts.login')
@section('content')
@include('partials.session')
<div class="container  px-6 pb-12 pt-6  h-full">
  <div class="grid grid-cols-1 place-items-center h-full g-6 text-gray-800 mt-20">
    <form action="{{ route('forget_password_verify_otp') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="overflow-hidden shadow rounded ">
        <div class="bg-white px-4 py-5 rounded sm:p-6">
          <div class="text-xl mb-2 ">
            <span class="font-semibold	">Verify Mobile Number</span>
          </div>
          <div class="border border-slite-50 border-dashed	  w-full mb-8"></div>
          <div class="grid grid-cols-12 ">
            <div class="lg:col-span-6 col-span-12">
              <img class="w-80 h-40" src="{{ asset('images/verify-password.svg') }}" alt="">
            </div>
            <div class="lg:col-span-6 col-span-12">
              <div class="col-span-12 mt-4">
                <label for="otp" class="block text-sm font-medium text-gray-700">Please Enter OTP to Continue</label>
                <input  value="{{ old('otp') }}" minlength="6" maxlength="6" autocomplete="off" id="otp" type="text" name="otp"
                class="mt-5 block w-full rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-gray-500 focus:outline-none focus:ring-gray-200 sm:text-sm"
                placeholder="OTP" />
                @error('otp')
                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
              </div>
            </div>
          </div>
        </div>
        <div class="bg-gray-100 px-4 py-3 text-right sm:px-6">
          <a href="{{ route('login_page') }}"
            class="bg-gray-200 mr-4 text-black inline-flex justify-center rounded-md border border-transparent  py-2 px-10 text-sm font-medium  shadow-sm hover:bg-gray-300 cursor-pointer focus:outline-none focus:ring-2 focus:ring-gray-200 focus:ring-offset-2">Back</a>
          <button id="submit"
            class="app-bg-color inline-flex justify-center rounded-md border border-transparent  py-2 px-10 text-sm font-medium text-white shadow-sm hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-gray-200 focus:ring-offset-2">Verify</button>
        </div>
      </div>
    </form>
  </div>
</div>
@include('loader.loader')
</section>
@endsection