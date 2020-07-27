<?php
/**
 * Created by PhpStorm.
 * User: noten
 * Date: 9/18/2019
 * Time: 4:09 AM
 */?>

<td class="text-center align-middle">
    {{ Form::open(['url' => 'stock/'.$item->id, 'method' => 'delete', 'id'=>'formelim-'.$item->id]) }}
    {{-- <span class="dropdown">
        <button id="btnSearchDrop2" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-info dropdown-toggle"><i class="fa fa-cog"></i></button>
        <span aria-labelledby="btnSearchDrop2" class="dropdown-menu mt-1 dropdown-menu-right" x-placement="bottom-end" style="position: absolute; transform: translate3d(-104px, 32px, 0px); top: 0px; left: 0px; will-change: transform;">
            <a href="project-tasks.html#" class="dropdown-item"><i class="ft-eye"></i> Open Task</a>
            <a href="project-tasks.html#" class="dropdown-item"><i class="ft-edit-2"></i> Edit Task</a>
            <a href="project-tasks.html#" class="dropdown-item"><i class="ft-check"></i> Complete Task</a>
            <a href="project-tasks.html#" class="dropdown-item"><i class="ft-upload"></i> Assign to</a>
            <div class="dropdown-divider"></div>
            <a href="project-tasks.html#" class="dropdown-item"><i class="ft-trash"></i> Delete Task</a>
        </span>
    </span> --}}
    <div class="btn-group btn-group-sm">
        <button type="button" class="btn btn-icon btn-sm btn-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><i class="fa fa-cog"></i></button>
        <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 39px, 0px); top: 0px; left: 0px; will-change: transform;">
            <a href="#" class="dropdown-item" data-name="{{ $item->product->name }}"
                data-price="{{ $item->price }}"
                data-warehouse="{{ strtoupper($item->warehouse->name) }}"
                data-stock_id="{{ $item->id }}"
                class="btn dropdown-item"
                data-toggle="modal" data-target="#addQtyModal"
                data-tooltip="tooltip" data-placement="left" title="Añadir stock"><i class="ft-plus-circle pr-1"></i> Añadir stock</a>
            <a href="#"
                data-min_stock="{{ $item->min_stock }}"
                data-name="{{ $item->product->name }}"
                data-stock_id="{{ $item->id }}"
                class="btn dropdown-item"
                data-toggle="modal" data-target="#editMinStockModal"
                data-tooltip="tooltip" data-placement="left" title="Establecer stock mínimo">
                <i class="ft-arrow-down pr-1"></i> Stock minimo
            </a>
            <a href="#"
                data-name="{{ $item->product->name }}"
                data-stock_id="{{ $item->id }}"
                data-warehouse="{{ strtoupper($item->warehouse->name) }}"
                data-from_warehouse_id="{{ $item->warehouse->id}}"
                data-qty="{{ $item->qty }}"
                data-product_id="{{ $item->product->id }}"
                class="btn dropdown-item"
                data-toggle="modal" data-target="#transferQtyModal"
                data-tooltip="tooltip" data-placement="left" title="Transferir a otro almacén">
                <i class="ft-log-out pr-1"></i> Transferir
            </a>
            <a href="#"
                data-name="{{ $item->product->name }}"
                data-price="{{ $item->price }}"
                data-cost_price="{{ $item->cost_price }}"
                data-warehouse="{{ $item->warehouse->name }}"
                data-stock_id="{{ $item->id }}"
                class="btn dropdown-item"
                data-toggle="modal" data-target="#editPriceModal"
                data-tooltip="tooltip" data-placement="left" title="Editar precio">
                <i class="ft-edit pr-1"></i> Editar precio
            </a>
            <div class="dropdown-divider"></div>
            <a href="#"
                onclick="alertElim('{{ $item->id }}')"
                class="btn dropdown-item"
                data-tooltip="tooltip" data-placement="left" title="Eliminar">
                <i class="ft-trash pr-1"></i> Eliminar
            </a>
        </div>
    </div>
    {{ Form::close() }}
</td>
