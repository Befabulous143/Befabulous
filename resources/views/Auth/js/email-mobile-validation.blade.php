{{-- verify email --}}
<script>
    var createBtn = document.getElementById('submit');
    function emailCheck(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        const validate = emailRegex.test(email);
        if(validate)
        {
            document.querySelector('#email-error').textContent = '';
            createBtn.disabled = false;
        } else{
            document.querySelector('#email-error').textContent = 'Invalid email address.';
            createBtn.disabled = true;
            return;
        }
        $.ajax({
            url: "{{ route('email-verify') }}",
            type: 'POST',
            headers: {
            "X-CSRF-Token": "{{ csrf_token() }}"
            },
            dataType: 'json',
            data: {
                email: email
            },
            success: function (response) {
                if(response.success === false){
                    document.querySelector('#email-error').textContent = 'Email already taken!Please try some other email.';
                    createBtn.disabled = true;
                    return;
                } else{
                    createBtn.disabled = false;
                    document.querySelector('#email-error').textContent = '';
                }
            },
            error: function (xhr, textStatus, errorThrown) {
                // Handle any errors
                console.error('AJAX request failed with status ' + xhr.status + ': ' + errorThrown);
            }
        });
    }
    function  mobileCheck(mobile) {
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
        if(mobile.length >= 13){
            document.querySelector('#mobile-error').textContent = '';
            createBtn.disabled = false;
        } else{
            document.querySelector('#mobile-error').textContent = 'Mobile number atleast must have 10 digits!';
            createBtn.disabled = true;
            return;
        }
        $.ajax({
            url: "{{ route('mobile-verify') }}",
            type: 'POST',
            headers: {
            "X-CSRF-Token": "{{ csrf_token() }}"
            },
            dataType: 'json',
            data: {
                mobile: mobile
            },
            success: function (response) {
                if(response.success === false){
                    document.querySelector('#mobile-error').textContent = 'Mobile number is already taken!Please try some other mobile number.';
                    createBtn.disabled = true;
                    return;
                } else{
                    createBtn.disabled = false;
                    document.querySelector('#mobile-error').textContent = '';
                }
            },
            error: function (xhr, textStatus, errorThrown) {
                // Handle any errors
                console.error('AJAX request failed with status ' + xhr.status + ': ' + errorThrown);
            }
        });
    }
</script>