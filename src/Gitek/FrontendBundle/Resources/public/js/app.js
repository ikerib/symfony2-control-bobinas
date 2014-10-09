/**
 * Created by ikerib on 07/10/14.
 */
var myApp = angular.module('myApp',['ngRoute','ngResource', 'datatables']);

myApp.config(
    ['$routeProvider', '$locationProvider',
    function ($routeProvider, $locationProvider) {
        //$locationProvider.html5Mode(false).hashPrefix('!');

        $routeProvider
            .when("/", {
                controller: 'frontendController'
            })
            .when("/tabla",{
                templateUrl: '/bundles/frontend/partials/tabla.html',
                controller: 'tablaController'
            });
    }
]);

myApp.directive('ngEnter', function () {
    return function (scope, element, attrs) {
        element.bind("keydown keypress", function (event) {
            if(event.which === 13) {
                scope.$apply(function (){
                    scope.$eval(attrs.ngEnter);
                });

                event.preventDefault();
            }
        });
    };
});

myApp.directive('autoFocus', function ($timeout) {
    return {
        scope: {
            trigger: '@autoFocus'
        },
        link: function (scope, element) {
            scope.$watch('trigger', function (value) {
                console.log('focus to element ' + element[0].id + " " +value );
                if (value == 'true') {
                    $timeout(function () {
                        console.log('giving focus to element', element[0].id);
                        element[0].focus();
                    });
                }
            });
        }
    };
});

myApp.controller('frontendController', ['$scope', '$http','$location', function($scope, $http, $location) {
    $scope.of = {};

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

    $scope.leeComponente = function() {

        //var t = $('#example2').DataTable();

        //t.row.add( [
        //    '11RE050049',
        //    'f45',
        //    'R27',
        //    '3',
        //    '122'
        //] ).draw();


    }


}]);

myApp.controller('tablaController', ['$scope', '$http', function($scope, $http) {
    $('#codbarcomponente').focus();
}]);