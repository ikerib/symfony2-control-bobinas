/**
 * Created by ikerib on 07/10/14.
 */
var myApp = angular.module('myApp',['ngRoute','ngResource', 'datatables']);

myApp.config(['$routeProvider', '$locationProvider',
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

myApp.factory('ofertas', function () {
    return {
        of: "OF212042",
        fetxa_fabricacion_inicio: "19/06/2014",
        fetxa_fabricacion_fin: "17/07/2014",
        cantidad_a_fabricar: 250,
        articulo: "3CI0473010 blablabla",
        operaciones: [
            { operacion : [
                {
                    componente: "11RE050049 R 1206",
                    posicion_feeder: "f38",
                    posicion_msql: "R27 R49 R58",
                    cantidad: 3.00,
                    total: 750.50
                },
                {
                    componente: "11BO090004 BO 1812",
                    posicion_feeder: "f24",
                    posicion_msql: "L3",
                    cantidad: 1.00,
                    total: 252.50
                },
                {
                    componente: "11CC030025",
                    posicion_feeder: "f46",
                    posicion_msql: "C27 C33",
                    cantidad: 2.00,
                    total: 500.50
                }
            ]},
            { operacion : [
                {
                    componente: "11RE050049 R 1206",
                    posicion_feeder: "f38",
                    posicion_msql: "R27 R49 R58",
                    cantidad: 3.00,
                    total: 750.50
                },
                {
                    componente: "11BO090004 BO 1812",
                    posicion_feeder: "f24",
                    posicion_msql: "L3",
                    cantidad: 1.00,
                    total: 252.50
                },
                {
                    componente: "11CC030025",
                    posicion_feeder: "f46",
                    posicion_msql: "C27 C33",
                    cantidad: 2.00,
                    total: 500.50
                }
            ]},
        ],
        finalizado: false
    };
});

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

myApp.controller('tablaController', ['$scope', '$http', '$location','DTOptionsBuilder', 'DTColumnBuilder', function($scope, Data, $http, $location, DTOptionsBuilder, DTColumnBuilder, $resource) {

    $('#codbarcomponente').focus();
console.log(Data.operaciones);
    $scope.ofs = Data.operaciones[0];

    $scope.dtOptions = DTOptionsBuilder.newOptions().withPaginationType('full_numbers').withBootstrap();

    $scope.leeComponente = function() {

        var newof = {};
        newof.componente="0000000";
        newof.posicion_feeder="0000000";
        newof.posicion_msl="0000000";
        newof.cantidad="0000000";
        newof.total="0000000";

        $scope.ofs.push(newof);

    }

}]);