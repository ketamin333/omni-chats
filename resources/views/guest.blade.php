@extends('layouts.base')

@section('vite')
    @vite(['resources/css/app.css', 'resources/js/guest.ts'])
@endsection

@section('root')
    <div id="guest"></div>
@endsection
