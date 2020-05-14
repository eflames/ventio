<?php
/**
 * Created by PhpStorm.
 * User: ernestoflames
 * Date: 17/1/19
 * Time: 2:37 AM
 */?>
<div class="modal animated bounceInUp text-left report-modal" id="byProductModal" role="dialog" aria-labelledby="byProductModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <label class="modal-title text-text-bold-600" id="byProductModal"><h3 class="mb-0">Generar por producto</h3></label>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {{ Form::open(['route' => 'report.byProduct', 'method' => 'post']) }}
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <fieldset class="form-group form-group-style">
                            <label for="client_id" class="filled">Producto:<span class="text-danger">*</span></label>
                            <select class="input-xl select2-ajax-products form-control" id="" name="product_id" required></select>
                        </fieldset>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <fieldset class="form-group form-group-style">
                            <label for="name" class="filled">Desde:</label>
                            {{ Form::date('date_from', null, ['class' => 'form-control', 'id' => 'name']) }}
                        </fieldset>
                    </div>
                    <div class="col-6">
                        <fieldset class="form-group form-group-style">
                            <label for="name" class="filled">Hasta:</label>
                            {{ Form::date('date_to', null, ['class' => 'form-control', 'id' => 'name']) }}
                        </fieldset>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="reset" class="btn btn-light btn-lg" data-dismiss="modal" value="Cancelar">
                <button type="submit" class="btn btn-indigo btn-lg ld-ext-right">Generar
                    <div class="ld ld-ring ld-spin"></div>
                </button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
