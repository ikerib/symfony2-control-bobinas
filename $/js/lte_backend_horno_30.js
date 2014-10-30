/**
 * Created by ikerib on 16/10/14.
 */

myApp.controller('hornoController', function($scope, OfertasService, toasty, $http, $location, $window, $resource, $timeout, dialogs,menufactory){

    $scope.mostrarpregunta = true;
    $scope.mostrarencargado = false;
    $scope.mostrarencargadopasswd = false;
    $scope.serigrafiaValidado = false;

    $scope.validarpickandplace = function() {
        $scope.mostrarpregunta = false;
        $scope.mostrarencargado = true;
        $scope.mostrarencargadopasswd = false;
    }

    $scope.askpasswd = function() {

        $scope.mostrarpregunta = false;
        $scope.mostrarencargado = false;
        $scope.mostrarencargadopasswd = true;

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

    $scope.verificarSerigrafia = function() {
        console.log("hemen!");
        $location.path('horno');

    }

});

