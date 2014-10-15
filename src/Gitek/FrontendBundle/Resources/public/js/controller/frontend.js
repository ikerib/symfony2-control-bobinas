/**
 * Created by ikerib on 15/10/14.
 */
myApp.controller('frontendController', ['$scope', '$http', '$location', function($scope, $http, $location) {

    $scope.leeof = function () {

        var codbar = $scope.of.codbaroferta;

        $http.get('/api/v1/ordens/' + codbar).success(function(data) {
            $scope.of.id = data.id;
            $('#operacion').focus();
        });

    }

    $scope.leoperacion = function () {

        var codbar = $scope.of.codbaroperacion;

        $http.get('/api/v1/operacions/' + codbar).success(function(data) {
            $scope.of.operacion = data.operacion;
            $location.url('/tabla')

        });
    }
}]);