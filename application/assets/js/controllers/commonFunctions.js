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