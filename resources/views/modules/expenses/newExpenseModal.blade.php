<?php
/**
 * Created by PhpStorm.
 * User: noten
 * Date: 6/20/2019
 * Time: 11:55 PM
 */?>

<div class="modal animated bounceInLeft text-left" id="newExpenseModal" role="dialog" aria-labelledby="newExpenseModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-orange">
                <label class="modal-title text-text-bold-600" id="newExpenseModal"><h3 class="text-white">Nuevo gasto</h3></label>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-white">&times;</span>
                </button>
            </div>
            {{ Form::open(['route' => 'expenses.store', 'method' => 'post']) }}
                <div class="modal-body">
                    @include('modules.expenses.partials._formModal')
                </div>
                <div class="modal-footer">
                    <input type="reset" class="btn btn-grey btn-lg" data-dismiss="modal" value="Cancelar">
                    <button type="submit" class="btn btn-orange btn-lg ld-ext-right">Crear
                        <div class="ld ld-ring ld-spin"></div>
                    </button>
                </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
