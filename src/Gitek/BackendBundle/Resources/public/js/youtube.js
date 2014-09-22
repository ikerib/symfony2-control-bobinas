
$(document).ready(function() {

  var badubada = $('#gitek_superlineabundle_instrucciontype_youtube').val();
//  console.log("Badubada: " + badubada);
  if (badubada!=="") {
    $('#urlyoutube').val("http://www.youtube.com/watch?v=" + badubada);
  }
});

// youtube
$('#btnguardar').click(function() {
//      console.log("IEUP!");
//      console.log($('#urlyoutube').val());
      if ($('#urlyoutube').val() !== "") {
        try {

          var video_id = $('#urlyoutube').val().split('v=')[1];
//          console.log(video_id);
          var ampersandPosition = video_id.indexOf('&');
//          console.log(ampersandPosition);
          if(ampersandPosition != -1) {
              video_id = video_id.substring(0, ampersandPosition);
          }
//          console.log(video_id);
          $('#gitek_superlineabundle_instrucciontype_youtube').val(video_id);


          $('#formulario').submit();
        }
        catch(err) {
          alert ("No es una dirección Youtube válida.");
          return;
        }


      } else {
        $('#gitek_superlineabundle_instrucciontype_youtube').val("");
        $('#formulario').submit();
      }


});

$('#btn_delurl').click(function() {
  $('#gitek_superlineabundle_instrucciontype_youtube').val("");
  $('#urlyoutube').val("");
  $('#delurl').empty();
  $('#btn_delurl').hide();
});

$(".fancyoutube").click(function() {
    $.fancybox({
      'padding'   : 0,
      'autoScale'   : false,
      'transitionIn'  : 'none',
      'transitionOut' : 'none',
      'title'     : this.title,
      'width'     : 680,
      'height'    : 495,
      'href'      : this.href.replace(new RegExp("watch\\?v=", "i"), 'v/'),
      'type'      : 'swf',
      'swf'     : {
      'wmode'     : 'transparent',
      'allowfullscreen' : 'true'
      }
    });

    return false;
  });