@extends('layouts.login')
@section('content')
@include('partials.session')
@include('partials.js-error')
<style>
    input {
        background: white;
    }
</style>
<section class=" h-screen w-full">
    <div class="" style="display:flex;justify-content:center;align-items:center;height: 100%;padding: 0 12px 0 12px;">
        <div style="max-width: 500px"
            class="md:w-8/12 lg:w-5/12 mb-6 md:mb-0 bg-gray-100 rounded lg:px-16 lg:py-8   p-10  w-full h-auto">
            <form id="loginForm">
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
                    <input minlength="8" maxlength="18" autocomplete="off" type="text" name="phone" id="phone"
                        class="form-control bg-white text-lg block w-full px-4 py-2  font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                        placeholder="" />
                </div>
                <div class="mb-2">
                    <input onkeydown="if (event.keyCode === 32) event.preventDefault();" value="{{ old('password') }}"
                        onchange="hidePassword()" autocomplete="off" id="password" type="password" name="password"
                        class="form-control bg-white text-lg block w-full px-4 py-2  font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                        placeholder="Password" required />
                    <div class="flex justify-between">
                        <div class="ml-2 mt-2">
                            <input type="checkbox" class="lg:mt-0" onclick="showPassword()"> <span
                                class="lg:text-sm sm:text-sm text-xs ">Show Password</span>
                        </div>
                        <div class="ml-2 mt-2">
                            <a href="{{ route('forget_password') }}"
                                class="lg:text-sm sm:text-sm text-xs app-text-color hover:underline">Forget
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

        function showSuccessMessage(message) {
            const errorContainer =  document.getElementById('js-error-container');
            const successContainer =  document.getElementById('js-success-container');
            const successMessage =  document.getElementById('js-success-msg');
            successContainer.style.display = 'block';
            errorContainer.style.display = "none";
            successMessage.innerHTML  = message;
        }
        function showErrorMessage(message) {
            const successContainer =  document.getElementById('js-success-container');
            const errorContainer =  document.getElementById('js-error-container');
            const errorMessage =  document.getElementById('js-error-msg');
            successContainer.style.display = 'none';
            errorContainer.style.display = "block";
            errorMessage.innerHTML  = message;
        }
        const params = new URLSearchParams(window.location.search);
        if (params.has('password_changed')) {
            showSuccessMessage('Password reset successfully!');
        }
        if (params.has('user_already_exists')) {
            showErrorMessage('User Already Exists!');
        }
        if (window.location.search.includes('?password_changed')) {
        var urlWithoutLoginParam = window.location.href.replace('?password_changed=1', '');
        history.replaceState(null, '', urlWithoutLoginParam);
        }
        if (window.location.search.includes('?user_already_exists')) {
        var urlWithoutLoginParam = window.location.href.replace('?user_already_exists', '');
        history.replaceState(null, '', urlWithoutLoginParam);
        }
</script>

@include('Auth.js.js')
@include('loader.loader')
@include('Auth.ajax-requests.login-ajax')
@endsection