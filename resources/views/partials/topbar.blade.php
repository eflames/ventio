<?php
/**
 * Created by PhpStorm.
 * User: ernestoflames
 * Date: 18/1/19
 * Time: 11:37 PM
 */?>

<nav class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-static-top navbar-light bg-white bg-lighten-1 navbar-border navbar-brand-center">
    <div class="navbar-wrapper">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item mobile-menu d-md-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="horizontal-nav-dark.html#"><i class="ft-menu font-large-1"></i></a></li>
                <li class="nav-item">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <img id="logo" src="{{ asset('images/logo.png') }}" alt="vent.IO logo" style="height: 30px; width: auto"
                             data-tooltip="tooltip" data-placement="right" title="{{ config('ventio.VERSION') }}">
                    </a>
                </li>
            </ul>
        </div>
        <div class="navbar-container content">
            <div class="collapse navbar-collapse" id="navbar-mobile">
                <ul class="nav navbar-nav mr-auto float-left">
                </ul>
                <ul class="nav navbar-nav float-right">
                    <li class="dropdown dropdown-user nav-item">
                        <a class="dropdown-toggle nav-link dropdown-user-link"
                           href="#" data-toggle="dropdown">
                            <span class="avatar avatar-online"></span>
                            <span class="user-name" style="font-size: 0.8rem;"><i class="fa fa-user grey"></i><strong>{{ auth()->user()->name }}</strong></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item @if(Request::is('miperfil*')) active @endif" href="{{ route('profile.edit') }}" data-tooltip="tooltip" data-placement="left" title="Editar perfil de usuario"><i class="ft-user"></i> Mi perfil</a>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#changeUserModal" accesskey="u" data-tooltip="tooltip" data-placement="left" title="Cambio rápido de usuario"><i class="ft-repeat"></i> Cambiar usuario</a>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#shortcutsModal" data-tooltip="tooltip" data-placement="left" title="Lista de atajos de teclado"><i class="fa fa-keyboard-o"></i> Atajos de teclado</a>
                            <a class="dropdown-item" href="{{ route('system.about') }}" data-tooltip="tooltip" data-placement="left" title="Información sobre la aplicación">
                                <i class="fa fa-desktop"></i> Acerca de Ventio
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ url('/logout') }}"
                               onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                <i class="ft-power"></i> Cerrar sesión
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
<form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
    {{ csrf_field() }}
</form>