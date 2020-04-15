<?php
/**
 * Created by PhpStorm.
 * User: noten
 * Date: 3/11/2019
 * Time: 8:33 PM
 */?>
@if($saleTotal > 0)
    @if($balance > 0)
        <div class="row">
            <div class="col-xl-12 col-md-12">
                <div class="card">
                    <div class="card-content">
                        <div class="media align-items-stretch bg-warning text-white rounded">
                            <div class="bg-warning bg-darken-2 p-2 media-middle">
                                <i class="fa fa-credit-card fa-2x font-large-2 text-white"></i>
                            </div>
                            <div class="media-body p-2">
                                <h5 class="text-white">Este cliente posee un balance a su favor</h5>
                                <span>
                            <a href="#" class="warning darken-4 text-bold-700" onclick="applyBalance({{ $sale->id }})">
                                Aplicar a esta venta
                            </a>
                        </span>
                            </div>
                            <div class="media-right p-2 media-middle">
                                <h1 class="warning darken-4 text-bold-700">${{ number_format($balance, 2) }}</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endif
