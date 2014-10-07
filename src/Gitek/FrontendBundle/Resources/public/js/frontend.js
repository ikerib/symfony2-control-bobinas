/**
 * Created by ikerib on 07/10/14.
 */
$(function() {

    $('.login').on('click', function(){
        $miid = $(this).data('userid');
        $('#userid').val($miid);
        $('#userid').text($miid);
        $('#frmlogin').submit();
    });

});