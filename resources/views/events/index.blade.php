@extends('layouts.app')

@section('content')


<div class="container mt-4">
    <div class="row d-flex">
        <div class="col-lg-8 offset-lg-2 col-12">
            <div class="calendar-container p-4 rounded shadow">
                <h2 class="text-center mb-4">Időpontok</h2>
                <div id="app">
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
    @vite('resources/js/events.js')
@endsection
