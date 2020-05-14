<?php
/**
 * Created by PhpStorm.
 * User: noten
 * Date: 3/25/2019
 * Time: 3:52 AM
 */?>
<html>
<head>
    <title>Acceso denegado</title>
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
            <div class="col-md-6 text-right">
                <div>
                    <img alt="404" class="img-fluid" src="{{ asset('images/403.png') }}" />
                </div>
            </div>
            <div class="col-md-6 col-lg-5 d-flex align-items-center mt-4 mt-md-0">
                <div>
                    <h1>403 - Acceso denegado</h1>
                    <p class="margin-top-s">Lo sentimos pero la página que intentas visitar está protegida y no posees los permisos suficientes para acceder, contacta al adminsitrador del sistema.</p>
                    <p><a href="javascript:history.back();" class="btn btn-pink btn-lg">Regresar</a></p>
                </div>
            </div>
        </div>
    </div>
</section>
</body>
</html>
