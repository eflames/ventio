<?php
/**
 * Created by PhpStorm.
 * User: noten
 * Date: 2/1/2019
 * Time: 8:20 PM
 */?>
@extends('layouts.ventioMaster')
@section('content')
@include('modules.vars.newVarModal')
@include('modules.vars.editVarModal')
@include('partials.alerts')

    <div class="content-body">
        <section id="configuration">
            <div class="row">
                <div class="col-12">
                    <div class="card border-top-3 border-top-pink">
                        <div class="card-content collapse show">
                            <div class="card-body card-dashboard">
                                <div class="row">
                                    <div class="col-12 text-center">
                                        <h1>Acerca de:</h1>
                                        <img src="{{ asset('images/logo_ventio.png') }}" alt="Logo Ventio">
                                        <h3>{{ config('ventio.VERSION') }}</h3>
                                    </div>
                                </div>
                                <hr>
                                <div class="row mt-2">
                                    <div class="col-5 offset-2">
                                        <div class="row">
                                            <div class="col-12">
                                                <h3 class="mb-1">Changelog <small class="grey">Lista de cambios y actualizaciones</small></h3>
                                                ---
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <h4 class="pink">v1.7.0 <small class="grey">19/07/2020 <strong>(ACTUAL)</strong></small></h4>
                                                <ul>
                                                    <li>First official release. RC removed.</li>
                                                    <li>Ventio now has licensing method.</li>
                                                    <li>New logo and colors.</li>
                                                    <li>Change notification bars to toastr notifications</li>
                                                    <li>Improved search method</li>
                                                    <li>New live searchbar system in sales, clients, products & stock (no longer using datatables)</li>
                                                    <li>Added button in stock list to create products</li>
                                                    <li>Added limit in client fields (ID and Telephone)</li>
                                                    <li>Added quantity column in stock reports</li>
                                                    <li>Fix credits number in dashboard</li>
                                                    <li>Improved loading effects in buttons</li>
                                                    <li>New reports view design with category</li>
                                                    <li>New stock log report added</li>
                                                    <li>Added CSV exports to WooCommerce</li>
                                                    <li>UI improves and fixes</li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <h4 class="pink">v1.6.1RC <small class="grey">20/05/2020</small></h4>
                                                <ul>
                                                    <li>Fixed stock log doesn't store changes when adding stock from products</li>
                                                    <li>Fixed pagination when filtering logs</li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <h4 class="pink">v1.6.0RC <small class="grey">12/05/2020</small></h4>
                                                <ul>
                                                    <li>Upgraded Laravel version, from 5.7 to 6.18 LTS</li>
                                                    <li>New column to add stock in the same product screen</li>
                                                    <li>Improved performance with cache in stock and sales</li>
                                                    <li>Added filter by User, product and date in stock log</li>
                                                    <li>Added button to change warehouse inside sale</li>
                                                    <li>Added warehouse filter for Stock Reports</li>
                                                    <li>Fixed filtered stock view in ajax loading</li>
                                                    <li>Fixed clients view in ajax loading</li>
                                                    <li>New and simplified view of configuration screen</li>
                                                    <li>Added accounts maintenance in configuration</li>
                                                    <li>Added custom logo capability</li>
                                                    <li>New min_stock field with alerts and reports</li>
                                                    <li>New options in "Configuración Avanzada"</li>
                                                    <li>Changelog moved to "Acerca de" and doesn't require Internet</li>
                                                    <li>New icon design added</li>
                                                    <li>Add preventing method to doubleclick in closing sales</li>
                                                    <li>UI Improves</li>
                                                    <li>More than 155 files touched in this version</li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <h4 class="pink">v1.5.3RC <small class="grey">18/02/2020</small></h4>
                                                <ul>
                                                    <li>Fixed error in stock log when products does not exist</li>
                                                    <li>Reversed order in changelog</li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <h4 class="pink">v1.5.2RC <small class="grey">17/02/2020</small></h4>
                                                <ul>
                                                    <li>Added button to partial or total payment of credits</li>
                                                    <li>Fixed menu bar z-index</li>
                                                    <li>Fixed calculations in byType report</li>
                                                    <li>Added payment method in loans when adding manually</li>
                                                    <li>Fix error when deleting loan payment</li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <h4 class="pink">v1.5.1RC <small class="grey">18/12/2019</small></h4>
                                                <ul>
                                                    <li>Added closed_at field in sales to fix dates from closed sales.</li>
                                                    <li>Fix “ver registro” button in loans, now opens in separate page</li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <h4 class="pink">v1.5.0RC <small class="grey">16/12/2019</small></h4>
                                                <ul>
                                                    <li>Added button in loans module to make 1 single payment for many loans</li>
                                                    <li>Added “abonos por pagar” item in byBtype reports (flujo de caja)</li>
                                                    <li>Added config var exchange_rate for amount in Bs by dollar</li>
                                                    <li>UI Improvements in payment windows (sales)</li>
                                                    <li>Auto calculate Bs amount using exchange_rate when button is pressed</li>
                                                    <li>New report with items in stock with prices to sharing for customers added</li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <h4 class="pink">v1.4.0RC <small class="grey"> 22/11/2019</small></h4>
                                                <ul>
                                                    <li>Now ventio use Semantic Versioning (SEMVER)</li>
                                                    <li>Change BETA to RELEASE CANDIDATE</li>
                                                    <li>Entering in Release Candidate version</li>
                                                    <li>Version in log in screen updated</li>
                                                    <li>Changelogs now public for everyone</li>
                                                    <li>Removed Devolution as payment method in sales</li>
                                                    <li>Fixed item list table when no items added in sales</li>
                                                    <li>Fixed action buttons display in item list table</li>
                                                    <li>New byCategory report added</li>
                                                    <li>New global shortcuts</li>
                                                    <li>UI Improvements</li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <h4 class="pink">v1.3.10b <small class="grey"> 22/11/2019</small></h4>
                                                <ul>
                                                    <li>Total client debts in the sale warning box</li>
                                                    <li>Fix date change when proc sale, not saving</li>
                                                    <li>Display loan payments in reports by type</li>
                                                    <li>When sale in payments exceed sale amount, pay loans or load credits automatically</li>
                                                    <li>Devolution method removed from fast payment methods in sale</li>
                                                    <li>Manually added loans now have a comment</li>
                                                    <li>Fast (full payment) button in sale now add left amount not all sale amount</li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <h4 class="pink">v1.3.9b <small class="grey"> 16/10/2019</small></h4>
                                                <ul>
                                                    <li>Keyboard shortcuts</li>
                                                    <li>Sale item actions buttons</li>
                                                    <li>Gift option to sale item</li>
                                                    <li>Added version in login</li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <h4 class="pink">v1.3.8b <small class="grey"> 17/09/2019</small></h4>
                                                <ul>
                                                    <li>UI Speed Improvements (Stock & Products)</li>
                                                    <li>Switch User in menu</li>
                                                    <li>UI Fixes</li>
                                                    <li>DB Backup package</li>
                                                    <li>Manual Loans added</li>
                                                    <li>Quick Payments button added</li>
                                                    <li>Change date in sales</li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <h4 class="pink">v1.3.7b <small class="grey"> 23/08/2019</small></h4>
                                                <ul>
                                                    <li>Stock log module added</li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <h4 class="pink">v1.3.6b <small class="grey"> 23/08/2019</small></h4>
                                                <ul>
                                                    <li>Stock report added</li>
                                                    <li>Fix description msg in select2</li>
                                                    <li>Expenses and commission added in profit report</li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <h4 class="pink">v1.3.5b <small class="grey"> 15/08/2019</small></h4>
                                                <ul>
                                                    <li>Devolution feature added</li>
                                                    <li>Users and Clients to Uppercase</li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <h4 class="pink">v1.3.4b <small class="grey"> 11/07/2019</small></h4>
                                                <ul>
                                                    <li>Commission report added</li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <h4 class="pink">v1.3.3b <small class="grey"> 10/07/2019</small></h4>
                                                <ul>
                                                    <li>Report refactoring, every report has its own view</li>
                                                    <li>UI Improvements</li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <h4 class="pink">v1.3.2b <small class="grey"> 01/07/2019</small></h4>
                                                <ul>
                                                    <li>Profit report added</li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <h4 class="pink">v1.3.1b <small class="grey"> 20/06/2019</small></h4>
                                                <ul>
                                                    <li>Expenses module added</i>
                                                    <li>Fixes and refactoring in roles section</i>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <h4 class="pink">v1.3.0b <small class="grey"> 18/06/2019</small></h4>
                                                <ul>
                                                    <li>New report, income by type added</li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <h4 class="pink">v1.2.5b <small class="grey"> 18/06/2019</small></h4>
                                                <ul>
                                                    <li>UI Improvements</li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <h4 class="pink">v1.2.4b <small class="grey"> 28/05/2019</small></h4>
                                                <ul>
                                                    <li>Fix decimal in payments</li>
                                                    <li>Fix order details link in dashboard</li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <h4 class="pink">v1.2.3b <small class="grey"> 28/05/2019</small></h4>
                                                <ul>
                                                    <li>Fix price in products sale select2 box when production</li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <h4 class="pink">v1.2.2b <small class="grey"> 21/05/2019</small></h4>
                                                <ul>
                                                    <li>Fix strict operators</li>
                                                    <li>Fix mix manifest error in production</li>
                                                    <li>UI Improvements</li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <h4 class="pink">v1.2.1b <small class="grey"> 13/05/2019</small></h4>
                                                <ul>
                                                    <li>Cost prices added & more than 1 stock with different price</li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <h4 class="pink">v1.1.1b <small class="grey"> 25/04/2019</small></h4>
                                                <ul>
                                                    <li>Bs. field in sale payments and report in bs added</li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <h4 class="pink">v1.1.0b <small class="grey"> 23/04/2019</small></h4>
                                                <ul>
                                                    <li>Config var module added</li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <h4 class="pink">v1.0.1a <small class="grey"> 05/04/2019</small></h4>
                                                <ul>
                                                    <li>Sales by product report added</li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <h4 class="pink">v1.0.0a <small class="grey"> 14/01/2019</small></h4>
                                                <ul>
                                                    <li>Initial Release</li>
                                                </ul>
                                            </div>
                                        </div>
                            
                                    </div>
                                    <div class="col-3">
                                        <div class="row">
                                            <div class="col-12 text-right">
                                                <img src="{{ asset('images/logo_banner.jpg') }}" alt="Ernesto Flames" style="width: 100%">
                                                Ventio es una Aplicación Web para administrar el inventario y las ventas desarrollado, distribuido y licenciado por Ernesto Flames - <span class="grey"><a href="http://www.ernestoflames.com">www.ernestoflames.com</a></span>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-12">
                                                <h4>Horas invertidas hasta <strong>{{ config('ventio.VERSION') }}</strong></h4>
                                                <ul>
                                                    <li><strong>299</strong> horas de desarollo</li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <h4>Tecnología y librerías:</h4>
                                                <ul>
                                                    <li>Laravel Framework v6.18 LTS</li>
                                                    <li>Twitter Bootstrap v4.1.3</li>
                                                    <li>Yajra Datatables v1</li>
                                                    <li>Barryvdh DomPdf</li>
                                                    <li>Sweet Alert v2</li>
                                                    <li>Google ChartJS</li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <h4>Leyenda de versionamiento:</h4>
                                                <ul>
                                                    <li>v: Version</li>
                                                    <li>a: Alpha</li>
                                                    <li>b: Beta</li>
                                                    <li>RC: Release Candidate</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

@stop