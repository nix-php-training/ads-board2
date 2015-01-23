var Search = function () {
    var self = this;
    self.input = $('#page-search');
    return self;
};

Search.prototype = {

    render: function (data) {

        var div = $('#posts');
        div.empty();

        for (var i = 0, l = data.length; i < l; i += 1) {

            var postList = $('<div>').attr('id', 'post-list').attr('class', 'row post-list vertical-align');

            var subj = data[i].subject,
                desc = data[i].decstiption,
                price = data[i].price,
                imgLink = data[i].img,
                userId = data[i].userId,
                userName = data[i].userName,
                cDate = data[i].cDate.split(' ')[0], // get date
                cTime = data[i].cDate.split(' ')[1], // get time
                adsId = data[i].id;

            var dateTime = $('<div>').attr('class', 'col-md-2 text-right date-time'),
                date = $('<h1>').text(cDate),
                time = $('<h2>').text(cTime);
            dateTime.append(date);
            dateTime.append(time);

            var images = $('<div>').attr('class', 'col-md-2 images'),
                lightbox = $('<a>').attr('href',
                    cnst.IMG_HOST + cnst.SEPARATOR +
                    userId + cnst.SEPARATOR +
                    adsId + cnst.SEPARATOR + imgLink).
                    attr('data-lightbox', 'image-' + adsId).
                    attr('data-title', subj),

                img = $('<img>').attr('src',
                    cnst.IMG_HOST + cnst.SEPARATOR +
                    userId + cnst.SEPARATOR +
                    adsId + cnst.SEPARATOR +
                    cnst.PREVIEW + imgLink).
                    attr('class', 'thumbnail img-responsive');

            lightbox.append(img);
            images.append(lightbox);

            var postText = $('<div>').attr('class', 'col-md-6 text post-text'),
                postHeader = $('<h1>'),
                subject = $('<a>').attr('href', '/postdetail/' + adsId).text(subj),
                postOwner = $('<a>').attr('href', '/profile/' + userId).text(userName);

            postHeader.append(subject);
            postText.append(postHeader);
            postText.append(postOwner);

            var postPrice = $('<div>').attr('class', 'col-md-2 post-price text-right'),
                priseHeader = $('<h1>').text('$' + price);

            postPrice.append(priseHeader);

            postList.append(dateTime);
            postList.append(images);
            postList.append(postText);
            postList.append(postPrice);

            div.append(postList);
        }
    },

    search: function (query) {

        $.post('/livesearch', {q: query}, function (data) {

            if (data) {
                data = JSON.parse(data);
                Search.prototype.render(data);
            } else {
                var posts = $('#posts'),
                    notFound = $('<h5>').attr('class', 'text-danger text-center').text('Nothing found by query: ' + query);
                posts.empty();
                posts.append(notFound);

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