$(".AddItemForm").submit(function()
{
    let postData = $(this).serializeArray();
    let formURL = $(this).attr("action");
    let focus = '#' + $(this).data("focus");
    let saleId = $('#sale_id').val();
    $.ajax(
        {
            url : formURL,
            type: "POST",
            data : postData,
            beforeSend:function(){
                $('.sale-overlay').fadeIn();
                $('.addbutton').hide();
            },
            success:function(data)
            {
                loadDivs(saleId);
                console.log(saleId);
                $('.sale-overlay').fadeOut();
                $('.AddItemForm').trigger("reset");
                $('.addbutton').fadeIn();
                $(focus).focus();
                $('#messageBar').show().delay(3200).fadeOut(300);
                $('#messageBarText').html(data);
                $('#stock_id').val(null).trigger('change');
            },
            error: function(data)
            {
                $('#errorBar').show();
                $('html, body').animate({ scrollTop: 0 }, 0);
                $('#errorBarText').html(data.responseText.replace(/\"/g, ""));
                $('.sale-overlay').fadeOut();
                $('#newPaymentModal').modal('hide').focus();
                $('.addbutton').fadeIn();
            }
        });
    return false;
});

$(".changePriceForm").submit(function()
{
    let postData = $(this).serializeArray();
    let formURL = $(this).attr("action");
    let saleId = $('#sale_id').val();
    $.ajax(
        {
            url : formURL,
            type: "POST",
            data : postData,
            beforeSend:function(){
                $('.sale-overlay').fadeIn();
                $('.addbutton').hide();
            },
            success:function(data)
            {
                loadDivs(saleId);
                $('.sale-overlay').fadeOut();
                $('.AddItemForm').trigger("reset");
                $('.addbutton').fadeIn();
                $('#messageBar').show().delay(3200).fadeOut(300);
                $('#messageBarText').html(data);
            },
            error: function(data)
            {
                console.log(data);
                $('#errorBar').show();
                $('html, body').animate({ scrollTop: 0 }, 0);
                $('#errorBarText').html(data.responseJSON);
                $('.sale-overlay').fadeOut();
                $('#changePriceModal').modal('hide').focus();
                $('.addbutton').fadeIn();
            }
        });
    return false;
});

function loadItemsDiv(saleId, callback) {
    $.ajax({
        type: "GET",
        url: '/api/venta/getItems/' + saleId,
        cache: false,
        dataType: 'html',
        success: function(data){
            $('#itemsTable').html(data).fadeIn('slow');
            if (callback != undefined) {
                callback();
            }
        }
    });
}

function loadTotalDiv(saleId, callback) {
    $.ajax({
        type: "GET",
        url: '/api/venta/getTotal/' + saleId,
        cache: false,
        dataType: 'html',
        success: function(data){
            $('#salePrice').html(data).fadeIn('slow');
            if (callback != undefined) {
                callback();
            }
        }
    });
}

function loadButtonsDiv(saleId, callback) {
    $.ajax({
        type: "GET",
        url: '/api/venta/getButtons/' + saleId,
        cache: false,
        dataType: 'html',
        success: function(data){
            $('#procButtons').html(data).fadeIn('slow');
            if (callback != undefined) {
                callback();
            }
        }
    });
}

function deleteItem(itemId, saleId, url, focus){
    $.ajax({
        type: "GET",
        url: url + itemId,
        cache: false,
        beforeSend:function(){
            $('.sale-overlay').fadeIn();
        },
        success:function(data)
        {
            loadDivs(saleId);
            $('.sale-overlay').fadeOut();
            $('#messageBar').show().delay(3200).fadeOut(300);
            $('#messageBarText').html(data);
            $('html, body').animate({
                scrollTop: $(focus).offset().top
            }, 1000);
        },
        error: function(data)
        {
            $('#errorBar').show();
            $('html, body').animate({ scrollTop: 0 }, 0);
            $('#errorBarText').html(data.responseText);
            $('.sale-overlay').fadeOut();
            $('#newPaymentModal').modal('hide').focus();
            $('.addbutton').fadeIn();
        }
    });
}

function giftItem(itemId, saleId, url, focus){
    console.log(url + itemId);
    $.ajax({
        type: "GET",
        url: url + itemId,
        cache: false,
        beforeSend:function(){
            $('.sale-overlay').fadeIn();
        },
        success:function(data)
        {
            loadDivs(saleId);
            $('.sale-overlay').fadeOut();
            $('#messageBar').show().delay(3200).fadeOut(300);
            $('#messageBarText').html(data);
            $('html, body').animate({
                scrollTop: $(focus).offset().top
            }, 1000);
        },
        error: function(data)
        {
            $('#errorBar').show();
            $('html, body').animate({ scrollTop: 0 }, 0);
            $('#errorBarText').html(data.responseText);
            $('.sale-overlay').fadeOut();
            $('#newPaymentModal').modal('hide').focus();
            $('.addbutton').fadeIn();
        }
    });
}


function updateItem(itemId,saleId){
    let itemQty = $('#itemQty-'+itemId).val();
    $.ajax({
        type: "GET",
        url: '/api/venta/updateItem/' + itemId + '/' + itemQty,
        cache: false,
        dataType: 'html',
        beforeSend:function(){
            $('.sale-overlay').fadeIn();
        },
        success:function(data)
        {
            loadDivs(saleId);
            $('.sale-overlay').fadeOut();
            $(itemQty).val('');
            $('#messageBar').show().delay(3200).fadeOut(300);
            $('#messageBarText').html(data.replace(/\"/g, ""));
        },
        error: function(data)
        {
            $('#errorBar').show();
            $('html, body').animate({ scrollTop: 0 }, 0);
            $('#errorBarText').html(data.responseText.replace(/\"/g, ""));
            $('.sale-overlay').fadeOut();
            $('#newPaymentModal').modal('hide').focus();
            $('.addbutton').fadeIn();
            loadDivs(saleId);
        }
    });
}


function loadPaymentDiv(saleId, callback) {
    $.ajax({
        type: "GET",
        url: '/api/venta/getPayments/' + saleId,
        cache: false,
        dataType: 'html',
        success: function(data){
            $('#paymentItems').html(data).fadeIn('slow');
            if (callback != undefined) {
                callback();
            }
        }
    });
}

function loadBalanceDiv(saleId, callback) {
    $.ajax({
        type: "GET",
        url: '/api/venta/getBalance/' + saleId,
        cache: false,
        dataType: 'html',
        success: function(data){
            $('#balance').html(data).fadeIn('slow');
            if (callback != undefined) {
                callback();
            }
        }
    });
}

function loadDivs(saleId){
    loadItemsDiv(saleId);
    loadTotalDiv(saleId);
    loadPaymentDiv(saleId);
    loadButtonsDiv(saleId);
    loadBalanceDiv(saleId);
}

function hideAlert() {
    $('#messageBar').fadeOut();
}
function hideErrorAlert() {
    $('#errorBar').fadeOut();
}

function applyBalance(saleId){
    $.ajax({
        type: "GET",
        url: '/api/venta/applyBalance/' + saleId,
        cache: false,
        beforeSend:function(){
            $('.sale-overlay').fadeIn();
        },
        success:function(data)
        {
            loadDivs(saleId);
            $('.sale-overlay').fadeOut();
            $('#messageBar').show().delay(3200).fadeOut(300);
            $('#messageBarText').html(data);
        },
        error: function(data)
        {
            let json, errors = [];
            json = $.parseJSON(data.responseText);
            $.each(json.errors, function(key, value){
                errors += value + '<br>';
            });
            $('#errorBar').show();
            $('html, body').animate({ scrollTop: 0 }, 0);
            $('#errorBarText').html(data.responseText);
            $('.sale-overlay').fadeOut();
        }
    });
}
function addAllPayment(saleId, paymentMethod){
    console.log(saleId, paymentMethod);
    $.ajax({
        type: "GET",
        url: '/venta/addAllPayment/' + saleId + '/' + paymentMethod,
        cache: false,
        beforeSend:function(){
            $('.sale-overlay').fadeIn();
        },
        success:function(data)
        {
            loadDivs(saleId);
            $('.sale-overlay').fadeOut();
            $('#messageBar').show().delay(3200).fadeOut(300);
            $('#messageBarText').html(data);
            $('html, body').animate({
                scrollTop: $("#paymentItems").offset().top
            }, 1000);
        },
        error: function(data)
        {
            let json, errors = [];
            json = $.parseJSON(data.responseText);
            $.each(json.errors, function(key, value){
                errors += value + '<br>';
            });
            $('#errorBar').show();
            $('html, body').animate({ scrollTop: 0 }, 0);
            $('#errorBarText').html(data.responseText);
            $('.sale-overlay').fadeOut();
        }
    });
}