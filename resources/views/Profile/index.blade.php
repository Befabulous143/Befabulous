@extends('layouts.app')
@section('content')
<style>
    .none {
        display: none;
    }
</style>
{{-- {{ dd($data) }} --}}
<div class=" grid grid-cols-1  place-items-start lg:p-4 px-4 pb-2 py-16  w-auto h-64 g-6 text-gray-800">
    <div class="grid  shadow-xl app-bg-color rounded grid-cols-1 w-full  p-4 lg:pr-10 lg:pl-10">
        <div class="grid grid-cols-1 place-items-center h-36" style="">
            @php
            if (auth()->user() != null) {
            $profile = asset(auth()->user()->profile);
            }
            @endphp
            <img class="w-56 h-56 rounded-full bg-gray-200	border-4 border-amber-600 p-2"
                src="{{ $profile ?? asset('images/user-pic.png')}}" alt="">
        </div>
    </div>
</div>
<div class="grid grid-cols-1 place-items-start  px-4 pt-10 pb-4 lg:pt-4   w-auto h-auto g-6 text-gray-800">
    <div class="grid  grid-cols-1 w-full">
        <div class="grid grid-cols-1">
            <div class="grid lg:mt-0 sm:mt-2 mt-5  grid-cols-1 gap-4 place-items-center  pt-0 pb-0">
                <h2 class="lg:text-lg text-lg text-gray-700 font-semibold	">{{ $data['firstname'] ?? '' }} {{
                    $data['lastname'] ?? '-----' }}</h2>
            </div>
            <div class="grid  grid-cols-1 gap-4 place-items-center  pt-0 pb-2">
                <h2 class="lg:text-lg text-lg text-gray-700 font-semibold	">({{ $data['email'] ?? '' }})
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
            <div class="grid grid-cols-1 text-left w-72 lg:w-auto">
                Edit Profile
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
            <div class="grid grid-cols-1 text-left w-72 lg:w-auto">
                Change Password
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
            <div class="grid grid-cols-1 text-left w-72 lg:w-auto">
                General Terms & Conditions
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
        <div  class="grid grid-cols-1 text-left">
            <a>
                Close Your Account
            </a>
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
        <div  class="grid grid-cols-1 text-left">
            <a>
                Logout
            </a>
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
        Swal.fire('Your account closed successfully!', '', 'success')
        document.getElementById('closeAccount').click();
    } 
    })
    });
});
</script>
@endsection