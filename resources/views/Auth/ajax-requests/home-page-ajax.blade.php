<script>
    var errorContainer =  document.getElementById('js-error-container');
    var errorMessage =  document.getElementById('js-error-msg');
    var successContainer =  document.getElementById('js-success-container');
    var successMessage =  document.getElementById('js-success-msg');
    var submitBtn =  document.getElementById('submit');
    var loaderAnim = document.getElementById("loader");
    $(document).ready(function() {
    
        function userDetails() {
            loaderAnim.style.display = 'block';
            $.ajax({
                url: '{{ config('app.api_base_url') }}/mobile/v2/api/customer/get', // Replace with your server-side fetch endpoint
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
                console.log(res);
                if(res.customers.customer[0].group_points_summaries.group_points_summary[0].lifetime_points){
                    $('#lifetime_points').html(res.customers.customer[0].group_points_summaries.group_points_summary[0].lifetime_points);
                }
                if(res.customers.customer[0].group_points_summaries.group_points_summary[0].loyalty_points){
                    $('#loyalty_points').html(res.customers.customer[0].group_points_summaries.group_points_summary[0].loyalty_points);
                    currencyConverstion(res.customers.customer[0].group_points_summaries.group_points_summary[0].loyalty_points);
                }
                if(res.customers.customer[0].points_summaries.points_summary.length > 0){
                   const allPoints = pointSummary(res.customers.customer[0].points_summaries.points_summary);
                   console.log(allPoints);
                   $('#redeemed').html(allPoints.redeemed);
                   $('#expired').html(allPoints.expired);
                   $('#returned').html(allPoints.returned);
                   $('#adjusted').html(allPoints.adjusted);
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
        function currencyConverstion(point) {
            loaderAnim.style.display = 'block';
            const phoneNumber = localStorage.getItem('cap_mobile');
            const countryCode = getCountryCode(phoneNumber);
            const currencySymbol = getCurrencySymbol(phoneNumber);

            $.ajax({
                url: '{{ config('app.api_base_url') }}/mobile/v2/api/points/value/'+countryCode, // Replace with your server-side fetch endpoint
                type: 'GET',
                headers: {
                    'cap_authorization' : localStorage.getItem('cap_authorization'),
                    'cap_brand' : "{{ config('app.brand') }}",
                    'cap_mobile' : phoneNumber,
                },
                data:{
                    'points' : point 
                },
                success: function(res) {
                if(res.response.points.redeemable.points){
                    $('#converted_points').html(res.response.points.redeemable.points + '<span class="text-xs"> '+currencySymbol+'</span>');
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
        function getCoupons() {
            loaderAnim.style.display = 'block';
            const phoneNumber = localStorage.getItem('cap_mobile');
            $.ajax({
                url: '{{ config('app.api_base_url') }}/mobile/v2/api/customer/coupon?status=active', // Replace with your server-side fetch endpoint
                type: 'GET',
                headers: {
                    'cap_authorization' : localStorage.getItem('cap_authorization'),
                    'cap_brand' : "{{ config('app.brand') }}",
                    'cap_mobile' : phoneNumber,
                },
                success: function(res) {
                if(res && res.response && res.response.customers && res.response.customers.customer[0] && res.response.customers.customer[0].coupons && res.response.customers.customer[0].coupons.coupon){
                    return showCoupons(res.response.customers.customer[0].coupons.coupon);
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

        function getCountryCode(mobile) {
            var countryCode = '';
            switch (mobile.substring(0,3)) {
            case '962':
                countryCode = 'jordinar';
                break;
            case '971':
                countryCode = 'uae';
                break;
            case '968':
                countryCode = 'oman';
                break;
            case '973':
                countryCode = 'bahrain';
                break;
            case '974':
                countryCode = 'qatar';
                break;
            case '966':
                countryCode = 'ksa';
                break;
            default:
                countryCode = 'jordinar';
                break;
            }

            return countryCode;
        }

        function getCurrencySymbol(mobile) {
            var countryCode = '';
            switch (mobile.substring(0,3)) {
                case '962':
                value = 'JOD';
                break;
                case '971':
                value = 'AED';
                break;
                case '968':
                value = 'OMR';
                break;
                case '973':
                value = 'BHD';
                break;
                case '974':
                value = 'QAR';
                break;
                case '966':
                value = 'SAR';
                break;
                default:
                value = 'JOD';
                break;
            }

            return value;
        }
        
        function pointSummary(data) {
            var redeemed = 0;
            var expired = 0;
            var returned = 0;
            var adjusted = 0;

            for (var key in data) {
                if (data.hasOwnProperty(key)) {
                var value = data[key];
                redeemed += parseFloat(value.redeemed, 10);
                expired += parseFloat(value.expired, 10);
                returned += parseFloat(value.returned, 10);
                adjusted += parseFloat(value.adjusted, 10);
                }
            }
            if(redeemed < 0){
                redeemed = 0;
            }
            if(expired < 0){
                expired = 0;
            }
            if(returned < 0){
                returned = 0;
            }
            if(adjusted < 0){
                adjusted = 0;
            }
            return {
                redeemed: redeemed,
                expired: expired,
                returned: returned,
                adjusted: adjusted
            };
        }

        function showCoupons(coupons) {
            loaderAnim.style.display = 'block';
            $.ajax({
                url: '{{ route('coupons-view') }}', // Replace with your server-side fetch endpoint
                type: 'POST',
                data:{
                    _token: '{{ csrf_token() }}',
                    coupons: JSON.stringify(coupons)
                },
                success: function(res) {
                    if(res){
                        $('#coupons-show').html(res);
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

        
        // Call the function to populate the form on page load
        userDetails();
        getCoupons();
    });
</script>