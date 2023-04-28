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
    <div onclick="openCouponModal({{ json_encode($coupon) }})"
        class="cursor-pointer flex app-bg-color mt-4   w-full h-40 rounded-md py-2 shadow-md shadow-gray-400">
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
            <img src="{{ $coupon_img }}" class="w-32 h-32 rounded" alt="Coupen_img" srcset="">
        </div>
        <div class="text-white w-52 mt-4  px-3">
            <div class="flex flex-col justify-left">
                <h1 title="{{ $coupon['series_name'] ?? '' }}" style="" class="text-lg font-bold w-full">
                    {{ $coupon['series_name'] ?? '' }}
                </h1>
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

<style>
    /* The Modal (background) */
    .coupon-modal {
        display: none;
        /* Hidden by default */
        position: fixed;
        /* Stay in place */
        z-index: 1;
        /* Sit on top */
        padding-top: 20px;
        /* Location of the box */
        left: 0;
        top: 0;
        width: 100%;
        /* Full width */
        height: 100%;
        /* Full height */
        overflow: auto;
        /* Enable scroll if needed */
        background-color: rgb(0, 0, 0);
        /* Fallback color */
        background-color: rgba(0, 0, 0, 0.4);
        /* Black w/ opacity */
    }

    /* Modal Content */
    .coupon-modal-content {
        background-color: #fff6e7;
        border-radius: 14px;
        margin: auto;
        border: 1px solid #888;
        position: relative;
        max-height: 580px;
        min-height: 480px;
        overflow-y: auto;
    }

    /* The Close Button */
    .close {
        color: rgb(170, 130, 100);
        float: right;
        font-weight: bold;
        cursor: pointer;
        position: absolute;
        right: 10px;
        top: 10px;
        font-size: 20px;
        z-index: 11;
    }

    .coupon-image-modal {
        padding: 0;
    }

    @media only screen and (max-width: 600px) {
        .coupon-modal-content {
            max-height: 640px;
            min-height: 570px;
            width: 90%;
        }

        .close {
            position: fixed;
            right: 0;
            top: 0;
            padding: 26px 26px 0 0;
        }

        .coupon-image-modal {
            padding: 0 50px 0 50px;
        }
    }

    * {
        box-sizing: border-box
    }

    body {
        font-family: Verdana, sans-serif;
        margin: 0
    }

    .mySlides {
        display: none
    }

    img {
        vertical-align: middle;
    }

    /* Slideshow container */
    .slideshow-container {
        max-width: 1000px;
        position: relative;
        margin: auto;
        border-radius: 14px 14px 0 0;
        background-color: white !important;
        height: 16rem;
    }





    /* Caption text */
    .text {
        color: #f2f2f2;
        font-size: 15px;
        padding: 8px 12px;
        position: absolute;
        bottom: 8px;
        width: 100%;
        text-align: center;
    }



    /* The dots/bullets/indicators */
    .dot {
        cursor: pointer;
        height: 15px;
        width: 15px;
        margin: 0 2px;
        background-color: #bbb;
        border-radius: 50%;
        display: inline-block;
        transition: background-color 0.6s ease;
    }

    .carousel-dots {
        position: absolute;
        bottom: 10px;
        left: 50%;
    }

    .active,
    .dot:hover {
        background-color: #717171;
    }

    /* Fading animation */
    .fade {
        animation-name: fade;
        animation-duration: 1.5s;
    }

    @keyframes fade {
        from {
            opacity: .4
        }

        to {
            opacity: 1
        }
    }

    .description-container {
        background: #fff6e7;
    }
    .terms-condtions br:after {
    content: "\2022"; /* Unicode character for bullet point */
    margin-left: 5px; /* Add some space between the bullet and text */
    }
</style>

<div id="couponModal" class="coupon-modal">
    <!-- Modal content -->
    <div class=" coupon-modal-content w-1/2">
        <div class="close">
            <i onclick="closeModal()" class="fa-solid fa-circle-xmark"></i>
        </div>
        <div id="coupon-carousel">

        </div>
    </div>

</div>

<script>
    function openCouponModal(data) {
    var modal = document.getElementById("couponModal");
    $.ajax({
        url: '{{ route('get-coupon-data') }}',
        type: 'GET',
        data: {
            data: data
        },
        success: function(response) {
            $('#coupon-carousel').html(response);
             var couponDetailsContainer = document.getElementById("coupon-details-container");
            var couponConditionDetails = document.getElementById("coupon-condition-details");
            couponDetailsContainer.style.display  = 'block';
            couponConditionDetails.style.display  = 'none';  
        },
        error: function(xhr, status, error) {
            console.log(error);
        }
    });

    modal.style.display = "block";
    window.onclick = function(event) {
      if (event.target == modal) {
        modal.style.display = "none";
      }
    }
    }

    function closeModal(){
        const modal = document.getElementById("couponModal");
        modal.style.display = "none";
    }
</script>