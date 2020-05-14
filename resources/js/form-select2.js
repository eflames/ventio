//select2 hack
$('.modal-body select').css('width', '100%');
! function(e, t, r) {
    "use strict";

r(".select2-ajax-products").select2({
        placeholder: "Seleccionar producto",
        ajax: {
            // url: "http://api.github.com/search/repositories",
            url: "/api/productos/",
            dataType: "json",
            delay: 250,
            data: function(e) {
                return {
                    q: e.term
                }
            },
            processResults: function(e, t) {
                return {
                    results: e
                };
            },
        },
        escapeMarkup: function(e) {
            return e
        },
        minimumInputLength: 2,
        templateResult: function(e) {
            if (e.loading) return e.text;
            // return "<strong>" + e.name + "</strong>";
            var t = "<div class='container text-center'><p><span class='ft-shopping-cart green'></span> - <span class='text-bold-700 text-uppercase'> " + e.name + "</span><br>" +
                e.description + "<br>" 
                + "</span> <span class='badge badge-secondary mt-1'>" + e.category + "</span></div>";
            return t;



            // var t = '<div class='select2-result-repository clearfix'><div class='select2-result-repository__meta'><div class='select2-result-repository__title'>" + e.name + "</div>";
            // e.description && (t += "<div class='select2-result-repository__description'>" + e.description + "</div>");
            // return t += "<div class='select2-result-repository__statistics'><div class='select2-result-repository__forks'><i class='fa fa-code-branch mr-0'></i> " + e.category + "</div>"
        },
        templateSelection: function(e) {
            return e.name || e.text
        }
    });
r(".select2-ajax-products-sale").select2({
        placeholder: "Seleccionar producto",
        ajax: {
            // url: "http://api.github.com/search/repositories",
            url: "/api/productos-stock/",
            dataType: "json",
            delay: 250,
            data: function(e) {
                return {
                    q: e.term
                }
            },
            processResults: function(e, t) {
                return {
                    results: e
                };
            },
        },
        escapeMarkup: function(e) {
            return e
        },
        minimumInputLength: 2,
        templateResult: function(e) {
            if (e.loading) return e.text;
            // return "<strong>" + e.name + "</strong>";
            var t = "<div class='container pt-1 pb-1'><span class='ft-shopping-cart green'></span> - <span class='text-bold-700 text-uppercase'> " + e.name + "</span></strong>" +
                "<span class='float-right'><span class='badge badge-md badge-secondary'><i class='icon-drawer'></i>" + e.stock + "</span><span class='ml-1 badge badge-md badge-success'><strong>$" + e.price + "</strong></span></span></div>";
            return t;



            // var t = '<div class='select2-result-repository clearfix'><div class='select2-result-repository__meta'><div class='select2-result-repository__title'>" + e.name + "</div>";
            // e.description && (t += "<div class='select2-result-repository__description'>" + e.description + "</div>");
            // return t += "<div class='select2-result-repository__statistics'><div class='select2-result-repository__forks'><i class='fa fa-code-branch mr-0'></i> " + e.category + "</div>"
        },
        templateSelection: function(e) {
            return e.name || e.text
        }
    });
    r(".select2-ajax-clients").select2({
        placeholder: "Seleccionar cliente",
        ajax: {
            // url: "http://api.github.com/search/repositories",
            url: "/api/clientes/",
            dataType: "json",
            delay: 250,
            data: function(e) {
                return {
                    q: e.term
                }
            },
            processResults: function(e, t) {
                return {
                    results: e
                };
            },
        },
        escapeMarkup: function(e) {
            return e
        },
        minimumInputLength: 2,
        templateResult: function(e) {
            if (e.loading) return e.text;
            // return "<strong>" + e.name + "</strong>";
            var t = "<div class='container'><h4 class='text-uppercase pt-0'><span class='ft-user green'></span> - " + e.name + "</h4>" +
                "<strong><span class='fa fa-id-card grey'></span> " + e.id_number + " | <strong><span class='fa fa-phone grey'>" + "</strong> " + e.telephone + "</div>";
            return t;



            // var t = '<div class='select2-result-repository clearfix'><div class='select2-result-repository__meta'><div class='select2-result-repository__title'>" + e.name + "</div>";
            // e.description && (t += "<div class='select2-result-repository__description'>" + e.description + "</div>");
            // return t += "<div class='select2-result-repository__statistics'><div class='select2-result-repository__forks'><i class='fa fa-code-branch mr-0'></i> " + e.category + "</div>"
        },
        templateSelection: function(e) {
            return e.name || e.text
        }
    })
}(window, document, jQuery);