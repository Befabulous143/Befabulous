
<?php $__env->startSection('content'); ?>
<?php echo $__env->make('countries-drop-down.countries-style', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="mt-0 lg:mt-2 p-2 pt-0  pb-10">
  <div class="mt-5 md:col-span-2 md:mt-0">
    <form action="<?php echo e(route('update')); ?>" method="POST" enctype="multipart/form-data">
      <?php echo csrf_field(); ?>
      <div class="overflow-hidden shadow rounded ">
        <div class="bg-white px-4 py-5 rounded sm:p-6">
          <div class="grid grid-cols-1 place-items-center mb-8">
            <label for="upload_profile" style='width: 150px;height: 150px;position: relative;'
              class='rounded-full border border cursor-pointer border-slite-200 shadow'>
              <div id="img_preview">
                <span id="img-icon" style="position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);"
                  class="w-full   text-center font-normal text-gray-400 text-4xl">
                  <?php if(auth()->user()): ?>
                  <img id="loaded-img"
                    style='width: 150px;height: 150px;position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);'
                    class='rounded-full' src="<?php echo e(asset(auth()->user()->profile)); ?>" alt="">
                  <?php else: ?>
                  <i style="opacity:0.7" class="fa-solid fa-user"></i>
                  <?php endif; ?>
                </span>
              </div>
            </label>
            <input type="file" name="profile" accept="image/*" id="upload_profile" onchange="preview_image1()" multiple
              class="hidden w-full" value="<?php echo e(old('profile')); ?>" />
            <span id="error1" class="text-xs text-red-500 mt-2"></span>
            <?php $__errorArgs = ['profile'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <p class="text-red-500 text-xs mt-2"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            <div class="flex gap-6 mt-2">
              <label for="upload_profile" class="cursor-pointer block text-sm font-medium text-gray-700">Upload <i
                  class="fa-solid fa-pen-to-square text-sky-700"></i></label>
              <div onclick="removeImage()" class="cursor-pointer block text-sm font-medium text-gray-700">Remove <i
                  class="fa-solid fa-trash text-red-500"></i></div>
            </div>
          </div>
          <div class="border border-slite-50 border-dashed	  w-full mb-8"></div>
          <div class="grid grid-cols-6 gap-6">
            <div class="col-span-6 sm:col-span-3">
              <label for="firstname" class="block text-sm font-medium text-gray-700">First name</label>
              <input type="text" name="firstname" value="<?php echo e($data['firstname'] ?? ''); ?>" id="firstname"
                autocomplete="given-name"
                class="mt-1.5 block w-full rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-gray-500 focus:outline-none focus:ring-gray-200 sm:text-sm">
              <?php $__errorArgs = ['firstname'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
              <p class="text-red-500 text-xs mt-2"><?php echo e($message); ?></p>
              <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="col-span-6 sm:col-span-3">
              <label for="lastname" class="block text-sm font-medium text-gray-700">Last name</label>
              <input type="text" name="lastname" value="<?php echo e($data['lastname'] ?? ''); ?>" id="lastname"
                autocomplete="family-name"
                class="mt-1.5 block w-full rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-gray-500 focus:outline-none focus:ring-gray-200 sm:text-sm">
              <?php $__errorArgs = ['lastname'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
              <p class="text-red-500 text-xs mt-2"><?php echo e($message); ?></p>
              <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="col-span-6 sm:col-span-3">
              <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
              <input type="email" name="email" value="<?php echo e($data['email'] ?? ''); ?>" id="email" autocomplete="email"
                class="mt-1.5 block w-full rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-gray-500 focus:outline-none focus:ring-gray-200 sm:text-sm">
              <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
              <p class="text-red-500 text-xs mt-2"><?php echo e($message); ?></p>
              <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="col-span-6 sm:col-span-3">
              <label for="mobile" class="block text-sm font-medium text-gray-700">Mobile</label>
              <input readonly value="<?php echo e('+'.$data['mobile'] ?? ''); ?>"
                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1').replace(/^0[^.]/, '0');"
                type="text" name="mobile" id="mobile" autocomplete="mobile"
                class=" mt-1.5 block w-full rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-gray-500 focus:outline-none focus:ring-gray-200 sm:text-sm">
              <?php $__errorArgs = ['mobile'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
              <p class="text-red-500 text-xs mt-2"><?php echo e($message); ?></p>
              <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="col-span-6 sm:col-span-2">
              <label for="dob" class="block text-sm font-medium text-gray-700">Date of birth</label>
              <input onchange="_calculateAge(this.value)" <?php echo e(isset($data['dob']) ? 'readonly' : ''); ?> type="date"
                value="<?php echo e(isset($data['dob']) ? \Carbon\Carbon::parse($data['dob'])->format('Y-m-d') : ''); ?>" name="dob"
                id="dob" autocomplete="city"
                class="cursor-pointer mt-1.5 block w-full rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-gray-500 focus:outline-none focus:ring-gray-200 sm:text-sm">
              <?php $__errorArgs = ['dob'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
              <p class="text-red-500 text-xs mt-2"><?php echo e($message); ?></p>
              <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="col-span-6 sm:col-span-2">
              <label for="age" class="block text-sm font-medium text-gray-700">Age</label>
              <input readonly type="number" min="0" max="150" value="<?php echo e($data['age'] ?? old('age') ?? ''); ?>" name="age"
                id="age" autocomplete="address-level2"
                class="mt-1.5 block w-full rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-gray-500 focus:outline-none focus:ring-gray-200 sm:text-sm">
              <?php $__errorArgs = ['age'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
              <p class="text-red-500 text-xs mt-2"><?php echo e($message); ?></p>
              <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="col-span-6 sm:col-span-6 lg:col-span-2">
              <label for="area" class="block text-sm font-medium text-gray-700">Street Address</label>
              <input type="text" value="<?php echo e($data['area'] ?? old('area') ?? ''); ?>" name="area" id="area"
                autocomplete="address-level2"
                class="mt-1.5 block w-full rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-gray-500 focus:outline-none focus:ring-gray-200 sm:text-sm">
              <?php $__errorArgs = ['area'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
              <p class="text-red-500 text-xs mt-2"><?php echo e($message); ?></p>
              <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="col-span-6 sm:col-span-6 lg:col-span-2">
              <label for="city" class="block text-sm font-medium text-gray-700">City</label>
              <input type="text" value="<?php echo e($data['city'] ?? ''); ?>" name="city" id="city" autocomplete="address-level2"
                class="mt-1.5 block w-full rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-gray-500 focus:outline-none focus:ring-gray-200 sm:text-sm">
              <?php $__errorArgs = ['city'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
              <p class="text-red-500 text-xs mt-2"><?php echo e($message); ?></p>
              <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="col-span-6 sm:col-span-3 lg:col-span-2">
              <label for="State" class="block text-sm font-medium text-gray-700">State</label>
              <input type="text" value="<?php echo e($data['state'] ?? ''); ?>" name="State" id="State"
                autocomplete="address-level1"
                class="mt-1.5 block w-full rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-gray-500 focus:outline-none focus:ring-gray-200 sm:text-sm">
              <?php $__errorArgs = ['State'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
              <p class="text-red-500 text-xs mt-2"><?php echo e($message); ?></p>
              <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="col-span-6 sm:col-span-3 lg:col-span-2">
              <label for="zip" class="block text-sm font-medium text-gray-700">ZIP / Postal code</label>
              <input type="text" value="<?php echo e($data['zip'] ?? ''); ?>" name="zip" id="zip" autocomplete="zip"
                class="mt-1.5 block w-full rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-gray-500 focus:outline-none focus:ring-gray-200 sm:text-sm">
              <?php $__errorArgs = ['zip'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
              <p class="text-red-500 text-xs mt-2"><?php echo e($message); ?></p>
              <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="col-span-6 sm:col-span-3 lg:col-span-2">
              <label for="country_of_residence" class="block text-sm font-medium text-gray-700">Country</label>
              <input type="text" value="<?php echo e($data['country_of_residence'] ?? ''); ?>" name="country_of_residence"
                id="country_of_residence" autocomplete="address-level1"
                class="mt-1.5 block w-full rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-gray-500 focus:outline-none focus:ring-gray-200 sm:text-sm">
              <?php $__errorArgs = ['country_of_residence'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
              <p class="text-red-500 text-xs mt-2"><?php echo e($message); ?></p>
              <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="col-span-6 sm:col-span-2">
              <label for="firstname" class="block text-sm font-medium text-gray-700">Gender</label>
              <select name="gender"
                class="mt-1.5 block w-full rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-gray-500 focus:outline-none focus:ring-gray-200 sm:text-sm">
                <option value="Not Applicable" <?php echo e(isset($data['gender']) && $data['gender']=='Not Applicable'
                  ? 'selected' : ''); ?>>Not Applicable</option>
                <option value="Male" <?php echo e(isset($data['gender']) && $data['gender']=='Male' ? 'selected' : ''); ?>>Male
                </option>
                <option value="Female" <?php echo e(isset($data['gender']) && $data['gender']=='Female' ? 'selected' : ''); ?>>
                  Female</option>
              </select>
              <?php $__errorArgs = ['gender'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
              <p class="text-red-500 text-xs mt-2"><?php echo e($message); ?></p>
              <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="col-span-6 sm:col-span-2">
              <label for="wedding_date" class="block text-sm font-medium text-gray-700">Wedding Date</label>
              <input
                value="<?php echo e(isset($data['wedding_date']) ? \Carbon\Carbon::parse($data['wedding_date'])->format('Y-m-d') : ''); ?>"
                type="date" name="wedding_date" id="wedding_date" autocomplete="wedding_date"
                class="cursor-pointer mt-1.5 block w-full rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-gray-500 focus:outline-none focus:ring-gray-200 sm:text-sm">
              <?php $__errorArgs = ['wedding_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
              <p class="text-red-500 text-xs mt-2"><?php echo e($message); ?></p>
              <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="col-span-6 sm:col-span-2">
              <label for="marital_status" class="block text-sm font-medium text-gray-700">Marital Status</label>
              <select name="marital_status"
                class="mt-1.5 block w-full rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-gray-500 focus:outline-none focus:ring-gray-200 sm:text-sm">
                <option <?php echo e(isset($data['marital_status']) && $data['marital_status']=='Single' ? 'selected' : ''); ?>

                  value="Single">Single</option>
                <option <?php echo e(isset($data['marital_status']) && $data['marital_status']=='Married' ? 'selected' : ''); ?>

                  value="Married">Married</option>
                <option <?php echo e(isset($data['marital_status']) && $data['marital_status']=='Divorced' ? 'selected' : ''); ?>

                  value="Divorced">Divorced</option>
                <option <?php echo e(isset($data['marital_status']) && $data['marital_status']=='Widowed' ? 'selected' : ''); ?>

                  value="Widowed">Widowed</option>

              </select>
              <?php $__errorArgs = ['marital_status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
              <p class="text-red-500 text-xs mt-2"><?php echo e($message); ?></p>
              <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="col-span-6 sm:col-span-2 relative">
              <label for="nationality" class="block text-sm font-medium text-gray-700">Nationality</label>
              <input type="text" value="<?php echo e($data['nationality'] ?? old('nationality') ?? ''); ?>" name="nationality"
                id="countries" autocomplete="address-level1"
                class="mt-1.5 block w-full rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-gray-500 focus:outline-none focus:ring-gray-200 sm:text-sm">
              <?php echo $__env->make('countries-drop-down.countries', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
              <?php $__errorArgs = ['nationality'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
              <p class="text-red-500 text-xs mt-2"><?php echo e($message); ?></p>
              <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            
            

          </div>
        </div>
        <div class="bg-gray-100 px-4 py-3 text-right sm:px-6">
          <a href="<?php echo e(route('profile')); ?>"
            class="bg-gray-200 mr-4 text-black inline-flex justify-center rounded-md border border-transparent  py-2 px-10 text-sm font-medium  shadow-sm hover:bg-gray-300 cursor-pointer focus:outline-none focus:ring-2 focus:ring-gray-200 focus:ring-offset-2">Back</a>
          <button id="submit"
            class="app-bg-color inline-flex justify-center rounded-md border border-transparent  py-2 px-10 text-sm font-medium text-white shadow-sm hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-gray-200 focus:ring-offset-2">Update</button>
        </div>
      </div>
      <input type="hidden" name="image_removed" id="image_removed" value="">

    </form>
  </div>
</div>
<?php echo $__env->make('countries-drop-down.countries-js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('Auth.js.js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<script>
  $('#user-img').css({"display":"none"});
  $('#image_removed').val('');
</script>
<?php echo $__env->make('loader.loader', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Befabulous\resources\views/Profile/edit.blade.php ENDPATH**/ ?>