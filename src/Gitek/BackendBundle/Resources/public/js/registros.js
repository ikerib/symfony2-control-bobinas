$("a#fancyBoxLink").fancybox({
    'href': '#filtrofecha',
    'titleShow': false,
    'transitionIn': 'elastic',
    'transitionOut': 'elastic'
});

$(document).ready(function () {
    var $myDiv = $('#lanzadorerror');

    if ($myDiv.length) {
        $.fancybox.open({"href": "#lanzadorerror", "closeBtn": false});
    }

    $('.btn_fancy_itxi').on('click', function () {
        $.fancybox.close();
        return false;
    });

    $('#btnbidali').on('click', function (e) {

        var lineak = $('#gitek_superlineabundle_registrotype_lineas').val();

        if (lineak === null) {
            e.preventDefault();
            alert("Tienes que seleccionar una línea como mínimo.");
        } else {
            $('#formu').submit();
        }

    });

//    $('#gitek_superlineabundle_registrotype_fecha').change(function () {
//
//        if ($('#gitek_superlineabundle_registrotype_fechafin').val() === "") {
//            var mifec = $('#gitek_superlineabundle_registrotype_fecha').val();
//            $('#gitek_superlineabundle_registrotype_fecha').val(mifec);
//        }
//    });

    $('#reservation').daterangepicker({
            locale: {
                applyLabel: 'Seleccionar',
                fromLabel: 'Desde',
                toLabel: 'Hasta',
                customRangeLabel: 'Rango personalizado',
                daysOfWeek: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
                monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                firstDay: 1
            }
        },
        function (start, end, label) {
            $('#gitek_superlineabundle_registrotype_fecha').val(start.format('YYYY-MM-DD'));
            $('#gitek_superlineabundle_registrotype_fechafin').val(end.format('YYYY-MM-DD'));
        });

});

