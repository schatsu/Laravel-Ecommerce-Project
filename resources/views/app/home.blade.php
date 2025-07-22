@extends('app.layouts.main')
@section('title', 'Ana Sayfa')
@section('content')
    <!-- categories -->
    <x-categories-component/>
    <!-- /categories -->
    <!-- sliders -->
    <x-sliders-component/>
    <!-- sliders -->
    <!-- Landing Categories -->
    <x-landing-categories-component/>
    <!-- /Categories -->
    <!-- Icon box -->
    <x-icon-box-component/>
    <!-- /Icon box -->
@endsection
