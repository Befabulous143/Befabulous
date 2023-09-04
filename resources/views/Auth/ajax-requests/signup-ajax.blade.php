{{-- user create ajax start --}}
<script>
    var errorContainer =  document.getElementById('js-error-container');
    var errorMessage =  document.getElementById('js-error-msg');
    var successContainer =  document.getElementById('js-success-container');
    var successMessage =  document.getElementById('js-success-msg');
    var submitBtn =  document.getElementById('submit');
    var loaderAnim = document.getElementById("loader");
    var otpContainer = document.getElementById("otp-container");
    var verifyOtpBtn =  document.getElementById('verify-otp-btn');
    var resendOtpBtn =  document.getElementById('resend-otp-btn');
    var createBtn = document.getElementById('create-btn');
    var sessionId = '';
    var identifierValue = '';
    var password = '';
    var confirmPassword = '';
    var firstName = '';
    var lastName = '';
    var profile = '';
    var authToken = '';
    var email = '';
    var retry = 0;

    function hideErrorMsg(){
        setTimeout(function() {
            errorContainer.style.display = "none";
            successContainer.style.display = "none";
        }, 10000);
    }

    function showResendOtpOption(){
        retry++;
        console.log(retry);
        if(retry > 3){
            successContainer.style.display = 'none';
            errorContainer.style.display = "block";
            errorMessage.innerHTML  = "You can't resend OTP! please try later.";
            return;
        }
        setTimeout(function() {
            resendOtpBtn.style.display = "block";
        }, 10000);
    }

    function otpResend(params) {
        submitBtn.style.display = 'block';
        submitBtn.click();
        submitBtn.style.display = 'none';
    }

    $(document).ready(function() {
        $('#registerForm').submit(function(e) {
            e.preventDefault();
            submitBtn.disabled  = true;
            loaderAnim.style.display = 'block';
            password = $('#password').val();
            confirmPassword = $('#password_confirmation').val();
            identifierValue = $('#phone').val().replace('+','');
            firstName = $('#firstname').val();
            lastName = $('#lastname').val();
            email = $('#email').val();
            profile = $('#upload_profile')[0].files[0];
            var formData = {
                identifierType : "MOBILE",
                identifierValue : identifierValue,
                brand : "{{ config('app.brand') }}",
                password : password,
                confirmPassword : confirmPassword,
            };
            
            $.ajax({
                url: '{{ config('app.api_base_url') }}/auth/v1/web/token/generate',
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(formData),
                success: function(res) {
                    submitBtn.disabled  = false;
                    loaderAnim.style.display = 'none';
                    errorContainer.style.display = "none";
                    if (res && res.user && res.user.userRegisteredForPassword && res.user.userRegisteredForPassword  === true) { 
                        window.location.href = "{{ route('login_page') }}?user_already_exists";
                        return;
                    } else{
                        sessionId = res.user.sessionId;
                        return otpGenerate();
                    }
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseJSON.message);
                    // Handle login error
                }
            });
        });
    });

    function otpGenerate(){
        password = $('#password').val();
        confirmPassword = $('#password_confirmation').val();
        identifierValue = $('#phone').val().replace('+','');
        firstName = $('#firstname').val();
        lastName = $('#lastname').val();
        email = $('#email').val();
        profile = $('#upload_profile')[0].files[0];
        resendOtpBtn.style.display = "none";
        const otpFormData = {
                            identifierType : "MOBILE",
                            identifierValue : identifierValue,
                            brand : "{{ config('app.brand') }}",
                            sessionId: sessionId
        }
        $.ajax({
                url: '{{ config('app.api_base_url') }}/auth/v1/web/otp/generate',
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(otpFormData),
                success: function(res) {
                    showResendOtpOption();
                    loaderAnim.style.display = 'none';
                    if (res.status.success) {
                        const validOtpFormData = {
                            identifierType : "MOBILE",
                            identifierValue : identifierValue,
                            brand : "{{ config('app.brand') }}",
                            password : password,
                            confirmPassword : confirmPassword,
                            sessionId: sessionId  
                        };
                        successContainer.style.display = 'block';
                        errorContainer.style.display = "none";
                        successMessage.innerHTML  = "OTP sent successfully to your mobile number.";
                        otpContainer.style.display = "block";
                        submitBtn.style.display  = "none";
                        verifyOtpBtn.style.display  = "block";
                        return;
                    } else{
                        submitBtn.disabled  = false;
                        loaderAnim.style.display = 'none';
                        successContainer.style.display = 'none';
                        errorContainer.style.display = "block";
                        errorMessage.innerHTML  = 'Something went wrong! Please contact our support';
                        if(res.status.message){
                            errorMessage.innerHTML  = res.status.message;
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseJSON.message);
                    loaderAnim.style.display = 'none';
                    submitBtn.disabled  = false;
                }
            });
            setTimeout(function() {
            errorContainer.style.display = "none";
            successContainer.style.display = "none";
        }, 10000);
    }

    $('#verify-otp-btn').click(function(e) {
            password = $('#password').val();
            confirmPassword = $('#password_confirmation').val();
            identifierValue = $('#phone').val().replace('+','');
            firstName = $('#firstname').val();
            lastName = $('#lastname').val();
            email = $('#email').val();
            profile = $('#upload_profile')[0].files[0];
        e.preventDefault();
        const otp = $('#otp').val();
        const formData = {
        identifierType : "MOBILE",
        identifierValue : identifierValue,
        brand : "{{ config('app.brand') }}",
        sessionId: sessionId,
        otp: otp
        }
        $.ajax({
                url: '{{ config('app.api_base_url') }}/auth/v1/web/otp/validate',
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(formData),
                success: function(res) {
                    loaderAnim.style.display = 'none';
                    if (res.status.success) {
                        authToken = res.auth.token;
                        verifyOtpBtn.style.display = 'none';
                        createBtn.style.display = 'block';
                        successContainer.style.display = 'block';
                        successMessage.innerHTML  = "OTP verified successfully!";
                        errorContainer.style.display = "none";
                        otpContainer.style.display = "none";
                        return;
                    } else{
                        submitBtn.disabled  = false;
                        loaderAnim.style.display = 'none';
                        successContainer.style.display = 'none';
                        errorContainer.style.display = "block";
                        errorMessage.innerHTML  = 'Something went wrong! Please contact our support';
                        if(res.status.message){
                            errorMessage.innerHTML  = res.status.message;
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseJSON.message);
                    loaderAnim.style.display = 'none';
                    submitBtn.disabled  = false;
                }
            });
            hideErrorMsg();
    });

    function validateEmail() {
        createBtn.disabled = true;
        password = $('#password').val();
        confirmPassword = $('#password_confirmation').val();
        identifierValue = $('#phone').val().replace('+','');
        firstName = $('#firstname').val();
        lastName = $('#lastname').val();
        email = $('#email').val();
        profile = $('#upload_profile')[0].files[0];
        $.ajax({
            url: "https://eu-api-gateway.capillarytech.com/mobile/v2/api/customers/lookup?source=INSTORE&identifierName=email&identifierValue="+email,
            type: "GET",
            dataType: "json",
            headers: {
                'cap_authorization' : authToken,
                'cap_brand' : "{{ config('app.brand') }}",
                'cap_mobile' : identifierValue,
            },
            success: function(res) {
                createBtn.disabled = false;
               if(res.entity){
                loaderAnim.style.display = 'none';
                successContainer.style.display = 'none';
                errorContainer.style.display = "block";
                errorMessage.innerHTML  = 'The Email id is already exists!';
                return;
               }else{
                const createData = {
                    root: {
                        customer: [
                            {
                            firstname: firstName || '',
                            lastname: lastName || '',
                            email: email || ''
                            }
                        ]
                    }
                };
                const createHeaders = {
                    'cap_authorization' : authToken,
                    'cap_brand' : "{{ config('app.brand') }}",
                    'cap_mobile' : identifierValue,
                };
                return createCustomer(createData,createHeaders);
               }
            },
            error: function(xhr, status, error) {
                // Handle error
            }
        });
    }

    function createCustomer(body,headers) {
        $.ajax({
            url: "https://eu-api-gateway.capillarytech.com/mobile/v2/api/customer/add",
            type: "POST",
            contentType: 'application/json',
            headers: headers,
            data:JSON.stringify(body),
            success: function(res) {
                console.log(res);
                if(res && res.status && res.status.success === 'true'){
                   const userId = res.customers.customer[0].user_id;
                   if(profile && userId){
                        const data = {
                            authToken: headers.cap_authorization,
                            cap_mobile: headers.cap_mobile,
                            user_id: res.customers.customer[0].user_id,
                            firstname: res.customers.customer[0].firstname,
                            lastname: res.customers.customer[0].lastname,
                        }
                        return uploadImage(userId,data);
                   }else{
                       const redirectFormData = {
                                    authToken: headers.cap_authorization,
                                    cap_mobile: headers.cap_mobile,
                                    user_id: res.customers.customer[0].user_id,
                                    firstname: res.customers.customer[0].firstname,
                                    lastname: res.customers.customer[0].lastname,
                                    _token: '{{ csrf_token() }}',
                        };
                       return redirectToDashboard(redirectFormData);
                   }
                }else{
                   loaderAnim.style.display = 'none';
                   successContainer.style.display = 'none';
                   errorContainer.style.display = "block";
                   errorMessage.innerHTML  = 'Something went wrong! Please contact our support';
                   return;
                }
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });
    }
    
    function uploadImage(userId,data){
        var formData = new FormData();
        var imageFile = $('#upload_profile')[0].files[0];
        formData.append('profile', imageFile);
        formData.append('user_id', userId);
        formData.append('_token', '{{ csrf_token() }}');

        $.ajax({
            url: '{{ route("upload-image") }}',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(res) {
                const redirectFormData = {
                                    authToken: data.authToken,
                                    cap_mobile: data.cap_mobile,
                                    user_id: data.user_id,
                                    firstname: data.firstname,
                                    lastname: data.lastname,
                                    _token: '{{ csrf_token() }}',
                        };
                return redirectToDashboard(redirectFormData);
            },
            error: function(xhr, status, error) {
            console.error(error);
            }
        });
    }

    function redirectToDashboard(formData) {
        getIpDetails();
            $.ajax({
                    url: '{{ route("redirect-to-dashboard") }}',
                    method: 'POST',
                    data: formData,
                    success: function(res) {
                        if (res.success) {
                            localStorage.setItem('cap_authorization', formData.authToken);
                            localStorage.setItem('cap_brand', "{{ config('app.brand') }}" );
                            localStorage.setItem('cap_mobile', formData.cap_mobile);
                            localStorage.setItem('user_id', formData.user_id);
                            localStorage.setItem('firstname', formData.firstname);
                            localStorage.setItem('lastname', formData.lastname);
                            setTimeout(function() {
                                window.location.href = "{{ route('dashboard') }}?logined=true";
                            },6000);
                            setTimeout(function() {
                                successContainer.style.display = 'block';
                                errorContainer.style.display = "none";
                                successMessage.innerHTML  = "Welcome" + formData.firstname + formData.lastname;
                            }, 5000);
                        } else{
                            submitBtn.disabled  = false;
                            loaderAnim.style.display = 'none';
                            successContainer.style.display = 'none';
                            errorContainer.style.display = "block";
                            errorMessage.innerHTML  = 'Something went wrong! Please contact our support';
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseJSON.message);
                        loaderAnim.style.display = 'none';
                        submitBtn.disabled  = false;
                    }
                });
                setTimeout(function() {
                errorContainer.style.display = "none";
                successContainer.style.display = "none";
            }, 10000);
    }
    hideErrorMsg();
    function getIpDetails() {
            fetch('https://api.ipify.org?format=json')
            .then(response => response.json())
            .then(data => {
                const clientIp = data.ip;
                fetchIpDetails(clientIp);
            })
            .catch(error => {
                console.error('Error fetching client IP address:', error);
            });

        }
        function fetchIpDetails(ipAddress) {
           fetch(`https://freeipapi.com/api/json/${ipAddress}`)
            .then(response => response.json())
            .then(data => {
                localStorage.setItem('countryCode', data.countryCode);
            })
            .catch(error => {
                console.error('Error fetching IP details:', error);
            });
        }
</script>
{{-- user create ajax end --}}