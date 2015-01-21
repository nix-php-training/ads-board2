var LiveSearch = function () {
    var self = this;
    self.input = $('#search');
    self.button = $('#do-search');
    self.match = $('.high');
    return self;
};

LiveSearch.prototype = {

    find: false,

    render: function (data, query) {

        var ul = $('#search-result');
        ul.empty();
        ul.slideDown(200);

        for (var i = 0, l = data.length; i < l; i += 1) {

            var subj = data[i].subject,
                price = data[i].price,
                imgLink = data[i].img,
                userId = data[i].userId,
                adsId = data[i].id,
                li = $('<li>').attr('class', 'media-list-link'),
                a = $('<a>').attr('href', cnst.DETAIL_LINK + adsId),
                img = $('<img>').attr('src',
                    cnst.IMG_HOST + cnst.SEPARATOR +
                    userId + cnst.SEPARATOR +
                    adsId + cnst.SEPARATOR +
                    cnst.PREVIEW + imgLink),
                container = $('<span>'),
                heading = $('<b>').attr('class', 'high').text(subj),
                p = $('<p>').text('$' + price);

            container.append(heading);
            container.append(p);

            a.append(img);
            a.append(container);

            li.append(a);

            ul.append(li);
        }

        var more = $('<li>'),
            link = $('<a>').attr('href', '/search/' + processParameter(query)).attr('class', 'btn btn-default').text('See more');
        more.append(link);
        ul.append(more);
    },

    search: function (query) {

        $.post('/livesearch', {q: query}, function (data) {

            if (data) {
                data = JSON.parse(data);
                LiveSearch.prototype.render(data, query);
                LiveSearch.prototype.find = true;
                $('.high').highlight(query);
            } else {
                $('#search-result').slideUp(100).empty();
                LiveSearch.prototype.find = false;
            }
        });
    }
};

$(function () {
    var search = new LiveSearch();

    search.input.keyup(function () {
        search.search(search.input.val());
    });

    // hide list if input focus out
    search.input.blur(function () {
        setTimeout(function () {
            var focused = $(document.activeElement);
            if (!focused.hasClass('media') && (focused.parents('.media-list').length === 0)) {
                $('#search-result').slideUp(100);
            }
        }, 100);
    });

    // show list if input focus in
    search.input.focus(function () {
        if (search.find) {
            $('#search-result').slideDown(200);
        }
    });



    search.button.click(function () {
        var path = (search.input.val() !== '') ? 'search' + cnst.SEPARATOR + processParameter(search.input.val()) : 'search';
        window.location.href = cnst.HOST + path;
        return false;
    });

});