/**
 * Created by ikerib on 15/10/14.
 */
myApp.controller('frontendController', function($scope, $http, $location, menufactory) {

    $scope.leeof = function () {

        var codbar = $scope.of.codbaroferta;
        $http.get('http://gitek2.grupogureak.com/proxy/expertis/' + codbar).success(function(data) {
            if ( data.IDArticulo == "-" ) {
                $scope.of.id = "no encontrado.";
                $('#of').focus();
            } else {
                $scope.of.id = data.NOrden;
                $('#operacion').focus();
            }
        });

    }

    $scope.leoperacion = function () {

        var codbar = $scope.of.codbaroperacion;
        var of = $scope.of.id;
        http://10.0.0.12:5080/expertis/poropertaoperacion?of=OF212042&operacion=50179314
        $http.get('http://10.0.0.12:5080/expertis/poropertaoperacion?of=' + of + '&operacion=' + codbar).success(function(data) {
            if ( data.length > 0) {
                $scope.of.operacion = data.operacion;
                menufactory.setNumber(1);
                $location.url('/tabla')
            } else {
                $scope.of.operacion = "no encontrado";
            }

        });
    }

});