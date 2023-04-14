@extends('layouts.login')
@section('content')
@include('partials.session')
<style>
    input {
        background: white;
    }
</style>
<section class="h-screen ">
    <div class="container  px-6 pb-12 pt-6  h-full">
        <div class="grid grid-cols-1 place-items-center h-full g-6 text-gray-800">
            <div class="md:w-8/12 lg:w-5/12 mb-6 md:mb-0 bg-gray-100 rounded lg:px-16 lg:py-8   p-10  w-full h-auto">
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <!-- Email input -->
                    <div class="mb-6 flex justify-end	">
                        <img class="w-52 " src="{{ asset('images/microsite_logo.png') }}" alt="" srcset="">
                    </div>
                    <div class="mb-2 flex flex-col">
                        <span class="text-2xl font-bold">JOIN AND BE FABULOUS</span>
                        <span class="app-text-color text-2xl font-bold ">Hi, Welcome!</span>
                        <span class="text-lg font-light	">Please Login to Continue</span>
                    </div>

                    <div class="mb-6">
                        <input  minlength="8" maxlength="18" autocomplete="off" 
                            type="text" name="phone" id="phone"
                            class="form-control bg-white text-lg block w-full px-4 py-2  font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                            placeholder="" />
                    </div>
                    <div class="mb-2">
                        <input value="{{ old('password') }}" onchange="hidePassword()" autocomplete="off" id="password"
                            type="password" name="password"
                            class="form-control bg-white text-lg block w-full px-4 py-2  font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                            placeholder="Password" />
                        <div class="flex justify-between">
                            <div class="ml-2 mt-2">
                                <input type="checkbox" onclick="showPassword()"> Show Password
                            </div>
                            <div class="ml-2 mt-2">
                                <a href="{{ route('forget_password') }}" class="app-text-color hover:underline">Forget
                                    Password?</a>
                            </div>
                        </div>
                    </div>
                    <!-- Submit button -->
                    <button id="submit" type="submit" style=" background-color: #ab8464;"
                        class="inline-block px-7 py-5  text-white font-medium text-sm leading-snug uppercase rounded shadow-md    transition duration-150 ease-in-out w-full ">
                        Login
                    </button>

                </form>

                <div class="mt-4">
                    Don't have an account? <a class="app-text-color font-semibold" href="{{ route('register') }}">Sign
                        up</a>
                </div>
            </div>
            <div class="md:w-8/12 lg:w-5/12 lg:ml-20">

            </div>
        </div>
    </div>
</section>
<script>
        function showPassword() {
        var x = document.getElementById("password");
        if (x.type === "password") {
        x.type = "text";
        } else {
        x.type = "password";
        }
        }
        function hidePassword(){
            var x = document.getElementById("password");
            x.type="password";
        }
</script>

@include('Auth.js.js')
@include('loader.loader')

@endsection