//configuramos el calendario
$.datepicker.regional['es'] = {
    closeText: 'Cerrar',
    prevText: '&#x3c;Ant',
    nextText: 'Sig&#x3e;',
    currentText: 'Hoy',
    monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
        '               Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
    monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun',
        'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
    dayNames: ['Domingo', 'Lunes', 'Martes', 'Mi&eacute;rcoles', 'Jueves', 'Viernes', 'S&aacute;bado'],
    dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mi&eacute;', 'Juv', 'Vie', 'S&aacute;b'],
    dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'S&aacute;'],
    weekHeader: 'Sm',
    dateFormat: 'yy-mm-dd',
    firstDay: 1,
    isRTL: false,
    showMonthAfterYear: false,
    yearSuffix: ''};

$.datepicker.setDefaults($.datepicker.regional['es']);

$("#gitek_superlineabundle_registrotype_fecha").datepicker({
    dateFormat: 'yy-mm-dd',
    onSelect: function (dateText, inst) {
        // $("form input.somedatefield").val(dateText);
    }
});

$("#gitek_superlineabundle_registrotype_fechafin").datepicker({
    dateFormat: 'yy-mm-dd',
    onSelect: function (dateText, inst) {
        // $("form input.somedatefield").val(dateText);
    }
});


//boton eliminar puesto
$('.btnezabatu').on('click', function(){
//    var tabletid = $(ui.draggable.children('input')).val();
    var mytab = $('#mytab').val();
    var mix = $(this).siblings(".datos").find('input[name="x"]').val();
    var miy = $(this).siblings(".datos").find('input[name="y"]').val();
    var miid = $(this).siblings(".datos").find('input[name="id"]').val();

    var instruccionid = $(this).siblings(".datos").find('input[name="instruccionid"]').val();
    var usuarioid = $(this).siblings(".datos").find('input[name="usuarioid"]').val();
    var url = Routing.generate('delete_puesto', { id: miid });

    console.log("*********************");
    console.log("*********************");
    console.log('x =>' + mix);
    console.log('y =>' + miy);
    console.log('miid =>' + miid);
    console.log('instruccion id =>' + instruccionid);
    console.log('usuario id =>' + usuarioid);
    console.log('url =>' + url);
    console.log("*********************");
    console.log("*********************");


    $.ajax(url, {
        type: "DELETE",
        contentType: "application/json",
        success: function (data) {
            datos = $.parseJSON(data);
            var miurl = Routing.generate('puesto_config', { id: datos, mytab: mytab });
            window.location.replace(miurl);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }
    });

});


$(".dropeliminar").droppable({
    tolerance: "intersect",
    accept: ".cajapuesto",
    activeClass: "ui-state-default",
    hoverClass: "ui-state-hover",
    drop: function (event, ui) {
        var mytab = $('#mytab').val();
        var instruccionid = $(ui.draggable.children('input')).val();
        var mix = $(this).siblings(".datos").find('input[name="x"]').val();
        var miy = $(this).siblings(".datos").find('input[name="y"]').val();
        var miid = $(this).siblings(".datos").find('input[name="id"]').val();
        var tabletid = $(this).siblings(".datos").find('input[name="tabletid"]').val();

        var mid = $(ui.draggable.find('input[name="id"]'));

        $('<div></div>').appendTo('body')
            .html('<div><h6>¿Estas seguro?</h6></div>')
            .dialog({
                modal: true, title: 'Eliminar puesto', zIndex: 10000, autoOpen: true,
                width: 'auto', resizable: false,
                buttons: {
                    Si: function () {
                        $(ui.draggable).remove();
                        var url = Routing.generate('delete_puesto', { id: mid.val() });
                        $.ajax(url, {
                            type: "DELETE",
                            contentType: "application/json",
                            success: function (data) {
                                datos = $.parseJSON(data);
                                // console.log(datos);
                                // var prodid = datos.productoid;
                                var miurl = Routing.generate('puesto_config', { id: datos, mytab: mytab });
                                window.location.replace(miurl);
                            },
                            error: function (xhr, ajaxOptions, thrownError) {
                                alert(xhr.status);
                                alert(thrownError);
                            }
                        });
                        $(this).dialog("close");
                    },
                    No: function () {
                        $(this).dialog("close");
                    }
                },
                close: function (event, ui) {
                    $(this).remove();
                }
            });
    }
});

