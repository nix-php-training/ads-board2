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

            var desc = data[i].adsDesc,
                price = data[i].adsPrice,
                imgLink = data[i].img,
                userId = data[i].userId,
                adsId = data[i].adsId,
                li = $('<li>').attr('class', 'media'),
                a = $('<a>').attr('class', 'media-left').attr('href', cnst.DETAIL_LINK + adsId),
                img = $('<img>').attr('src',
                    cnst.IMG_HOST + cnst.SEPARATOR +
                    userId + cnst.SEPARATOR +
                    adsId + cnst.SEPARATOR +
                    cnst.PREVIEW + imgLink),
                mbody = $('<div>').attr('class', 'media-body'),
                heading = $('<h4>').attr('class', 'media-heading').text(desc),
                p = $('<p>').text(price);

            mbody.append(heading);
            mbody.append(p);

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

            console.log(data);
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