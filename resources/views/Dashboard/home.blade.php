@extends('layouts.app')
@section('content')
        <div class=" grid grid-cols-1  place-items-center px-4 w-auto h-auto g-6 text-gray-800">
                <img class="lg:w-auto w-56" src="{{ asset('images/banner_image.svg') }}" alt="">
        </div>
        <div class="grid grid-cols-1 place-items-start lg:px-4 lg:pb-6 lg:pt-0 px-4 py-4  w-auto h-auto g-6 text-gray-800">
            <div class="grid  grid-cols-1 w-full">
                <div class="grid  grid-cols-2 gap-4 ">
                    <div  class="flex gap-2">
                        <a target="_blank" href="https://qa.bfab.com/">
                            <img class="w-44 mt-4 lg:block sm:block hidden" src="{{ asset('images/Bfab Link For Desktop website.png') }}" alt="" srcset="">
                        </a>
                    </div>
                    <div class=" grid  grid-cols-1 gap-4 place-items-end pt-0 pb-2 mt-2">
                        <a href="{{ route('point_history') }}" class="overflow-hidden text-center relative flex gap-1 lg:px-10 px-6 py-3 shadow-md shadow-gray-400 rounded-xl text-white app-bg-color" data-mdb-ripple="true"
                            data-mdb-ripple-color="light">
                                <img class="w-6 h-6" src="{{ asset('images/Icon_1.png') }}" alt="">
                            Transactions
                            <div style="position: absolute;left:0;top:14px;width:4px;height:20px;background:white;border-radius:4px"></div>
                            <div style="position: absolute;right:0;top:14px;width:4px;height:20px;background:white;border-radius:4px"></div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class=" grid grid-cols-1 place-items-start lg:pt-0  px-4 pb-2  w-auto h-auto g-6 text-gray-800">
            <div class="grid grid-cols-3 shadow-md shadow-gray-400 lg:pr-10 lg:pl-20 px-4 lg:py-6 py-4 text-white app-bg-color grid-cols-1 w-full rounded ">
                <div class="grid grid-rows-2 gap-0 text-center">
                    <span class="text-center lg:text-left">Lifetime Points</span>
                    <span class="lg:text-2xl text-xl lg:mt-0 mt-3 text-center lg:text-left  font-extrabold">{{ $data['group_points_summaries']['group_points_summary'][0]['lifetime_points']??0 }}</span>
                </div>
                <div class="grid grid-rows-2 gap-0 text-center">
                    <span class="text-center lg:text-left">Current Loyalty Points</span>
                    <span class="lg:text-2xl text-xl lg:mt-0 mt-3 text-center lg:text-left  font-extrabold">{{ $data['group_points_summaries']['group_points_summary'][0]['loyalty_points']??0 }}</span>
                </div>
                <div class="grid grid-rows-2 gap-0 text-center lg:text-left">
                    Currency Conversion Point
                    <span  class="lg:text-2xl text-xl lg:mt-0 mt-3  font-extrabold">{{ $currency_value??0 }} <span class="text-xs">{{ $currency_symbol }}</span></span>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-1 place-items-start  px-4 pt-4 pb-4 lg:py-4   w-auto h-auto g-6 text-gray-800">
            <div class="grid  grid-cols-1 w-full">
                <div class="grid grid-cols-1">
                    <div class="grid  grid-cols-1 gap-4 place-items-start  pt-0 pb-2">
                            <h2 class="lg:text-lg text-lg text-gray-700 font-semibold">Points</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class=" grid grid-cols-1 place-items-start  px-4 pb-2  w-auto h-auto g-6 text-gray-800">
                <div class="grid grid-cols-4 shadow-md shadow-gray-400 px-2 lg:py-8 py-4 lg:px-2 text-white app-bg-color grid-cols-1 w-full h-auto rounded ">
                    <div class="flex flex-col items-center gap-1  text-center">
                        <img class="w-12 h-12" src="{{ asset('images/Icon_2.png') }}" alt="">
                        <span class="text-sm  font-semibold">{{ $points['adjusted']??0 }}</span>
                        <span>Points</span>
                        <span class="mt-2">Adjusted</span>
                    </div>
                    <div class="flex flex-col gap-1 items-center text-center">
                        <img class="w-12 h-12" src="{{ asset('images/Icon_3.png') }}" alt="">
                        <span class="text-sm  font-semibold">{{ $points['redeemed']??0 }}</span>
                        <span>Points</span>
                        <span class="mt-2">Redeemed</span>
                    </div>
                    <div class="flex flex-col gap-1 items-center text-center">
                        <img class="w-12 h-12" src="{{ asset('images/Icon_4.png') }}" alt="">
                        <span class="text-sm  font-semibold">{{ $points['returned']??0 }}</span>
                        <span>Points</span>
                        <span class="mt-2">Returned</span>
                    </div>
                    <div class="flex flex-col gap-1 items-center text-center">
                        <img class="w-12 h-12" src="{{ asset('images/Icon_5.png') }}" alt="">
                        <span class="text-sm  font-semibold">{{ $points['expired']??0 }}</span>
                        <span>Points</span>
                        <span class="mt-2">Expired</span>
                    </div>
                </div>
            </div>
        <div class="mt-6 border  border-gray-200 w-full"></div>
        @include('offers.index',['coupons' => $coupons])

        <script>
            function showSuccessMessage(message) {
            const errorContainer =  document.getElementById('js-error-container');
            const successContainer =  document.getElementById('js-success-container');
            const successMessage =  document.getElementById('js-success-msg');
            successContainer.style.display = 'block';
            errorContainer.style.display = "none";
            successMessage.innerHTML  = message;
            }
        const params = new URLSearchParams(window.location.search);
        if (params.has('logined')) {
            showSuccessMessage('Welcome ' + localStorage.getItem('firstname') +' '+localStorage.getItem('lastname'));
        }
        if (params.has('password_changed')) {
            showSuccessMessage("Password reset successfully!");
        }
        if (window.location.search.includes('?logined')) {
        var urlWithoutLoginParam = window.location.href.replace('?logined=true', '');
        history.replaceState(null, '', urlWithoutLoginParam);
        }
        if (window.location.search.includes('?password_changed')) {
        var urlWithoutLoginParam = window.location.href.replace('?password_changed', '');
        history.replaceState(null, '', urlWithoutLoginParam);
        }
        </script>
@endsection