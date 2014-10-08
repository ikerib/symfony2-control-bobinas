/**
 * Created by ikerib on 07/10/14.
 */
var myApp = angular.module('myApp',['ngRoute','ngResource']);

myApp.config(
    ['$routeProvider', '$locationProvider',
    function ($routeProvider, $locationProvider) {
        $locationProvider.html5Mode(true).hashPrefix('!');
        $routeProvider
            .when("/", {
                templateUrl: 'pages/material', // dummy example
                controller: 'frontendController'
            })
            .otherwise({redirectTo: '/home'});
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


myApp.controller('frontendController', ['$scope', '$http', function($scope, $http) {
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
            $('#operacion').focus();
        });

    }




}]);