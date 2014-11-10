/**
 * Created by ikerib on 16/10/14.
 */

myApp.controller('pickandplaceController', function($scope, OfertasService, toasty, $http, $location, $window, $resource, $timeout, dialogs, menufactory){

    $('#codbarcomponente').focus();

    var ofertas = OfertasService.first();

    $scope.ofs = ofertas.operaciones[0].materiales;
    $scope.valuenow = 30;


    $scope.containsObject = function(obj, list) {
        var i;
        for (i = 0; i < list.length; i++) {
            if (list[i].codbarcomponente === obj) {
                return true;
            }
        }
    }

    $scope.leeComponente = function() {

        if ( $scope.containsObject($scope.codbarcomponente,$scope.ofs) == true) {
            toasty.pop.error({
                title: 'Error!',
                msg: 'Ese componente ya ha sido incluido.',
                timeout: 3000,
                showClose: true,
                clickToClose: true,
            });
            $scope.codbarcomponente="";
            return
        } else {
            $('#codbarposicion').focus();
        }
    }

    $scope.leePosicion = function() {

        if ( $scope.containsObject($scope.codbarposicion,$scope.ofs) == true) {
            toasty.pop.error({
                title: 'Error!',
                msg: 'Esea hubicación es incorrecta.',
                timeout: 0,
                showClose: true,
                clickToClose: true,
            });
            $scope.codbarposicion="";
            return
        }

        var newof = {};
        newof.codbarcomponente = $scope.codbarcomponente;
        newof.codbarposicion = $scope.codbarposicion;
        newof.componente="0000000";
        newof.posicion_feeder="0000000";
        newof.posicion_msl="0000000";
        newof.cantidad="0000000";
        newof.total="0000000";

        $scope.ofs.push(newof);
        $scope.codbarcomponente="";
        $scope.codbarposicion="";
        $scope.valuenow = parseInt($scope.valuenow) +10;

        toasty.pop.success({
            title: "Correcto!",
            msg: 'Añadido correctamente.',
            timeout: 3000,
            showClose: true,
            myData: 'Testing 1 2 3', // Strings, integers, objects etc.
            onClick: function (toasty) {
                toasty.remove();
            },
            onAdd: function (toasty) {
                console.log(toasty.id + ' has been added!');
            },
            onRemove: function (toasty) {
                console.log(toasty.id + ' has been removed!');
            }
        });

        $('#codbarcomponente').focus();

        if ( $scope.ofs.length > 9 ) {

            var dlg = dialogs.confirm("Confirmación","Has completado la fase 2. ¿Pasamos a la fase3?");
            dlg.result.then(function(btn){
                menufactory.setNumber(2);
                $location.path('serigrafia');
            },function(btn){
                console.log(btn);
            });
        };

    }

    $scope.removeMaterial = function ( idx ) {
        var of_to_delete = $scope.ofs[idx];

        $scope.ofs.splice(idx, 1);
        $scope.valuenow = parseInt($scope.valuenow) -10;
    };

});

