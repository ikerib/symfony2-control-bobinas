/**
 * Created by ikerib on 15/10/14.
 */
myApp.controller('menuController', function($scope, OfertasService,toasty, $http, $location, $window, $resource, $timeout, dialogs, menufactory){

    $scope.menua = 0;
    $scope.$watch(function () { return menufactory.getNumber();         }, function (value) {
        $scope.menua = value;
    });
});
