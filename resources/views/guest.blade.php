@extends('layouts.base')

@section('vite')
    @vite(['resources/css/app.css', 'resources/js/guest.js'])
@endsection

@section('root')
    <div id="guest"></div>
@endsection
