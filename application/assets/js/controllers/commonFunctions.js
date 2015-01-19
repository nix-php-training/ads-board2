/**
 * For array sort by user id
 *
 * @param a
 * @param b
 * @returns {number}
 */
var byId = function (a, b) {
    if (parseInt(a.id) < parseInt(b.id))
        return -1;
    if (parseInt(a.id) > parseInt(b.id))
        return 1;
    return 0;
};

function createAdsDom(data)
{
    var div = $('#posts');
    div.empty();
    div.slideDown(200);

    for (var i = 0, l = data.length; i < l; i += 1) {

        var postList = $('<div>').attr('id', 'post-list').attr('class', 'row post-list vertical-align');

        var subj = data[i].subject,
            desc = data[i].decstiption,
            price = data[i].price,
            imgLink = data[i].img,
            userId = data[i].userId,
            userName = data[i].userName,
            cDate = data[i].cDate,
            adsId = data[i].id;

        var dateTime = $('<div>').attr('class', 'col-md-2 text-right date-time'),
            h1 = $('<h1>').text(cDate);
        dateTime.append(h1);

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
}

$(function() {
    var select = $('#categories');
    select.change(function(){
        //alert(select.val());
        $.post('home/adsload',{ catId: select.val()}, function(data){
                //alert('success');

                data = JSON.parse(data);

                createAdsDom(data);
                //$.each(createAdsDom(data));
            }
        );
        //$.ajax({
        //type: "POST",
        //url: "/home/adsload",
        //data: { "value": select.val()},
        //dataType: 'json',
        //error: alert('errir'),
        //success: function(data){
        //    alert('success');
        //    data = JSON.parse(data);
        //    createAdsDom(data);
        //    //$.each(createAdsDom(data));
        //}
        //});
    });
});

