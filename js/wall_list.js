/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var base_url = $("body").attr("data-base_url");
var img_cdn_url = "https://imgcdn.crowdwisdom.co.in/" + base_url.replace("http://", "").replace("https://", "");
var date = new Date();
var timestamp = date.getTime();
var flag = true;
var uid = $("body").attr("data-uid");
var predictionid = $("body").attr("data-detailid");
$(function () {
    $(document).ajaxStart(function () {
        $("#loading").show();
    });
    $(document).ajaxStop(function () {
        $("#loading").hide();
    });

    $("a.head-login").attr("href", base_url + "Login?section=question");
    var default_prediction_count = 7;
    var voice_list_offset = 0;
    load_discussion_wall(voice_list_offset);
    //var article_list_offset = 0;
    //load_articles(article_list_offset);

    /* This is for detail view */
    if (predictionid != "") {
        var latest_voice_list_offset = 0;
        load_latest_voices(latest_voice_list_offset);
        $("a.head-login").attr("href", base_url + "Login?section=predictiondetail&vid=" + predictionid);
    }

    $(".blog-list-page .load-more-voice-list").on("click", function (e) {
        if (voice_list_offset == 0) {
            default_prediction_count = 7;
        } else {
            default_prediction_count = 6;
        }
        voice_list_offset = voice_list_offset + default_prediction_count;
        load_discussion_wall(voice_list_offset);
    });
    /* Points checking for create voice */
    $(".btn_create_wall").on("click", function (e) {
        e.preventDefault();
        var uid = $("body").attr("data-uid");
        if (uid == 0) {
            window.location.assign(base_url + "Login?section=wall");
        } else {
            window.location.assign(base_url + "Wall/raise_wall");
        }
//        e.preventDefault();
//        var uid = $("body").attr("data-uid");
//        var silver_points = $("body").attr("data-silver_points");
//        var body = '';
//        if (uid == 0) {
//            window.location.assign(base_url + "Login?section=predictions");
//        } else if (silver_points < 25) {
//            body = '<div><img src="' + base_url + 'images/banners/coin_f.png"><span>' + silver_points + '</span></div><p>You can\'t raise any Poll.</p><p>You must have 25 silver points to raise a Voice.</p>';
//            $("#silverPointsCheck .modal-title").html("Your Balance Points");
//            $('#silverPointsCheck .modal-body').html(body);
//            $('#silverPointsCheck button#create_voice_yes').hide();
//            $('#silverPointsCheck button#create_voice_no').hide();
//            $('#silverPointsCheck button#create_voice_ok').show();
//            $('#silverPointsCheck').modal('show');
//        } else {
//            body = '<div><img src="' + base_url + 'images/banners/coin_f.png"><span>' + silver_points + '</span></div><p>Redeem 25 Points to raise a voice.</p>';
//            $("#silverPointsCheck .modal-title").html("Your Balance Points");
//            $('#silverPointsCheck .modal-body').html(body);
//            $('#silverPointsCheck button#create_voice_yes').show();
//            $('#silverPointsCheck button#create_voice_no').show();
//            $('#silverPointsCheck button#create_voice_ok').hide();
//            $('#silverPointsCheck').modal('show');
//        }
    });
    /*Click yes button*/
    $('#silverPointsCheck button#create_voice_yes').on("click", function () {
        window.location.assign(base_url + "Predictions/raise_prediction");
    });
    if (options.toast) {
        Materialize.Toast.removeAll();
        Materialize.toast(options.toast, 4000);
        return false;
    }

    load_sidebar($(".predictions-list"), "predictions");
    load_sidebar($(".side-voice-list"), "voices");
    load_sidebar($(".side-from-web"), "rated_articles");
    load_sidebar($(".wall-list"), "wall");
    load_sidebar($(".questions-list"), "questions");
});

function convert_numbers(value) {
    if (isNaN(value))
        return 0;
    var newvalue = value;
    var suffixNum = '';
    if (value >= 1000) {
        suffixNum = ("" + value).length;
        if (suffixNum == 4 || suffixNum == 5 || suffixNum == 6) {
            newvalue = Math.floor(value / 1000) + "K";
        }
        if (suffixNum >= 7) {
            newvalue = Math.floor(value / 1000000) + "M";
        }
    }
    return newvalue;
}

