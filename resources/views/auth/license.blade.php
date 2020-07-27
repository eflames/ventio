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
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('favicon-96x96.png') }}">
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
                            <div class="row">
                                <div class="col-12 text-center">
                                    <h3>Ingrese un hash de licenciamiento válido <br> para continuar con la aplicación.</h3>
                                </div>
                            </div>
                            @include('partials.alerts')
                            <div class="card-content">
                                <div class="card-body text-center">
                                    <form method="POST" action="{{ route('installLicense') }}">
                                        @csrf
                                        <fieldset class="form-group form-group-style">
                                            <label for="email" class="filled">hash de licencia: <span class="text-danger">*</span></label>
                                            {{ Form::textarea('value', null, ['class' => 'form-control']) }}
                                            @if ($errors->has('value'))
                                                <p class="badge-default badge-danger block-tag text-center"><small class="block-area white">{{ $errors->first('value') }}</small></p>
                                            @endif
                                        </fieldset>

                                        <button type="submit" class="btn ld-ext-right btn-outline-info"><i class="ft-check-square"></i> Instalar licencia
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
@yield('after-scripts')
</body>
</html>
