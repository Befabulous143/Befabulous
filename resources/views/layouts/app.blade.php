<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}" sizes="32x32">
  <title>{{ config('app.name') }}</title>
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
    integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link
    href="https://fonts.googleapis.com/css2?family=Gruppo&family=Montserrat:wght@300&family=Poiret+One&family=Redressed&family=Roboto:ital,wght@1,300&display=swap"
    rel="stylesheet">
</head>

<body>
  @include('partials.session')
  <section class="h-full mb-20  grid grid-cols-1 place-items-center overflow-y-auto">
    <div class="container   lg:w-3/5 h-full lg:px-4 py-5 pb-10 lg:py-3 ">
      <div class="grid grid-cols-1 place-items-start  px-4  w-auto h-auto g-6 text-gray-800">
        <div class="grid  grid-cols-1 w-full  ">
          <div class="grid grid-cols-2">
            <div class="grid   grid-cols-1 gap-4 place-items-start  ">
              <div class="grid grid-cols-1  place-items-center pr-2 pt-3 pb-2 cursor-pointer">
                <a href="{{ route('dashboard') }}">
                  <img class="w-36" src="{{ asset('images/microsite_logo.png') }}" alt="menu" srcset="">
                </a>
              </div>
            </div>
            <div class="grid  grid-cols-1 gap-4 place-items-end  pt-1 pb-2 ">
              <a href={{ route('profile') }}>
                @php
                if (isset(auth()->user()->profile) && auth()->user()->profile!= null) {
                $profile = asset(auth()->user()->profile);
                }
                @endphp
                @if(isset($profile))   
                <img id="user-img" class="rounded-full bg-white p-1  border-4 border-yellow-600  w-16 h-16 z-2"
                  src="{{ $profile}}" alt="user" srcset="">
                @else
                <div id="user-img" class="rounded-full bg-white p-1  border-4 border-yellow-600  w-16 h-16 z-2">
                  <i style="opacity:0.7;font-size:30px;margin-top:8px;margin-left:12px" class="fa-solid fa-user "></i>
                </div>
                @endif
              </a>
            </div>
          </div>
        </div>
      </div>
      @yield('content')
    </div>
  </section>
  <div class="lg:hidden sm:hidden md:hidden hover:block w-full app-bg-color h-16 fixed bottom-0">
    <div class="grid grid-cols-4 w-full h-16 text-center justify-items-center	 text-white items-center">
      <a href="{{ route('dashboard') }}"><i style="font-size: 24px" class="fa-solid fa-house"></i></a>
      <a href="{{ route('point_history') }}" class="">
        <img  class="w-8 h-8" src="{{ asset('images/Icon_1.png') }}" alt="">
      </a>
      <a target="_blank" href="https://qa.bfab.com" class="">
        <img  class="w-8 h-8" src="{{ asset('images/Icon_bfab.com link for mobile.png') }}" alt="">
      </a>
      <a href="{{ route('profile') }}"><img class="w-8 h-8" src="{{ asset('images/Icon_6.png') }}" alt="user" ></a>
    </div>
  </div>
  <div>
    <span class="text-xs text-gray-600 ml-2 lg:block sm:block hidden">Copyright © 2023 <b class="app-text-color">Bfab</b> all rights reserved.</span>
  </div>
</body>

</html>