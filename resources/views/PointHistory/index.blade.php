@extends('layouts.app')
@section('content')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<div class="grid grid-cols-1 place-items-start  px-3.5 pt-10 pb-4 lg:py-0 lg:pt-10   w-auto h-auto g-6 text-gray-800">
  <div class="grid  grid-cols-1 w-full">
    <div class="grid grid-cols-1">
      <div class="grid  grid-cols-1 gap-4 place-items-start  pt-0 pb-2">
        <h2 class="lg:text-2xl text-lg text-gray-700 font-semibold	">Transaction History</h2>
      </div>
    </div>
  </div>
</div>
<div class="grid grid-cols-1 place-items-start  px-4 pt-10 pb-4 lg:py-0 lg:pt-10   w-auto h-auto g-6 text-gray-800">
  <div class="grid  grid-cols-1 w-full">
    <div class="grid grid-cols-1">
      <div class="grid  grid-cols-1 gap-4 place-items-start  pt-0 pb-2">
        <h2 class="lg:text-lg text-lg text-gray-700 font-semibold	">Pick a month to view transaction history</h2>
      </div>
    </div>
  </div>
</div>
<form action="{{ route('point_history') }}" method="POST">
  @csrf
  <div class="sm:grid sm:grid-cols-1 lg:flex gap-2 lg:m-0 ml-4">
    <div class=" grid grid-cols-1 place-items-start  lg:ml-4 text-gray-800">
      <input
        class="z-2 border border-2 border-gray-300 focus:outline-none focus:ring focus:ring-yellow-700 rounded py-1.5 text-sm px-2 w-52 text-left"
        type="text" name="daterange" value="01/01/2018 - 01/15/2018" />
    </div>
    <div class="mt-4 lg:mt-0">
      <button id="submit" class="py-1.5 mt-0.5 rounded shadow-md text-white text-sm px-3 app-bg-color"> GET</button>
    </div>
  </div>
</form>
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
    <div style="font-family: 'Montserrat', sans-serif;
                "
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
        <h2 class="text-md  font-thin font-semibold mt-1  ml-0.5" title="{{ $trans['notes'] ?? '' }}"
          style="display: -webkit-box;max-width: 250px;height:70px;-webkit-line-clamp: 3;-webkit-box-orient: vertical;overflow: hidden;text-overflow: ellipsis;">
          {{ $trans['notes'] ?? '' }}
        </h2>
      </div>
    </div>
    <div class=" flex flex-col justify-center items-center px-3">
      <span class="text-md  font-normal font-semibold"> {{ $trans['amount'] ?? '' }}</span>
      <span class="text-sm  font-normal ml-0.5">QAR</span>
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

<script>
  $(function() {
      var fromDate = new Date(@json($start_date));
      var toDate = new Date(@json($end_date));
      var firstDay = new Date(fromDate.getFullYear(), fromDate.getMonth(), fromDate.getDate());
      var lastDay = new Date(toDate.getFullYear(), toDate.getMonth(), toDate.getDate());
      $('input[name="daterange"]').daterangepicker({
        opens: 'right',
        startDate:firstDay,
        endDate:lastDay,
        ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
           'All Time' : [moment().subtract(18, 'year'),moment()]
        }
      });
    });
</script>

@include('PointHistory.modal.transaction-detail-modal')
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
@include('loader.loader')
@endsection