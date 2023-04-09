<?php if(Session::has('false')): ?>
<div id="session-msg" class="bg-red-50 absolute lg:right-2 lg:top-2 lg:w-auto w-full border-t-4 border-red-500 rounded-b text-red-900 px-4 py-1 shadow-md" role="alert">
    <div class="flex gap-3">
      <div class="">
        <span class="text-lg"><i class="fa-solid fa-circle-xmark"></i></i></span>
    </div>
    <div class="py-1">
        <p class="text-sm "><?php echo e(Session::get('false')); ?></p>
    </div>
    </div>
  </div>
<?php endif; ?>
<?php if(Session::has('true')): ?>
<div id="session-msg" class="bg-teal-100 absolute lg:right-2 lg:top-2 lg:w-auto w-full border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-1 shadow-md" role="alert">
    <div class="flex gap-3">
      <div class="">
        <span class="text-lg"><i class="fa-solid fa-circle-check"></i></span>
    </div>
    <div class="py-1">
        <p class="text-sm "> <?php echo e(Session::get('true')); ?></p>
    </div>
    </div>
  </div>
<?php endif; ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function(){
    setTimeout(function() {
    $('#session-msg').fadeOut('fast');
}, 10000);
});
</script><?php /**PATH D:\Befabulous\resources\views/partials/session.blade.php ENDPATH**/ ?>