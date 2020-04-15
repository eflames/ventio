<?php
/**
 * Created by PhpStorm.
 * User: noten
 * Date: 9/18/2019
 * Time: 4:09 AM
 */?>

<td class="text-center align-middle">
    {{ Form::open(['url' => 'stock/'.$id, 'method' => 'delete', 'id'=>'formelim-'.$id]) }}
    <div class="btn-group btn-group-sm">
        <button type="button" class="btn btn-icon btn-sm btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><i class="fa fa-cog"></i></button>
        <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 39px, 0px); top: 0px; left: 0px; will-change: transform;">
            <button type="button"
                    data-name="{{ $name }}"
                    data-price="{{ $price }}"
                    data-warehouse="{{ strtoupper($warehouse) }}"
                    data-stock_id="{{ $id }}"
                    class="btn dropdown-item"
                    data-toggle="modal" data-target="#addQtyModal"
                    data-tooltip="tooltip" data-placement="left" title="Añadir stock">
                <span class="fa fa-plus-circle"></span> Añadir stock
            </button>
            <button type="button"
                    data-name="{{ $name }}"
                    data-stock_id="{{ $id }}"
                    data-warehouse="{{ strtoupper($warehouse) }}"
                    data-from_warehouse_id="{{ $warehouseid}}"
                    data-qty="{{ $qty }}"
                    data-product_id="{{ $productid }}"
                    class="btn dropdown-item"
                    data-toggle="modal" data-target="#transferQtyModal"
                    data-tooltip="tooltip" data-placement="left" title="Transferir a otro almacén">
                <span class="fa fa-exchange"></span> Transferir
            </button>
            <button type="button"
                    data-name="{{ $name }}"
                    data-price="{{ $price }}"
                    data-cost_price="{{ $cost_price }}"
                    data-warehouse="{{ $warehouse }}"
                    data-stock_id="{{ $id }}"
                    class="btn dropdown-item"
                    data-toggle="modal" data-target="#editPriceModal"
                    data-tooltip="tooltip" data-placement="left" title="Editar precio">
                <span class="fa fa-dollar"></span> Editar precio
            </button>
            <div class="dropdown-divider"></div>
            <button type="button"
                    onclick="alertElim('{{ $id }}')"
                    class="btn dropdown-item"
                    data-tooltip="tooltip" data-placement="left" title="Eliminar">
                <span class="fa fa-times"></span> Eliminar
            </button>
        </div>
    </div>
    {{ Form::close() }}
</td>
