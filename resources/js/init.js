function alertElim(id) {
    swal({
            title: "¿Está seguro que desea eliminar?",
            text: "Si lo elimina no podrá recuperarlo nuevamente",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#DA4453',
            confirmButtonText: "Si, Eliminar",
            cancelButtonText: "No",
            closeOnConfirm: true,
            closeOnCancel: false
        },
        function(isConfirm){
            if (isConfirm) {
                $('#formelim-'+id).submit();
            } else {
                swal({
                    title: "Cancelado",
                    text: "¡UFF! Menos mal que existe esto.",
                    type: "success",
                    confirmButtonText: "Lo sabemos :)"
                });
                //swal("Cancelado", "¡UFF! Menos mal que existe esto.", "success","asdasd");
            }
        })
}
function procSale() {
    swal({
            title: "¿Está seguro que desea procesar la venta?",
            text: "Una vez procesada no se puede editar",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#1B2942',
            confirmButtonText: "Si, Procesar",
            cancelButtonText: "No",
            closeOnConfirm: true,
            closeOnCancel: false
        },
        function(isConfirm){
            if (isConfirm) {
                $('.formAjax').submit();
            } else {
                swal({
                    title: "Cancelado",
                    text: "Puede seguir editando la venta",
                    type: "success",
                    confirmButtonText: "Ok"
                });
            }
        })
}
(function(window, document, $) {
    'use strict';


    $(window).on('load',function(){
        $('.form-group-style .form-control').focus(function() {
            $(this).parent(".form-group-style").addClass('focus');
            if($(this).val() !== ""){
                $(this).parent(".form-group-style").children("label").addClass("filled");
            }
            else{
                $(this).parent(".form-group-style").children("label").removeClass("filled");
            }
        });
        $('.form-group-style .form-control').focusout(function() {
            if($(this).parent(".form-group-style").hasClass('focus')){
                $(this).parent(".form-group-style").removeClass('focus');
            }
            if($(this).val() !== ""){
                $(this).parent(".form-group-style").children("label").addClass("filled");
            }
            else{
                $(this).parent(".form-group-style").children("label").removeClass("filled");
            }
        });
    });
})(window, document, jQuery);



$(document).ready(function() {
    $(".datatable-spanish").DataTable({
        // responsive: true,
        "ordering": false,
        language: {
            lengthMenu: "Mostrar _MENU_ registros por página",
            zeroRecords: "No hay resultados",
            info: "Mostrando página _PAGE_ de _PAGES_",
            infoEmpty: "No hay resultados",
            infoFiltered: "(Filtrando de _MAX_ registros totales)",
            search: "Buscar:",
            paginate: {
                first: "Primero",
                last: "Último",
                next: "Siguiente",
                previous: "Anterior"
            },
        }
    });

    $("#datatable-spanish-sales-dt").DataTable({
        processing: true,
        serverSide: true,
        // responsive: true,
        "ordering": false,
        ajax: '/ventas-dt',
        // "aaSorting": [[6, "desc"]],
        columns: [
            { data: 'id', name: 'id', className: 'align-middle'},
            { data: 'client', name: 'client', className: 'align-middle' },
            { data: 'closed_at', name: 'closed_at', className: 'align-middle' },
            { data: 'qty', name: 'qty', className: 'align-middle' },
            { data: 'amount', name: 'amount', className: 'align-middle' },
            { data: 'status', name: 'status', className: 'align-middle' },
            { data: 'actions', name: 'actions', className: 'align-middle' },
        ],
        language: {
            lengthMenu: "Mostrar _MENU_ registros por página",
            zeroRecords: "No hay resultados",
            info: "Mostrando página _PAGE_ de _PAGES_",
            infoEmpty: "No hay resultados",
            infoFiltered: "(Filtrando de _MAX_ registros totales)",
            search: "Buscar:",
            processing: "Procesando data...",
            paginate: {
                first: "Primero",
                last: "Último",
                next: "Siguiente",
                previous: "Anterior"
            },
        }
    });

    $("#datatable-spanish-products-dt").DataTable({
        processing: true,
        serverSide: true,
        // responsive: true,
        "ordering": false,
        ajax: '/products-dt',
        // "aaSorting": [[6, "desc"]],
        columns: [
            { data: 'identifier', name: 'identifier', className: 'align-middle'},
            { data: 'name', name: 'name', className: 'align-middle' },
            { data: 'category_name', name: 'category_name', className: 'align-middle' },
            { data: 'actions', name: 'actions', className: 'align-middle' },
        ],
        language: {
            lengthMenu: "Mostrar _MENU_ registros por página",
            zeroRecords: "No hay resultados",
            info: "Mostrando página _PAGE_ de _PAGES_",
            infoEmpty: "No hay resultados",
            infoFiltered: "(Filtrando de _MAX_ registros totales)",
            search: "Buscar:",
            processing: "Procesando data...",
            paginate: {
                first: "Primero",
                last: "Último",
                next: "Siguiente",
                previous: "Anterior"
            },
        }
    });

    $("#datatable-spanish-stock-dt").DataTable({
        processing: true,
        serverSide: true,
        // responsive: true,
        "ordering": false,
        ajax: '/stock-dt',
        // "aaSorting": [[6, "desc"]],
        columns: [
            { data: 'identifier', name: 'identifier', className: 'align-middle'},
            { data: 'name', name: 'name', className: 'align-middle' },
            { data: 'qty', name: 'qty', className: 'align-middle' },
            { data: 'warehouse', name: 'warehouse', className: 'align-middle' },
            { data: 'price', name: 'price', className: 'align-middle' },
            { data: 'cost_price', name: 'cost_price', className: 'align-middle' },
            { data: 'actions', name: 'actions', className: 'align-middle' },
        ],
        language: {
            lengthMenu: "Mostrar _MENU_ registros por página",
            zeroRecords: "No hay resultados",
            info: "Mostrando página _PAGE_ de _PAGES_",
            infoEmpty: "No hay resultados",
            infoFiltered: "(Filtrando de _MAX_ registros totales)",
            search: "Buscar:",
            processing: "Procesando data...",
            paginate: {
                first: "Primero",
                last: "Último",
                next: "Siguiente",
                previous: "Anterior"
            },
        }
    });
});

$( "button, input[type='submit']" ).click(function(e){
    $(this).addClass('running').delay(1250).queue(function( next ){
        $(this).removeClass('running');
        next();
    });
});

function changeSeller(){
    $('#sellerDiv').toggle('display');
}
function changeDate(){
    $('#dateDiv').toggle('display');
}