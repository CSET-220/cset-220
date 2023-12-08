@extends('layouts.app')

@section('title', 'Family - Home')

@section('mainContent')

    <div class="ml-4">
        <div class="mt-4 mb-10">
            <h1 class="text-3xl mb-2">Welcome, {{ $user->first_name }} {{ $user->last_name }}</h1>
        </div>

        <div class="flex justify-around">
            <div class="mb-6 w-72">
                <h2 class="text-xl mb-4">Your family:</h2>
                <div>
                    @forelse ($user->families as $member)
                        <div class="flex justify-between items-center mb-2">
                            <h3>{{ $member->patient->user->first_name }} {{ $member->patient->user->last_name }}</h3>
                            <button class="btn">
                                <a href="{{ route('family.logs', ['patient_id' => $member->patient->id]) }}">View all logs</a>
                            </button>
                        </div>
                    @empty
                        <p>You're not connected with any family members yet</p>
                    @endforelse
                </div>
            </div>
            <div>
                <h2 class="text-xl mb-4">Want to check up on a family member?</h2>
                <form id="family-code-form" method="post" class="flex flex-col w-64 items-start">
                    <div class="mb-2">
                        <label for="patient-id">Enter their Patient ID:</label>
                        <input type="text" name="patient_id" id="patient-id" placeholder="Patient ID" required>
                    </div>
    
                    <div class="mb-4">
                        <label for="family-code">Enter their Family Code:</label>
                        <input type="text" name="family_code" id="family-code" placeholder="Family Code" required>
                    </div>
    
                    <button type="submit" class="btn">View Family Member Logs</button>
                </form>
    
                <div id="alert" class="hidden items-center w-72 p-4 mt-4 text-red-800 border-t-4 border-red-300 bg-red-100 dark:text-red-400 dark:bg-gray-800 dark:border-red-800 transition duration-1000" role="alert">
                    <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
    
                    <div id="alert-message" class="ms-3 text-sm font-medium"></div>
    
                    <button type="button" id="dismiss-btn" class="ms-auto -mx-1.5 -my-1.5 bg-red-100 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-gray-700" aria-label="Close">
                        <span class="sr-only">Dismiss</span>
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')

    <script type="module" src="{{ asset('js/family/family-show.js') }}"></script>

@endsection