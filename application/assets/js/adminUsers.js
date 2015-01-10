var app = angular.module('adminApp', ['smart-table']);

app.controller('userCtrl', ['$scope', '$http', function ($scope, $http) {

    $scope.rowCollection = [];
    $scope.displayedCollection = [];

    var byId = function (a, b) {
        if (a.id < b.id)
            return -1;
        if (a.id > b.id)
            return 1;
        return 0;
    };

    $http.get('/admin/showusers').success(function (data) {
        $scope.rowCollection = data.sort(byId);
    }).error(function () {

    });

    $scope.displayedCollection = [].concat($scope.rowCollection);

    //ban user
    $scope.ban = function (row) {
        var index = $scope.rowCollection.indexOf(row);
        if (index !== -1) {
            //TODO: implementation of user ban function
        }
    }
}]);
