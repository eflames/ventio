<?php
/**
 * Created by PhpStorm.
 * User: noten
 * Date: 3/2/2019
 * Time: 7:48 PM
 */?>

<div class="modal animated bounceInLeft text-left" id="returnModal" role="dialog" aria-labelledby="returnModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-blue-grey">
                <label class="modal-title text-text-bold-600"><h3 class="text-white modal-title-changed"></h3></label>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-white">&times;</span>
                </button>
            </div>
            {{ Form::open(['route' => 'sale.return', 'method' => 'post']) }}
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <fieldset class="form-group form-group-style">
                            <label for="comment" class="filled">Comentario: (opcional)</label>
                            {{ Form::textarea('comment', null, ['class' => 'form-control', 'id' => 'SaleComment', 'rows' => 3]) }}
                            {{ Form::hidden('detail_id', $sale->id, ['id' => 'detail_id']) }}
                        </fieldset>
                    </div>
                </div>

                <div class="row pt-1">
                    <div class="col-6 text-center">
                        <div class="form-group pb-1">
                            <input type="checkbox" class="js-switch" name="return_stock" value="1" />
                            <label for="return_stock" class="font-medium-1 text-bold-400 ml-1">Regresar stock</label>
                        </div>
                    </div>
                    <div class="col-6 text-center">
                        <div class="form-group pb-1">
                            <input type="checkbox" class="js-switch" name="return_payment" value="1" />
                            <label for="return_payment" class="font-medium-1 text-bold-400 ml-1">Descontar pago</label>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <input type="reset" class="btn btn-outline-grey btn-lg" data-dismiss="modal" value="Cancelar">
                <button type="submit" class="btn btn-blue-grey btn-lg ld-ext-right">Devolver
                    <div class="ld ld-ring ld-spin"></div>
                </button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
