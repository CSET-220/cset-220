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
                        <label for="login_email" class="block mb-2 text-sm font-medium text-white">Your email</label>
                        <input type="email" name="login_email" id="login_email" class=" border text-sm rounded-lg  focus:border-blue-500 block w-full p-2.5 bg-gray-600  placeholder-gray-400 text-white @error('login_email') border-red-500 @enderror border-gray-500" placeholder="name@email.com" required>
                        @error('login_email')
                            <p class="text-xs text-red-500">{{ $errors->first('login_email') }}</p>
                        @enderror
                    </div>

                    {{-- PASSWORD --}}
                    <div>
                        <label for="login_password" class="block mb-2 text-sm font-medium text-white">Your password</label>
                        <input type="password" name="login_password" id="login_password" placeholder="Password" class="border text-sm rounded-lg  focus:border-blue-500 block w-full p-2.5 bg-gray-600  placeholder-gray-400 text-white @error('login_password') border-red-500 @enderror border-gray-500" required>
                        @error('login_password')
                            <p class="text-xs text-red-500">{{ $errors->first('login_password') }}</p>
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