var app = angular.module('adminApp', ['smart-table']);

app.controller('planCtrl', ['$scope', '$http', function ($scope, $http) {

    var testData = [
        {
            'id': '0',
            'name': 'free',
            'price': '0',
            'term': '30',
            'posts': '10'
        },
        {
            'id': '1',
            'name': 'pro',
            'price': '99',
            'term': '30',
            'posts': '1000'
        },
        {
            'id': '2',
            'name': 'business',
            'price': '199',
            'term': '30',
            'posts': '0'
        }
    ];

    $scope.rowCollection = [];
    $scope.displayedCollection = [];
    $scope.editingData = [];

    $scope.rowCollection = testData;

    $scope.displayedCollection = [].concat($scope.rowCollection);


    for (var i = 0, length = $scope.displayedCollection.length; i < length; i++) {
        $scope.editingData[$scope.displayedCollection[i].id] = false;
    }


    $scope.edit = function(tableData){
        $scope.editingData[tableData.id] = true;
        $scope.editorEnabled = true;
    };

    $scope.cancelEditing = function(tableData){
        $scope.editingData[tableData.id] = false;
        $scope.editorEnabled = false;
    };


    $scope.update = function(tableData){
        $scope.editingData[tableData.id] = false;
        $scope.editorEnabled = false;

        console.log(tableData);
    };
}]);