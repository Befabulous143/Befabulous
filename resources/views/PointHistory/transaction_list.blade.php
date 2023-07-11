
<div class="grid grid-cols-1 place-items-start  px-3.5 pt-10 pb-4 lg:py-0 lg:pt-5   w-auto h-auto g-6 text-gray-800">
    <div class="grid  grid-cols-1 w-full">
      <div class="grid grid-cols-1">
        <div class="grid  grid-cols-1 gap-4 place-items-start  pt-0 pb-2">
          <h2 class="lg:text-xl text-lg text-gray-700 font-semibold	">Detailed View Date Wise {{ isset($data['firstname'])
            ? '('.$data['firstname'].')' : '' }}</h2>
        </div>
      </div>
    </div>
  </div>
  {{-- transaction view --}}
  <div class="grid lg:grid-cols-2 sm:grid-cols-2  sm:gap-6 grid-cols-1  px-4 pt-4 pb-10  w-full h-auto  ">
    @if (isset($data['transactions']['transaction']) && is_array($data['transactions']['transaction']) &&
    $data['transactions']['transaction']!=[])
    @foreach ($data['transactions']['transaction'] as $trans)
    <div class="relative flex p-2 shadow-sm w-full h-36 border border rounded-2xl border-gray-300   mt-4">
      <div 
        class="text-white app-bg-color  flex flex-col text-center shadow-md rounded-2xl border-0  lg:w-48 w-32">
        @php
        if ($trans['billing_time'] != '') {
        $date = \Carbon\Carbon::parse($trans['billing_time']);
        }
        @endphp
        <span class="text-3xl font-semibold mt-3">
          {{ $date->format('M') ?? '' }}
        </span>
        <span class="text-3xl font-semibold">
          {{ $date->format('d') ?? '' }}
        </span>
        <span class="text-1xl font-semibold">
          {{ $date->format('Y') ?? '' }}
        </span>
      </div>
      <div class="text-gray-800 lg:w-full w-52  py-2 px-3">
        <div class="flex flex-col justify-left">
          <h1 class="text-1xl uppercase font-semibold mt-1" title="{{ $trans['store'] ?? '' }}"
            style="display: -webkit-box;max-width: 250px;height:20px;-webkit-line-clamp: 1;-webkit-box-orient: vertical;overflow: hidden;text-overflow: ellipsis;">
            {{ $trans['store'] ?? '' }}
          </h1>
          <span class="mt-1.5 text-sm">{{ $trans['type'] }}</span>
          <h2 class="text-md  font-thin font-semibold mt-1  ml-0.5" title="{{ $trans['notes'] ?? '' }}"
            style="display: -webkit-box;max-width: 250px;height:70px;-webkit-line-clamp: 3;-webkit-box-orient: vertical;overflow: hidden;text-overflow: ellipsis;">
            {{ $trans['notes'] ?? '' }}
          </h2>
        </div>
      </div>
      <div class=" flex flex-col justify-center items-center px-3">
        <span class="text-md  font-normal font-semibold"> {{ $trans['amount'] ?? '' }}</span>
        @php
          $store_code = explode('.',$trans['store_code'])[1]??'';
          switch ($store_code) {
            case 'jordinar':
                  $currency = "JOD";
                  break;
              case 'uae':
                  $currency = "AED";               
                  break;
              case 'oman':
                  $currency = 'OMR';   
                  break;
              case 'bahrain':
                  $currency = 'BHD'; 
                  break;
              case 'qatar':
                  $currency = 'QAR'; 
                  break;
              case 'ksa':
                  $currency = 'SAR';
                  break;
              default:
                  $currency = $store_code;
                  break;
          }
        @endphp
        <span class="text-sm  font-normal ml-0.5">{{ $currency }}</span>
      </div>
      @php
        $transaction_detail = json_encode($trans);
      @endphp
      <button onclick="openTransactionModal({{ $transaction_detail }})" style="position: absolute;bottom:7px;right:15px;color:#ab8464" id="myBtn" class="hover:underline">View more</button>
    </div>
    @endforeach
    @else
    <div class=" grid grid-cols-1 place-items-start  px-4 pt-4 pb-10  w-auto h-auto g-6 text-gray-800">
      No Data Found This Month
    </div>
    @endif
  </div>