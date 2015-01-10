var app = angular.module('adminApp', ['smart-table']);

app.controller('userCtrl', ['$scope', '$http', function ($scope, $http) {

    /**
     * Show alert message flag
     *
     * @type {boolean}
     */
    $scope.hideError = true;
    $scope.hideSuccess = true;

    /**
     * user list
     * @type {Array}
     */
    $scope.rowCollection = [];

    /**
     * user list for render
     *
     * @type {Array}
     */
    $scope.displayedCollection = [];

    var btnType = {'danger': 'btn-danger', 'info': 'btn-info', 'hidden': 'hidden'};
    var btnTitle = {"banUnban": 'Ban', 'unban': 'Unban'};

    $scope.btnType = 'danger';

    /**
     * get data from server
     */
    $http.get('/admin/getusers').success(function (data) {

        $scope.hideError = true;

        $scope.rowCollection = setBtnType(data.sort(byId));

        // statistics info
        statisticInfo(data);
    }).error(function () {
        $scope.hideError = false;
    });

    $scope.displayedCollection = [].concat($scope.rowCollection);

    /**
     * Ban user
     *
     * @param row
     */
    $scope.banUnban = function (row) {
        var index = $scope.rowCollection.indexOf(row);
        var path = '', status = '';
        if (index !== -1) {
            // if current status == banned then unban
            // else ban selected user
            if (row.status === 'banned') {
                path = '/admin/unbanuser';
                status = 'registered'
            } else {
                path = '/admin/banuser';
                status = 'banned'
            }

            $http({
                url: path,
                method: "POST",
                data: 'id=' + row.id,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function () {
                $scope.rowCollection[index].status = status;
                $scope.rowCollection = setBtnType($scope.rowCollection.sort(byId));
                $scope.displayedCollection = [].concat($scope.rowCollection);
                statisticInfo($scope.rowCollection);
            }).error(function () {
                $scope.hideError = false;
            });
        }
    };


    /**
     * Get count of elements with value by key
     *
     * @param data
     * @param key
     * @param value
     * @returns {number}
     */
    var getCountOf = function (data, key, value) {
        var count = 0,
            l = data.length;
        for (var i = 0; i < l; i += 1) {
            if (data[i][key] === value) {
                count++;
            }
        }
        return count;
    };

    /**
     * Set class for button banUnban/unban
     * Has class hidden for unconfirmed user
     *
     * @param data
     * @returns {*}
     */
    var setBtnType = function (data) {
        var l = data.length;
        for (var i = 0; i < l; i += 1) {
            var row = data[i], status = row['status'];

            if (status === 'banned') {
                row['btnType'] = btnType.info;
                row['btnTitle'] = btnTitle.unban;
            } else if (status === 'unconfirmed') {
                row['btnType'] = btnType.hidden;
            } else {
                row['btnType'] = btnType.danger;
                row['btnTitle'] = btnTitle.banUnban;
            }
        }
        return data;
    };

    var statisticInfo = function (data) {
        $scope.userAmount = data.length;
        $scope.bannedUser = getCountOf(data, 'status', 'banned');
        $scope.unconfirmedUser = getCountOf(data, 'status', 'unconfirmed');
        $scope.registeredUser = getCountOf(data, 'status', 'registered');
    }

}]);