$('#btnAddPuesto').click(function () {
    var mytab = $('#mytab').val();
    var productoid = $('#productoid').val();
    var url = Routing.generate('post_puestos');

    $.ajax(url, {
        type: "POST",
        data: { lineaid: mytab, productoid: productoid },
        contentType: "application/json",
        success: function (data) {
            datos = $.parseJSON(data);
            var prodid = datos.producto.id;
            var miurl = Routing.generate('puesto_config', { id: prodid, mytab: mytab });
            window.location.replace(miurl);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }
    });
});

$(".dragtablet").draggable({
    appendTo: "body",
    cursor: "move",
    helper: 'clone',
    revert: "invalid"
});

$(".droptablet").droppable({
    tolerance: "intersect",
    accept: ".dragtablet",
    activeClass: "ui-state-default",
    hoverClass: "ui-state-hover",

    drop: function (event, ui) {
        // Solo un drop
        var tabletid = $(ui.draggable.children('input')).val();
        var mix = $(this).siblings(".datos").find('input[name="x"]').val();
        var miy = $(this).siblings(".datos").find('input[name="y"]').val();
        var miid = $(this).siblings(".datos").find('input[name="id"]').val();
        var instruccionid = $(this).siblings(".datos").find('input[name="instruccionid"]').val();
        var usuarioid = $(this).siblings(".datos").find('input[name="usuarioid"]').val();

        $(this).append($(ui.draggable.children()));
        $(this).addClass("mitablet");

        $(ui.draggable).remove();
        $(this).next().next()
            .find("input[name='instruccionid']")
            .val(instruccionid);

        var url = Routing.generate('put_puesto', { id: miid });
        $.ajax(url, {
            type: "PUT",
            data: { x: mix, y: miy, tabletid: tabletid, instruccionid: instruccionid, usuarioid: usuarioid },
            contentType: "application/json",
            success: function () {
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            }
        });
    }
});

$(".draginstruccion").draggable({
    appendTo: "body",
    cursor: "move",
    helper: "clone",
    // helper: function(event) {
    //   return $('<span class="badge badge-success"/>').text($(this).text());
    // },
    revert: "invalid"
});

$(".dropinstruccion").droppable({
    tolerance: "intersect",
    accept: ".draginstruccion",
    activeClass: "ui-state-default",
    hoverClass: "ui-state-hover",
    drop: function (event, ui) {

        var instruccionid = $(ui.draggable.children('input')).val();
        var mix = $(this).siblings(".datos").find('input[name="x"]').val();
        var miy = $(this).siblings(".datos").find('input[name="y"]').val();
        var miid = $(this).siblings(".datos").find('input[name="id"]').val();
        var tabletid = $(this).siblings(".datos").find('input[name="tabletid"]').val();
        var usuarioid = $(this).siblings(".datos").find('input[name="usuarioid"]').val();
        // $(this).remove();
        $(this).text("");
        // console.log($(ui.draggable.children()));
        var element = $(ui.draggable).children().clone();
        $(this).append(element);
        var url = Routing.generate('put_puesto', { id: miid });
        $.ajax(url, {
            type: "PUT",
            data: { x: mix, y: miy, tabletid: tabletid, instruccionid: instruccionid, usuarioid: usuarioid },
            contentType: "application/json",
            success: function () {

            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            }
        });
    }
});

$(".dragusuario").draggable({
    appendTo: "body",
    cursor: "move",
    helper: 'clone',
    revert: "invalid"
});

