@extends('layouts.app')
@section('content')
<script>
   $('#user-img').css({"display":"none"});
</script>
@include('countries-drop-down.countries-style')
<div class="mt-0 lg:mt-2 p-2 pt-0  pb-10">
  <div class="mt-5 md:col-span-2 md:mt-0">
    <form action="{{ route('update') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="overflow-hidden shadow rounded ">
        <div class="bg-white px-4 py-5 rounded sm:p-6">
          <div class="grid grid-cols-1 place-items-center mb-8">
            <label for="upload_profile" style='width: 150px;height: 150px;position: relative;'
              class='rounded-full border border cursor-pointer border-slite-200 shadow'>
              <div id="img_preview">
                <span id="img-icon" style="position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);"
                  class="w-full   text-center font-normal text-gray-400 text-4xl">
                  @if(auth()->user())
                  <img id="loaded-img"
                    style='width: 150px;height: 150px;position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);'
                    class='rounded-full' src="{{ asset(auth()->user()->profile) }}" alt="">
                  @else
                  <i style="opacity:0.7" class="fa-solid fa-user"></i>
                  @endif
                </span>
              </div>
            </label>
            <input type="file" name="profile" accept="image/*" id="upload_profile" onchange="preview_image1()" multiple
              class="hidden w-full" value="{{  old('profile') }}" />
            <span id="error1" class="text-xs text-red-500 mt-2"></span>
            @error('profile')
            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
            @enderror
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
              <input oninput="validateNameInput(this)" type="text" name="firstname" value="{{ $data['firstname'] ?? '' }}" id="firstname"
                autocomplete="given-name"
                class="mt-1.5 block w-full rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-gray-500 focus:outline-none focus:ring-gray-200 sm:text-sm">
              @error('firstname')
              <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
              @enderror
            </div>

            <div class="col-span-6 sm:col-span-3">
              <label for="lastname" class="block text-sm font-medium text-gray-700">Last name</label>
              <input oninput="validateNameInput(this)" type="text" name="lastname" value="{{ $data['lastname'] ?? '' }}" id="lastname"
                autocomplete="family-name"
                class="mt-1.5 block w-full rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-gray-500 focus:outline-none focus:ring-gray-200 sm:text-sm">
              @error('lastname')
              <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
              @enderror
            </div>

            <div class="col-span-6 sm:col-span-3">
              <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
              <input onkeyup="emailCheck(this.value,'{{ $data['email'] }}')" type="email" name="email" value="{{ $data['email'] ?? '' }}" id="email" autocomplete="email"
                class="mt-1.5 block w-full rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-gray-500 focus:outline-none focus:ring-gray-200 sm:text-sm">
              @error('email')
              <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
              @enderror
              <p id="email-error" class="text-red-500 text-xs mt-2"></p>
            </div>

            <div class="col-span-6 sm:col-span-3">
              <label for="mobile" class="block text-sm font-medium text-gray-700">Mobile</label>
              <input readonly value="{{ '+'.$data['mobile'] ?? '' }}"
                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1').replace(/^0[^.]/, '0');"
                type="text" name="mobile" id="mobile" autocomplete="mobile"
                class=" mt-1.5 block w-full rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-gray-500 focus:outline-none focus:ring-gray-200 sm:text-sm">
              @error('mobile')
              <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-span-6 sm:col-span-2">
              <label for="dob" class="block text-sm font-medium text-gray-700">Date of birth</label>
              <input max="{{ date('Y-m-d') }}" onchange="_calculateAge(this.value)" {{ isset($data['dob']) ? 'readonly' : '' }} type="date"
                value="{{ isset($data['dob']) ? \Carbon\Carbon::parse($data['dob'])->format('Y-m-d') : '' }}" name="dob"
                id="dob" autocomplete="city"
                class="cursor-pointer mt-1.5 block w-full rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-gray-500 focus:outline-none focus:ring-gray-200 sm:text-sm">
              @error('dob')
              <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-span-6 sm:col-span-2">
              <label for="age" class="block text-sm font-medium text-gray-700">Age</label>
              <input readonly type="number" min="0" max="150" value="{{ $data['age'] ?? old('age') ?? '' }}" name="age"
                id="age" autocomplete="address-level2"
                class="mt-1.5 block w-full rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-gray-500 focus:outline-none focus:ring-gray-200 sm:text-sm">
              @error('age')
              <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-span-6 sm:col-span-6 lg:col-span-2">
              <label for="area" class="block text-sm font-medium text-gray-700">Street Address</label>
              <input type="text" value="{{ $data['area'] ?? old('area') ?? '' }}" name="area" id="area"
                autocomplete="address-level2"
                class="mt-1.5 block w-full rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-gray-500 focus:outline-none focus:ring-gray-200 sm:text-sm">
              @error('area')
              <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-span-6 sm:col-span-6 lg:col-span-2">
              <label for="city" class="block text-sm font-medium text-gray-700">City</label>
              <input oninput="validateNameInput(this)" type="text" value="{{ $data['city'] ?? '' }}" name="city" id="city" autocomplete="address-level2"
                class="mt-1.5 block w-full rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-gray-500 focus:outline-none focus:ring-gray-200 sm:text-sm">
              @error('city')
              <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
              @enderror
            </div>

            <div class="col-span-6 sm:col-span-3 lg:col-span-2">
              <label for="State" class="block text-sm font-medium text-gray-700">State</label>
              <input oninput="validateNameInput(this)" type="text" value="{{ $data['state'] ?? '' }}" name="State" id="State"
                autocomplete="address-level1"
                class="mt-1.5 block w-full rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-gray-500 focus:outline-none focus:ring-gray-200 sm:text-sm">
              @error('State')
              <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
              @enderror
            </div>

            <div class="col-span-6 sm:col-span-3 lg:col-span-2">
              <label for="zip" class="block text-sm font-medium text-gray-700">ZIP / Postal code</label>
              <input type="text" value="{{ $data['zip'] ?? '' }}" name="zip" id="zip" autocomplete="zip"
              onkeypress="return event.charCode >= 48 && event.charCode <= 57" maxlength="10"
                class="mt-1.5 block w-full rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-gray-500 focus:outline-none focus:ring-gray-200 sm:text-sm">
              @error('zip')
              <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
              @enderror
            </div>

            <div class="col-span-6 sm:col-span-3 lg:col-span-2">
              <label for="country_of_residence" class="block text-sm font-medium text-gray-700">Country</label>
              <input oninput="validateNameInput(this)" type="text" value="{{ $data['country_of_residence'] ?? '' }}" name="country_of_residence"
                id="country_of_residence" autocomplete="address-level1"
                class="mt-1.5 block w-full rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-gray-500 focus:outline-none focus:ring-gray-200 sm:text-sm">
              @error('country_of_residence')
              <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
              @enderror
            </div>

            <div class="col-span-6 sm:col-span-2">
              <label for="firstname" class="block text-sm font-medium text-gray-700">Gender</label>
              <select name="gender"
                class="mt-1.5 block w-full rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-gray-500 focus:outline-none focus:ring-gray-200 sm:text-sm">
                <option value="Not Applicable" {{ isset($data['gender']) && $data['gender']=='Not Applicable'
                  ? 'selected' : '' }}>Not Applicable</option>
                <option value="Male" {{ isset($data['gender']) && $data['gender']=='Male' ? 'selected' : '' }}>Male
                </option>
                <option value="Female" {{ isset($data['gender']) && $data['gender']=='Female' ? 'selected' : '' }}>
                  Female</option>
              </select>
              @error('gender')
              <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-span-6 sm:col-span-2">
              <label for="wedding_date" class="block text-sm font-medium text-gray-700">Wedding Date</label>
              <input
              max="{{ date('Y-m-d') }}"
                value="{{ isset($data['wedding_date']) ? \Carbon\Carbon::parse($data['wedding_date'])->format('Y-m-d') : '' }}"
                type="date" name="wedding_date" id="wedding_date" autocomplete="wedding_date"
                class="cursor-pointer mt-1.5 block w-full rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-gray-500 focus:outline-none focus:ring-gray-200 sm:text-sm">
              @error('wedding_date')
              <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-span-6 sm:col-span-2">
              <label for="marital_status" class="block text-sm font-medium text-gray-700">Marital Status</label>
              <select name="marital_status"
                class="mt-1.5 block w-full rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-gray-500 focus:outline-none focus:ring-gray-200 sm:text-sm">
                <option {{ isset($data['marital_status']) && $data['marital_status']=='Single' ? 'selected' : '' }}
                  value="Single">Single</option>
                <option {{ isset($data['marital_status']) && $data['marital_status']=='Married' ? 'selected' : '' }}
                  value="Married">Married</option>
                <option {{ isset($data['marital_status']) && $data['marital_status']=='Divorced' ? 'selected' : '' }}
                  value="Divorced">Divorced</option>
                <option {{ isset($data['marital_status']) && $data['marital_status']=='Widowed' ? 'selected' : '' }}
                  value="Widowed">Widowed</option>

              </select>
              @error('marital_status')
              <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
              @enderror
            </div>

            <div class="col-span-6 sm:col-span-2 relative">
              <label for="nationality" class="block text-sm font-medium text-gray-700">Nationality</label>
              <input type="text" value="{{ $data['nationality'] ?? old('nationality') ?? '' }}" name="nationality"
                id="countries" autocomplete="address-level1"
                class="mt-1.5 block w-full rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-gray-500 focus:outline-none focus:ring-gray-200 sm:text-sm">
              @include('countries-drop-down.countries')
              @error('nationality')
              <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
              @enderror
            </div>
            {{-- currently we don't need --}}
            {{-- <div class="col-span-6 sm:col-span-2">
              <label for="religion" class="block text-sm font-medium text-gray-700">Religion</label>
              <select name="religion"
                class="mt-1.5 block w-full rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-gray-500 focus:outline-none focus:ring-gray-200 sm:text-sm">
                <option value="">Select</option>
                <option {{ isset($data['religion']) && $data['religion']=='Hinduism' ? 'selected' : '' }}
                  value="Hinduism">Hinduism</option>
                <option {{ isset($data['religion']) && $data['religion']=='Christianity' ? 'selected' : '' }}
                  value="Christianity">Christianity</option>
                <option {{ isset($data['religion']) && $data['religion']=='Islam' ? 'selected' : '' }} value="Islam">
                  Islam</option>
                <option {{ isset($data['religion']) && $data['religion']=='Judaism' ? 'selected' : '' }}
                  value="Judaism">Judaism</option>
                <option {{ isset($data['religion']) && $data['religion']=='Buddhism' ? 'selected' : '' }}
                  value="Buddhism">Buddhism</option>
              </select>
              @error('religion')
              <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
              @enderror
            </div> --}}

          </div>
        </div>
        <div class="bg-gray-100 px-4 py-3 text-right sm:px-6">
          <a href="{{ route('profile') }}"
            class="bg-gray-200 mr-4 text-black inline-flex justify-center rounded-md border border-transparent  py-2 px-10 text-sm font-medium  shadow-sm hover:bg-gray-300 cursor-pointer focus:outline-none focus:ring-2 focus:ring-gray-200 focus:ring-offset-2">Back</a>
          <button id="submit"
            class="app-bg-color inline-flex justify-center rounded-md border border-transparent  py-2 px-10 text-sm font-medium text-white shadow-sm hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-gray-200 focus:ring-offset-2">Update</button>
        </div>
      </div>
      <input type="hidden" name="image_removed" id="image_removed" value="">

    </form>
  </div>
</div>
@include('countries-drop-down.countries-js')
@include('Auth.js.js')
<script>
 
  $('#image_removed').val('');
</script>
@include('loader.loader')
@include('Auth.js.email-mobile-validation')
@endsection