/**
 * Created by ikerib on 16/10/14.
 */

myApp.controller('aoiController', function($scope, OfertasService, toasty, $http, $location, $window, $resource, $timeout, dialogs,menufactory){

    $scope.mostrarpregunta = true;
    $scope.mostrarencargado = false;
    $scope.mostrarencargadopasswd = false;
    $scope.aoiValidado = false;

    $scope.validaraoi = function() {
        if (angular.isUndefined( $scope.aoiprograma )) {
            toasty.pop.error({
                title: "Error!",
                msg: 'Introduce el nombre del programa.',
                timeout: 0,
                showClose: true,
                clickToClose: false,
            });
        } else {
            $scope.mostrarpregunta = false;
            $scope.mostrarencargado = true;
            $scope.mostrarencargadopasswd = false;
        }
    }

    $scope.askpasswd = function() {

        $scope.mostrarpregunta = false;
        $scope.mostrarencargado = false;
        $scope.mostrarencargadopasswd = true;

        $http.get('/api/v1/emails/send').success(function(data) {});

        toasty.pop.wait({
            title: 'Esperar por favor',
            msg: 'Contactando con el encargado.',
            timeout: 0,
            clickToClose: false,
            showClose: false,
            onAdd: function(toasty) {

                var doSuccess = function() {
                    toasty.title = 'Success';
                    toasty.msg = 'Loading finished!';
                    toasty.setType('success');
                    toasty.showClose = true;
                }


            }
        });

    }

    $scope.verificarAoi = function() {
        menufactory.setNumber(6);
        $location.path('completado');

    }

});

