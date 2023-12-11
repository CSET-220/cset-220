    {{-- GETS FAMILY MEMBER INITIALS FOR POPOVER --}}
<div>
    @if(count($user_info->patient->families) < 1)
    @else
        <div class="flex items-center space-x-2 font-semibold text-gray-900 leading-8">
            <span clas="text-green-500">
                <svg xmlns="http://www.w3.org/2000/svg" height="16" width="20" viewBox="0 0 640 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.--><path d="M72 88a56 56 0 1 1 112 0A56 56 0 1 1 72 88zM64 245.7C54 256.9 48 271.8 48 288s6 31.1 16 42.3V245.7zm144.4-49.3C178.7 222.7 160 261.2 160 304c0 34.3 12 65.8 32 90.5V416c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V389.2C26.2 371.2 0 332.7 0 288c0-61.9 50.1-112 112-112h32c24 0 46.2 7.5 64.4 20.3zM448 416V394.5c20-24.7 32-56.2 32-90.5c0-42.8-18.7-81.3-48.4-107.7C449.8 183.5 472 176 496 176h32c61.9 0 112 50.1 112 112c0 44.7-26.2 83.2-64 101.2V416c0 17.7-14.3 32-32 32H480c-17.7 0-32-14.3-32-32zm8-328a56 56 0 1 1 112 0A56 56 0 1 1 456 88zM576 245.7v84.7c10-11.3 16-26.1 16-42.3s-6-31.1-16-42.3zM320 32a64 64 0 1 1 0 128 64 64 0 1 1 0-128zM240 304c0 16.2 6 31 16 42.3V261.7c-10 11.3-16 26.1-16 42.3zm144-42.3v84.7c10-11.3 16-26.1 16-42.3s-6-31.1-16-42.3zM448 304c0 44.7-26.2 83.2-64 101.2V448c0 17.7-14.3 32-32 32H288c-17.7 0-32-14.3-32-32V405.2c-37.8-18-64-56.5-64-101.2c0-61.9 50.1-112 112-112h32c61.9 0 112 50.1 112 112z"/></svg>            </span>
            <span class="tracking-wide">Your Family</span>
        </div>
        <div class="flex justify-around my-2">
            @foreach ($user_info->patient->families as $fam)
                @php
                    $names = explode(' ', $fam->user->full_name);
                    $initials = '';
                    foreach ($names as $name) {
                        $initials .= strtoupper(substr($name, 0, 1));
                    }
                @endphp
                @if ($fam->user->profile_pic)
                    <img data-popover-target="popover-patient-caregiver-{{ $fam->family_id }}" src="{{ asset($fam->user->profile_pic) }}" alt="" srcset="" class="w-8 h-8 rounded-full cursor-pointer ">
                @else
                    <div data-popover-target="popover-patient-caregiver-{{ $fam->family_id }}" class=" cursor-pointer relative inline-flex items-center justify-center w-8 h-8 overflow-hidden rounded-full bg-blue-600 hover:shadow-md">
                        <span class="font-medium text-gray-300">{{ $initials }}</span>
                    </div>
                @endif
        
                <div data-popover id="popover-patient-caregiver-{{ $fam->family_id }}" role="tooltip" class="absolute z-10 invisible inline-block w-64 text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:bg-gray-800 dark:border-gray-600">
                    <div class="p-3">
                        <div class="flex items-center justify-between mb-2">
                            @if ($fam->user->profile_pic)
                                <img src="{{ asset($fam->user->profile_pic) }}" alt="" srcset="" class="w-8 h-8 rounded-full cursor-pointer ">
                            @else
                                <div class=" cursor-pointer relative inline-flex items-center justify-center w-8 h-8 overflow-hidden rounded-full bg-blue-600">
                                    <span class="font-medium text-gray-300">{{ $initials }}</span>
                                </div>
                            @endif
                            <p>{{ $user_info->patient->contact_relation }}</p>
                            <div>
                                <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-xs px-3 py-1.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Call</button>
                            </div>
                        </div>
                        <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">
                            <a href="#">{{ $fam->user->full_name }}</a>
                        </p>
                        <p class="mb-3 text-sm font-normal">
                            <a class="hover:underline">{{ $fam->user->email }}</a>
                        </p>
                        <p class="mb-4 text-sm">Contact: <a href="#" class="text-blue-600 dark:text-blue-500 hover:underline">{{ $fam->user->phone }}</a>.</p>
                        
                    </div>
                    <div data-popper-arrow></div>
                </div>
                
            @endforeach

        </div>
    @endif

</div>
