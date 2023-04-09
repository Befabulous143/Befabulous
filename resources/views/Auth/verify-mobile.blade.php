@extends('layouts.login')
@section('content')
@include('partials.session')
<section class="h-screen ">
    <div class="container  px-6 py-6  h-full">
        <div class="grid grid-cols-1 place-items-center h-full g-6 text-gray-800">
            <div class="md:w-8/12 lg:w-5/12 mb-12 md:mb-0 bg-gray-100 rounded lg:p-16   p-10  w-full h-auto">
                <form action="{{ route('send-otp') }}" method="POST">
                    @csrf
                    <!-- Email input -->
                    <div class="mb-6 flex justify-end	">
                        <img class="w-52 " src="{{ asset('images/microsite_logo.png') }}" alt="" srcset="">
                    </div>
                    <div class="mb-6 flex flex-col">
                        <span class="text-2xl font-bold">JOIN AND BE FABULOUS</span>
                        <span class="app-text-color text-2xl font-bold ">Hi, Welcome!</span>
                        <span class="text-lg font-light	">Please Verify Mobile Number to Continue</span>
                    </div>

                    <div class="mb-6">
                        <input value="{{'+'.$mobile ?? '' }}" minlength="8" maxlength="15" autocomplete="off" id="phone" type="text" name="mobile"
                            class="form-control text-lg block w-full px-4 py-2  font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                            placeholder="Mobile number with country code" />
                    </div>
                    <!-- Submit button -->
                    <button id="submit" type="submit" style=" background-color: #ab8464;"
                        class="inline-block px-7 py-5  text-white font-medium text-sm leading-snug uppercase rounded shadow-md    transition duration-150 ease-in-out w-full ">
                        JOIN US
                    </button>

                </form>

                <div class="mt-4">
                    Don't have an account? <a class="app-text-color font-semibold" href="">Sign up</a>
                </div>
            </div>
            <div class="md:w-8/12 lg:w-5/12 lg:ml-20">

            </div>
        </div>
    </div>
</section>
<script>
    // get the input element
        const input = document.getElementById('phone');
        // add an oninput event listener to the input element
        input.addEventListener('input', function() {
        // regular expression to match a mobile number with country code
        const mobileNumberRegex = /^\+\d{1,3}\d{6,14}$/;
        
        // get the value of the input element
        const inputValue = input.value;
        
        // check if the input value matches the mobile number regex
        if (!mobileNumberRegex.test(inputValue)) {
            // if the input value does not match the mobile number regex, remove any non-numeric characters
            input.value = inputValue.replace(/[^\d\+]/g, '');
        }
        });
</script>
@include('loader.loader')
@endsection