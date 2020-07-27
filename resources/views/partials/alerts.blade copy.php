<?php
/**
 * Created by PhpStorm.
 * User: eflames
 * Date: 19/02/2015
 * Time: 12:01 PM
 */?>



@if (count($errors) > 0)
    <div class="alert alert-icon-left alert-danger alert-dismissible mb-2 alert-arrow-left" role="alert">
        <span class="alert-icon"><i class="fa fa-warning"></i></span>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>

            @foreach ($errors->all() as $error)
                {{ $error }}<br>
            @endforeach

    </div>
@endif

@if(@$message)
    <div id="messageBar" class="alert alert-icon-left alert-success alert-dismissible mb-2 alert-arrow-left" role="alert">
        <span class="alert-icon"><i class="fa fa-check"></i></span>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        {{$message}}
    </div>
@endif

@if(session()->has('message'))
    <div class="alert alert-icon-left alert-success alert-dismissible mb-2 alert-arrow-left" role="alert">
        <span class="alert-icon"><i class="fa fa-check"></i></span>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        {!! session()->pull('message') !!}
    </div>
@endif

@if(session()->has('warning'))
    <div class="alert alert-icon-left alert-warning alert-dismissible mb-2 alert-arrow-left" role="alert">
        <span class="alert-icon"><i class="fa fa-exclamation-circle"></i></span>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        {!! session()->pull('warning') !!}
    </div>
@endif

@if(session()->has('error'))
    <div class="alert alert-icon-left alert-danger alert-dismissible mb-2 alert-arrow-left" role="alert">
        <span class="alert-icon"><i class="fa fa-warning"></i></span>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        {{ session()->pull('error') }}
    </div>
@endif
<div id="messageBar" class="alert alert-icon-left alert-success alert-dismissible mb-2 alert-arrow-left"
     role="alert" style="display: none">
    <span class="alert-icon"><i class="fa fa-check"></i></span>
    <button type="button" class="close" onclick="hideAlert()">
        <span aria-hidden="true">×</span>
    </button>
    <span id="messageBarText"></span>
</div>
<div id="errorBar" class="alert alert-icon-left alert-danger mb-2 alert-arrow-left"
     role="alert"style="display: none">
    <span class="alert-icon"><i class="fa fa-warning"></i></span>
    <button type="button" class="close" onclick="hideErrorAlert()">
        <span aria-hidden="true">×</span>
    </button>
    <span id="errorBarText"></span>
</div>