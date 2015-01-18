var Search = function () {
    var self = this;

    self.input = $('#search');

    return self;
};

Search.prototype = {

    find: false,

    render: function (data) {

        var ul = $('#search-result');
        ul.empty();
        ul.slideDown(200);

        for (var i = 0, l = data.length; i < l; i += 1) {

            var login = data[i].login,
                email = data[i].email,
                li = $('<li>').attr('class', 'media'),
                a = $('<a>').attr('class', 'media-left').attr('href', '#'),
                img = $('<img>').attr('src', '/application/demoimg/preview/1.jpg'),
                mbody = $('<div>').attr('class', 'media-body'),
                heading = $('<h4>').attr('class', 'media-heading').text(login),
                p = $('<p>').text(email);

            mbody.append(p);
            mbody.append(heading);

            a.append(img);
            a.append(mbody);

            li.append(a);

            ul.append(li);
        }

        var more = $('<li>').attr('class', ''),
            link = $('<a>').attr('href', '/login').attr('class', 'btn btn-default').text('See more');
        more.append(link);
        ul.append(more);
    },

    search: function (query) {

        $.post('/search/search', {q: query}, function (data) {

            if (data) {
                data = JSON.parse(data);
                Search.prototype.render(data);
                Search.prototype.find = true;
            } else {
                $('#search-result').slideUp(100).empty();
                Search.prototype.find = false;
            }
        });
    }
};

$(function () {
    var search = new Search();

    search.input.keyup(function () {
        search.search(search.input.val());
    });

    search.input.blur(function () {
        $('#search-result').slideUp(100);
    });

    search.input.focus(function () {
        if (search.find) {
            $('#search-result').slideDown(200);
        }
    });

});