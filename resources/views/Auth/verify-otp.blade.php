@extends('layouts.login')
@section('content')
  @include('partials.session')
<section class="h-screen">
    <div class="container px-6 py-12 h-full">
        <div class="grid grid-cols-1 place-items-center h-full g-6 text-gray-800">
            <div style="max-width: 500px" class="md:w-8/12 lg:w-5/12 mb-12 md:mb-0 bg-gray-100 rounded lg:p-20   p-10  w-full h-auto">
                <form action="{{ route('verify-otp') }}" method="POST">
                    @csrf
                    <!-- Email input -->
                    <div class="mb-6 flex justify-end	">
                        <img class="w-52 " src="{{ asset('images/microsite_logo.png') }}" alt="" srcset="">
                    </div>
                    <div class="mb-6 flex flex-col">
                        <span class="text-2xl font-bold">VERIFY OTP</span>
                        <span class="text-2xl font-bold app-text-color" >Hi, Welcome
                            Back!</span>
                        <span class="text-lg font-light	">Please Enter OTP to Continue</span>
                    </div>

                    <!-- Password input -->
                    <div class="mb-6">
                        <input maxlength="6" name="otp_number" autocomplete="off" oninput="this.value = this.value.replace(/[^\d]/g, '');" type="text"
                            class="form-control text-lg block w-full px-4 py-2  font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                            placeholder="Enter Your OTP Here" />
                    </div>
                    <!-- Submit button -->
                    <button id="submit" type="submit"
                        class="inline-block px-7 py-5  text-white font-medium text-sm leading-snug uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out w-full"
                        data-mdb-ripple="true" data-mdb-ripple-color="light"
                        style="background-color: #ab8464;">
                       VERIFY OTP 
                    </button>

                </form>
            </div>
            <div class="md:w-8/12 lg:w-5/12 lg:ml-20">

            </div>
        </div>
    </div>
</section>
@include('loader.loader')
@endsection