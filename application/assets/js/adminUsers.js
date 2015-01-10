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

    var btnType = {'danger': 'danger', 'info': 'info'};
    var btnTitle = {'ban': 'Ban', 'unban': 'Unban'};

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
    $scope.ban = function (row) {
        var index = $scope.rowCollection.indexOf(row);
        if (index !== -1) {
            //TODO: implementation of user ban function
            console.log("index> " + index);
            console.log("id> " + row.id);
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
     * Set class for button ban/unban
     *
     * @param data
     * @returns {*}
     */
    var setBtnType = function (data) {
        var l = data.length;
        for (var i = 0; i < l; i += 1) {
            if (data[i]['status'] === 'banned') {
                data[i]['btnType'] = btnType.info;
                data[i]['btnTitle'] = btnTitle.unban;
            } else {
                data[i]['btnType'] = btnType.danger;
                data[i]['btnTitle'] = btnTitle.ban;
            }
        }
        return data;
    };

}]);
