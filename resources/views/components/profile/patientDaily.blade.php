@php
    if (count($user_info->patient->logs) > 0) {
        $log = $user_info->patient->logs->first();
    }
    else {
        $log = null;
    }
    if (count($user_info->lastApt) > 0) {
        $prevApt = $user_info->lastApt[0];
    } else {
        $prevApt = null;
    }
@endphp
<div  class="h-full flex flex-col justify-between">
@if ($log)
    <div class="p-2 pb-4 rounded-sm">
        <div class="flex items-center space-x-2 font-semibold text-gray-900 leading-8">
            <span clas="text-green-500">
                <svg xmlns="http://www.w3.org/2000/svg" height="16" width="14" viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.--><path d="M128 0c17.7 0 32 14.3 32 32V64H288V32c0-17.7 14.3-32 32-32s32 14.3 32 32V64h48c26.5 0 48 21.5 48 48v48H0V112C0 85.5 21.5 64 48 64H96V32c0-17.7 14.3-32 32-32zM0 192H448V464c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V192zm64 80v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V272c0-8.8-7.2-16-16-16H80c-8.8 0-16 7.2-16 16zm128 0v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V272c0-8.8-7.2-16-16-16H208c-8.8 0-16 7.2-16 16zm144-16c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V272c0-8.8-7.2-16-16-16H336zM64 400v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V400c0-8.8-7.2-16-16-16H80c-8.8 0-16 7.2-16 16zm144-16c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V400c0-8.8-7.2-16-16-16H208zm112 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V400c0-8.8-7.2-16-16-16H336c-8.8 0-16 7.2-16 16z"/></svg>
            </span>
            <span class="tracking-wide">Todays Log: {{ date('F d, Y', strToTime($log->date)) }} - {{ $log->caregiver->full_name }}</span>
        </div>
    </div>
    <ol class="items-center sm:flex justify-center">

        <li class="relative mb-6 sm:mb-0">
            <div class="flex items-center">
                @if ($log->breakfast)
                    <div data-popover-target="log-breakfast-{{ $log->id }}" class="z-0 flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full ring-0 ring-white dark:bg-blue-900 sm:ring-8 dark:ring-gray-900 shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" height="16" width="16" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.--><path fill="#1eff00" d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z"/></svg>
                    </div>
                    <div class="hidden sm:flex w-full bg-green-500 h-0.5"></div>
                @else
                    <div data-popover-target="log-breakfast-{{ $log->id }}" class="z-0 flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full ring-0 ring-white dark:bg-blue-900 sm:ring-8 dark:ring-gray-900 shrink-0">
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
                    <div data-popover-target="log-lunch-{{ $log->id }}" class="z-10 flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full ring-0 ring-white dark:bg-blue-900 sm:ring-8 dark:ring-gray-900 shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" height="16" width="16" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.--><path fill="#1eff00" d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z"/></svg>
                    </div>
                    <div class="hidden sm:flex w-full bg-green-500 h-0.5"></div>
                @else
                    <div data-popover-target="log-lunch-{{ $log->id }}" class="z-10 flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full ring-0 ring-white dark:bg-blue-900 sm:ring-8 dark:ring-gray-900 shrink-0">
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
                    <div data-popover-target="log-dinner-{{ $log->id }}" class="z-10 flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full ring-0 ring-white dark:bg-blue-900 sm:ring-8 dark:ring-gray-900 shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" height="16" width="16" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.--><path fill="#1eff00" d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z"/></svg>
                    </div>
                    <div class="hidden sm:flex w-full bg-green-500 h-0.5"></div>
                @else
                    <div data-popover-target="log-dinner-{{ $log->id }}" class="z-100 flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full ring-0 ring-white dark:bg-blue-900 sm:ring-8 dark:ring-gray-900 shrink-0">
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
@else
    <div class="p-2 pb-4 rounded-sm">
        <div class="flex items-center space-x-2 font-semibold text-gray-900 leading-8">
            <span clas="text-green-500">
                <svg xmlns="http://www.w3.org/2000/svg" height="16" width="14" viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.--><path d="M128 0c17.7 0 32 14.3 32 32V64H288V32c0-17.7 14.3-32 32-32s32 14.3 32 32V64h48c26.5 0 48 21.5 48 48v48H0V112C0 85.5 21.5 64 48 64H96V32c0-17.7 14.3-32 32-32zM0 192H448V464c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V192zm64 80v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V272c0-8.8-7.2-16-16-16H80c-8.8 0-16 7.2-16 16zm128 0v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V272c0-8.8-7.2-16-16-16H208c-8.8 0-16 7.2-16 16zm144-16c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V272c0-8.8-7.2-16-16-16H336zM64 400v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V400c0-8.8-7.2-16-16-16H80c-8.8 0-16 7.2-16 16zm144-16c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V400c0-8.8-7.2-16-16-16H208zm112 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V400c0-8.8-7.2-16-16-16H336c-8.8 0-16 7.2-16 16z"/></svg>
            </span>
            <span class="tracking-wide">No Logs Yet</span>
        </div>
    </div>
