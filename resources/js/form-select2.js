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
            var t = "<div class='container'><p><span class='fa fa-arrow-right green'></span><span class='text-bold-700 text-uppercase'> " + e.name + "</span><br>" +
                e.description + "<br><strong><span class='fa fa-list'>" +
                "</span> Categoría: </strong><span class='pink'>" + e.category + "</span></span></div>";
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
            var t = "<div class='container'><p><span class='fa fa-arrow-right green'></span><span class='text-bold-700 text-uppercase'> " + e.name + "</span></strong><br>" +
                "<strong>Stock:</strong> <span class='pink'>" + e.stock + "</span> <strong>Precio:</strong> </strong><span class='pink'>$ " + e.price + "</span></div>";
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
            var t = "<div class='container'><p><span class='fa fa-arrow-right green'></span><span class='text-bold-700 text-uppercase'> " + e.name + "</span><br>" +
                "<strong><span class='fa fa-id-card'></span> " + e.id_number + "<br><strong><span class='fa fa-phone'>" +
                "</strong> " + e.telephone + "</div>";
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