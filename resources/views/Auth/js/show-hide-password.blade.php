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