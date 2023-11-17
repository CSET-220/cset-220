<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    @yield('linkStyles')
    <title>@yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body class="min-h-screen flex flex-col relative">


    {{-- NAV --}}
    <!-- TODO fix conditionals once figured out -->
        <nav class="bg-gray-200 bg-gradient-to-r from-gray-700 to-gray-900 p-4">
            <div class="container mx-auto flex justify-between items-center">
                <a href="/" class="logo text-lg font-bold text-white">Wrinkly Ranch</a>
                <div class="wrapper inline-flex">
                    @auth
                        @if(auth()->user()->getAccess(['admin']))
                            <x-navbar.admin-nav />
                        @elseif(auth()->user()->getAccess(['supervisor']))
                            <x-navbar.supervisor-nav />
                        @elseif(auth()->user()->getAccess(['doctor']))
                            <x-navbar.doctor-nav />
                        @elseif(auth()->user()->getAccess(['caregiver']))
                            <x-navbar.caregiver-nav />
                        @elseif(auth()->user()->getAccess(['patient']))
                            <x-navbar.patient-nav />
                        @elseif(auth()->user()->getAccess(['family']))
                            <x-navbar.family-nav />
                        @endif
                        <div class="mr-2">
                            <!-- TODO change colors -->
                            <button id="dropdownInformationButton" data-dropdown-toggle="dropdownInformation" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">User <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/></svg></button>
                            <!-- Dropdown menu -->
                            <div id="dropdownInformation" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                                <div class="px-4 py-3 text-sm text-gray-900 dark:text-white">
                                    <div>{{Auth::user()->first_name}} {{Auth::user()->last_name}}</div>
                                    <div class="font-medium truncate">{{Auth::user()->email}}</div>
                                </div>
                                <!-- TODO fix hrefs once figured out -->
                                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownInformationButton">
                                    <li>
                                        <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Dashboard</a>
                                    </li>
                                </ul>
                                <div class="py-2">
                                    <a href="{{ route('app.logout') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Sign out</a>
                                </div>
                            </div>
                        </div>
                        @yield('navLink')
                        @else
                        <div class="mr-2">
                            <!-- TODO change colors -->
                            <button data-modal-target="login-modal" data-modal-toggle="login-modal" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Login</button>
                            <a href="#register" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Register</a>
                        </div>
                    @endauth
                </div>
            </div>
        </nav>
    {{--  --}}

        @yield('pageHeader')

    {{-- MAIN BODY CONTENT --}}

        @yield('mainContent')

    {{--  --}}



    {{-- FOOTER --}}
        <footer class="bg-gray-700 flex p-4 text-center justify-center items-center absolute bottom-0 w-full h-20">
            <p class="text-white">© 2023 Dave Drummond; David Leach; Ryan Short; Chris Wright</p>
        </footer>
    {{--  --}}


</body>
    @yield('script')

</html>
