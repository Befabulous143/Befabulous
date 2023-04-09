
<?php $__env->startSection('content'); ?>
        <div class=" grid grid-cols-1  place-items-start lg:p-4 px-4 pb-2 py-16  w-auto h-auto g-6 text-gray-800">
            <div style="background-image: url(<?php echo e(asset('images/banner_image.jpg')); ?>)" class="grid banner-image shadow-xl grid-cols-1 w-full  p-4 lg:pr-10 lg:pl-10">
                <div class="grid grid-cols-1 h-28" style="">
                </div>
            </div>
        </div>
        <div class="grid grid-cols-1 place-items-start lg:px-4 lg:py-6 px-4 py-4  w-auto h-auto g-6 text-gray-800">
            <div class="grid  grid-cols-1 w-full   lg:pr-0 lg:pl-10">
                <div class="grid grid-cols-1">
                    <div class="grid  grid-cols-1 gap-4 place-items-end  pt-0 pb-2">
                        <a href="<?php echo e(route('point_history')); ?>" class="flex gap-1 px-10 py-3 shadow-md shadow-gray-400 rounded text-white app-bg-color" data-mdb-ripple="true"
                            data-mdb-ripple-color="light">
                            <div class="grid grid-cols-1 place-items-center">
                                <img style="filter: invert(100%) sepia(16%) saturate(7463%) hue-rotate(222deg) brightness(119%) contrast(115%);" class="w-5 h-5" src="<?php echo e(asset('images/transaction (1).png')); ?>" alt="">
                            </div>
                            Transactions
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class=" grid grid-cols-1 place-items-start  px-4 pb-2  w-auto h-auto g-6 text-gray-800">
            <div class="grid grid-cols-3 shadow-md shadow-gray-400 lg:px-10 px-4 lg:py-6 py-4 text-white app-bg-color grid-cols-1 w-full rounded ">
                <div class="grid grid-rows-2 gap-0 text-center lg:text-left">
                    Total Points
                    <?php
                    $totalPoint =  $data['points_summaries']['points_summary'][0]['totalPoints'] ?? 0;
                    if ($totalPoint != null) {
                        $totalPoint = $data['points_summaries']['points_summary'][0]['totalPoints'];
                    }
                    else
                    {
                        $totalPoint = 0;
                    }
                    ?>
                    <span class="text-2xl  font-extrabold"><?php echo e($totalPoint); ?></span>
                </div>
                <div class="grid grid-rows-2 gap-0 text-center">
                    <span class="text-center lg:text-left">Total Loyalty Points</span>
                    <span class="text-2xl text-center lg:text-left  font-extrabold"><?php echo e($data['loyalty_points']??0); ?></span>
                </div>
                <div class="grid grid-rows-2 gap-0 text-center">
                    <span class="text-center lg:text-left">Life Time Points</span>
                    <span class="text-2xl text-center lg:text-left  font-extrabold"><?php echo e($data['loyalty_points']??0); ?></span>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-1 place-items-start  px-4 pt-4 pb-4 lg:py-4   w-auto h-auto g-6 text-gray-800">
            <div class="grid  grid-cols-1 w-full">
                <div class="grid grid-cols-1">
                    <div class="grid  grid-cols-1 gap-4 place-items-start  pt-0 pb-2">
                            <h2 class="lg:text-lg text-lg text-gray-700 font-semibold">Points</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class=" grid grid-cols-1 place-items-start  px-4 pb-2  w-auto h-auto g-6 text-gray-800">
                <div class="grid grid-cols-4 shadow-md shadow-gray-400 px-2 py-8 lg:px-2 text-white app-bg-color grid-cols-1 w-full h-auto rounded ">
                    <div class="flex flex-col gap-1  text-center">
                        <i class="fa-solid fa-hand-holding-dollar"></i>
                        <span class="text-sm  font-semibold"><?php echo e($data['points_summary']['adjusted']??0); ?> Pts</span>
                        <span>Adjusted</span>
                    </div>
                    <div class="flex flex-col gap-1 text-center">
                        <i class="fa-solid fa-circle-dollar-to-slot"></i>
                        <span class="text-sm  font-semibold"><?php echo e($data['points_summary']['redeemed']??0); ?> Pts Pts</span>
                        <span>Radeemed</span>
                    </div>
                    <div class="flex flex-col gap-1 text-center">
                        <i class="fa-solid fa-piggy-bank"></i>
                        <span class="text-sm  font-semibold"><?php echo e($data['points_summary']['returned']??0); ?> Pts Pts</span>
                        <span>Returned</span>
                    </div>
                    <div class="flex flex-col gap-1 text-center">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                        <span class="text-sm  font-semibold"><?php echo e($data['points_summary']['expired']??0); ?> Pts Pts</span>
                        <span>Expired</span>
                    </div>
                </div>
            </div>
        <div class="mt-6 border  border-gray-200 w-full"></div>
        <?php echo $__env->make('offers.index',['coupons' => $coupons], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\manikuttan\Befabulous\resources\views/Dashboard/home.blade.php ENDPATH**/ ?>