<?php
/**
 * Created by PhpStorm.
 * User: noten
 * Date: 3/21/2019
 * Time: 3:42 AM
 */?>

{{ Form::open(['url' => 'cuentas/por-cobrar/'.$credit->id, 'method' => 'delete', 'id'=>'formelim-'.$credit->id, 'class' => 'pt-1']) }}
<div class="btn-group btn-group-sm">
    <button type="button" class="btn btn-icon btn-sm btn-grey-blue dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><i class="fa fa-cog"></i></button>
    <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 39px, 0px); top: 0px; left: 0px; will-change: transform;">
        @can('manageCredits', \App\User::class)
            @if($percentage < 100)
                <button type="button" href="{{ route('sale.edit', ['id' => base64_encode( $credit->id )]) }}"  class="btn dropdown-item"
                        data-tooltip="tooltip" data-placement="left" title="Abonar" data-credit_id="{{ $credit->id }}"
                        data-toggle="modal" data-target="#addAmountModal">
                    <span class="fa fa-plus"></span> Abonar
                </button>
            @endif
        @endcan
        <a type="button" href="{{ route('loans.payments', $credit->id) }}"  class="btn dropdown-item"
                data-tooltip="tooltip" data-placement="left" title="Ver registro">
            <span class="fa fa-search"></span> Ver registro
        </a>
        @if($credit->comment)
            <button type="button"
                    class="btn dropdown-item" data-comment="{{ $credit->comment }}"
                    data-toggle="modal" data-target="#showCommentModal"
                    data-tooltip="tooltip" data-placement="left" title="Ver comentario">
                <span class="fa fa-exclamation-triangle"></span> Ver comentario
            </button>
        @endif
        @can('manageCredits', \App\User::class)
                {{--@if($credit->closed == 0)--}}
                    {{--<a href="{{ route('loans.close', ['id' => $credit->id]) }}"--}}
                       {{--class="btn dropdown-item"--}}
                       {{--data-tooltip="tooltip" data-placement="left" title="Abonar totalidad y cerrar">--}}
                        {{--<span class="fa fa-money"></span> Cerrar--}}
                    {{--</a>--}}
                {{--@endif--}}
            <div class="dropdown-divider"></div>
            <button type="button"
                    onclick="alertElim('{{ $credit->id }}')"
                    class="btn dropdown-item"
                    data-tooltip="tooltip" data-placement="left" title="Eliminar">
                <span class="fa fa-times"></span> Eliminar
            </button>
        @endcan
    </div>
</div>
{{ Form::close() }}
