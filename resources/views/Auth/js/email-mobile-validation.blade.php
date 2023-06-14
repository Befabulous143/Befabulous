{{-- verify email --}}
<script>
    var createBtn = document.getElementById('submit');
    function emailCheck(email,old_email = '',register) {
        if(old_email === email){
            document.querySelector('#email-error').textContent = '';
            createBtn.disabled = false;
            return;
        }
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        const validate = emailRegex.test(email);
        if(email.length === 0){
            document.querySelector('#email-error').textContent = 'The email field is required.';
            createBtn.disabled = true;
            return;
        } else if(validate)
        {
            document.querySelector('#email-error').textContent = '';
            createBtn.disabled = false;
        } else{
            document.querySelector('#email-error').textContent = 'Invalid email address.';
            createBtn.disabled = true;
            return;
        }
        // $.ajax({
        //     url: "{{ route('email-verify') }}",
        //     type: 'POST',
        //     headers: {
        //     "X-CSRF-Token": "{{ csrf_token() }}"
        //     },
        //     dataType: 'json',
        //     data: {
        //         email: email
        //     },
        //     success: function (response) {
        //         if(response.success === false){
        //             document.querySelector('#email-error').textContent = 'Email already taken!Please try some other email.';
        //             createBtn.disabled = true;
        //             return;
        //         } else{
        //             createBtn.disabled = false;
        //             document.querySelector('#email-error').textContent = '';
        //         }
        //     },
        //     error: function (xhr, textStatus, errorThrown) {
        //         // Handle any errors
        //         console.error('AJAX request failed with status ' + xhr.status + ': ' + errorThrown);
        //     }
        // });
    }

 
    function  mobileCheck(mobile,register) {
        const data = {
        "+962": 9,
        "+973": 8,
        "+968": 8,
        "+974": 8,
        "+966": 9,
        "+971": 9
        };
        var isMobilLength = 10;
        switch (data[mobile.substring(0, 4)]) {
            case 9:
            isMobilLength = 13;
            break;
            case 8:
                isMobilLength = 12;
                break;
        }
        var pattern = /^\+(?:[1-9]){1,3}(?:\d{1,14})$/; 
        var isValid = pattern.test(mobile);

        if(isValid)
        {
            document.querySelector('#mobile-error').textContent = '';
            createBtn.disabled = false;
        } else{
            document.querySelector('#mobile-error').textContent = 'Country code required!';
            createBtn.disabled = true;
            return;
        }
        if(mobile.length >= isMobilLength){
            document.querySelector('#mobile-error').textContent = '';
            createBtn.disabled = false;
        } else{
            document.querySelector('#mobile-error').textContent = 'Mobile number atleast must have '+ (isMobilLength - 4) +' digits!';
            createBtn.disabled = true;
            return;
        }
        // $.ajax({
        //     url: "{{ route('mobile-verify') }}",
        //     type: 'POST',
        //     headers: {
        //     "X-CSRF-Token": "{{ csrf_token() }}"
        //     },
        //     dataType: 'json',
        //     data: {
        //         mobile: mobile
        //     },
        //     success: function (response) {
        //         if(response.success === false){
        //             document.querySelector('#mobile-error').textContent = 'Mobile number is already taken!Please try some other mobile number.';
        //             createBtn.disabled = true;
        //             return;
        //         } else{
        //             createBtn.disabled = false;
        //             document.querySelector('#mobile-error').textContent = '';
        //         }
        //     },
        //     error: function (xhr, textStatus, errorThrown) {
        //         // Handle any errors
        //         console.error('AJAX request failed with status ' + xhr.status + ': ' + errorThrown);
        //     }
        // });
    }
</script>