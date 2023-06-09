<div id="coupon-details-container">
    {{-- carousel section start --}}
    <div class="slideshow-container animate-pulse lg:h-64 h-32">
        <div class="mySlides fade">
            <div id="slider1" class="w-full lg:h-64 h-32" style="background: url('{{ $data['standard_image_2'] ?? '' }}');
                background-size: cover;
                background-repeat: no-repeat; 
                background-position: center center;">
            </div>
        </div>
        <div class="mySlides fade">
            <div class="w-full lg:h-64 h-32" style="background: url('{{ $data['standard_image_3'] ?? '' }}');
                background-size: cover;
                background-repeat: no-repeat; 
                background-position: center center;">

            </div>
        </div>

        {{-- <div class="mySlides fade">
            <div class="w-full lg:h-64 h-32" style="background: url('{{ $data['standard_image_3'] ?? '' }}') ;
                background-size: cover;
                background-repeat: no-repeat; 
                background-position: center center;">
            </div>
        </div> --}}
        <div style="text-align:center" class="carousel-dots">
            <span class="dot" onclick="currentSlide(1)"></span>
            <span class="dot" onclick="currentSlide(2)"></span>
            {{-- <span class="dot" onclick="currentSlide(3)"></span> --}}
        </div>
    </div>
    {{-- carousel section end --}}
    <div class="description-container">
        <div class="flex justify-between px-3 py-2">
            <div class="flex flex-col">
                <span class="text-gray-600 font-semibold lg:text-xl text-sm">{{ $data['series_name'] ?? '' }}</span>
                <span class="text-xs text-gray-700 mt-1">Valid from {{ $data['created_date'] ?? ''}}</span>
                <span class="text-xs text-gray-700">Valid till {{ $data['valid_till'] ?? ''}}</span>
            </div>
            <div>
            </div>
        </div>
        <div class="text-base/loose  leading-relaxed text-gray-700 px-3">
            <p>
                {!! $data['standard_description'] !!}
            </p>
            <a onclick="openOfferCondition()" class="app-text-color cursor-pointer">
                *Conditions apply
            </a>
        </div>
        <div class="py-3">
            <div class="flex justify-center">
                <span class="text-xs text-gray-800 font-semibold">Scan the barcode to redeem offer</span>
            </div>
            <div class="flex  justify-center mt-0.5 ">
                @php
                // $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
                $generator = new \Picqer\Barcode\BarcodeGeneratorJPG();
                $barcode = $generator->getBarcode($data['code'], $generator::TYPE_CODE_128, 3, 50);
                $base64 = base64_encode($barcode);
                @endphp
                <div class="coupon-image-modal">
                    <div class="grid grid-cols-1 text-left">
                        <img src="data:image/png;base64,{{ $base64 }}" alt="Barcode">
                        <h1 style="font-size: 9px" class="text-gray-800  font-bold">{{ $data['code'] ?? '' }} </h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="coupon-condition-details" style="padding:20px">
    <div class="text-xl app-text-color font-medium ">
        Offers Terms & conditions
        <div class="terms-condtions list-disc mt-3 text-sm text-gray-700 leading-7">
            {!! nl2br(e($data['standard_terms_and_conditions'])) ?? '' !!}
        </div>
    </div>
</div>
