@extends('layouts.app')

@section('title', 'Family - Patient Logs')

@section('mainContent')

    <div id="log-content">
        <x-logs.logs-table :patient="$patient" />
    </div>

@endsection