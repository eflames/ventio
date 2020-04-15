<?php
/**
 * Created by PhpStorm.
 * User: noten
 * Date: 2/1/2019
 * Time: 5:05 PM
 */?>

@extends('layouts.ventioMaster')
@section('content')
    <div class="container">
        <div class="row pt-5">
            <div class="col-12 text-center">
                <img src="{{ asset('images/error.png') }}" alt="Error" class="error-icon">
            </div>
        </div>
        <div class="row pt-3 pb-5">
            <div class="col-12 text-center">
                <div class="text-danger"> <h3>{{ $error }}</h3> </div>
            </div>
        </div>
        <div class="row pt-3 pb-5">
            <div class="col-12 text-center">
                <button class="btn btn-outline-grey btn-lg" onclick="history.back()"><span class="fa fa-arrow-left"></span> Regresar</button>
            </div>
        </div>
    </div>
@stop

