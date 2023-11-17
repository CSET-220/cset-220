@extends('layouts.app')

@section('title', 'Rosters')

@section('navLink')
    @if(auth()->check())
        @if(auth()->user()->getAccess(['admin']))
            <x-navbar.admin-nav />
        @elseif(auth()->user()->role == 'supervisor')
            <x-navbar.supervisor-nav />
        @elseif(auth()->user()->role == 'doctor')
            <x-navbar.doctor-nav />
        @elseif(auth()->user()->role == 'caregiver')
            <x-navbar.caregiver-nav />
        @elseif(auth()->user()->role == 'patient')
            <x-navbar.patient-nav />
        @elseif(auth()->user()->role == 'family')
            <x-navbar.family-nav />
        @endif
    @endif
@endsection