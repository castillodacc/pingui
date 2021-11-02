<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', '') {{ config('app.name') }}</title>

        <link rel="shortcut icon" href="{{ asset('/favicon.png') }}" type="image/x-icon">
        <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('/adminlte/css/AdminLTE.min.css') }}">
        <link rel="stylesheet" href="{{ asset('/adminlte/css/skins/'.config('frontend.theme').'.min.css') }}">

        <!--[if gte IE 7]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bluebird/3.3.4/bluebird.min.js"></script>
        <script> 'use strict'; var promise = new Promise(function(resolve) { setTimeout(function() { resolve("result"); }, 1000); }); promise.then(function(result) { /*alert("Fulfilled: " + result);*/ }, function(error) { /*alert("Rejected: " + error);*/ }); </script>

        @yield('head')
    </head>

    @yield('end')

    <script src="{{ mix('/js/app.js') }}"></script>
    <script src="{{ asset('/adminlte/js/adminlte.min.js') }}"></script>
    @yield('footer')
</html>
