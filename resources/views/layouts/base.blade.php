<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    @component('layouts.main_header')
    @endcomponent 
    @yield('head')
</head>
<body>
    @yield('body')
    @stack('bottom-scripts')
</body>
</html>