/**
 * Replace `-+*=\|/!@#$%^&():;'".,` ` as `_`
 *
 * @param val
 * @returns {XML|string|*|void}
 */
function processParameter(val) {
    val = val.replace(/[-+*\.,%#@!`'"\\&\^:;\(\)=$\\\|\/ ]/g, "_");
    return val;
}

/**
 * Split datetime by space
 *
 * @param datetime
 * @returns {Array|*}
 */
function splitDateTime(datetime) {
    var tmp = datetime.split(' ');
    return {date: tmp[0], time: tmp[1]}
}