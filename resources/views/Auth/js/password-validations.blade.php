<script>
    // onkeyup="isPasswordValid(this.value)"
    // <p id="password-error" class="text-red-500 text-xs mt-2"></p>
    // submit btn id="submit"
   var submitBtn = document.getElementById("submit");
     function isPasswordValid (password) {
        if (password.length >= 8 && /[A-Z]/.test(password) && /\d/.test(password)) {
            document.querySelector('#password-error').textContent = '';
            submitBtn.disabled = false;
            return;
        }
        else {
            document.querySelector('#password-error').textContent = 'Password must be at least 8 characters long, including one uppercase letter and one number';
            submitBtn.disabled = true;
            return;
        }
    }  
    // onkeyup="isConfirmPasswordValid(this.value)"
    // <p id="cpassword-error" class="text-red-500 text-xs mt-2"></p>
    //submit btn id="submit"
    function isConfirmPasswordValid (cpassword) {
        const passwordValue = document.getElementById("password").value;
        if (passwordValue === cpassword) {
            document.querySelector('#cpassword-error').textContent = '';
            submitBtn.disabled = false;
            return;
        }
        else {
            document.querySelector('#cpassword-error').textContent = "Confirm password doesn't match!";
            submitBtn.disabled = true;
            return;
        }
    }    
</script>