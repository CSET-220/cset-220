<div class="flex flex-col h-full justify-between">
    <div class="flex flex-col">
        <div class="flex items-center justify-between space-x-2 font-semibold text-gray-900 leading-8">
            <div class="flex items-center space-x-2">
                <span clas="text-green-500">
                    <svg xmlns="http://www.w3.org/2000/svg" height="16" width="20" viewBox="0 0 640 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.--><path d="M72 88a56 56 0 1 1 112 0A56 56 0 1 1 72 88zM64 245.7C54 256.9 48 271.8 48 288s6 31.1 16 42.3V245.7zm144.4-49.3C178.7 222.7 160 261.2 160 304c0 34.3 12 65.8 32 90.5V416c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V389.2C26.2 371.2 0 332.7 0 288c0-61.9 50.1-112 112-112h32c24 0 46.2 7.5 64.4 20.3zM448 416V394.5c20-24.7 32-56.2 32-90.5c0-42.8-18.7-81.3-48.4-107.7C449.8 183.5 472 176 496 176h32c61.9 0 112 50.1 112 112c0 44.7-26.2 83.2-64 101.2V416c0 17.7-14.3 32-32 32H480c-17.7 0-32-14.3-32-32zm8-328a56 56 0 1 1 112 0A56 56 0 1 1 456 88zM576 245.7v84.7c10-11.3 16-26.1 16-42.3s-6-31.1-16-42.3zM320 32a64 64 0 1 1 0 128 64 64 0 1 1 0-128zM240 304c0 16.2 6 31 16 42.3V261.7c-10 11.3-16 26.1-16 42.3zm144-42.3v84.7c10-11.3 16-26.1 16-42.3s-6-31.1-16-42.3zM448 304c0 44.7-26.2 83.2-64 101.2V448c0 17.7-14.3 32-32 32H288c-17.7 0-32-14.3-32-32V405.2c-37.8-18-64-56.5-64-101.2c0-61.9 50.1-112 112-112h32c61.9 0 112 50.1 112 112z"/></svg>            </span>
                <span class="tracking-wide">Your Family</span>
            </div>
            <div>
                <button data-popover-target="add_family" id="show_patient_search" type="button" class="text-white focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center me-2 ">
                        <svg xmlns="http://www.w3.org/2000/svg" height="16" width="20" viewBox="0 0 640 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.--><path d="M96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3zM504 312V248H440c-13.3 0-24-10.7-24-24s10.7-24 24-24h64V136c0-13.3 10.7-24 24-24s24 10.7 24 24v64h64c13.3 0 24 10.7 24 24s-10.7 24-24 24H552v64c0 13.3-10.7 24-24 24s-24-10.7-24-24z"/></svg>
                    <span class="sr-only">Icon description</span>
                </button>
                <div data-popover id="add_family" role="tooltip" class="absolute w-fit z-10 invisible inline-block w-64 text-sm transition-opacity duration-300 border  rounded-lg shadow-sm opacity-0 text-gray-400 border-gray-600 bg-gray-800">
                    <div class="px-3 py-2 border-b rounded-t-lg border-gray-600 bg-gray-700">
                        <h3 class="font-semibold text-white">Add Family</h3>
                    </div>
                    
                    <div data-popper-arrow></div>
                </div>
            </div>
        </div>
        <div id="patient_search_form" class="hidden">
            <div class="">
                <form class="flex justify-between" action="{{ route('family.dashboard.connect', ['user' =>Auth::user()]) }}" method="GET" id="fam_code_form">
                    <div class="relative z-0 w-1/2">
                        <input type="number" id="patient_id_search" class="block py-1.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                        <label for="patient_id_search" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">Enter Patient ID</label>
                    </div>  
                    <div class="relative w-1/2">
                        <div class="relative z-0">
                            <input type="text" id="fam_code_search" data-family-id="{{ Auth::id() }}" name="fam_code_search" class="block py-1.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                            <label for="fam_code_search" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">Search For Family With Family Code</label>
                        </div>
                        <button type="submit" id="fam_code_search_btn" class="text-white absolute end-2.5 bottom-1.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-1 py-1 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Search</button>
                    </div>
                </form>
            </div>        
        </div>
    </div>

    @if(count($user_info->families) < 1)
        <p>Search For Family to view Log.</p>
    @else

        <div id="indicators-carousel" class="relative w-full h-40" data-carousel="static">
            <!-- Carousel wrapper -->
            <div class="relative overflow-hidden rounded-lg h-40">
                <!-- Item 1 -->
                <div class="relative hidden duration-700 ease-in-out mb-4" data-carousel-item="">

                </div>
                @foreach ($user_info->families as $index => $fam)
                    @php
                        $patient = $fam->patient;
                        $log = $patient->logs->first();
                        $prevApt = $patient->appointments[0];
                    @endphp
                    <div  class="hidden duration-700 ease-in-out" {{ $index === 0 ? 'data-carousel-item=active' : 'data-carousel-item' }}>
                        <p class="text-left p2"></p>
                        <h1 class="text-xl font-extrabold text-center dark:text-white p-2">Patient: <small class="ms-2 font-semibold text-gray-500 dark:text-gray-400">{{ $patient->user->full_name }}</small></h1>

                        <ol class="items-center sm:flex justify-center px-4">
            
                            <li class="relative mb-6 sm:mb-0">
                                <div class="flex items-center">
                                    @if ($log->breakfast)
                                        <div data-popover-target="family-log-breakfast-{{ $log->id }}" class="z-0 flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full ring-0 ring-white dark:bg-blue-900 sm:ring-8 dark:ring-gray-900 shrink-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="16" width="16" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.--><path fill="#1eff00" d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z"/></svg>
                                        </div>
                                        <div class="hidden sm:flex w-full bg-green-500 h-0.5"></div>
                                    @else
                                        <div data-popover-target="family-log-breakfast-{{ $log->id }}" class="z-0 flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full ring-0 ring-white dark:bg-blue-900 sm:ring-8 dark:ring-gray-900 shrink-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="16" width="16" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.--><path fill="#ff0000" d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM175 175c9.4-9.4 24.6-9.4 33.9 0l47 47 47-47c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9l-47 47 47 47c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0l-47-47-47 47c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l47-47-47-47c-9.4-9.4-9.4-24.6 0-33.9z"/></svg>                
                                        </div>
                                        <div class="hidden sm:flex w-full bg-red-500 h-0.5"></div>
                                    @endif
                                </div>
                                <div class="mt-3 sm:pe-8">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Breakfast</h3>
                                    @if ($log->breakfast)
                                        <p class="text-sm"><span class="font-bold">Status:</span> <span class="text-green-500">Ate</span></p>
                                    @else
                                        <p class="text-sm"><span class="font-bold">Status:</span> <span class="text-red-500">Did not Eat</span></p>
                                    @endif
                                </div>
                            </li>
                        
                            <li class="relative mb-6 sm:mb-0">
                                <div class="flex items-center">
                                    @if ($log->lunch)
                                        <div data-popover-target="family-log-lunch-{{ $log->id }}" class="z-10 flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full ring-0 ring-white dark:bg-blue-900 sm:ring-8 dark:ring-gray-900 shrink-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="16" width="16" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.--><path fill="#1eff00" d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z"/></svg>
                                        </div>
                                        <div class="hidden sm:flex w-full bg-green-500 h-0.5"></div>
                                    @else
                                        <div data-popover-target="family-log-lunch-{{ $log->id }}" class="z-10 flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full ring-0 ring-white dark:bg-blue-900 sm:ring-8 dark:ring-gray-900 shrink-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="16" width="16" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.--><path fill="#ff0000" d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM175 175c9.4-9.4 24.6-9.4 33.9 0l47 47 47-47c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9l-47 47 47 47c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0l-47-47-47 47c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l47-47-47-47c-9.4-9.4-9.4-24.6 0-33.9z"/></svg>                
                                        </div>
                                        <div class="hidden sm:flex w-full bg-red-500 h-0.5"></div>
                                    @endif
                                </div>
                                <div class="mt-3 sm:pe-8">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Lunch</h3>
                                    @if ($log->lunch)
                                        <p class="text-sm"><span class="font-bold">Status:</span> <span class="text-green-500">Ate</span></p>
                                    @else
                                        <p class="text-sm"><span class="font-bold">Status:</span> <span class="text-red-500">Did not Eat</span></p>
                                    @endif
                                </div>
                            </li>
                        
                            <li class="relative mb-6 sm:mb-0">
                                <div class="flex items-center">
                                    @if ($log->dinner)
                                        <div data-popover-target="family-log-dinner-{{ $log->id }}" class="z-10 flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full ring-0 ring-white dark:bg-blue-900 sm:ring-8 dark:ring-gray-900 shrink-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="16" width="16" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.--><path fill="#1eff00" d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z"/></svg>
                                        </div>
                                        <div class="hidden sm:flex w-full bg-green-500 h-0.5"></div>
                                    @else
                                        <div data-popover-target="family-log-dinner-{{ $log->id }}" class="z-100 flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full ring-0 ring-white dark:bg-blue-900 sm:ring-8 dark:ring-gray-900 shrink-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="16" width="16" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.--><path fill="#ff0000" d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM175 175c9.4-9.4 24.6-9.4 33.9 0l47 47 47-47c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9l-47 47 47 47c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0l-47-47-47 47c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l47-47-47-47c-9.4-9.4-9.4-24.6 0-33.9z"/></svg>                
                                        </div>
                                        <div class="hidden sm:flex w-full bg-red-500 h-0.5"></div>
                                    @endif
                                </div>
                                <div class="mt-3 sm:pe-8">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Dinner</h3>
                                    @if ($log->dinner)
                                        <p class="text-sm"><span class="font-bold">Status:</span> <span class="text-green-500">Ate</span></p>
                                    @else
                                        <p class="text-sm"><span class="font-bold">Status:</span> <span class="text-red-500">Did not Eat</span></p>
                                    @endif                                   
                                </div>
                            </li>
                        
                        </ol>
                    </div>
                    
                @endforeach
            </div>

            {{-- POPOVERS --}}
            {{-- MORNING --}}
            <div data-popover id="family-log-breakfast-{{ $log->id }}" role="tooltip" class="absolute overflow-visible z-50 invisible inline-block w-64 text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:border-gray-600 dark:bg-gray-800">
                <div class="px-3 py-2  border-b border-gray-200 rounded-t-lg dark:border-gray-600 bg-gray-700">
                    <h3 class="font-semibold text-white">Morning RX</h3>
                </div>
                <div class="px-3 py-2 flex flex-col">
                    @if ($prevApt->morningPrescriptions)
                        <h1><span class="font-bold">Name:</span> {{ $prevApt->morningPrescriptions->medication_name }}</h1>
                        <h1><span class="font-bold">Dosage:</span> {{ $prevApt->morningPrescriptions->medication_dosage . "mg" }}</h1>
                        @if ($log->morning_med == 0)
                            <h1><span class="font-bold">Status:</span><span class="text-red-500"> Not Taken</span></h1>
                        @elseif ($log->morning_med == 1)
                            <h1><span class="font-bold">Status:</span><span class="text-green-500"> Taken</span></h1>
                        @endif
                    @else
                        N/A
                    @endif
                </div>
                <div data-popper-arrow></div>
            </div>

            {{-- AFTERNOON --}}
            <div data-popover id="family-log-lunch-{{ $log->id }}" role="tooltip" class="absolute overflow-visible z-50 invisible inline-block w-64 text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:border-gray-600 dark:bg-gray-800">
                <div class="px-3 py-2  border-b border-gray-200 rounded-t-lg dark:border-gray-600 bg-gray-700">
                    <h3 class="font-semibold text-white">Afternoon RX</h3>
                </div>
                <div class="px-3 py-2 flex flex-col">
                    @if ($prevApt->afternoonPrescriptions)
                        <h1><span class="font-bold">Name:</span> {{ $prevApt->afternoonPrescriptions->medication_name }}</h1>
                        <h1><span class="font-bold">Dosage:</span> {{ $prevApt->afternoonPrescriptions->medication_dosage . "mg" }}</h1>
                        @if ($log->afternoon_med == 0)
                            <h1><span class="font-bold">Status:</span><span class="text-red-500"> Not Taken</span></h1>
                        @elseif ($log->afternoon_med == 1)
                            <h1><span class="font-bold">Status:</span><span class="text-green-500"> Taken</span></h1>
                        @endif
                    @else
                        N/A
                    @endif
                </div>
                <div data-popper-arrow></div>
            </div>

            {{-- NIGHT --}}
            <div data-popover id="family-log-dinner-{{ $log->id }}" role="tooltip" class="absolute overflow-visible z-50 invisible inline-block w-64 text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:border-gray-600 dark:bg-gray-800">
                <div class="px-3 py-2  border-b border-gray-200 rounded-t-lg dark:border-gray-600 bg-gray-700">
                    <h3 class="font-semibold text-white">Night RX</h3>
                </div>
                <div class="px-3 py-2 flex flex-col">
                    @if ($prevApt->nightPrescriptions)
                        <h1><span class="font-bold">Name:</span> {{ $prevApt->nightPrescriptions->medication_name }}</h1>
                        <h1><span class="font-bold">Dosage:</span> {{ $prevApt->nightPrescriptions->medication_dosage . "mg" }}</h1>
                        @if ($log->night_med == 0)
                            <h1><span class="font-bold">Status:</span><span class="text-red-500"> Not Taken</span></h1>
                        @elseif ($log->night_med == 1)
                            <h1><span class="font-bold">Status:</span><span class="text-green-500"> Taken</span></h1>
                        @endif
                    @else
                        N/A
                    @endif
                </div>
                <div data-popper-arrow></div>
            </div>





            <!-- Slider controls -->
            <button type="button" class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-prev>
                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                    <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
                    </svg>
                    <span class="sr-only">Previous</span>
                </span>
            </button>
            <button type="button" class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-next>
                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                    <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <span class="sr-only">Next</span>
                </span>
            </button>
        </div>
        <div></div>
    @endif
</div>