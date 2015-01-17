var Search = function () {
    var self = this;

    self.input = $('#search');

    return self;
};

Search.prototype = {

    createLi: function (data) {

        var li = $('<li>');
        li.text(data);

        return li;
    },

    render: function (li) {

        var resultBox = $('#search-result');
        resultBox.empty();

        var ul = $('<ul>').attr({'class': 'search-result'});
        ul.empty();

        for (var i = 0, l = li.length; i < l; i += 1) {
            ul.append(li[i]);
        }

        resultBox.append(ul);
    },

    describe: function (id) {

        return $.ajax({
            url: '/search/searchdetail',
            data: {id: id},
            type: 'POST',
            success: function (response) {
                Search.prototype.createLi(response);
            }
        });
    },
    search: function (query) {
        var li = [];

        $.post('/search/search', {q: query}, function (data) {
            data = JSON.parse(data);


            // expects data['matches']
            if (data.hasOwnProperty('matches')) {

                for (var i = 0, l = data.matches.length; i < l; i += 1) {

                    var tmp = Search.prototype.describe(data.matches[i].id);
                    li.push(tmp);

                    console.log(li);
                }

                Search.prototype.render(li);

            } else {
                console.log('doesn\'t match');
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