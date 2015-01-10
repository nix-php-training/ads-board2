var app = angular.module('adminApp', ['smart-table']);

app.controller('userCtrl', ['$scope', '$http', function ($scope, $http) {

    //var testData = [
    //    {
    //        'login': 'dude',
    //        'email': 'dude@mail.com',
    //        'name': 'Olivier Renard',
    //        'banned': false
    //    },
    //    {
    //        'login': 'notDude',
    //        'email': 'notdude@mail.com',
    //        'name': 'Maria Frere',
    //        'banned': false
    //    },
    //    {
    //        'login': 'pepper',
    //        'email': 'pepper@mail.com',
    //        'name': 'Max Renard',
    //        'banned': true
    //    }
    //];

    $scope.rowCollection = [];
    $scope.displayedCollection = [];

    $http.get('/admin/showusers').success(function(data) {
        $scope.rowCollection.push(data);

        console.log($scope.rowCollection);
    }).error(function(){

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
