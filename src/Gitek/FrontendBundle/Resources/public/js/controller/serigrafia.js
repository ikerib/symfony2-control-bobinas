/**
 * Created by ikerib on 15/10/14.
 */
myApp.controller('serigrafiaController', function($scope, OfertasService, toasty, $http, $location, $window, $resource, $timeout, dialogs, menufactory){

    $scope.mostrarpregunta = true;
    $scope.mostrarencargado = false;
    $scope.mostrarencargadopasswd = false;
    $scope.serigrafiaValidado = false;


    $http.get('/api/v1/serigrafia').success(function(data) {
        $scope.galderak = data;
    }).error(function () {
        $scope.galderak="";
    });

    $scope.validarserigrafia = function() {
        $scope.mostrarpregunta = false;
        $scope.mostrarencargado = true;
        $scope.mostrarencargadopasswd = false;
    }

    $scope.llamaEncargado = function() {
        toasty.pop.error({
            title: "Error!",
            msg: 'LLAMA AL ENCARGADO.',
            timeout: 0,
            showClose: true,
            clickToClose: false,
        });
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

    $scope.verificarSerigrafia = function() {

        menufactory.setNumber(3);
        $location.path('pickandplace');

    }

});

