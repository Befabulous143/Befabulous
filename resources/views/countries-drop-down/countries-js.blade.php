<script>
  countries.onfocus = function() {
      browsers.style.display = 'block';
      countries.style.borderRadius = "5px 5px 0 0";
    };
    for (let option of browsers.options) {
      option.onclick = function() {
        countries.value = option.value;
        browsers.style.display = 'none';
        countries.style.borderRadius = "5px";
      }
    };
    
    countries.oninput = function() {
      currentFocus = -1;
      var text = countries.value.toUpperCase();
      for (let option of browsers.options) {
        if (option.value.toUpperCase().indexOf(text) > -1) {
          option.style.display = "block";
        } else {
          option.style.display = "none";
        }
      };
    }
    var currentFocus = -1;
    countries.onkeydown = function(e) {
      if (e.keyCode == 40) {
        currentFocus++
        addActive(browsers.options);
      } else if (e.keyCode == 38) {
        currentFocus--
        addActive(browsers.options);
      } else if (e.keyCode == 13) {
        e.preventDefault();
        if (currentFocus > -1) {
          /*and simulate a click on the "active" item:*/
          if (browsers.options) browsers.options[currentFocus].click();
        }
      }
    }
    
    function addActive(x) {
      if (!x) return false;
      removeActive(x);
      if (currentFocus >= x.length) currentFocus = 0;
      if (currentFocus < 0) currentFocus = (x.length - 1);
      x[currentFocus].classList.add("active");
    }
    
    function removeActive(x) {
      for (var i = 0; i < x.length; i++) {
        x[i].classList.remove("active");
      }
    }
  const ignoreMe = document.getElementById('countries');
  window.addEventListener('mouseup', function(event){
      if (event.target != ignoreMe && event.target.parentNode != ignoreMe){
        browsers.style.display = 'none';
        }
});
</script>