var app = angular.module('adminApp', ['smart-table']);

app.controller('userCtrl', ['$scope', '$http', function ($scope, $http) {

    /**
     * Show alert message flag
     *
     * @type {boolean}
     */
    $scope.showError = true;

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
    $http.get('/admin/showusers').success(function (data) {

        $scope.showError = true;

        $scope.rowCollection = setBtnType(data.sort(byId));

        // statistics info
        $scope.userAmount = data.length;
        $scope.bannedUser = getCountOf(data, 'status', 'banner');
        $scope.unconfirmedUser = getCountOf(data, 'status', 'unconfirmed');
        $scope.registeredUser = getCountOf(data, 'status', 'registered');
    }).error(function () {
        $scope.showError = false;
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
                path = '/admin/unban';
                status = 'registered'
            } else {
                path = '/admin/ban';
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
            }).error(function () {
                $scope.showError = false;
            });
        }
    };

    // local functions

    /**
     * For array sort by user id
     *
     * @param a
     * @param b
     * @returns {number}
     */
    var byId = function (a, b) {
        if (a.id < b.id)
            return -1;
        if (a.id > b.id)
            return 1;
        return 0;
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

}]);
