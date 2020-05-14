<?php
/**
 * Created by PhpStorm.
 * User: noten
 * Date: 2/3/2019
 * Time: 11:55 PM
 */?>

<div class="modal animated bounceInUp text-left" id="importModal" role="dialog" aria-labelledby="importModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-light-green">
                <label class="modal-title text-text-bold-600" id="importModal"><h3 class="text-white">Importar productos en lote</h3></label>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-white">&times;</span>
                </button>
            </div>
            {{ Form::open(['url' => 'productos/csv-import', 'method' => 'post', 'enctype' => 'multipart/form-data']) }}
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <fieldset class="form-group">
                                <label for="identifier" class="filled">Archivo CSV<span class="text-danger">*</span></label>
                                <input type="file" class="form-control-file" id="csvfile" name="csvfile">
                            </fieldset>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-warning text-center">El archivo debe ser formato CSV y debe tener un formato
                                específico. Puedes descargar la plantilla <a href="{{ asset('csv-templates/products.csv') }}"
                                                                             target="_blank"><strong>AQUÍ</strong></a></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="reset" class="btn btn-grey btn-lg" data-dismiss="modal" value="Cancelar">
                    <button type="submit" class="btn btn-light-green btn-lg ld-ext-right">Importar
                        <div class="ld ld-ring ld-spin"></div>
                    </button>
                </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
