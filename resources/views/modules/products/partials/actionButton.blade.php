<?php
/**
 * Created by PhpStorm.
 * User: noten
 * Date: 9/18/2019
 * Time: 3:10 AM
 */?>
<div class="row">
    <div class="col-12 text-center">
        {{ Form::open(['url' => 'productos/'.$id, 'method' => 'delete', 'id'=>'formelim-'.$id]) }}
        <button type="button"
                class="btn btn-grey-blue btn-sm" data-comment="{{ $description }}"
                data-toggle="modal" data-target="#showCommentModal"
                data-tooltip="tooltip" data-placement="left" title="ver descripción">
            <span class="fa fa-exclamation-triangle"></span>
        </button>
        @can('manageInventory', \App\User::class)
            <a href="{{route('products.edit', ['id' => $id]) }}" data-tooltip="tooltip"
               data-placement="top" title="Editar" class="btn btn-blue btn-sm">
                <span class="fa fa-pencil"></span>
            </a>
            <button type="button" onclick="alertElim('{{ $id }}')"
                    class="btn btn-danger btn-sm"
                    data-tooltip="tooltip" data-placement="right" title="Eliminar">
                <span class="fa fa-times"></span>
            </button>
        @endcan
        {{ Form::close() }}
    </div>
</div>
