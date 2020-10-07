<?php
/**
 * Created by PhpStorm.
 * User: ernestoflames
 * Date: 15/1/19
 * Time: 10:00 PM
 */?>
<!DOCTYPE html>
<html class="loading" lang="es" data-textdirection="ltr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('favicon-96x96.png') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">

    {!! SEO::generate(true) !!}

    <link rel="stylesheet" type="text/css" href="{{ asset('css/googlefonts.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/ventio-icons.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/ventio-styles.css') }}">

    @yield('after-styles')

</head>
<body class="horizontal-layout horizontal-top-icon-menu 2-columns menu-expanded"
      data-open="hover" data-menu="horizontal-menu" data-col="2-columns">
@include('modules.home.newClientModal')
@include('modules.home.newSaleModal')
@include('modules.home.changeUserModal')
@include('modules.home.shortcutsModal')
@include('partials.topbar')

@include('partials.menubar')

<div class="app-content container-fluid center-layout mt-2">
    <div class="content-wrapper">
        <div class="app-content content">
            <div class="content-wrapper">
                @yield('content')
            </div>
        </div>
    </div>
</div>

@include('partials.footer')

<script src="{{ asset('js/ventio-scripts.js') }}"></script>

@yield('after-scripts')
<script>
    $('.masterModal').css("margin-top", 100);
</script>
</body>
</html>