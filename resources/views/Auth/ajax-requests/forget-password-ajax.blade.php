{{-- forget password ajax call start --}}

<script>
    var errorContainer =  document.getElementById('js-error-container');
    var errorMessage =  document.getElementById('js-error-msg');
    var successContainer =  document.getElementById('js-success-container');
    var successMessage =  document.getElementById('js-success-msg');
    var submitBtn =  document.getElementById('submit');
    var verifyOtpBtn =  document.getElementById('verify-otp-btn');
    var loaderAnim = document.getElementById("loader");
    var otpContainer = document.getElementById("otp-container");
    var sessionId = '';
  
    $(document).ready(function() {
      $('#submit').click(function(e) {
                e.preventDefault();
                submitBtn.disabled  = true;
                loaderAnim.style.display = 'block';
                const phone = $('#phone').val().replace('+', '');
                const password = $('#password').val();
                const confirmPassword = $('#password_confirmation').val();
                if(phone.length < 4){
                  errorContainer.style.display = "block";
                  errorMessage.innerHTML  = "Phone Number field is required!";
                  submitBtn.disabled  = false;
                  loaderAnim.style.display = 'none';
                  return;
                }
                if(!password){
                  errorContainer.style.display = "block";   
                  errorMessage.innerHTML  = "Password field is required!";
                  submitBtn.disabled  = false;
                  loaderAnim.style.display = 'none';
                  return;
                }
                if(!confirmPassword){
                  errorContainer.style.display = "block";   
                  errorMessage.innerHTML  = "Confirm password field is required!";
                  submitBtn.disabled  = false;
                  loaderAnim.style.display = 'none';
                  return;
                }
                var formData = {
                    identifierType : "MOBILE",
                    identifierValue : phone,
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
                      // && res.user.userRegisteredForPassword && res.user.userRegisteredForPassword === true
                        if (res && res.user) {
                          sessionId =  res.user.sessionId; 
                          const forgetPasswordFormData = {
                                identifierType : "MOBILE",
                                identifierValue : phone,
                                brand : "{{ config('app.brand') }}",
                                password : password,
                                confirmPassword : confirmPassword,
                                sessionId: res.user.sessionId
                            }
                            return updateForgetPassword(forgetPasswordFormData);
                        } else{
                            errorContainer.style.display = "block";
                            errorMessage.innerHTML  = "You don't have an account!";
                            submitBtn.disabled  = false;
                        }
                        loaderAnim.style.display = 'none';
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
  
        function updateForgetPassword(formData) {
            $.ajax({
                    url: '{{ config('app.api_base_url') }}/auth/v1/web/password/forget',
                    method: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify(formData),
                    success: function(res) {
                        loaderAnim.style.display = 'none';
                        if (res.status.success) {
                            const otpGenerateFormData = {
                                  identifierType : "MOBILE",
                                  identifierValue : formData.identifierValue,
                                  brand : "{{ config('app.brand') }}",
                                  password : formData.password,
                                  confirmPassword : formData.confirmPassword,
                                  sessionId: formData.sessionId
                              }
                            return otpGenerate(otpGenerateFormData);
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
  
        function otpGenerate(formData){
            const otpFormData = {
                                identifierType : "MOBILE",
                                identifierValue : formData.identifierValue,
                                brand : "{{ config('app.brand') }}",
                                sessionId: formData.sessionId
            }
            $.ajax({
                    url: '{{ config('app.api_base_url') }}/auth/v1/web/otp/generate',
                    method: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify(otpFormData),
                    success: function(res) {
                        loaderAnim.style.display = 'none';
                        if (res.status.success) {
                            const validOtpFormData = {
                                identifierType : "MOBILE",
                                identifierValue : formData.identifierValue,
                                brand : "{{ config('app.brand') }}",
                                password : formData.password,
                                confirmPassword : formData.confirmPassword,
                                sessionId: formData.sessionId  
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
          e.preventDefault();
          const phone = $('#phone').val().replace('+', '');
          const password = $('#password').val();
          const confirmPassword = $('#password_confirmation').val();
          const otp = $('#otp').val();
          const formData = {
            identifierType : "MOBILE",
            identifierValue : phone,
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
                            window.location.href = "{{ route('login_page') }}?password_changed=1";
                            return;
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
        });
  
     
  </script>
  {{-- forget password ajax call end --}}