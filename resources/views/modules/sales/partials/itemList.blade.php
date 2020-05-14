<?php
/**
 * Created by PhpStorm.
 * User: noten
 * Date: 3/1/2019
 * Time: 8:06 AM
 */?>

@forelse($details as $detail)
    <tr>
        <td class="text-center w-15 align-middle">
                <input type="number" class="form-control input-sm text-center" min="1" id="itemQty-{{ $detail->id }}"
                       value="{{ $detail->qty }}" onchange="updateItem({{ $detail->id }},{{ $detail->sale->id }})">
        </td>
        <td class="align-middle">
            <strong>{{ $detail->product->name }}</strong>
        </td>
        <td class="text-right align-middle" style="width: 150px">
            @if($detail->authorized_by)
                <span class="warning fa fa-warning"
                      data-tooltip="tooltip" data-placement="left" title="Precio cambiado por {{ $detail->authorizedBy->name }}">
            </span>
            @endif
                @if($detail->gift)
                    <span class="pink"><small>¡REGALO!</small></span>
                @else
                    <strong>${{ number_format($detail->price,2) }}</strong>
                @endif
        </td>
        <td class="text-center align-middle" style="width: 200px">
            @if(!$detail->gift)
                <a href="#" onclick="giftItem({{ $detail->id }},{{ $detail->sale->id }},'/api/venta/giftItem/', '#')"
                   data-tooltip="tooltip" data-placement="left" title="Este item es un regalo" class="btn btn-outline-pink btn-sm">
                    <span class="fa fa-gift"></span>
                </a>
                @can('discount', \App\User::class)
                    <a href="#" data-item_id="{{ $detail->id }}"
                       data-item_name="{{ $detail->product->name }}"
                       data-item_price="{{ $detail->price }}"
                       data-sale_id="{{ $detail->sale->id }}"
                       data-toggle="modal" data-target="#changePriceModalFull"
                       data-tooltip="tooltip" data-placement="top" title="Cambiar precio" class="btn btn-outline-indigo btn-sm">
                        <span class="fa fa-lock"></span>
                    </a>
                @else
                    <a href="#" data-item_id="{{ $detail->id }}"
                       data-item_name="{{ $detail->product->name }}"
                       data-item_price="{{ $detail->price }}"
                       data-toggle="modal" data-target="#changePriceModal"
                       data-tooltip="tooltip" data-placement="top" title="Cambiar precio (requiere permiso)" class="btn btn-outline-grey btn-sm">
                        <span class="fa fa-lock"></span>
                    </a>
                @endcan
            @endif
                <a href="#" onclick="deleteItem({{ $detail->id }},{{ $detail->sale->id }},'/api/venta/deleteItem/', '#')"
                   data-tooltip="tooltip" data-placement="right" title="Elimnar este item" class="btn btn-outline-danger btn-sm">
                    <span class="fa fa-remove"></span>
                </a>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="4" class="text-center">No hay artículos agregados en esta venta aún.</td>
    </tr>
@endforelse

