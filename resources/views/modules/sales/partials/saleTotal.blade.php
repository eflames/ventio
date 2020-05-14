<?php
/**
 * Created by PhpStorm.
 * User: noten
 * Date: 3/1/2019
 * Time: 8:19 AM
 */?>
<div class="card animated tada @if($saleTotal == 0) bg-blue-grey @else bg-success @endif text-white mb-1">
    <div class="card-content">
        <div class="card-body">
            <div class="project-search">
                <p class="text-center">Total esta venta:</p>
                <div class="text-center">
                    <h1 class="text-white">${{ number_format($saleTotal, 2) }}</h1>
                </div>
            </div>
        </div>
    </div>
</div>


