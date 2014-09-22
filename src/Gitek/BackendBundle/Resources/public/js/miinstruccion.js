
$('.noencontrado').click(function(){
  location.reload(true); // con true desde el servidor, false desde la cache
});

$('.pedidomaterial').click(function(){

  var puestoid   = $('#puestoid').val();
  var productoid = $('#productoid').val();
  var lineaid    = $('#lineaid').val();
  var usuarioid  = $('#usuarioid').val();
  var materialid = $(this).next().val();

  if($(this).hasClass('kuadro')) {
    // marcamos pedido como recibido
    var pedidoid = $(this).next().next().val();
    var url      = Routing.generate('put_pedido', { id: pedidoid });
    var midiv    = $(this);
    $.ajax(url, {
          type : "PUT",
          contentType : "application/json",
          success : function(data) {
            $(midiv).removeClass('kuadro');
            $(midiv).removeClass('kuadro-gorria');
            $(midiv).removeClass('kuadro-berdea');
            $(midiv).removeClass('kuadro-urdina');
            $(midiv).removeClass('kuadro-beltza');
            $('#avisopedido').toggle();
            $(midiv).next().next().val("");
          },
          error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      });
  } else {
    var url = Routing.generate('post_pedidos');
    var midiv = $(this);
    $.ajax(url, {
          type : "POST",
          data: { materialid: materialid, puestoid:puestoid, productoid:productoid, lineaid:lineaid, usuarioid:usuarioid },
          contentType : "application/json",
          success : function(data) {

            datos = $.parseJSON(data);
            $('#avisopedido').toggle();
            $(midiv).addClass('kuadro');
            $(midiv).addClass('pedidoencurso');
            $(midiv).addClass(datos.kolorea);
            $(midiv).next().next().val(datos.pedidoid);
          },
          error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      });
  }
});

$(document).ready(function() {
  $('video').get(0).play();
});
