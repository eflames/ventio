<?php
/**
 * Created by PhpStorm.
 * User: noten
 * Date: 3/19/2019
 * Time: 3:05 AM
 */?>
{{ Form::open(['url' => 'venta/delete/'.$sale->id, 'method' => 'post', 'id'=>'formelim-'.$sale->id, 'class' => 'pt-1']) }}
<div class="btn-group btn-group-sm">
    @can('sell', \App\User::class)
            @if( $sale->status->name == 'Incompleto')
                <a href="{{ route('sale.edit', ['id' => base64_encode($sale->id)]) }}"  class="btn btn-sm btn-grey-blue btn-outline-accent-4"
                    data-tooltip="tooltip" data-placement="left" title="Editar">
                <span class="ft-edit mr-1"></span> Editar
                </a>
                <button type="button" class="btn btn-icon btn-sm btn-grey-blue dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"></button>
                <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 39px, 0px); top: 0px; left: 0px; will-change: transform;">
                    <a href="{{ route('sale.view', ['id' => base64_encode($sale->id)]) }}" data-tooltip="tooltip" data-placement="left" title="Ver detalles" class="btn dropdown-item">
                        <span class="ft-eye mr-1"></span> Detalles
                    </a>
                    <div class="dropdown-divider"></div>
                    <button type="button"
                        onclick="alertElim('{{ $sale->id }}')"
                        class="btn dropdown-item"
                        data-tooltip="tooltip" data-placement="left" title="Eliminar">
                    <span class="ft-trash mr-1"></span> Eliminar
                    </button>
                </div>
            @else
                <a href="{{ route('sale.view', ['id' => base64_encode($sale->id)]) }}" data-tooltip="tooltip" data-placement="left" title="Ver detalles" 
                    class="btn btn-grey-blue"><span class="ft-eye mr-1"></span> Ver detalles</a>
            @endif
        @endcan
</div>
{{ Form::close() }}

