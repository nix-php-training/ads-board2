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

            var subj = data[i].subject,
                price = data[i].price,
                imgLink = data[i].img,
                userId = data[i].userId,
                adsId = data[i].id,
                li = $('<li>').attr('class', 'media'),
                a = $('<a>').attr('class', 'media-left').attr('href', cnst.DETAIL_LINK + adsId),
                img = $('<img>').attr('src',
                    cnst.IMG_HOST + cnst.SEPARATOR +
                    userId + cnst.SEPARATOR +
                    adsId + cnst.SEPARATOR +
                    cnst.PREVIEW + imgLink),
                mbody = $('<div>').attr('class', 'media-body'),
                heading = $('<h4>').attr('class', 'media-heading').text(subj),
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

            //console.log(data);
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

    // hide list if input focus out
    search.input.blur(function () {
        $('#search-result').slideUp(100);
    });

    // show list if input focus in
    search.input.focus(function () {
        if (search.find) {
            $('#search-result').slideDown(200);
        }
    });

});