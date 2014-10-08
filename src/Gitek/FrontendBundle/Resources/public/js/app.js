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

myApp.controller('frontendController', ['$scope', '$http', function($scope, $http) {
    $scope.of = {};

    $scope.leeof = function (codbar) {

        $http.get('of/' + codbar).success(function(data) {
            $scope.of.id = data;
        });

    }

}]);