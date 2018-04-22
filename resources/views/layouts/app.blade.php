@extends('layouts.base')

@section('head')
    @yield('head_includes')
@endsection
@section('body')
    @component('layouts.main_nav')
    @endcomponent
    @yield('content')
    @component('layouts.bottom_scripts')
    @endcomponent
    @yield('bottom_includes')
@endsection