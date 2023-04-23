@extends('layouts.app')
@section('content')
        <div class=" grid grid-cols-1  place-items-center px-4 w-auto h-auto g-6 text-gray-800">
                <img class="lg:w-auto w-56" src="{{ asset('images/banner_image.svg') }}" alt="">
        </div>
        <div class="grid grid-cols-1 place-items-start lg:px-4 lg:pb-6 lg:pt-0 px-4 py-4  w-auto h-auto g-6 text-gray-800">
            <div class="grid  grid-cols-1 w-full">
                <div class="grid grid-cols-2">
                    <div class="flex gap-2">
                       <span class="app-text-color font-semibold text-3xl mt-2">Tier : </span>
                       @if(isset($data['current_slab']) && (Str::upper($data['current_slab']) == 'NONE' || Str::upper($data['current_slab']) == 'SILVER'))
                        <img class="w-14 h-14" src="{{ asset('images/Silver_Tier.png') }}" alt="">
                       @endif
                    </div>
                    <div class="grid  grid-cols-1 gap-4 place-items-end  pt-0 pb-2 mt-2">
                        <a href="{{ route('point_history') }}" class="overflow-hidden relative flex gap-1 px-10 py-3 shadow-md shadow-gray-400 rounded-xl text-white app-bg-color" data-mdb-ripple="true"
                            data-mdb-ripple-color="light">
                            <div class="grid grid-cols-1 place-items-center">
                                <img class="w-6 h-6" src="{{ asset('images/Icon_1.png') }}" alt="">
                            </div>
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
                <div class="grid grid-rows-2 gap-0 text-center lg:text-left">
                    Total Points
                    <span class="text-2xl  font-extrabold">{{ $data['lifetime_purchases']??0 }}</span>
                </div>
                <div class="grid grid-rows-2 gap-0 text-center">
                    <span class="text-center lg:text-left">Total Loyalty Points</span>
                    <span class="text-2xl text-center lg:text-left  font-extrabold">{{ $data['group_points_summaries']['group_points_summary'][0]['loyalty_points']??0 }}</span>
                </div>
                <div class="grid grid-rows-2 gap-0 text-center">
                    <span class="text-center lg:text-left">Life Time Points</span>
                    <span class="text-2xl text-center lg:text-left  font-extrabold">{{ $data['group_points_summaries']['group_points_summary'][0]['lifetime_points']??0 }}</span>
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
                <div class="grid grid-cols-4 shadow-md shadow-gray-400 px-2 py-8 lg:px-2 text-white app-bg-color grid-cols-1 w-full h-auto rounded ">
                    <div class="flex flex-col items-center gap-1  text-center">
                        <img class="w-12 h-12" src="{{ asset('images/Icon_2.png') }}" alt="">
                        <span class="text-sm  font-semibold">{{ $points['adjusted']??0 }} Pts</span>
                        <span>Adjusted</span>
                    </div>
                    <div class="flex flex-col gap-1 items-center text-center">
                        <img class="w-12 h-12" src="{{ asset('images/Icon_3.png') }}" alt="">
                        <span class="text-sm  font-semibold">{{ $points['redeemed']??0 }} Pts</span>
                        <span>Redeemed</span>
                    </div>
                    <div class="flex flex-col gap-1 items-center text-center">
                        <img class="w-12 h-12" src="{{ asset('images/Icon_4.png') }}" alt="">
                        <span class="text-sm  font-semibold">{{ $points['returned']??0 }} Pts</span>
                        <span>Returned</span>
                    </div>
                    <div class="flex flex-col gap-1 items-center text-center">
                        <img class="w-12 h-12" src="{{ asset('images/Icon_5.png') }}" alt="">
                        <span class="text-sm  font-semibold">{{ $points['expired']??0 }} Pts</span>
                        <span>Expired</span>
                    </div>
                </div>
            </div>
        <div class="mt-6 border  border-gray-200 w-full"></div>
        @include('offers.index',['coupons' => $coupons])
@endsection