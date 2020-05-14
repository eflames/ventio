<?php
/**
 * Created by PhpStorm.
 * User: ernestoflames
 * Date: 18/1/19
 * Time: 11:37 PM
 */?>

<div class="header-navbar navbar-expand-sm navbar navbar-horizontal navbar-fixed navbar-dark navbar-without-dd-arrow navbar-bordered navbar-shadow justify-content-center" role="navigation" data-menu="menu-wrapper">
    <div class="navbar-container main-menu-content" data-menu="menu-container">
        <ul class="nav navbar-nav" id="main-menu-navigation" data-menu="menu-navigation">

            <li class="nav-item @if(Request::is('/')) active @endif"><a class="dropdown-toggle nav-link" href="{{ route('home') }}"><i class="icon-home"></i><span data-i18n="nav.dash.main">Inicio</span></a></li>
            @canany(['sales', 'sell'], \App\User::class)
                <li class="dropdown nav-item @if(Request::is('venta*')) active @endif" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><i class="icon-basket-loaded"></i><span data-i18n="nav.templates.main">Ventas</span></a>
                    <ul class="dropdown-menu">
                        @can('sales', \App\User::class)
                            <li class="dropdown @if(Request::is('ventas')) active @endif"><a class="dropdown-item" href="{{ route('sales.list') }}" accesskey="l" >Ventas registradas</a></li>
                        @endcan
                        @can('sell', \App\User::class)
                            <li class="dropdown"><a class="dropdown-item" href="#" data-toggle="modal" data-target="#newSaleModal" accesskey="n">Nueva venta</a></li>
                        @endcan
                    </ul>
                </li>
            @endcanany
            @can('listInventory', \App\User::class)
                <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><i class="icon-drawer"></i><span data-i18n="nav.layouts.temp">Inventario</span></a>
                    <ul class="dropdown-menu">
                        <li class="dropdown @if(Request::is('stock*')) active @endif"><a class="dropdown-item" href="{{ route('stock.list') }}" accesskey="s">Stock</a></li>
                        <li class="dropdown @if(Request::is('productos*')) active @endif"><a class="dropdown-item" href="{{ route('products.list') }}" accesskey="i">Productos</a></li>
                    </ul>
                </li>
            @endcan
            @can('listClients', \App\User::class)
            <li class="dropdown nav-item @if(Request::is('cliente*')) active @endif" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><i class="icon-user-following"></i><span data-i18n="nav.category.general">Clientes</span></a>
                <ul class="dropdown-menu">
                    <li class="dropdown"><a class="dropdown-item @if(Request::is('clientes')) active @endif" href="{{ route('clients.list') }}">Clientes registrados</a></li>
                    <li class="dropdown"><a class="dropdown-item @if(Request::is('clientes/create')) active @endif" href="{{ route('clients.create') }}">Nuevo cliente</a></li>
                </ul>
            </li>
            @endcan
            @can('listCredits', \App\User::class)
                <li class="dropdown nav-item @if(Request::is('cuentas*')) active @endif" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><i class="icon-credit-card"></i><span data-i18n="nav.category.general">Cuentas</span></a>
                    <ul class="dropdown-menu">
                        <li class="dropdown @if(Request::is('cuentas/por-cobrar')) active @endif"><a class="dropdown-item" href="{{ route('loans.list') }}">Por cobrar</a></li>
                        <li class="dropdown @if(Request::is('cuentas/por-pagar')) active @endif"><a class="dropdown-item" href="{{ route('credits.list') }}">Por pagar</a></li>
                        <li class="dropdown @if(Request::is('creditos/gastos')) active @endif"><a class="dropdown-item" href="{{ route('expenses.list') }}">Gastos</a></li>
                    </ul>
                </li>
            @endcan
            @can('reports', \App\User::class)
                <li class="dropdown nav-item @if(Request::is('reporte*')) active @endif"><a class="nav-link" href="{{ route('reports.list') }}"><i class="icon-pie-chart"></i><span data-i18n="nav.category.general">Reportes</span></a></li>
            @endcan
            @can('users', \App\User::class)
                <li class="dropdown nav-item @if(Request::is('usuarios*')) active @endif" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><i class="icon-lock"></i><span data-i18n="nav.category.general">Usuarios</span></a>
                    <ul class="dropdown-menu">
                        <li class="dropdown @if(Request::is('usuarios')) active @endif"><a class="dropdown-item" href="{{ route('users.list') }}">Usuarios registrados</a></li>
                        <li class="dropdown @if(Request::is('usuarios/create*')) active @endif"><a class="dropdown-item" href="{{ route('users.create') }}">Crear usuario</a></li>
                        <li class="dropdown @if(Request::is('usuarios/permisos*')) active @endif"><a href="{{ route('roles.list') }}" class="dropdown-item">Roles y permisos</a></li>
                    </ul>
                </li>
            @endcan
            @can('config', \App\User::class)
                <li class="dropdown nav-item @if(Request::is('categorias*') OR Request::is('almacenes*') OR Request::is('metodos-de-pago*') OR Request::is('sistema*')) active @endif" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><i class="icon-wrench"></i><span data-i18n="nav.category.general">Config</span></a>
                    <ul class="dropdown-menu">
                        <li class="dropdown @if(Request::is('configuracion*')) active @endif"><a class="dropdown-item" href="{{ route('config.general') }}">Configuración general</a></li>
                        <li class="dropdown @if(Request::is('categorias*')) active @endif"><a class="dropdown-item" href="{{ route('categories.index') }}">Categorías de producto</a></li>
                        <li class="dropdown @if(Request::is('almacenes*')) active @endif"><a class="dropdown-item" href="{{ route('warehouses.index') }}">Administrar almacenes</a></li>
                        <li class="dropdown @if(Request::is('metodos-de-pago*')) active @endif"><a class="dropdown-item" href="{{ route('paymentMethods.index') }}">Métodos de pago</a></li>
                    </ul>
                </li>
            @endcan
        </ul>
    </div>
    <!-- /horizontal menu content-->
</div>