@endif



        {{-- GETS PATIENT UPCOMING APPOINTMENTS --}}
        <div class="mt-1">
            <div class="flex items-center space-x-2 font-semibold text-gray-900 leading-8">
                <span clas="text-green-500">
                    <svg xmlns="http://www.w3.org/2000/svg" height="16" width="14" viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.--><path d="M128 0c17.7 0 32 14.3 32 32V64H288V32c0-17.7 14.3-32 32-32s32 14.3 32 32V64h48c26.5 0 48 21.5 48 48v48H0V112C0 85.5 21.5 64 48 64H96V32c0-17.7 14.3-32 32-32zM0 192H448V464c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V192zm64 80v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V272c0-8.8-7.2-16-16-16H80c-8.8 0-16 7.2-16 16zm128 0v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V272c0-8.8-7.2-16-16-16H208c-8.8 0-16 7.2-16 16zm144-16c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V272c0-8.8-7.2-16-16-16H336zM64 400v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V400c0-8.8-7.2-16-16-16H80c-8.8 0-16 7.2-16 16zm144-16c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V400c0-8.8-7.2-16-16-16H208zm112 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V400c0-8.8-7.2-16-16-16H336c-8.8 0-16 7.2-16 16z"/></svg>
                </span>
                <span class="tracking-wide">Upcoming Appointments</span>
            </div>
            <div class="flex justify-evenly w-full mt-4">
                @if (count($user_info->patient->appointments) < 1)
                    <p class="text-blue-500">No Appointments</p>
                @endif
                
                @foreach ($user_info->patient->appointments as $appointment)
                    {{-- <p>{{ $appointment->doctor->full_name }}</p> --}}
                    @php
                        $drNames = explode(' ', $appointment->doctor->full_name);
                        $drInitials = '';
                        foreach ($drNames as $name) {
                            $drInitials .= strtoupper(substr($name, 0, 1));
                        }
                    @endphp
                    @if ($appointment->doctor->profile_pic)
                        <img data-popover-target="popover-doctor-{{ $drInitials }}" src="{{ asset($appointment->doctor->profile_pic) }}" alt="" srcset="" class="w-8 h-8 rounded-full cursor-pointer ">
                    @endif
                    <div data-popover-target="popover-doctor-{{ $drInitials }}" class=" cursor-pointer relative inline-flex items-center justify-center w-8 h-8 overflow-hidden rounded-full bg-blue-600">
                        <span class="font-medium text-gray-300">{{ $drInitials }}</span>
                    </div>
    
                    <div data-popover id="popover-doctor-{{ $drInitials }}" role="tooltip" class="absolute z-10 invisible inline-block w-64 text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:bg-gray-800 dark:border-gray-600">
                        <div class="p-3">
                            <div class="flex items-center justify-between mb-2">
                                <div class=" cursor-pointerrelative inline-flex items-center justify-center w-8 h-8 overflow-hidden rounded-full bg-blue-600">
                                    <span class="font-medium text-gray-300">{{ $initials }}</span>
                                </div>
                                <p>Doctor</p>
                                <div>
                                    <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-xs px-3 py-1.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Call</button>
                                </div>
                            </div>
                            <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">
                                <a href="#">{{ $appointment->doctor->full_name }}</a>
                            </p>
                            <p class="mb-3 text-sm font-normal">
                                <a class="hover:underline">{{ $appointment->doctor->email }}</a>
                            </p>
                            <p class="mb-4 text-sm">Appointment On <a class="text-blue-600 dark:text-blue-500 hover:underline">{{ date('F d, Y', strToTime($appointment->date)) }}</a>.</p>
                            
                        </div>
                        <div data-popper-arrow></div>
                    </div>
                @endforeach
            </div>
        </div>

    @if ($log)
        {{-- POPOVERS --}}
        <div data-popover id="log-breakfast-{{ $log->id }}" role="tooltip" class="absolute overflow-visible z-50 invisible inline-block w-64 text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:border-gray-600 dark:bg-gray-800">
            <div class="px-3 py-2  border-b border-gray-200 rounded-t-lg dark:border-gray-600 bg-gray-700">
                <h3 class="font-semibold text-white">Morning RX</h3>
            </div>
            <div class="px-3 py-2 flex flex-col">
                @if ($prevApt)
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
                @else
                    <h1 class="font-bold">N/A</h1>
                @endif
            </div>
            <div data-popper-arrow></div>
        </div>


        {{-- AFTERNOON --}}
        <div data-popover id="log-lunch-{{ $log->id }}" role="tooltip" class="absolute overflow-visible z-50 invisible inline-block w-64 text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:border-gray-600 dark:bg-gray-800">
            <div class="px-3 py-2  border-b border-gray-200 rounded-t-lg dark:border-gray-600 bg-gray-700">
                <h3 class="font-semibold text-white">Afternoon RX</h3>
            </div>
            <div class="px-3 py-2 flex flex-col">
                @if($prevApt)
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
                @else
                    <h1 class="font-bold">N/A</h1>
                @endif
            </div>
            <div data-popper-arrow></div>
        </div>


        {{-- NIGHT --}}
        <div data-popover id="log-dinner-{{ $log->id }}" role="tooltip" class="absolute overflow-visible z-50 invisible inline-block w-64 text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:border-gray-600 dark:bg-gray-800">
            <div class="px-3 py-2  border-b border-gray-200 rounded-t-lg dark:border-gray-600 bg-gray-700">
                <h3 class="font-semibold text-white">Night RX</h3>
            </div>
            <div class="px-3 py-2 flex flex-col">
                @if ($prevApt)
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
                @else
                    <h1 class="font-bold">N/A</h1>
                @endif
            </div>
            <div data-popper-arrow></div>
        </div>
        
    @endif


</div>

