@extends('layouts.app')
@section('content')
@include('loader.loader')
<style>
    .none {
        display: none;
    }
</style>

<div class=" grid grid-cols-1  place-items-start lg:p-4 px-4 pb-2 py-16  w-auto h-64 g-6 text-gray-800">
    <div class="grid  shadow-xl app-bg-color rounded grid-cols-1 w-full  p-4 lg:pr-10 lg:pl-10">
        <div class="grid grid-cols-1 place-items-center h-36" style="">
            @php
            if (auth()->user() != null) {
            $profile = asset(auth()->user()->profile);
            }
            @endphp
             @if(isset($profile)) 
                <img class="w-56 h-56 rounded-full bg-gray-200	border-4 border-amber-600 p-2"
                    src="{{ $profile}}" alt="">
             @else
                <div id="user-img" class="w-56 h-56 rounded-full bg-gray-200	border-4 border-amber-600 p-2">
                    <i style="opacity:0.7;font-size:130px;padding: 25px 0 0 43px;" class="fa-solid fa-user "></i>
                </div>
             @endif
        </div>
    </div>
</div>
<div class="grid grid-cols-1 place-items-start  px-4 pt-10 pb-4 lg:pt-4   w-auto h-auto g-6 text-gray-800">
    <div class="grid  grid-cols-1 w-full">
        <div class="grid grid-cols-1">
            <div class="grid lg:mt-0 sm:mt-2 mt-5  grid-cols-1 gap-4 place-items-center  pt-0 pb-0">
                <h2 class="lg:text-lg text-lg text-gray-700 font-semibold" id="user-name"></h2>
            </div>
            <div class="grid  grid-cols-1 gap-4 place-items-center  pt-0 pb-2">
                <h2 class="lg:text-lg text-lg text-gray-700 font-semibold	" id="email">
                    <a href="{{ route('edit') }}"><i class="fa-solid fa-pen-to-square"></i> </a>
                </h2>
            </div>
        </div>
    </div>
</div>
<a href="{{ route('edit') }}">
    <div class=" grid grid-cols-1 place-items-start  px-4 pt-4 pb-10  w-auto h-auto g-6 text-gray-800">
        <div
            class="card-bg-color grid grid-cols-2  px-4 py-2 cursor-pointer text-gray-900 font-semibold  grid-cols-1 w-full rounded lg:pr-10 lg:pl-10">
            <div class="flex gap-2 text-left w-72 lg:w-auto">
              <img src="{{ asset('images/edit-profile.png') }}" class="w-7 h-7" alt="">  
              <div class="flex items-center">
                Edit Profile
              </div>
            </div>
            <div class="grid grid-cols-1 text-right" id="arrow-down1">
                <i class="fa-solid fa-angle-right font-semibold text-2xl"></i>
            </div>
        </div>
    </div>
</a>
<a href="{{ route('change_password') }}">
    <div class=" grid grid-cols-1 place-items-start  px-4  pb-10  w-auto h-auto g-6 text-gray-800">
        <div
            class="card-bg-color grid grid-cols-2  px-4 py-2 cursor-pointer text-gray-900 font-semibold  grid-cols-1 w-full rounded lg:pr-10 lg:pl-10">
            <div class="flex gap-2 text-left w-72 lg:w-auto">
              <img src="{{ asset('images/change-password.png') }}" class="w-7 h-7" alt="">  
              <div class="flex items-center">
                Change Password
              </div>
            </div>
            <div class="grid grid-cols-1 text-right" id="arrow-down1">
                <i class="fa-solid fa-angle-right font-semibold text-2xl"></i>
            </div>
        </div>
    </div>
</a>
<a href="{{ route('terms') }}">
    <div class=" grid grid-cols-1 place-items-start  px-4  pb-10  w-auto h-auto g-6 text-gray-800">
        <div
            class="card-bg-color grid grid-cols-2  px-4 py-2 cursor-pointer text-gray-900 font-semibold  grid-cols-1 w-full rounded lg:pr-10 lg:pl-10">
            <div class="flex gap-2 text-left w-72 lg:w-auto">
                <img src="{{ asset('images/terms-condition.png') }}" class="w-7 h-7" alt="">  
                <div class="flex items-center">
                    General Terms & Conditions
                </div>
            </div>
            <div class="grid grid-cols-1 text-right" id="arrow-down1">
                <i class="fa-solid fa-angle-right font-semibold text-2xl"></i>
            </div>
        </div>
    </div>
</a>
<div class=" grid grid-cols-1 place-items-start  px-4 pb-10  w-auto h-auto g-6 text-gray-800">
    <div id="confirm-to-close"
        class="card-bg-color grid grid-cols-2  px-4 py-2 cursor-pointer text-gray-900 font-semibold  grid-cols-1 w-full rounded lg:pr-10 lg:pl-10">
        <div class="flex gap-2 text-left w-72 lg:w-auto">
            <img src="{{ asset('images/trash.png') }}" class="w-8 h-8" alt="">  
            <div class="flex items-center">
                Close Your Account
            </div>
        </div>
        <div class="grid grid-cols-1 text-right">
            <a>
                <i class="fa-solid fa-angle-right font-semibold text-2xl"></i>
            </a>
        </div>
    </div>
