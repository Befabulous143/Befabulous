{{-- login ajax start --}}
<script>
    var errorContainer =  document.getElementById('js-error-container');
    var errorMessage =  document.getElementById('js-error-msg');
    var successContainer =  document.getElementById('js-success-container');
    var successMessage =  document.getElementById('js-success-msg');
    var submitBtn =  document.getElementById('submit');
    var loaderAnim = document.getElementById("loader");
    var csrfToken = '{{ csrf_token() }}';
    $(document).ready(function() {
            $('#loginForm').submit(function(e) {
                e.preventDefault();
                submitBtn.disabled  = true;
                loaderAnim.style.display = 'block';
                const phone = $('#phone').val().replace('+', '');
                const password = $('#password').val();
                var formData = {
                    identifierType : "MOBILE",
                    identifierValue : phone,
                    brand : "{{ config('app.brand') }}",
                    password : password,
                    confirmPassword : password,
                };
                $.ajax({
                    url: '{{ config('app.api_base_url') }}/auth/v1/web/token/generate',
                    method: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify(formData),
                    success: function(res) {
                        if (res && res.user && res.user.userRegisteredForPassword && res.user.userRegisteredForPassword === true) {
                            const loginFormData = {
                                identifierType : "MOBILE",
                                identifierValue : phone,
                                brand : "{{ config('app.brand') }}",
                                password : password,
                                sessionId: res.user.sessionId
                            }
                            return validateLoginPassword(loginFormData);
                        } else{
                            errorContainer.style.display = "block";
                            errorMessage.innerHTML  = "You don't have an account!";
                            submitBtn.disabled  = false;
                            loaderAnim.style.display = 'none';
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseJSON.message);
                        // Handle login error
                        submitBtn.disabled  = false;
                        loaderAnim.style.display = 'none';
                    }
                });
            });
            setTimeout(function() {
                errorContainer.style.display = "none";
                successContainer.style.display = "none";
            }, 10000);
        });

        function validateLoginPassword(formData){
            $.ajax({
                    url: '{{ config('app.api_base_url') }}/auth/v1/web/password/validate',
                    method: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify(formData),
                    success: function(res) {
                        console.log(res.status.success);
                        if (res.status.success) {
                            const userHeader = {
                                cap_authorization : res.auth.token,
                                cap_brand  : "{{ config('app.brand') }}",
                                cap_mobile :  formData.identifierValue,    
                            };
                            return getUserDetails(userHeader);
                        } else{
                            submitBtn.disabled  = false;
                            loaderAnim.style.display = 'none';
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

        function getUserDetails(header) {
            $.ajax({
                    url: '{{ config('app.api_base_url') }}/mobile/v2/api/customer/get',
                    method: 'GET',
                    contentType: 'application/json',
                    data: {
                        'subscriptions': 'true',
                        'mlp': 'true',
                        'user_id': 'true',
                        'optin_status': 'true',
                        'slab_history': 'true',
                        'expired_points': 'true',
                        'points_summary': 'true',
                        'membership_retention_criteria': 'true'
                    },
                    headers: header,
                    success: function(res) {
                        if (res.status.success_count) {
                            const redirectFormData = {
                                authToken: header.cap_authorization,
                                cap_mobile: header.cap_mobile,
                                user_id: res.customers.customer[0].user_id,
                                firstname: res.customers.customer[0].firstname,
                                lastname: res.customers.customer[0].lastname,
                                _token: csrfToken,
                            };
                            return redirectToDashboard(redirectFormData);
                        } else{
                            submitBtn.disabled  = false;
                            loaderAnim.style.display = 'none';
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

        function redirectToDashboard(formData) {
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
                            window.location.href = "{{ route('dashboard') }}?logined=true";
                            setTimeout(function() {
                                successContainer.style.display = 'block';
                                errorContainer.style.display = "none";
                                successMessage.innerHTML  = "Welcome" + formData.firstname + formData.lastname;
                            }, 10000);
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
</script>
{{-- login ajax end --}}