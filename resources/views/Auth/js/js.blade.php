<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdn.tutorialjinni.com/intl-tel-input/17.0.8/css/intlTelInput.css"/>
<script src="https://cdn.tutorialjinni.com/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
<script>
    function preview_image1() {
                var filePath = document.getElementById("upload_profile");
                // Allowing file type
                var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.pdf)$/i;
                if (!allowedExtensions.exec(filePath.value)) {
                    if(filePath.value === ''){
                        document.getElementById("error1").innerHTML =
                            "Profile picture field is required!";
                    }
                    else{
                        document.getElementById("error1").innerHTML =
                            "The file must be a file of type: jpg , jpeg , png , pdf";
                    }
                    document.getElementById("error1").style.color = "red";
                    filePath.value = "";
                    $("#img").remove();
                    $("#img_preview").append(
                                    $(" <span style='position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);opacity:0.7' class='w-full   text-center font-normal text-gray-400 text-4xl'><i class='fa-solid fa-user'></i></span>")
                                );
                    return false;
                } else {
                    var filePath = document.getElementById("upload_profile");
                    if (filePath.files.length > 0) {
                        for (var i = 0; i < filePath.files.length; i++) {
                            const fsize = filePath.files.item(i).size;
                            const file = Math.round(fsize / 1024);
                            if (file >= 5000) {
                                document.getElementById("error1").innerHTML =
                                    "File too Big, please select a file less than 5mb";
                                document.getElementById("error1").style.color = "red";
                                document.getElementById("error1").style.color = "red";
                                filePath.value = "";
                                $("#img").remove();
                                $("#img_preview").append(
                                    $(" <span style='position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);opacity:0.7' class='w-full   text-center font-normal text-gray-400 text-4xl'><i class='fa-solid fa-user'></i></span>")
                                );
                                return false;
                            } else {
                                document.getElementById("error1").innerHTML =
                                    "<b>" + file + "</b> KB";
                                document.getElementById("error1").style.color = "blue";
                                $('#img_preview').html('');
                                $("#img_preview").append(
                                    $("<img id='img' style='width: 150px;height: 150px;position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);' class='rounded-full' src='" +
                                        URL.createObjectURL(event.target.files[i]) +
                                        "'><br>")
                                );
                            }
                        }
                    }
                }
            }
</script>

<script>
    // get the input element
const input = document.getElementById('phone');

// add an oninput event listener to the input element
input.addEventListener('input', function() {
// regular expression to match a mobile number with country code
const mobileNumberRegex = /^\+\d{1,3}\d{6,14}$/;

// get the value of the input element
const inputValue = input.value;

// check if the input value matches the mobile number regex
if (!mobileNumberRegex.test(inputValue)) {
// if the input value does not match the mobile number regex, remove any non-numeric characters
input.value = inputValue.replace(/[^\d\+]/g, '');
}
});

</script>

{{-- birthdate calculations --}}

<script>
    function _calculateAge(birthday) { // birthday is a date
        const birthdate = new Date(birthday)
        var ageDifMs = Date.now() - birthdate.getTime();
        
        var ageDate = new Date(ageDifMs); // miliseconds from epoch
        document.getElementById("age").value = Math.abs(ageDate.getUTCFullYear() - 1970);
    }
</script>

{{-- phone country code --}}

<script>
    var phoneInput = document.querySelector("#phone");
    let iti = window.intlTelInput(phoneInput, {
        separateDialCode: false,
        nationalMode: true,
        preferredCountries: ["ae","jo","om","bh","sa","qa","in"],
        utilsScript: "path/to/utils.js"
    });
    var dialCode = iti.getSelectedCountryData().dialCode;
    // set the input value to the dial code
    phoneInput.value = "+" + dialCode;
    var phoneContainer = document.querySelector(".iti");
    phoneContainer.style.width = "100%";
    phoneInput.placeholder  = "Mobile number with country code";

</script>

{{-- removing profile image --}}
<script>
    function removeImage()
{
    if($("#loaded-img").remove()){
        $("#img-icon").html("<i style='opacity:0.7' class='fa-solid fa-user'></i>");
    }
    if($("#img").remove()){
        $("#img_preview").html("<span style='position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);opacity:0.7' class='w-full   text-center font-normal text-gray-400 text-4xl'><i class='fa-solid fa-user'></i></span>");
    }
    $('#image_removed').val('image_removed');
}
</script>