<?php
/**
 * Created by PhpStorm.
 * User: ernestoflames
 * Date: 18/1/19
 * Time: 11:36 PM
 */?>

<footer class="footer footer-static footer-dark">
    <p class="clearfix blue-grey lighten-2 text-sm-center mb-0 px-2">
        <span class="float-md-left d-block d-md-inline-block">
            <img src="{{ asset('images/logo_bottom.png') }}" alt="Ventio by Ernesto Flames" style="padding-bottom: 2px;">
            Copyright  &copy; {{date('Y')}} | Ventio es un producto desarrollado por Ernesto Flames licenciado para {{ $config['store_name'] }}
        </span>
        <span class="float-md-right d-block d-md-inline-blockd-none d-lg-block">
            <a href="http://ernestoflames.com" target="_blank">
                <img src="{{ asset('images/logoef_footerIcon-w.png') }}" alt="Desarrollado por Ernesto Flames" style="height: 25px; width: auto">
            </a>
        </span>
    </p>
</footer>
