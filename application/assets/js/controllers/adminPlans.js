var app = angular.module('adminApp', ['smart-table']);

app.controller('planCtrl', ['$scope', '$http', function ($scope, $http) {

    $scope.rowCollection = [];
    $scope.displayedCollection = [];
    $scope.editingData = [];

    $scope.displayedCollection = [].concat($scope.rowCollection);


    for (var i = 0, length = $scope.displayedCollection.length; i < length; i++) {
        $scope.editingData[$scope.displayedCollection[i].id] = false;
    }

    /**
     * get data from server
     */
    $http.get('/admin/getplans').success(function (data) {

        $scope.hideError = true;

        $scope.rowCollection = data.sort(byId);

    }).error(function () {
        $scope.hideError = false;
    });


    $scope.edit = function (tableData) {
        $scope.editingData[tableData.id] = true;
        $scope.editorEnabled = true;
    };

    $scope.cancelEditing = function (tableData) {
        $scope.editingData[tableData.id] = false;
        $scope.editorEnabled = false;
    };


    $scope.save = function (tableData) {
        $scope.editingData[tableData.id] = false;
        $scope.editorEnabled = false;

        $http({
            url: '/admin/saveplan',
            method: "POST",
            data: $.param(tableData),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function () {

        }).error(function () {
            $scope.hideError = false;
        });
    };

    $scope.addPlan = function () {

        var newItem =
        {
            'id': $scope.rowCollection.length + 1,
            'name': '',
            'price': '',
            'term': '',
            'posts': ''
        };

        $scope.rowCollection.push(newItem);
    }
}]);
