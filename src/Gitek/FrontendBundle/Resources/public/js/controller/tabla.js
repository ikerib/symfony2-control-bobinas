/**
 * Created by ikerib on 15/10/14.
 */
myApp.controller('tablaController', function($scope, OfertasService,toasty, $http, $location, $window, $resource, $timeout, dialogs, menufactory){

    $('#codbarcomponente').focus();

    var ofertas = OfertasService.first();

    $scope.ofs = ofertas.operaciones[0].materiales;
    $scope.valuenow = 30;

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
        $scope.valuenow = parseInt($scope.valuenow) +10;

        toasty.pop.success({
            title: "Correcto!",
            msg: 'Añadido correctamente.',
            timeout: 5000,
            showClose: true,
            myData: 'Testing 1 2 3', // Strings, integers, objects etc.
            onClick: function (toasty) {
                //toasty.title = 'Well done!';
                //toasty.msg = 'Closing in 5 seconds.';
                //toasty.timeout = 5000;
                //console.log(toasty.myData);
                toasty.remove();
                //toasty.removeAll();
            },
            onAdd: function (toasty) {
                console.log(toasty.id + ' has been added!');
            },
            onRemove: function (toasty) {
                console.log(toasty.id + ' has been removed!');
            }
        });

        if ( $scope.ofs.length > 9 ) {

            var dlg = dialogs.confirm("Confirmación","Has completado la fase 1. ¿Pasamos a la fase2?");
            dlg.result.then(function(btn){
                menufactory.setNumber(2);
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
