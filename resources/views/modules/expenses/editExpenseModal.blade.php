<?php
/**
 * Created by PhpStorm.
 * User: noten
 * Date: 6/20/2019
 * Time: 11:55 PM
 */?>

<div class="modal animated bounceInUp text-left expenses-modal" id="editExpenseModal" role="dialog" aria-labelledby="editExpenseModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <label class="modal-title text-text-bold-600" id="editExpenseModal"><h3 class="mb-0 modal-title-changed">Editar</h3></label>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {{ Form::open(['url' => 'cuentas/gastos/editar', 'method' => 'put']) }}
                <div class="modal-body">
                    @include('modules.expenses.partials._formModal')
                </div>
                <div class="modal-footer">
                    <input type="reset" class="btn btn-light btn-lg" data-dismiss="modal" value="Cancelar">
                    <button type="submit" class="btn btn-orange btn-lg ld-ext-right">Actualizar
                        <div class="ld ld-ring ld-spin"></div>
                    </button>
                </div>
            {{ Form::hidden('expense_id', null, ['class' => 'form-control', 'id' => 'expense_id']) }}
            {{ Form::close() }}
        </div>
    </div>
</div>
