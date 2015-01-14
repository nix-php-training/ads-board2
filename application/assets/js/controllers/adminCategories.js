var app = angular.module('adminApp', ['smart-table']);

app.controller('categoriesCtrl', ['$scope', '$http', function ($scope, $http) {

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
    $http.get('/admin/getcategories').success(function (data) {

        $scope.hideError = true;
        $scope.rowCollection = data.sort(byId);

    }).error(function () {
        $scope.hideError = false;
    });

    $scope.edit = function (id) {
        $scope.editingData[id] = true;
        $scope.editorEnabled = true;
    };

    $scope.cancelEditing = function (id) {
        $scope.editingData[id] = false;
        $scope.editorEnabled = false;
    };


    $scope.save = function (row) {
        $scope.editingData[row.id] = false;
        $scope.editorEnabled = false;

        $http({
            url: '/admin/savecategory',
            method: "POST",
            data: $.param(row),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function () {

        }).error(function () {
            $scope.hideError = false;
        });
    };

    $scope.deleteCategory = function (row) {

        var index = $scope.rowCollection.indexOf(row);

        if (index !== -1) {
            $scope.rowCollection.splice(index, 1);

            $http({
                url: '/admin/removecategory',
                method: "POST",
                data: "id=" + row.id,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function () {

            }).error(function () {
                $scope.hideError = false;
            });
        }
    };

    $scope.addCategory = function () {

        var newItem =
        {
            'id': $scope.rowCollection.length + 1,
            'name': '',
            'description': ''
        };

        $scope.rowCollection.push(newItem);
    }
}]);
