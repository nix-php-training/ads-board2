var app = angular.module('adminApp', ['smart-table']);

app.controller('adsCtrl', ['$scope', '$http', function ($scope, $http) {

    $scope.rowCollection = [];
    $scope.displayedCollection = [];
    $scope.editingData = [];
    $scope.imgHost = cnst.IMG_HOST;
    $scope.imgPreview = cnst.PREVIEW;

    $scope.displayedCollection = [].concat($scope.rowCollection);

    /**
     * get data from server
     */
    $http.get('/admin/getadvertisements').success(function (data) {

        $scope.hideError = true;

        console.log(data);

        $scope.rowCollection = data.sort(byId);
        $scope.displayedCollection = [].concat($scope.rowCollection);

    }).error(function () {
        $scope.hideError = false;
    });


    $scope.deleteAds = function (row) {

        var index = $scope.rowCollection.indexOf(row);

        if (index !== -1) {
            $scope.rowCollection.splice(index, 1);

            $http({
                url: '/admin/removeadvertisement',
                method: "POST",
                data: "id=" + row.id,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function () {

            }).error(function () {
                $scope.hideError = false;
            });
        }
    };

    $scope.getDate = function (datetime) {
        return datetime.split(' ')[0];
    };

    $scope.getTime = function (datetime) {
        return datetime.split(' ')[1];
    };
}]);