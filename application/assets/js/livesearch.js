var LiveSearch = function () {
    var self = this;
    self.input = $('#search');
    self.button = $('#do-search');
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
                li = $('<li>').attr('class', 'media'),
                a = $('<a>').attr('class', 'media-left').attr('href', cnst.DETAIL_LINK + adsId),
                img = $('<img>').attr('src',
                    cnst.IMG_HOST + cnst.SEPARATOR +
                    userId + cnst.SEPARATOR +
                    adsId + cnst.SEPARATOR +
                    cnst.PREVIEW + imgLink),
                mbody = $('<div>').attr('class', 'media-body'),
                heading = $('<h4>').attr('class', 'media-heading').text(subj),
                p = $('<p>').text('$' + price);

            mbody.append(heading);
            mbody.append(p);

            a.append(img);
            a.append(mbody);

            li.append(a);

            ul.append(li);
        }

        var more = $('<li>').attr('class', ''),
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
            console.log(focused);
            if (!focused.hasClass('media-list') || focused.parents('.media-list').length === 0) {
                $('#search-result').slideUp(200);
            }
        }, 1);
    });

    // show list if input focus in
    search.input.focus(function () {
        if (search.find) {
            $('#search-result').slideDown(200).focus();
        }
    });



    search.button.click(function () {
        var path = (search.input.val() !== '') ? 'search' + cnst.SEPARATOR + processParameter(search.input.val()) : 'search';
        window.location.href = cnst.HOST + path;
        console.log(path);
        return false;
    });

});