<!-- Add a container element for the spinner -->
<div id="loader">
    <div class="spinner"></div>
</div>
<style>
    #loader {
        position: fixed;
        z-index: 9999;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(255, 255, 255, 0.8);
        display: none;
    }

    .spinner {
        border: 8px solid #f3f3f3;
        /* Light grey */
        border-top: 8px solid #ab8464;
        /* Blue */
        border-radius: 50%;
        width: 40px;
        height: 40px;
        animation: spin 2s linear infinite;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>

<script>
// Get a reference to the loader element
var loader = document.getElementById("loader");

var button = document.getElementById("submit");

button.addEventListener("click", function() {
    // Show the loader when the page is about to be unloaded or reloaded
    window.onbeforeunload = function() {
        loader.style.display = "block";
    }
});

// Hide the loader when the page has finished reloading
window.onload = function() {
    loader.style.display = "none";
}

</script><?php /**PATH D:\Befabulous\resources\views/loader/loader.blade.php ENDPATH**/ ?>