$(".dropusuario").droppable({
    tolerance: "intersect",
    accept: ".dragusuario",
    activeClass: "ui-state-default",
    hoverClass: "ui-state-hover",
    drop: function (event, ui) {
        var usuarioid = $(ui.draggable.children('input')).val();
        var mix = $(this).siblings(".datos").find('input[name="x"]').val();
        var miy = $(this).siblings(".datos").find('input[name="y"]').val();
        var miid = $(this).siblings(".datos").find('input[name="id"]').val();
        var tabletid = $(this).siblings(".datos").find('input[name="tabletid"]').val();
        var instruccionid = $(this).siblings(".datos").find('input[name="instruccionid"]').val();

        $(this).append($(ui.draggable.children("span")));

        $(ui.draggable).remove();
        $(this).next().next()
            .find("input[name='usuarioid']")
            .val(usuarioid);

        var url = Routing.generate('put_puesto', { id: miid });
        $.ajax(url, {
            type: "PUT",
            data: { x: mix, y: miy, tabletid: tabletid, instruccionid: instruccionid, usuarioid: usuarioid },
            contentType: "application/json",
            success: function () {
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            }
        });
    }
});

$(".cajapuesto").draggable({
    stop: function (event, ui) {
        var Stoppos = $(this).position();
        var mix = $(this).find('input[name="x"]');
        var miy = $(this).find('input[name="y"]');
        var miid = $(this).find('input[name="id"]').val();
        var tabletid = $(this).find('input[name="tabletid"]').val();
        var instruccionid = $(this).find('input[name="instruccionid"]').val();
        var usuarioid = $(this).find('input[name="usuarioid"]').val();
        mix.val(Stoppos.left);
        miy.val(Stoppos.top);

        var url = Routing.generate('put_puesto', { id: miid });
        $.ajax(url, {
            type: "PUT",
            data: { x: Stoppos.left, y: Stoppos.top, tabletid: tabletid, instruccionid: instruccionid, usuarioid: usuarioid },
            contentType: "application/json",
            success: function () {

            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            }
        });
    }
});


$('.mitooltip').tooltip({
    position: {
        my: "center bottom-20",
        at: "center top",
        using: function (position, feedback) {
            $(this).css(position);
            // console.log("Auskalo");
            $("<div>")
                .addClass("arrow")
                .addClass(feedback.vertical)
                .addClass(feedback.horizontal)
                .appendTo(this);
        }
    }
});


(function ($) {
    $.fn.liveDraggable = function (opts) {
        this.on("mousemove", function () {
            $(this).draggable(opts);
        });
    };
}(jQuery));

$('#cmbreferencia').on('change', function () {
    $('#dreferencias').html('');
    var referencias = {};
    var source = $("#theme-instrucciones").html();
    var template = Handlebars.compile(source);
    var ref = $(this).val();

    if (ref == '') {
        ref = "null";
    }
    var url = Routing.generate('filter_instrucciones', { 'ref': ref });
    var xhr = $.ajax(url, {
        type: "GET",
        contentType: "application/json"
    });
    xhr.done(function (data) {

        referencias = {referencias: data};

        $('#dreferencias').append(template(referencias));
        $(".draginstruccion").liveDraggable({
            appendTo: "body",
            cursor: "move",
            helper: "clone",
            revert: "invalid"
        });
        $('.mitooltip').tooltip({
            position: {
                my: "center bottom-20",
                at: "center top",
                using: function (position, feedback) {
                    $(this).css(position);
                    $("<div>")
                        .addClass("arrow")
                        .addClass(feedback.vertical)
                        .addClass(feedback.horizontal)
                        .appendTo(this);
                }
            }
        });
    });
});

$('#btn_delvideo').click(function () {
    miid = $('#delvideo').data('miid');

    var url = Routing.generate('deleteupload_instrucciones', { id: miid});

    $.ajax(url, {
        type: "POST",
        data: { },
        contentType: "application/json",
        success: function (data) {

//          console.log(data);
            $('#delvideo').empty();
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }
    });
});











