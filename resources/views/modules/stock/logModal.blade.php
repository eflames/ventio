<?php
/**
 * Created by PhpStorm.
 * User: noten
 * Date: 2/3/2019
 * Time: 11:55 PM
 */?>

<div class="modal animated bounceInLeft text-left" id="logModal" role="dialog" aria-labelledby="logModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-grey">
                <label class="modal-title text-text-bold-600" id="logModal"><h3 class="text-white">Resultados de la importación (LOG)</h3></label>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-white">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Resultado</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(session()->exists('results'))
                                @forelse(session()->get('results') as $result)
                                    <tr class="@if($result['status']) bg-success @else bg-warning @endif text-white">
                                        <td>{{ $result['identifier']}}</td>
                                        <td>{{ $result['message'] }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center"><strong>Sin resultados que mostrar</strong></td>
                                    </tr>
                                @endforelse
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="reset" class="btn btn-light-greenbtn-lg" data-dismiss="modal" value="Cerrar">
            </div>
        </div>
    </div>
</div>
