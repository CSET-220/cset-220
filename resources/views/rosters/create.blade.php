@extends('layouts.app')

@section('title', 'Rosters')

@section('navLink')
    @if(auth()->check())
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
    @endif
@endsection

@section('mainContent')
{{-- TODO need to finish authentication/design/filtering caregivers if selected --}}
<div class="min-h-full mt-1">
    <div class="flex justify-center mb-1">
        <div class="text-center">
            <h1 class="text-3xl font-semibold">Create New Roster</h1>
        </div>
    </div>
    <div class="mx-auto max-w-md">
        <form class=" max-w-md border bg-gray-300 border-slate-500 rounded-lg shadow-lg p-8" method="POST" action="{{route('rosters.store')}}">
            @csrf
            <div class="relative max-w-sm">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                    </svg>
                </div>
                <input required name="date" datepicker datepicker-autohide type="text" autocomplete="off" class="text-gray-900 text-sm focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 border-0 border-b-2 bg-gray-300 border-gray-200 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 cursor-pointer" placeholder="Select date">
            </div>
            <label for="underline_select" class="sr-only">Supervisor</label>
            <select required name="supervisor_id" id="underline_select" class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-gray-200 peer">
                <option hidden disabled selected>Supervisor</option>
                @forelse ($supervisors as $supervisor)
                    <option value="{{ intval($supervisor->id) }}">{{ $supervisor->first_name }} {{$supervisor->last_name}}</option>
                @empty
                    <option value="">No Supervisors</option>
                @endforelse
            </select>
            <label for="underline_select" class="sr-only">Doctor</label>
            <select required name="doctor_id" id="underline_select" class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-gray-200 peer">
                <option selected>Doctor</option>
                @forelse ($doctors as $doctor)
                    <option value="{{ intval($doctor->id) }}">{{ $doctor->first_name }} {{$doctor->last_name}}</option>
                @empty
                    <option value="">No Doctors</option>
                @endforelse
            </select>
            <label for="underline_select" class="sr-only">Caregiver 1</label>
            <select required name="caregiver1_id" id="underline_select" class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-gray-200 peer">
                <option selected>Caregiver 1</option>
                @forelse ($caregivers as $care1)
                    <option value="{{ intval($care1->id) }}">{{ $care1->first_name }} {{$care1->last_name}}</option>
                @empty
                    <option value="">No Caregivers</option>
                @endforelse
            </select>
            <label for="underline_select" class="sr-only">Caregiver 2</label>
            <select required name="caregiver2_id" id="underline_select" class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-gray-200 peer">
                <option selected>Caregiver 2</option>
                @forelse ($caregivers as $care2)
                    <option value="{{ intval($care2->id) }}">{{ $care2->first_name }} {{$care2->last_name}}</option>
                @empty
                    <option value="">No Caregivers</option>
                @endforelse
            </select>
            <label for="underline_select" class="sr-only">Caregiver 3</label>
            <select required name="caregiver3_id" id="underline_select" class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-gray-200 peer">
                <option selected>Caregiver 3</option>
                @forelse ($caregivers as $care3)
                    <option value="{{ intval($care3->id) }}">{{ $care3->first_name }} {{$care3->last_name}}</option>
                @empty
                    <option value="">No Caregivers</option>
                @endforelse
            </select>
            <label for="underline_select" class="sr-only">Caregiver 4</label>
            <select required name="caregiver4_id" id="underline_select" class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-gray-200 peer">
                <option selected>Caregiver 4</option>
                @forelse ($caregivers as $care4)
                    <option value="{{ intval($care4->id) }}">{{ $care4->first_name }} {{$care4->last_name}}</option>
                @empty
                    <option value="">No Caregivers</option>
                @endforelse
            </select>
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Create</button>
        </form>
    </div>
</div>
@endsection

@section('scripts')

@endsection