/*Slug creation for blog */
function create_slug(string) {
    var slug_string = '';
    slug_string = string.replace(/[~`!@#$%^&*()_=+{}|\/;'<>?,]/g, ''); //remove special characters from slug
    slug_string = slug_string.split(' ').join('-'); //creating slug

    return slug_string;
}


function load_discussion_wall(offset) {
    $.ajax({
        url: base_url + "Wall/lists",
        method: "POST",
        data: {offset: offset, notin: 0}
    }).done(function (result) {
        result = JSON.parse(result);
        var data = result['data'];
        var spacer = $('<div />', {class: 'w-100'})
        var ad = $('<div />', {class: 'adimg col-12 mt-3'})
                .append($("<a />", {class: "d-block", href: "http://www.loudst.com/", target: "_blank"})
                        .append($("<img />", {src: img_cdn_url + "images/special/samsung.jpg", class: "img-fluid "})))

        var html = $(".blog-list-section .blog-list");
        if (data.length > 0) {

            if (offset < 1 && $('.blog-list-page').length == 1)
            {
                var first = data.splice(0, 1)[0];
                $(".most-popular")
                        .append($('<div >', {class: 'row'})
                                .append(getblock(first, true)));
            }
            for (var i in data) {
                html.append(getblock(data[i], false));
            }
            $(".blog-detail-trending .blog-list").width($('.blog-detail-trending .blog-list-item').length * $(".blog-detail-trending .blog-list-item").outerWidth() + 100)
//show hide load-more-voice-list button
            if (result['is_available'] == "1") {
                $(".load-more-voice-list").closest('.load-btn-holder').removeClass('hide');
            } else {
                $(".load-more-voice-list").closest('.load-btn-holder').addClass('hide');
            }
        }


        $(".blog-list .adimg").remove();
        $(".blog-list .blog-list-item").each(function (a, b) {
            if ((a % 9 == 0 || a == 3) && a > 0 && $('.blog-list-page').length > 0)
            {
                ad.clone().insertBefore(b)
            }
        })
        if (flag) {
            $(".load-more-voice-list").trigger('click')
            flag = !flag
        }
    });
}

function getblock(data, top = false) {

    var total_votes = convert_numbers(data.total_votes);
    var total_likes = convert_numbers(data.total_likes);
    var total_views = convert_numbers(data.total_views);
    var total_comments = convert_numbers(data.total_comments);
    var slug = create_slug(data.title);
    var overlay = $('<div />', {class: "overlay"});
    var div = $("<div />", {class: top ? "col-12 top-blog pt-3 blog-list-item my-1" : "col-md-4 blog-list-item"})
    var a = $("<a/>", {
        href: base_url + 'Wall/detail/' + data.id + '/' + slug,
        class: "d-block pb-3",
        "data-content": "Most Popular Discussion",
        style: top ? "background: url('" + data.image + "') no-repeat center center;" : ""
    })

    var blogimg = $("<div />", {
        class: "voiceimg p-5",
        style: "background: url('" + data.image + "')  no-repeat center center;"
    });
    var likes = $("<small />", {class: "likes"}).html(total_votes + " Votes &nbsp;&nbsp;&#9679;&nbsp;&nbsp; " + total_comments + " Comments") //&nbsp;&nbsp;&#9679;&nbsp;&nbsp; " + total_views + " Views
    var category = $("<small />", {class: "category"}).html(data.category);
    var title = $('<h6 />').html(data.title);
    var segment = $("<div />", {class: "d-flex flex-column h-100 w-100 justify-content-end"});
    if (!top) {
        a
                .append(blogimg)
                .append(category)
                .append(title)
                .append(likes)

    } else {
        a
                .append(overlay)
                .append(segment
                        .append(category)
                        .append(title)
                        .append(likes)
                        );
    }

    div.append(a);
    return div;
}

function load_sidebar(b, q = "voices", offset = 0) {
    $.ajax({
        url: base_url + "Common/get_trending_" + q,
        method: "POST",
        data: {offset: offset, notin: 0}
    }).done(function (result) {

        var data = result['data'];
        var html = b;
        if (data.length > 0) {

            for (var i in data) {
                html.append(getsideblock(data[i], q));
            }

            if (result['is_available'] == "1") {
                $(".load-more", b.parent())
                        .attr("data-load", q).attr("data-offset", offset + data.length)
                        .closest('.load-btn-holder').removeClass('fade');
            } else {
                $(".load-more", b.parent())
                        .attr("data-load", q).attr("data-offset", offset + data.length)
                        .closest('.load-btn-holder').addClass('fade');
            }

            var tt = $(".h-list-detail .h-list");
            tt.width($('.blog-list-item', tt).length * $(".blog-list-item", tt).outerWidth() + 100)

        }
    });
}

function getsideblock(data, q) {
    var total_votes = '';
    if (q == "voices")
        q = "YourVoice/blog_detail/"
    else if (q == "questions")
        q = "AskQuestions/details/"
    else if (q == "rated_articles")
        q = "FromTheWeb/detail/"
    else if (q == "predictions")
        q = "Predictions/details/";
    else if (q == "wall") {
        q = "Wall/detail/";
    }
    var total_likes = convert_numbers(data.total_likes);
    var total_views = convert_numbers(data.total_views);
    var total_comments = convert_numbers(data.total_comments);
    var slug = create_slug(data.title);
    var div = $("<div />", {class: "col-md-4 blog-list-item"})
    var a = $("<a/>", {
        href: base_url + q + data.id + '/' + slug,
        class: "d-block pb-3",
        "data-content": "Most Popular Blog"
    })

    var blogimg = $("<div />", {
        class: "voiceimg p-5",
        style: "background: url('" + data.image + "')  no-repeat center center;"
    });
    var likes = '';

    if (q == "AskQuestions/details/" || q == "Predictions/details/" || q == "FromTheWeb/detail/") {
        total_votes = data.total_votes;
        likes = $("<small />", {class: "likes"}).html(total_votes + " Votes &nbsp;&nbsp;&#9679;&nbsp;&nbsp; " + total_comments + " Comments");
    } else {
        likes = $("<small />", {class: "likes"}).html(total_likes + " Likes &nbsp;&nbsp;&#9679;&nbsp;&nbsp; " + total_views + " Views &nbsp;&nbsp;&#9679;&nbsp;&nbsp; " + total_comments + " Comments");
    }

    var category = $("<small />", {class: "category"}).html(data.category);
    var title = $('<h6 />').html(data.title);

    a
            .append(blogimg)
            .append(category)
            .append(title)
            .append(likes)

    div.append(a);
    return div;
}