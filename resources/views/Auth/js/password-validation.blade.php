<script>
    const passwordInput = document.getElementById("password");
    const confirmPasswordInput = document.getElementById("password_confirmation");

        
    passwordInput.addEventListener("input", function () {
    const password = passwordInput.value;
    if (password.length >= 8 && /[A-Z]/.test(password) && /\d/.test(password)) {
    passwordInput.setCustomValidity("");
    }
    else {
    passwordInput.setCustomValidity("Password must be at least 8 characters long, including one uppercase letter and one number");
    }
    });

    //for confirm password
    confirmPasswordInput.addEventListener("input", function () {
    const password = passwordInput.value;
    const confirmPass = confirmPasswordInput.value;
    if (password === confirmPass) {
        confirmPasswordInput.setCustomValidity("");
    }
    else {
        confirmPasswordInput.setCustomValidity("Confirm password doesn't match!");
    }
    });
</script>

<script>
    function showPassword(id) {
        var x = '';
        if(id === 1){
            x = document.getElementById("password");
        }
        else
        {
             x = document.getElementById("password_confirmation");
        }
        if (x.type === "password") {
        x.type = "text";
        } else {
        x.type = "password";
        }
        }
</script>