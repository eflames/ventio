$('body').on('keyup', '#searchField', function(){
    var searchquery = $(this).val();
    var slug = $('#almacen').val();
    // console.log(searchquery);
    $.ajax({
        method: 'GET',
        url: $(this).data('url'),
        dataType: 'html',
        data: {
            "_token": $("meta[name='csrf-token']").attr("content"),
            searchquery : searchquery,
            almacen : slug
        },
        success: function(res){
            // console.log(slug);
            $('#recordsTable').html('');
            $('#recordsTable').html(res);
            stop();
        },
        beforeSend: function(){
            $('#loadSpinner').show();
                },
        complete: function(){
            $('#loadSpinner').hide();
        },
    });
});
    $('#transferQtyModal').css("margin-top", $(window).height() / 4 - $('.modal-content').height());
    $('#addStockModal').css("margin-top", $(window).height() / 4 - $('.modal-content').height() / 3);
    $('#editPriceModal').css("margin-top", $(window).height() / 4 - $('.modal-content').height() / 3);
    $('#editMinStockModal').css("margin-top", $(window).height() / 4 - $('.modal-content').height() / 3);
    $('#importModal').css("margin-top", $(window).height() / 4 - $('.modal-content').height() / 3);
    $('#addQtyModal').css("margin-top", $(window).height() / 4 - $('.modal-content').height() / 3);
    $('#editPriceModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var modal = $(this);
        modal.find('.modal-title-changed').html('Editar <strong>' + button.data('name') + ' (' + button.data('warehouse') + ')</strong>');
        modal.find('#name').val(button.data('name'));
        modal.find('#stock_id').val(button.data('stock_id'));
        modal.find('#price').val(button.data('price'));
        modal.find('#cost_price').val(button.data('cost_price'));
    });
    $('#addQtyModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var modal = $(this);
        modal.find('.modal-title-changed').html('Añadir stock <strong>' + button.data('name') + ' (' + button.data('warehouse') + ')</strong>');
        modal.find('#name').val(button.data('name'));
        modal.find('#stock_id').val(button.data('stock_id'));
        modal.find('#qty').val(button.data('qty'));
    });
    $('#editMinStockModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var modal = $(this);
        modal.find('.modal-title-changed').html('Editar stock mínimo de: <strong>' + button.data('name') + ')</strong>');
        modal.find('#name').val(button.data('name'));
        modal.find('#stock_id').val(button.data('stock_id'));
        modal.find('#min_stock').val(button.data('min_stock'));
    });
    $('#transferQtyModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var modal = $(this);
        modal.find('.modal-title-changed').html('Transferir stock <strong>' + button.data('name') + ' (' + button.data('warehouse') + ')</strong>');
        modal.find('#stock_id').val(button.data('stock_id'));
        modal.find('#product_id').val(button.data('product_id'));
        modal.find('#fromWarehouse').val(button.data('warehouse'));
        modal.find('#warehousename').val(button.data('warehouse'));
        modal.find('#from_warehouse_id').val(button.data('from_warehouse_id'));
        modal.find('#qty').val(button.data('qty')).attr('max', button.data('qty'));
        modal.find('#name').val(button.data('name'));
        // modal.find('#quantity').attr('data-slider-max', button.data('qty'));
    });
    $('#showCommentModal').css("margin-top", $(window).height() / 3 - $('.modal-content').height() / 3);
        $('#showCommentModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var modal = $(this);
            modal.find('#comment').html(button.data('comment'));
        });


        