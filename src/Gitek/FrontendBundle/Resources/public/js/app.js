/**
 * Created by ikerib on 07/10/14.
 */
var app = angular.module('app', ['ngRoute']);

app.config(function ($routeProvider) {
    $routeProvider

        .when('/', {
            controller: 'frontendController'
        })

});
