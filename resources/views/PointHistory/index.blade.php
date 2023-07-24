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
  <div class="sm:grid sm:grid-cols-1 lg:flex gap-2 lg:m-0 ml-4">
    <div class=" grid grid-cols-1 place-items-start  lg:ml-4 text-gray-800">
      <input
        class="z-2 border border-2 border-gray-300 focus:outline-none focus:ring focus:ring-yellow-700 rounded py-1.5 text-sm px-2 w-52 text-left"
        type="text" id="daterange" name="daterange" value="01/01/2018 - 01/15/2018" />
    </div>
    <div class="mt-4 lg:mt-0">
      <button onclick="transactionDetails()" id="submit" class="py-1.5 mt-0.5 rounded shadow-md text-white text-sm px-3 app-bg-color"> GET</button>
    </div>
  </div>
<div id="transaction-list">

</div>

<script>
  $(function() {
      var fromDate = new Date(moment().subtract(1, 'months').startOf('month'));
      var toDate = new Date(moment().subtract(1, 'months').endOf('month'));
      var firstDay = new Date(fromDate.getFullYear(), fromDate.getMonth(), fromDate.getDate());
      var lastDay = new Date(toDate.getFullYear(), toDate.getMonth(), toDate.getDate());
      $('input[name="daterange"]').daterangepicker({
        opens: 'right',
        startDate:firstDay,
        endDate:lastDay,
        maxDate: moment(),
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


<script>
  var errorContainer =  document.getElementById('js-error-container');
  var errorMessage =  document.getElementById('js-error-msg');
  var successContainer =  document.getElementById('js-success-container');
  var successMessage =  document.getElementById('js-success-msg');
  var submitBtn =  document.getElementById('submit');
  var loaderAnim = document.getElementById("loader");
  $(document).ready(function() {
  transactionDetails();
  });

  function transactionDetails() {
        loaderAnim.style.display = 'block';
        const dates = $('#daterange').val().split(' - ');
        const startDate = dates[0];
        const endDate = dates[1];
        $.ajax({
            url: '{{ config('app.api_base_url') }}/mobile/v2/api/points/history?start_date='+startDate+'&end_date='+endDate, // Replace with your server-side fetch endpoint
            type: 'GET',
            headers: {
                'cap_authorization' : localStorage.getItem('cap_authorization'),
                'cap_brand' : "{{ config('app.brand') }}",
                'cap_mobile' : localStorage.getItem('cap_mobile'),
            },
            data:{
            'subscriptions':'true',
            'mlp' : 'true',
            'user_id' : 'true',
            'optin_status' : 'true',
            'slab_history' : 'true',
            'expired_points' : 'true',
            'points_summary' : 'true',
            'membership_retention_criteria' : 'true',
            },
            success: function(res) {
            return transactionList(res.customer);
            
            loaderAnim.style.display = 'none';
            },
            error: function(xhr, status, error) {
            // Handle any errors that occur during the request
            console.log(error);
            loaderAnim.style.display = 'none';
            }

      });
  }

  function transactionList(transactions) {
          loaderAnim.style.display = 'block';
          $.ajax({
              url: '{{ route('transaction-history') }}', // Replace with your server-side fetch endpoint
              type: 'POST',
              data:{
                  _token: '{{ csrf_token() }}',
                  transactions: JSON.stringify(transactions)
              },
              success: function(res) {
                  if(res){
                      $('#transaction-list').html(res);
                  }
                  else{
                    $('#transaction-list').html('No data found!');
                  }
              loaderAnim.style.display = 'none';
              },
              error: function(xhr, status, error) {
              // Handle any errors that occur during the request
              console.log(error);
              loaderAnim.style.display = 'none';
              }
  
          });
  }
   

</script>
@endsection