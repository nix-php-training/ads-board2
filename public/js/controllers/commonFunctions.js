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

//function mysqlTimeStampToDate(timestamp) {
////function parses mysql datetime string and returns javascript Date object
////input has to be in this format: 2007-06-05 15:26:02
//    var regex=/^([0-9]{2,4})-([0-1][0-9])-([0-3][0-9]) (?:([0-2][0-9]):([0-5][0-9]):([0-5][0-9]))?$/;
//    var parts=timestamp.replace(regex,"$1 $2 $3 $4 $5 $6").split(' ');
//    return new Date(parts[0],parts[1]-1,parts[2],parts[3],parts[4],parts[5]);
//}

function createAdsDom(data) {
    var div = $('#posts');
    div.empty();
    div.slideDown(200);

    for (var i = 0, l = data.length; i < l; i += 1) {

        var postList = $('<div>').attr('id', 'post-list').attr('class', 'row post-list vertical-align');

        var subj = data[i].subject,
            desc = data[i].description,
            price = data[i].price,
            imgLink = data[i].images[0].imageName,
            imgPreview = data[i].imagesPreview[0].imageName,
            userId = data[i].userId,
            userName = data[i].login,
            cDate = data[i].unconvertedDate.split(' ')[0],
            cTime = data[i].unconvertedDate.split(' ')[1],
            adsId = data[i].id;

        var dateTime = $('<div>').attr('class', 'col-md-2 text-right date-time'),
            h1 = $('<h1>').text(cDate),
            h2 = $('<h2>').text(cTime);
        dateTime.append(h1);
        dateTime.append(h2);

        var images = $('<div>').attr('class', 'col-md-2 images'),
            lightbox = $('<a>').attr('href', imgLink).
                attr('data-lightbox', 'image-' + adsId).
                attr('data-title', subj),

            img = $('<img>').attr('src', imgPreview).
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

$(function () {
    var select = $('#categories');
    select.change(function () {

        $.post('home/adsload', {catId: select.val()}, function (data) {
                if (data) {
                    data = JSON.parse(data);
                    createAdsDom(data);
                }
                else {
                    var posts = $('#posts'),
                        notFound = $('<h5>').attr('class', 'text-danger text-center').text('There are no advertisements in the selected category.');
                    posts.empty();
                    posts.append(notFound);

                }
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
        //}
        //});
    });
});

