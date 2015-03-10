/**
 * Created by ikerib on 07/10/14.
 */
var myApp = angular.module('myApp',['ngRoute','ngResource', 'ngTable','ngAnimate', 'toasty',
    'ui.bootstrap', 'dialogs.main','pascalprecht.translate','dialogs.default-translations'])

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
            })
            .when("/serigrafia",{
                templateUrl: '/bundles/frontend/partials/serigrafia.html',
                controller: 'serigrafiaController'
            })
            .when("/pickandplace",{
                templateUrl: '/bundles/frontend/partials/pickandplace.html',
                controller: 'pickandplaceController'
            })
            .when("/horno",{
                templateUrl: '/bundles/frontend/partials/horno.html',
                controller: 'hornoController'
            })
            .when("/aoi",{
                templateUrl: '/bundles/frontend/partials/aoi.html',
                controller: 'aoiController'
            })
            .when("/completado",{
                templateUrl: '/bundles/frontend/partials/completado.html',
                controller: 'completadoController'
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

myApp.factory("menufactory", function () {
  var number = 0;
  function getNumber() {
    return number;
  }
  function setNumber(newNumber) {
    number = newNumber;
  }
  return {
    getNumber: getNumber,
    setNumber: setNumber,
  }
});

myApp.factory('OfertasService', function ($http) {
    var ordenes =[{
        of: "OF212042",
        fetxa_fabricacion_inicio: "19/06/2014",
        fetxa_fabricacion_fin: "17/07/2014",
        cantidad_a_fabricar: 250,
        articulo: "3CI0473010 blablabla",
        operaciones: [
            { operacion : 'blablabla',
                materiales:[
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
            { operacion : 'blebleble',
                materiales:[
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
    }];
    return {
        all: function() {
            return ordenes;
        },
        first: function() {
            return ordenes[0];
        }
    };
    // return {
    //     all: function(of,operacion) {
    //         var datuak = $http.get('http://10.0.0.12:5080/expertis/poropertaoperacion?of=' + of + '&operacion=' + operacion).success(function(data) {
    //             return data;
    //         });
    //         console.log("HEMEN");
    //         console.log(datuak);
    //     },
    //     first: function() {
    //         return ordenes[0];
    //     }
    // };
});