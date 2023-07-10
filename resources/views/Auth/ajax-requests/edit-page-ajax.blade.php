<script>
    var errorContainer =  document.getElementById('js-error-container');
    var errorMessage =  document.getElementById('js-error-msg');
    var successContainer =  document.getElementById('js-success-container');
    var successMessage =  document.getElementById('js-success-msg');
    var submitBtn =  document.getElementById('submit');
    var loaderAnim = document.getElementById("loader");

    
    $(document).ready(function() {

        function formatDate(dateString) {
          var date = new Date(dateString);
          var year = date.getFullYear();
          var month = ('0' + (date.getMonth() + 1)).slice(-2);
          var day = ('0' + date.getDate()).slice(-2);
          return year + '-' + month + '-' + day;
        }

        function showFormDetails() {
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
              'mlp' : 'false',
              'user_id' : 'true',
              'optin_status' : 'false',
              'slab_history' : 'false',
              'expired_points' : 'false',
              'points_summary' : 'false',
              'membership_retention_criteria' : 'true',
            },
            success: function(res) {
              // Assuming the response is a JSON object
              $('#firstname').val(res.customers.customer[0].firstname);
              $('#lastname').val(res.customers.customer[0].lastname);
              $('#email').val(res.customers.customer[0].email);
              $('#mobile').val(res.customers.customer[0].mobile);
              const extendFields = res.customers.customer[0].extended_fields.field;
              for (let index = 0; index < extendFields.length; index++) {
                const row = extendFields[index];
                if(row){
                  if(row.name === 'dob' || row.name === 'wedding_date'){
                    $('#'+row.name).val(formatDate(row.value));
                    if(row.value){
                      $('#'+row.name).prop('disabled','true');
                    }
                    $('#'+row.name).prop('max','{{ date("Y-m-d") }}');
                  } else if(row.name === 'nationality'){
                    $('#countries').val(row.value);
                  } else{
                      $('#'+row.name).val(row.value);
                  }
                }
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
        showFormDetails();

        $('#signupForm').submit(function(e) {
            e.preventDefault();
            var formDataArray = $(this).serializeArray(); // Serialize the form data
           
            submitBtn.disabled  = true;
            loaderAnim.style.display = 'block';
            profile = $('#upload_profile')[0].files[0];
            var formData = {}; // Initialize an empty object

            // Loop through the form data array
            for (var i = 0; i < formDataArray.length; i++) {
              var fieldName = formDataArray[i].name;
              var fieldValue = formDataArray[i].value;

              // Add each field to the formDataObject
              formData[fieldName] = fieldValue;
            }
            var formData = {
              "root": {
                "customer": [
                  {
                    "firstname": formData.firstname,
                    "lastname": formData.lastname,
                    "email": formData.email,
                    "extended_fields": {
                      "field": [
                        {
                          "name": "city",
                          "value": formData.city,
                        },
                        {
                          "name": "State",
                          "value": formData.state,
                        },
                        {
                          "name": "country_of_residence",
                          "value": formData.country_of_residence,
                        },
                        {
                          "name": "gender",
                          "value": formData.gender,
                        },
                        {
                          "name": "zip",
                          "value": formData.zip,
                        },
                        {
                          "name": "dob",
                          "value": formData.dob,
                        },
                        {
                          "name": "wedding_date",
                          "value": formData.wedding_date,
                        },
                        {
                          "name": "marital_status",
                          "value": formData.marital_status,
                        },
                        {
                          "name": "age",
                          "value": formData.age,
                        },
                        {
                          "name": "area",
                          "value": formData.area,
                        },
                        {
                          "name": "nationality",
                          "value": formData.nationality,
                        },
                      ]
                    }
                  }
                ]
              }
            };
          var jsonData = JSON.stringify(formData); // Convert the array to a JSON string
            $.ajax({
                url: '{{ config('app.api_base_url') }}/mobile/v2/api/customer/update',
                method: 'POST',
                contentType: 'application/json',
                headers: {
                'cap_authorization' : localStorage.getItem('cap_authorization'),
                'cap_brand' : "{{ config('app.brand') }}",
                'cap_mobile' : localStorage.getItem('cap_mobile'),
                },
                data: jsonData,
                success: function(res) {
                    submitBtn.disabled  = false;
                    loaderAnim.style.display = 'none';
                    successContainer.style.display = 'block';
                    errorContainer.style.display = "none";
                    successMessage.innerHTML  = "Customer detail updated successfully!";
                    if(profile){
                      return uploadImage();
                    }
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseJSON.message);
                    submitBtn.disabled  = false;
                    loaderAnim.style.display = 'none';
                }
            });
        });
    });


    function uploadImage(data){
        var formData = new FormData();
        var imageFile = $('#upload_profile')[0].files[0];
        formData.append('profile', imageFile);
        formData.append('user_id', localStorage.getItem('user_id'));
        formData.append('_token', '{{ csrf_token() }}');

        $.ajax({
            url: '{{ route("upload-image") }}',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(res) {
              console.log('Image uploaded successfully!');
            },
            error: function(xhr, status, error) {
              console.error(error);
            }
        });
    }
</script>