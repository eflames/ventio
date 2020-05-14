<?php
/**
 * Created by PhpStorm.
 * User: noten
 * Date: 2/15/2019
 * Time: 9:09 PM
 */?>

<?php
/**
 * Created by PhpStorm.
 * User: ernestoflames
 * Date: 15/1/19
 * Time: 10:00 PM
 */?>
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">
    <link rel="stylesheet" href="{{ asset('css/switchery.min.css') }}">

    <title>Inicio de sesión - Ventio</title>

    <link rel="stylesheet" type="text/css" href="{{ asset('css/googlefonts.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/ventio-icons.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/ventio-styles.css') }}">
    <style>
        .login_version{
            color: #8db7ca !important;
            position: absolute;
            right: 146px;
            font-size: 11px;
            font-weight: 400;
            top: 78px;
        }
    </style>

    @yield('after-styles')

</head>
<body class="horizontal-layout horizontal-top-icon-menu 1-column bg-full-screen-image menu-expanded blank-page blank-page" data-open="hover" data-menu="horizontal-menu" data-col="1-column">
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <section class="flexbox-container">
                <div class="col-12 d-flex align-items-center justify-content-center">
                    <div class="col-md-4 col-10 box-shadow-2 p-0">
                        <div class="card border-grey border-lighten-3 px-1 py-1 m-0">
                            <div class="card-header border-0">
                                <div class="card-title text-center">
                                    <img src="{{ asset('images/logo_ventio.png') }}" alt="Ventio"><br>
                                    <span class="login_version">{{ config('ventio.VERSION') }}</span>
                                </div>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <form method="POST" action="{{ route('login') }}">
                                        @csrf
                                        <fieldset class="form-group form-group-style">
                                            <label for="email" class="filled">Correo electrónico: <span class="text-danger">*</span></label>
                                            {{ Form::text('email', null, ['class' => 'form-control']) }}
                                            @if ($errors->has('email'))
                                                <p class="badge-default badge-danger block-tag text-center"><small class="block-area white">{{ $errors->first('email') }}</small></p>
                                            @endif
                                        </fieldset>
                                        <fieldset class="form-group form-group-style">
                                            <label for="password" class="filled">Contraseña: <span class="text-danger">*</span></label>
                                            {{ Form::password('password', ['class' => 'form-control']) }}
                                            @if ($errors->has('password'))
                                                <p class="badge-default badge-danger block-tag text-center"><small class="block-area white">{{ $errors->first('password') }}</small></p>
                                            @endif
                                        </fieldset>
                                        <div class="row">
                                            <div class="col-12 text-center">
                                                <div class="form-group pb-1">
                                                    <input type="checkbox" class="js-switch" name="remember" value="1" />
                                                    <label for="remember" class="font-medium-1 text-bold-400 ml-1">¿Recordar?</label>
                                                </div>
                                            </div>
                                        </div>

                                        <button type="submit" class="btn ld-ext-right btn-outline-info btn-block"><i class="ft-unlock"></i> Iniciar Sesión
                                            <div class="ld ld-ring ld-spin"></div>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

<script src="{{ asset('js/ventio-scripts.js') }}"></script>
<script src="{{ asset('js/switchery.min.js') }}"></script>
<script>
    var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));

    elems.forEach(function(html) {
        var switchery = new Switchery(html);
    });
</script>
</body>
</html>
