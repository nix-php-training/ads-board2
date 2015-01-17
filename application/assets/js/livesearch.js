var Search = function () {
    var self = this;

    self.input = $('#search');

    return self;
};

Search.prototype = {

    render: function (data) {

        var resultBox = $('#search-result');
        resultBox.empty();
        resultBox.slideDown(200);

        var ul = $('<ul>');
        ul.empty();

        for (var i = 0, l = data.length; i < l; i += 1) {

            var login = data[i].login,
                email = data[i].email,
                li = $('<li>').text(login + ' ' + email);

            ul.append(li);
        }

        ul.appendTo(resultBox);
    },

    search: function (query) {

        $.post('/search/search', {q: query}, function (data) {

            if (data) {
                data = JSON.parse(data);
                Search.prototype.render(data);
            } else {
                $('#search-result').slideUp(100).empty();
            }
        });
    }
};

$(function () {
    var search = new Search();

    search.input.keyup(function () {
        search.search(search.input.val());
    });

});