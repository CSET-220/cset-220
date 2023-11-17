@extends('layouts.app')

@section('title')
    Wrinkly Ranch - Elderly Care Management
@endsection

{{-- @section('navLink')
    
@endsection --}}

@section('pageHeader')
    {{-- HEADER --}}
    <div class="bg-gradient-to-r from-gray-700 to-gray-900 text-white py-10 w-full">
        <div class="container mx-auto text-center">
            <h1 class="text-4xl font-bold mb-4">Welcome to Wrinkly Ranch</h1>
            <p class="text-lg">Providing care for the elderly since 2023.</p>

            <a href="#about" class="bg-white text-blue-700 px-6 py-3 rounded-full mt-8 inline-block hover:bg-gray-200 transition duration-300 ease-in-out focus:outline-none focus:ring focus:border-blue-300">Learn More</a>
        </div>
    </div>
    {{--  --}}
@endsection


@section('mainContent')
<div class="flex flex-col mt-0 h-full w-full relative">
    {{-- About Section --}}
    <img src="https://bloximages.newyork1.vip.townnews.com/lancasteronline.com/content/tncms/assets/v3/editorial/6/1e/61eb14e8-fd7d-11e8-bc4d-2b789ec64ff5/5c1013f709321.image.jpg?resize=737%2C500" alt="" class="h-96" srcset="">
        <div style="background-image: url();" id="about" class="py-16 bg-no-repeat bg-cover bg-center">
            <div class="text-center">
                <h2 class="text-3xl font-bold mb-4">About Wrinkly Ranch</h2>
                <p class="text-lg text-gray-700">Words words words old people words words. Words words words old people words words words words words old people words words words words words old people words words.</p>
            </div>
        </div>
    {{--  --}}

    {{-- Services --}}
        <div class="py-16">
            <div class="container mx-auto text-center">
                <h2 class="text-3xl font-bold mb-8">Our Services</h2>
                <div class="flex flex-wrap justify-center">
                    {{-- Service --}}
                    <div class="flex flex-col justify-between bg-cover bg-center p-8 rounded-lg shadow-md mx-4 my-8 flex-shrink-0 flex-grow-0 w-72 h-96 hover:shadow-xl transition-all duration-300">
                        <h3 class="text-xl font-bold mb-4">Personalized Care</h3>
                        <p class="text-gray-700">We offer plans to meet the needs of each resident.</p>
                    </div>

                    <!-- Service -->
                    <div style="background-image: url('https://www.medline.com/wp-content/uploads/2022/12/BAN_Standardized-Pink_WEB_RGB-800x501-1.png')" class="flex flex-col justify-between bg-contain bg-no-repeat bg-center p-8 rounded-lg shadow-md mx-4 my-8 flex-shrink-0 flex-grow-0 w-72 h-96 hover:shadow-xl transition-all duration-300">
                        <h3 class="text-xl font-bold mb-4">Daily Logs</h3>
                        <p class="text-gray-700 rounded-md bg-white shadow-md">Never forget breakfast again!</p>
                    </div>

                    <!-- Service -->
                    <div style="background-image: url('https://static.timesofisrael.com/www/uploads/2020/01/iStock-1131485105-e1580044863445.jpg')" class="flex flex-col justify-between bg-cover bg-center p-8 rounded-lg shadow-md mx-4 my-8 flex-shrink-0 flex-grow-0 w-72 h-96 hover:shadow-xl transition-all duration-300">
                        <h3 class="text-xl font-bold mb-4">Medical Assistance</h3>
                        <p class="text-gray-700 rounded-md bg-white shadow-md">Our staff never sleeps. 24/7 medical care 7 days a week.</p>
                    </div>
                </div>
            </div>
        </div>
    {{--  --}}

    {{-- Login --}}
        <div id="login-modal" aria-hidden="true"  class="hidden overflow-y-auto overflow-x-hidden fixed inset-0 flex top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <!-- Modal content -->
                <div class="relative bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-white">Sign In To Wrinkly Ranch</h3>
            
                        <button type="button" class="end-2.5 text-gray-400 bg-transparent rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center hover:bg-gray-600 hover:text-white" data-modal-hide="login-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                
                    {{-- Modal FORM --}}
                    <div class="p-4 md:p-5">
                        <form action="{{ route('app.login') }}" method="post" class="space-y-4">

                            {{-- EMAIL --}}
                            <div>
                                <label for="email" class="block mb-2 text-sm font-medium text-white">Your email</label>
                                <input type="email" name="email" id="email" class=" border text-sm rounded-lg  focus:border-blue-500 block w-full p-2.5 bg-gray-600  placeholder-gray-400 text-white @error('email') border-red-500 @enderror border-gray-500" placeholder="name@email.com" required>
                                @error('email')
                                    <p class="text-xs text-red-500">{{ $errors->first('email') }}</p>
                                @enderror
                            </div>

                            {{-- PASSWORD --}}
                            <div>
                                <label for="password" class="block mb-2 text-sm font-medium text-white">Your password</label>
                                <input type="password" name="password" id="password" placeholder="Password" class="border text-sm rounded-lg  focus:border-blue-500 block w-full p-2.5 bg-gray-600  placeholder-gray-400 text-white @error('email') border-red-500 @enderror border-gray-500" required>
                                @error('password')
                                    <p class="text-xs text-red-500">{{ $errors->first('password') }}</p>
                                @enderror
                            </div>

                            {{-- REMEMBER ME --}}
                            <div class="flex justify-between">
                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input id="remember" type="checkbox" name="remember" value="1" class="w-4 h-4 border rounded  focus:ring-3  bg-gray-600 border-gray-500 focus:ring-blue-600 ring-offset-gray-800 focus:ring-offset-gray-800">
                                    </div>
                                    <label for="remember" class="ms-2 text-sm font-medium text-gray-300">Remember me</label>
                                </div>
                            </div>

                            {{-- LOGIN SUBMIT --}}
                            <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Login to your account</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    {{--  --}}


    {{-- Register --}}
        <div id="register" class="py-16">
            <h2 class="text-3xl font-bold mb-8 text-center">Do you or a Family Member Need Our Help?</h2>
            <div class=" w-1/2 mx-auto">
                <form class="p-8 rounded-lg shadow-lg bg-gray-300">

                    <div class="relative z-0 w-full mb-6 group">
                        <input type="email" name="register_email" id="register_email" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                        <label for="register_email" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Email address</label>
                    </div>


                    <div class="relative z-0 w-full mb-6 group">
                        <input type="password" name="register_password" id="register_password" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                        <label for="register_password" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Password</label>
                    </div>


                    <div class="relative z-0 w-full mb-6 group">
                        <input type="password" name="repeat_password" id="register_repeat_password" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                        <label for="register_repeat_password" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Confirm password</label>
                    </div>


                    <div class="grid md:grid-cols-2 md:gap-6">
                        <div class="relative z-0 w-full mb-6 group">
                            <input type="text" name="register_first_name" id="register_first_name" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                            <label for="register_first_name" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">First name</label>
                        </div>

                        <div class="relative z-0 w-full mb-6 group">
                            <input type="text" name="register_last_name" id="register_last_name" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                            <label for="register_last_name" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Last name</label>
                        </div>
                    </div>


                    <div class="grid md:grid-cols-2 md:gap-6">
                        <div class="relative z-0 w-full mb-6 group">
                            <input type="tel" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" name="register_phone" id="register_phone" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                            <label for="register_phone" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Phone number (123-456-7890)</label>
                        </div>
                        <div class="relative z-0 w-full mb-6 group">
                            <div class="relative max-w-sm">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                   <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                      <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                    </svg>
                                </div>
                                <input datepicker datepicker-autohide datepicker-buttons datepicker-format="yyyy/mm/dd" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date">
                              </div>
                        </div>
                    </div>
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                </form>
            </div>
        </div>
    {{--  --}}
</div>


@endsection

@section('script')
<script>
    jQuery(document).ready(function () {

        @if ($errors->has('email'))
            console.log('ERRORS PRESENT')
            jQuery(function($){ $("#login-modal").removeClass('hidden'); }) 
        @endif

    });
    
</script>
@endsection
