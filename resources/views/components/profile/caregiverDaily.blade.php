<div class="h-full flex flex-col justify-between">
    <div class="p-2 pb-4 rounded-sm">
        <div class="flex items-center space-x-2 font-semibold text-gray-900 leading-8">
            <span clas="text-green-500">
                <svg xmlns="http://www.w3.org/2000/svg" height="16" width="14" viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.--><path d="M128 0c17.7 0 32 14.3 32 32V64H288V32c0-17.7 14.3-32 32-32s32 14.3 32 32V64h48c26.5 0 48 21.5 48 48v48H0V112C0 85.5 21.5 64 48 64H96V32c0-17.7 14.3-32 32-32zM0 192H448V464c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V192zm64 80v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V272c0-8.8-7.2-16-16-16H80c-8.8 0-16 7.2-16 16zm128 0v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V272c0-8.8-7.2-16-16-16H208c-8.8 0-16 7.2-16 16zm144-16c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V272c0-8.8-7.2-16-16-16H336zM64 400v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V400c0-8.8-7.2-16-16-16H80c-8.8 0-16 7.2-16 16zm144-16c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V400c0-8.8-7.2-16-16-16H208zm112 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V400c0-8.8-7.2-16-16-16H336c-8.8 0-16 7.2-16 16z"/></svg>
            </span>
            <span class="tracking-wide">Your Patients For Today</span>
        </div>
    </div>
    <ol class="items-center sm:flex justify-center">
        @if (count($caregiverPatients) < 1)
            <p class="text-center w-full">No Patients Today</p>
        @endif
        @foreach ($caregiverPatients as $patientLog)
        
            <li class="relative mb-6 sm:mb-0">
                <div class="flex items-center">
                    <div data-popover-target="popover-apt-{{ $patientLog->id }}" class="z-10 flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full ring-0 ring-white dark:bg-blue-900 sm:ring-8 dark:ring-gray-900 shrink-0">
                        <svg class="w-2.5 h-2.5 text-blue-800 dark:text-blue-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                        </svg>
                    </div>
                    <div class="hidden sm:flex w-full h-0.5 bg-gray-700"></div>
                </div>
                <div class="mt-3 sm:pe-8">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $patientLog->patient->user->full_name }}</h3>
                    <time class="block mb-2 text-sm font-normal leading-none text-gray-400 dark:text-gray-500"></time>
                    <p class="text-base font-normal text-gray-500 dark:text-gray-400"></p>
                </div>
                <div data-popover id="popover-apt-{{ $patientLog->id }}" role="tooltip" class="absolute z-10 invisible inline-block w-64 text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:border-gray-600 dark:bg-gray-800">
                    <div class="px-3 py-2 bg-gray-100 border-b border-gray-200 rounded-t-lg dark:border-gray-600 dark:bg-gray-700">
                        <h3 class="font-semibold text-gray-900 dark:text-white">Patient: {{ $patientLog->patient->user->full_name }}</h3>
                    </div>
                    <div class="px-3 py-2">
                        <ol class="relative border-s border-gray-700">                  
                            <li class="mb-10 ms-6">            
                                <span class="absolute flex items-center justify-center w-6 h-6 {{ $patientLog->breakfast ? 'bg-blue-100' : 'bg-red-500' }} rounded-full -start-3 ring-8 ring-white dark:ring-gray-900">
                                    <svg class="w-2.5 h-2.5 text-gray-800 dark:text-blue-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                    </svg>
                                </span>
                                <h3 class="flex items-center mb-1 text-lg font-semibold text-gray-900 dark:text-white">Breakfast</h3>
                                <time class="block mb-2 text-sm font-normal leading-none text-gray-400 dark:text-gray-500"></time>
                                <p class="mb-4 text-base font-normal text-gray-500 dark:text-gray-400">{{ $patientLog->breakfast ? 'Taken' : 'Not Taken' }}</p>
                            </li>
                            <li class="mb-10 ms-6">
                                <span class="absolute flex items-center justify-center w-6 h-6 {{ $patientLog->lunch ? 'bg-blue-100 ' : 'bg-red-500' }} rounded-full -start-3 ring-8 ring-white dark:ring-gray-900">
                                    <svg class="w-2.5 h-2.5 text-gray-800 dark:text-blue-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                    </svg>
                                </span>
                                <h3 class="mb-1 text-lg font-semibold text-gray-900 dark:text-white">Lunch</h3>
                                <time class="block mb-2 text-sm font-normal leading-none text-gray-400 dark:text-gray-500"></time>
                                <p class="text-base font-normal text-gray-500 dark:text-gray-400">{{ $patientLog->lunch ? 'Taken' : 'Not Taken' }}</p>
                            </li>
                            <li class="ms-6">
                                <span class="absolute flex items-center justify-center w-6 h-6 {{ $patientLog->dinner ? 'bg-blue-100 ' : 'bg-red-500' }} rounded-full -start-3 ring-8 ring-white dark:ring-gray-900">
                                    <svg class="w-2.5 h-2.5 text-gray-800 dark:text-blue-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                    </svg>
                                </span>
                                <h3 class="mb-1 text-lg font-semibold text-gray-900 dark:text-white">Dinner</h3>
                                <time class="block mb-2 text-sm font-normal leading-none text-gray-400 dark:text-gray-500"></time>
                                <p class="text-base font-normal text-gray-500 dark:text-gray-400">{{ $patientLog->dinner ? 'Taken' : 'Not Taken' }}</p>
                            </li>
                        </ol>
                    </div>
                    <div data-popper-arrow></div>
                </div>
            </li>
        @endforeach
    </ol>
    <div></div>
</div>