{{-- change password ajax request start --}}
<script>
         var errorContainer =  document.getElementById('js-error-container');
          var errorMessage =  document.getElementById('js-error-msg');
          var successContainer =  document.getElementById('js-success-container');
          var successMessage =  document.getElementById('js-success-msg');
          var submitBtn =  document.getElementById('submit');
          var loaderAnim = document.getElementById("loader");
          
          var phone = localStorage.getItem('cap_mobile');
          var authToken = localStorage.getItem('cap_authorization');
          var cap_brand = localStorage.getItem('cap_brand');
  
          $(document).ready(function() {
              $('#changePasswordForm').submit(function(e) {
                  e.preventDefault();
                  submitBtn.disabled  = true;
                  loaderAnim.style.display = 'block';
                  const password = $('#password').val();
                  const oldPassword = $('#old_password').val();
                  const confirmPassword = $('#password_confirmation').val();
  
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
                                  brand : cap_brand,
                                  password : oldPassword,
                                  newPassword: password,
                                  confirmPassword: confirmPassword ,
                                  sessionId: res.user.sessionId,
                                  token: authToken
                              }
                              return changePassword(loginFormData);
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
  
              function changePassword(formData){
              $.ajax({
                      url: '{{ config('app.api_base_url') }}/auth/v1/web/password/change',
                      method: 'POST',
                      contentType: 'application/json',
                      data: JSON.stringify(formData),
                      success: function(res) {
                          console.log(res.status.success);
                          if (res.status.success) {
                              window.location.href = "{{ route('dashboard') }}?password_changed";
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
          }
  
              setTimeout(function() {
                  errorContainer.style.display = "none";
                  successContainer.style.display = "none";
              }, 10000);
          });
  </script>
  {{-- change password ajax request end --}}