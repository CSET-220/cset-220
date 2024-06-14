@extends('layouts.app')

@section('title', 'Patient Logs')

@section('mainContent')

    <div id="log-content">
        <x-logs.logs-table :patient="$patient" />
    </div>

@endsection