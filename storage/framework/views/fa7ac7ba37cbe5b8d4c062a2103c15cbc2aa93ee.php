<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/png" href="<?php echo e(asset('images/favicon.png')); ?>" sizes="32x32">
  <title><?php echo e(config('app.name')); ?></title>
  <link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
    integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link
    href="https://fonts.googleapis.com/css2?family=Gruppo&family=Montserrat:wght@300&family=Poiret+One&family=Redressed&family=Roboto:ital,wght@1,300&display=swap"
    rel="stylesheet">
</head>

<body>
  <?php echo $__env->make('partials.session', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  <section class="h-full  grid grid-cols-1 place-items-center overflow-y-auto">
    <div class="container   lg:w-3/5 h-full lg:px-4 py-5 pb-10 lg:py-3 ">
      <div class="grid grid-cols-1 place-items-start  px-4  w-auto h-auto g-6 text-gray-800">
        <div class="grid  grid-cols-1 w-full  ">
          <div class="grid grid-cols-2">
            <div class="grid   grid-cols-1 gap-4 place-items-start  ">
              <div class="grid grid-cols-1  place-items-center pr-2 pt-3 pb-2 cursor-pointer">
                <a href="<?php echo e(route('dashboard')); ?>">
                  <img class="w-36" src="<?php echo e(asset('images/microsite_logo.png')); ?>" alt="menu" srcset="">
                </a>
              </div>
            </div>
            <div class="grid  grid-cols-1 gap-4 place-items-end  pt-1 pb-2 ">
              <a href=<?php echo e(route('profile')); ?>>
                <?php
                if (isset(auth()->user()->profile) && auth()->user()->profile!= null) {
                $profile = asset(auth()->user()->profile);
                }
                ?>
                <img id="user-img" class="rounded-full bg-white p-1  border-4 border-yellow-600  w-16 h-16 z-2"
                  src="<?php echo e($profile  ?? asset('images/user-pic.png')); ?>" alt="user" srcset="">
              </a>
            </div>
          </div>
        </div>
      </div>
      <?php echo $__env->yieldContent('content'); ?>
    </div>
  </section>
  <div class="lg:hidden sm:hidden md:hidden hover:block w-full app-bg-color h-16 fixed bottom-0">
    <div class="grid grid-cols-3 w-full h-16 text-center justify-items-center	 text-white items-center">
      <a href="<?php echo e(route('dashboard')); ?>"><i class="fa-solid fa-house text-xl"></i></a>
      <a href="<?php echo e(route('point_history')); ?>" class="">
        <img style="filter: invert(100%) sepia(16%) saturate(7463%) hue-rotate(222deg) brightness(119%) contrast(115%);"
          class="w-6 h-6" src="<?php echo e(asset('images/transaction (1).png')); ?>" alt="">
      </a>
      <a href="<?php echo e(route('profile')); ?>"><i class="fa-solid fa-user text-xl"></i></a>
    </div>
  </div>

</body>

</html><?php /**PATH C:\Users\manikuttan\Befabulous\resources\views/layouts/app.blade.php ENDPATH**/ ?>