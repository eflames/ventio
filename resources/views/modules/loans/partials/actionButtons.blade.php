<?php
/**
 * Created by PhpStorm.
 * User: noten
 * Date: 3/21/2019
 * Time: 3:42 AM
 */?>

{{ Form::open(['url' => 'cuentas/por-cobrar/'.$credit->id, 'method' => 'delete', 'id'=>'formelim-'.$credit->id, 'class' => 'pt-1']) }}
<div class="btn-group btn-group-sm">
    <button type="button" class="btn btn-icon btn-sm btn-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><i class="fa fa-cog"></i></button>
    <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 39px, 0px); top: 0px; left: 0px; will-change: transform;">
        <a href="{{ route('loans.payments', $credit->id) }}" data-tooltip="tooltip" data-placement="left" title="Ver registro de abonos" class="dropdown-item"><i class="ft-eye pr-1"></i> Ver registro</a>
        @can('manageCredits', \App\User::class)
            @if($percentage < 100)
                <a href="#" data-tooltip="tooltip" data-placement="left" title="Abonar monto a deuda" data-credit_id="{{ $credit->id }}"
                    data-toggle="modal" data-target="#addAmountModal" class="dropdown-item"><i class="ft-plus-circle pr-1"></i> Abonar</a>
            @endif
        @endcan
        @if($credit->comment)
            <a href="project-tasks.html#" class="dropdown-item" data-comment="{{ $credit->comment }}"
                data-toggle="modal" data-target="#showCommentModal" data-tooltip="tooltip" data-placement="left" title="Ver comentario"><i class="ft-message-square pr-1"></i> Ver comentario</a>
        @endif
        
        
        <div class="dropdown-divider"></div>
        @can('manageCredits', \App\User::class)
                {{--@if($credit->closed == 0)--}}
                    {{--<a href="{{ route('loans.close', ['id' => $credit->id]) }}"--}}
                       {{--class="btn dropdown-item"--}}
                       {{--data-tooltip="tooltip" data-placement="left" title="Abonar totalidad y cerrar">--}}
                        {{--<span class="fa fa-money"></span> Cerrar--}}
                    {{--</a>--}}
                {{--@endif--}}
            <a href="#" onclick="alertElim('{{ $credit->id }}')"
                class="btn dropdown-item"
                data-tooltip="tooltip" data-placement="left" title="Eliminar" class="dropdown-item"><i class="ft-trash pr-1"></i> Eliminar</a>
        @endcan
        
    </div>
</div>
{{ Form::close() }}
