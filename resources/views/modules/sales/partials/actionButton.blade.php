<?php
/**
 * Created by PhpStorm.
 * User: noten
 * Date: 3/19/2019
 * Time: 3:05 AM
 */?>
{{ Form::open(['url' => 'venta/delete/'.$id, 'method' => 'post', 'id'=>'formelim-'.$id, 'class' => 'pt-1']) }}
<div class="btn-group btn-group-sm">
    <button type="button" class="btn btn-icon btn-sm btn-grey-blue dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><i class="fa fa-cog"></i></button>
    <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 39px, 0px); top: 0px; left: 0px; will-change: transform;">
        <a href="{{ route('sale.view', ['id' => base64_encode($id)]) }}" data-tooltip="tooltip" data-placement="left" title="Ver detalle" class="btn dropdown-item">
            <span class="fa fa-search"></span> Ver detalle
        </a>
        @can('sell', \App\User::class)
            @if( $status == 'Incompleto')
                <a href="{{ route('sale.edit', ['id' => base64_encode($id)]) }}"  class="btn dropdown-item"
                        data-tooltip="tooltip" data-placement="left" title="Editar">
                    <span class="fa fa-pencil"></span> Editar
                </a>
                <div class="dropdown-divider"></div>
                <button type="button"
                        onclick="alertElim('{{ $id }}')"
                        class="btn dropdown-item"
                        data-tooltip="tooltip" data-placement="left" title="Eliminar">
                    <span class="fa fa-times"></span> Eliminar
                </button>
            @endif
        @endcan
    </div>
</div>
{{ Form::close() }}
