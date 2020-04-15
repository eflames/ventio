! function(e, i, s) {
    "use strict";
    Morris.Bar({
        element: "completed-project",
        data: [{
            device: "Ene",
            earning: 1835
        }, {
            device: "Feb",
            earning: 2356
        }, {
            device: "Mar",
            earning: 1459
        }, {
            device: "Abr",
            earning: 1289
        }, {
            device: "May",
            earning: 1647
        }],
        xkey: "device",
        ykeys: ["earning"],
        labels: ["Vendidos"],
        barGap: 6,
        barSizeRatio: .3,
        gridTextColor: "#fff",
        gridLineColor: "#fff",
        goalLineColors: "#000",
        numLines: 4,
        gridtextSize: 14,
        resize: !0,
        barColors: ["#E91E63"],
        xLabelAngle: 35,
        hideHover: "auto",
    });
}(window, document, jQuery);