</div>
<div class=" grid grid-cols-1 place-items-start  px-4 pb-10  w-auto h-auto g-6 text-gray-800">
    <div id="confirm-logout"
        class="card-bg-color grid grid-cols-2  px-4 py-2 cursor-pointer text-gray-900 font-semibold  grid-cols-1 w-full rounded lg:pr-10 lg:pl-10">
        <div class="flex gap-2 text-left w-72 lg:w-auto">
            <img src="{{ asset('images/exit.png') }}" class="w-7 h-7" alt="">  
            <div class="flex items-center">
                Logout
            </div>
        </div>
        <div class="grid grid-cols-1 text-right">
            <a>
                <i class="fa-solid fa-angle-right font-semibold text-2xl"></i>
            </a>
        </div>
    </div>
</div>
<form action="{{ route('delete') }}" method="POST" class="hidden">
    @csrf
    <button type="submit" id="closeAccount"></button>
</form>
<a href="{{ route('logout') }}" id="logOut" class="hidden"></a>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    $('#user-img').css({"display":"none"})

    window.addEventListener('load', function() {
  // Get a reference to the button element
  var confirmLogoutButton = document.getElementById('confirm-logout');
  var confirmToCloseAccount = document.getElementById('confirm-to-close');

    // Add a click event listener to the button
    confirmLogoutButton.addEventListener('click', function() {
    Swal.fire({
    title: "Are you sure?",
    text: "you want to logout!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: 'Yes',
    confirmButtonColor: '#ab8464',
    customClass: {
        actions: 'my-actions',
        cancelButton: 'order-1 right-gap',
        confirmButton: 'order-2',
    }
    }).then((result) => {
    if (result.isConfirmed) {
        localStorage.clear();
        Swal.fire('Logout successfully!', '', 'success')
        document.getElementById('logOut').click();
    } 
    })
    });


    // Add a click event listener to the button
    confirmToCloseAccount.addEventListener('click', function() {
    Swal.fire({
    title: "Are you sure?",
    text: "You will not be able to recover your account!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: 'Yes',
    confirmButtonColor: '#ab8464',
    customClass: {
        actions: 'my-actions',
        cancelButton: 'order-1 right-gap',
        confirmButton: 'order-2',
    }
    }).then((result) => {

    if (result.isConfirmed) {
        $.ajax({
            url: '{{ config('app.api_base_url') }}/mobile/v2/api/PII/delete', // Replace with your server-side fetch endpoint
            type: 'GET',
            headers: {
                'cap_authorization' : localStorage.getItem('cap_authorization'),
                'cap_brand' : "{{ config('app.brand') }}",
                'cap_mobile' : localStorage.getItem('cap_mobile'),
            },
            data:{},
            success: function(res) {
                if(res.status.success){

                    Swal.fire('Your account closed successfully!', '', 'success')
                    window.location.href = "{{ route('login_page') }}?account_deleted";
                } else{
                    Swal.fire('Something wen wrong!', '', 'warning')
                }

            },
            error: function(xhr, status, error) {
            // Handle any errors that occur during the request
            console.log(error);
            loaderAnim.style.display = 'none';
            }

        });
      
        
    } 
    })
    });
});
</script>

<script>
var errorContainer =  document.getElementById('js-error-container');
var errorMessage =  document.getElementById('js-error-msg');
var successContainer =  document.getElementById('js-success-container');
var successMessage =  document.getElementById('js-success-msg');
var submitBtn =  document.getElementById('submit');
var loaderAnim = document.getElementById("loader");
$(document).ready(function() {

    function showFormDetails() {
        loaderAnim.style.display = 'block';
        $.ajax({
            url: '{{ config('app.api_base_url') }}/mobile/v2/api/customer/get', // Replace with your server-side fetch endpoint
            type: 'GET',
            headers: {
                'cap_authorization' : localStorage.getItem('cap_authorization'),
                'cap_brand' : "{{ config('app.brand') }}",
                'cap_mobile' : localStorage.getItem('cap_mobile'),
            },
            data:{
            'subscriptions':'true',
            'mlp' : 'false',
            'user_id' : 'true',
            'optin_status' : 'false',
            'slab_history' : 'false',
            'expired_points' : 'false',
            'points_summary' : 'false',
            'membership_retention_criteria' : 'true',
            },
            success: function(res) {
            // Assuming the response is a JSON object
            let username = res.customers.customer[0].firstname;
            if(res.customers.customer[0].lastname){
                username += ' '+ res.customers.customer[0].lastname;
            }
            $('#user-name').html(username);
            $('#email').html('('+res.customers.customer[0].email+') <a href="{{ route('edit') }}"><i class="fa-solid fa-pen-to-square"></i> </a>');
            loaderAnim.style.display = 'none';
            },
            error: function(xhr, status, error) {
            // Handle any errors that occur during the request
            console.log(error);
            loaderAnim.style.display = 'none';
            }

        });
    }

    // Call the function to populate the form on page load
    showFormDetails();
});
</script>
@endsection