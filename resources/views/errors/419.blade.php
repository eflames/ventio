<?php
/**
 * Created by PhpStorm.
 * User: noten
 * Date: 3/25/2019
 * Time: 3:52 AM
 */?>
<html>
<head>
    <title>Sesión expirada</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/googlefonts.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ mix('css/ventio-styles.css') }}">
    <style>
        .align-items-center {
            -ms-flex-align: center!important;
            align-items: center!important;
        }
        .d-flex {
            display: -ms-flexbox!important;
            display: flex!important;
        }
    </style>
</head>
<body>
<section class="section mt-5">
    <div class="container">
        <div class="row mt-5 mb-5">
            <div class="col-12 text-center">
                <img src="{{ asset('images/logo_ventio.png') }}" alt="Logo">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div>
                    <img alt="419" class="img-fluid" src="{{ asset('images/419.png') }}" />
                </div>
            </div>
            <div class="col-md-6 col-lg-5 d-flex align-items-center mt-4 mt-md-0">
                <div>
                    <h1>419 - Formulario expirado</h1>
                    <p class="margin-top-s">Por tu seguridad, el formulario que acabas de enviar ha sido desactivado por inactividad, regresa y refresca la página para intentarlo nuevamente.</p>
                    <p><a href="javascript:history.back();" class="btn btn-pink btn-lg">Regresar</a></p>
                </div>
            </div>
        </div>
    </div>
</section>
</body>
</html>
