/**
 * Created by ikerib on 15/10/14.
 */
myApp.controller('tablaController', function($scope, OfertasService, $http, $location, $window, $resource, $timeout, dialogs){

    $('#codbarcomponente').focus();

    var ofertas = OfertasService.first();

    $scope.ofs = ofertas.operaciones[0].materiales;

    $scope.leeComponente = function() {

        var newof = {};
        newof.componente="0000000";
        newof.posicion_feeder="0000000";
        newof.posicion_msl="0000000";
        newof.cantidad="0000000";
        newof.total="0000000";

        // API.PostOf({ newof }, function (success) {
        $scope.ofs.push(newof);
        $scope.codbarcomponente="";
        if ( $scope.ofs.length > 9 ) {

            var dlg = dialogs.confirm("Confirmacioón","Has completado la fase 1. ¿Pasamos a la fase2?");
            dlg.result.then(function(btn){
                //$window.location.href = "/app_dev.php/fase2";
                $location.path('serigrafia');
            },function(btn){
                console.log(btn);
            });
        };
        // })
    }

    $scope.removeMaterial = function ( idx ) {
        var of_to_delete = $scope.ofs[idx];

        // API.DeleteOf({ id: of_to_delete.id }, function (success) {
        $scope.ofs.splice(idx, 1);
        // });
    };

});
