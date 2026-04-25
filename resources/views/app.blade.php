@extends('layouts.base')

@section('vite')
    @vite(['resources/css/app.css', 'resources/js/app.ts'])
@endsection

@section('root')
    <div id="app"></div>
@endsection
