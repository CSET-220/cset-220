<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    @vite('resources/css/app.css')
</head>
<body class="min-h-screen flex flex-col">


    {{-- NAV --}}
        <nav class="bg-gray-200 bg-gradient-to-r from-gray-700 to-gray-900 p-4">
            <div class="container mx-auto flex justify-around items-center">
                <a href="/" class="logo text-lg font-bold text-white">Wrinkly Ranch</a>
                <div class="flex space-x-2">
                    <a href="/" class="text-gray-400 pb-1 hover:text-white border-0 hover:border-b-2 transition-all duration-200">Home</a>
                    <a href="#" class="text-gray-400 pb-1 hover:text-white border-0 hover:border-b-2 transition-all duration-200">LINK</a>
                    @yield('navLink')
                </div>
            </div>
        </nav>
    {{--  --}}
    

    

    {{-- MAIN BODY CONTENT --}}
        <div class="flex-grow flex justify-center items-center mx-auto min-h-full w-full">
            @yield('mainContent')

            <form action="{{ route('app.login') }}" method="post" class="flex flex-col shadow-lg">
                <input type="text" name="email" placeholder="Email" class="mb-4 rounded-md p-4 shadow-md border border-gray-300 focus:outline-blue-500 hover:shadow-lg @error('email') outline-red-500 @enderror" id="">
                <input type="password" name="password" placeholder="Password" class="mb-4 rounded-md p-4 shadow-md border border-gray-300 focus:outline-blue-500 hover:shadow-lg @error('password') outline-red-500 @enderror" id="">
                <input type="submit" value="Login" class="p-4 rounded-md shadow-md border-1 border-gray-300 hover:text-white hover:bg-blue-500 hover:shadow-lg transition-all duration-300 ">
            </form>

        </div>
    {{--  --}}



    {{-- FOOTER --}}
        <footer class="bg-gray-700 flex p-4 text-center justify-center items-center">
            <p class="text-white">© 2023 Dave Drummond; David Leach; Ryan Short; Chris Wright</p>
        </footer>
    {{--  --}}
    
</body>
    {{-- @yield('script') --}}
</html>
