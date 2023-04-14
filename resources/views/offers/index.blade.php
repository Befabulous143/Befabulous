{{-- {{ dd($coupons) }} --}}
<div class="grid grid-cols-1 place-items-start  px-4 pt-0 pb-4 lg:py-0 lg:pt-0   w-auto h-auto g-6 text-gray-800">
    <div class="grid  grid-cols-1 w-full">
        <div class="grid grid-cols-1">
            <div class="grid  grid-cols-1 gap-4 place-items-start  pt-0 pb-2">
                <h2 class="lg:text-lg text-lg text-gray-700 font-semibold">Coupons</h2>
            </div>
        </div>
    </div>
</div>
<div class=" grid lg:grid-cols-2 sm:grid-cols-2 sm:gap-6 grid-cols-1 mt-2 px-4  w-full h-auto  ">
    @if(isset($coupons) && is_array($coupons) && $coupons != [])
    @foreach ($coupons as $coupon)
    <div class="flex app-bg-color mt-4   w-full h-40 rounded-md py-2 shadow-md shadow-gray-400">
        <div class="flex items-center justify-center w-48  pl-3  ">
            @php
                    $coupon_img = '';
                if(isset($coupon['standard_image_1']) && !empty($coupon['standard_image_1'])){
                    $coupon_img = $coupon['standard_image_1'];
                } else if(isset($coupon['standard_image_2']) && !empty($coupon['standard_image_2'])){
                    $coupon_img = $coupon['standard_image_2'];
                } else if(isset($coupon['standard_image_3']) && !empty($coupon['standard_image_3'])){
                    $coupon_img = $coupon['standard_image_3'];
                } else{
                    $coupon_img = asset('images/undraw_gifts_0ceh.svg');
                }
            @endphp
            <img src="{{ $coupon_img }}"
                class="w-32 h-32 rounded" alt="Coupen_img" srcset="">
        </div>
        <div class="text-white w-52   px-3">
            <div class="flex flex-col justify-left">
                <h1 title="{{ $coupon['series_name'] ?? '' }}"
                    style="display: -webkit-box;max-width: 250px;height:30px;-webkit-line-clamp: 1;-webkit-box-orient: vertical;overflow: hidden;text-overflow: ellipsis;"
                    class="text-lg font-bold w-full">
                    {{ $coupon['series_name'] ?? '' }}
                </h1>
                <h2 class="text-md font-thin   ml-0.5" title="{{ $coupon['standard_description'] ??'' }}"
                    style="display: -webkit-box;max-width: 250px;height:50px;-webkit-line-clamp: 2;-webkit-box-orient: vertical;overflow: hidden;text-overflow: ellipsis;">
                    {{ $coupon['standard_description'] ?? ''}}
                </h2>
                @php
                // $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
                $generator = new \Picqer\Barcode\BarcodeGeneratorJPG();
                $barcode = $generator->getBarcode($coupon['code'], $generator::TYPE_CODE_128, 3, 50);
                $base64 = base64_encode($barcode);
                @endphp
                <div class="bg-white  pt-1 px-3 lg:px-2  lg:w-44 md:px-1   text-center">
                    <div class="grid grid-cols-1 text-left">
                        <img src="data:image/png;base64,{{ $base64 }}" alt="Barcode">
                        <h1 style="font-size: 9px" class="text-gray-800  font-bold">{{ $coupon['code'] ?? '' }} </h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    @else
    No Coupon Found For This Account
    @endif
</div>