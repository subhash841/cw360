
var base_url = $("body").attr("data-base_url");
var uid = $("body").attr("data-uid");
var voiceid = $("body").attr("data-detailid");
var date = new Date();
var timestamp = date.getTime();

$(function () {

    /* Points checking for create voice */
    /*$(".edit-voice").on("click", function (e) {
     e.preventDefault();
     var base_url = $("body").attr("data-base_url");
     var uid = $("body").attr("data-uid");
     var silver_points = $("body").attr("data-silver_points");
     
     if (uid == 0) {
     window.location.assign(base_url + "Login");
     }
     if (silver_points < 40) {
     $('#silverPointsCheck').modal('show');
     } else {
     $('#silverPointsCheck').modal('show');
     }
     });*/
    $("a.head-login").attr("href", base_url + "Login?section=voicedetail&vid=" + voiceid);

    //var default_voice_count = 6;
    var voice_list_offset = 0;
    load_voices(voice_list_offset);

    var latest_voice_offset = 0;
    load_latest_voices(latest_voice_offset);

    /* Show Delete voice confirmation modal */
    $("#cnfDeleteVoiceModal").on("show.bs.modal", function (event) {
        var base = "#cnfDeleteVoiceModal ";
        var relatedTarget = $(event.relatedTarget);
        var voice_id = relatedTarget.attr("data-id");
        $(base + "#del_voice_id").val(voice_id);
    });

    /* Delete voice confirmation - Yes*/
    $("#cnfDeleteVoiceModal button#btn_delete_voice_yes").on("click", function (event) {
        var _this = $(this);
        var voice_id = $("#cnfDeleteVoiceModal #del_voice_id").val();

        _this.attr("disabled", "disabled").html('Processing...');
        $.ajax({
            url: base_url + "YourVoice/delete_voice",
            method: "POST",
            data: {voice_id: voice_id}
        }).done(function (result) {
            setTimeout(function () {
                _this.removeAttr("disabled").html('Yes');
                window.location.assign(base_url + "YourVoice");
            }, 2000);
        });
    });

    /*Click Like*/
    $(".voice-like").on("click", callback_voice_like);

    /*$('.fa-thumbs-o-up').click(function () {
     $(this).removeClass('fa-thumbs-o-up');
     $(this).addClass('fa-thumbs-up');
     });*/

    /*delete Comment reply*/
    $(document).on("click", ".reply-delete", callback_delete_comment_reply);

    /* add img-fluid to each image in the description*/
    $(".description-container img").each(function () {
        $(this).addClass("img-fluid");
    });

    $("textarea.comment-text").on('keyup', function (e) {
        $(this).closest(".comment-box-holder").find(".comment-error").html('');
    });

    /* View More Comments of Voice*/
    $(".view-more-comments").on("click", view_more_comments);

    /* Post comment */
    $(".post-comment").on("click", function (e) {
        e.preventDefault();
        if (uid == 0) {
            window.location.assign(base_url + "Login?section=voicedetail&vid=" + voiceid);
            return false;
        }
        var _this = $(this);
        var comment = _this.closest(".comment-box-holder").find("textarea.comment-text").val().trim();
        var voice_id = _this.attr("data-id");
        var comment_html = '';
        var total_comments = parseInt($("#comentbox .total-comments-count").html());
        if (comment == "") {
            _this.closest(".comment-box-holder").find(".comment-error").html('Please enter comment');
            return false;
        }
        _this.addClass("disabled");
        $.ajax({
            url: base_url + "YourVoice/comment_on_voice",
            method: "POST",
            data: {voice_id: voice_id, comment: comment}
        }).done(function (result) {
            result = JSON.parse(result);
            if (result.status) {
                _this.removeClass("disabled");
                _this.closest(".comment-box-holder").find("textarea.comment-text").val('');
                $("#comentbox .total-comments-count").html(total_comments + 1);  //increase total count from 1
                var comment_id = result.data.comment_id;
                var alias = 'You';

                comment_html += '<div class="row comment_num_' + comment_id + '">\
                                    <div class="col-11 offset-1 pt-0 comment-text-holder">\
                                        <h6 class="font-weight-bold mb-0 pt-2">' + alias + '</h6>\
                                        <p class="maincolor p-comment mb-0 font-weight-300">' + comment + '</p>\
                                        <div class="edit_comment_box_holder hide" style="display:none;">\
                                            <textarea class="cust-textarea edit-comment-text" placeholder="Write Comment Here">' + comment + '</textarea>\
                                            <i class="sendicon fa fa-chevron-right post-edit-comment" aria-hidden="true" data-id="' + voice_id + '" data-comment_id="' + comment_id + '"></i>\
                                            <p class="error edit-comment-error mb-0 ml-1" style="font-size: 14px;color: red;"></p>\
                                        </div>\
                                        <div class="d-flex justify-content-space">\
                                            <p class="mx-2">\
                                                <i class="fa fa-reply"></i>\
                                                <a href="#" class="a-nostyle show-hide-reply" data-id="' + voice_id + '" data-comment_id="' + comment_id + '"><small>reply</small></a>\
                                            </p>\
                                            <p class="mx-2"><i class="fa fa-pencil-square-o"></i>\
                                                <a href="#" class="a-nostyle edit-comment" data-id="' + voice_id + '" data-comment_id="' + comment_id + '"><small>Edit</small></a>\
                                            </p>\
                                            <p class="mx-2"><i class="fa fa-trash-o"></i>\
                                                <a href="#" class="a-nostyle comment-delete" data-id="' + voice_id + '" data-comment_id="' + comment_id + '"><small>Delete</small></a>\
                                            </p>\
                                        </div>\
                                    </div>\
                                    <div class="col-11 border offset-1 reply-container_' + comment_id + '" style="display:none;">\
                                        <div class="row">\
                                            <div class="col-md-1 col-2 pr-0">\
                                                <img src="' + base_url + '/images/other/profile.png" class="img-fluid text-center pt-2">\
                                            </div>\
                                            <div class="col-11 pt-2 comment-reply-box-holder">\
                                                <textarea class="cust-textarea comment-reply-text" placeholder="Write Reply Here"></textarea>\
                                                <a href="#" class="post-comment-reply" data-id="' + voice_id + '" data-comment_id="' + comment_id + '"><i class="sendicon fa fa-chevron-right" aria-hidden="true"></i></a>\
                                                <p class="error comment-reply-error mb-0 ml-1" style="font-size: 14px;color: red;"></p>\
                                            </div>\
                                        </div>\
                                        <div class="comment-reply-list">\
                                            \
                                        </div>\
                                    </div>\
                                </div>';

                var increased_offset = parseInt(_this.closest(".comment_container").find(".row .view-more-comments").attr("data-offset")) + 1;
                _this.closest(".comment_container").find(".comments-list").prepend(comment_html);
                _this.closest(".comment_container").find(".row .view-more-comments").attr("data-offset", increased_offset);
            } else {
                _this.removeClass("disabled");
            }
        });
    });

    /* Edit comment - START */
    $(document).on("click", ".edit-comment", function (e) {
        e.preventDefault();
        var comment_id = $(this).attr("data-comment_id");

        $(this).closest(".comment_num_" + comment_id).find(".edit_comment_box_holder").show();
        $(this).closest(".comment_num_" + comment_id).find("p.p-comment").hide();
    });

    $(document).on("click", ".post-edit-comment", function (e) {
        e.preventDefault();
        var _this = $(this);
        var voice_id = _this.attr("data-id");
        var comment_id = _this.attr("data-comment_id");
        var comment = _this.closest(".edit_comment_box_holder").find("textarea.edit-comment-text").val().trim();

        if (comment == "") {
            _this.closest(".edit_comment_box_holder").find(".edit-comment-error").html('Please enter comment');
            return false;
        }
        _this.addClass("disabled");
        $.ajax({
            url: base_url + "YourVoice/update_comment_on_voice",
            method: "POST",
            data: {voice_id: voice_id, comment_id: comment_id, comment: comment}
        }).done(function (result) {
            result = JSON.parse(result);
            if (result.status) {
                _this.removeClass("disabled");
                _this.closest(".comment_num_" + comment_id).find(".edit_comment_box_holder").hide();
                _this.closest(".comment_num_" + comment_id).find("p.p-comment").html(comment).show();
            } else {
                _this.removeClass("disabled");
            }
        });
    });

    /* Retain the comment edit box on document click */
    $(document).on("click", function (event) {
        if ($(event.target).html() == 'Edit') {
            return false;
        }
        if ($(event.target).attr("class") == "cust-textarea edit-comment-text") {
            return false;
        }
        if ($(event.target).attr("class") == "sendicon fa fa-chevron-right post-edit-comment") {
            return false;
        }
        if ($(event.target).attr("class") == "cust-textarea edit-comment-reply-text") {
            return false;
        }
        if ($(event.target).attr("class") == "sendicon fa fa-chevron-right post-edit-reply-comment") {
            return false;
        }
        $(".edit_comment_box_holder").hide();
        $(".edit_comment_reply_box_holder").hide();
        $("p.maincolor").show();
    });
    /* Edit comment - END */

    /* slideToggle reply box*/
    $(document).on("click", ".show-hide-reply", function (e) {
        e.preventDefault();
        if (uid == 0) {
            window.location.assign(base_url + "Login?section=voicedetail&vid=" + voiceid);
            return false;
        }
        var _this = $(this);
        var voice_id = _this.attr("data-id");
        var comment_id = _this.attr("data-comment_id");
        var offset = 0;
        var reply_html = '';
        var edit_comment = '';
        var view_more_replies_html = '';

        $.ajax({
            url: base_url + "YourVoice/get_comment_replies",
            method: "POST",
            data: {voice_id: voice_id, comment_id: comment_id, offset: offset}
        }).done(function (result) {
            result = JSON.parse(result);
            console.log(result);
            for (var r in result['data']) {
                var comment_reply_id = result['data'][r].id;
                var alias = result['data'][r].alias;
                var comment_reply = result['data'][r].reply;

                if (uid == result['data'][r].user_id) {
                    edit_comment = '<p class="mx-2"><i class="fa fa-pencil-square-o"></i>\
                                        <a href="#" class="a-nostyle edit-comment-reply" data-id="' + voice_id + '" data-comment_id="' + comment_id + '"  data-reply_id="' + comment_reply_id + '"><small>Edit</small></a>\
                                    </p>\
                                    <p class="mx-2"><i class="fa fa-trash-o"></i>\
                                        <a href="#" class="a-nostyle reply-delete" data-id="' + voice_id + '" data-comment_id="' + comment_id + '"  data-reply_id="' + comment_reply_id + '"><small>Delete</small></a>\
                                    </p>';
                } else {
                    edit_comment = '';
                }

                reply_html += '<div class="row reply_num_' + comment_reply_id + '">\
                                <div class="col-11 offset-1 pt-2 comment-reply-text-holder">\
                                    <h6 class="font-weight-bold mb-0 pt-2">' + alias + '</h6>\
                                    <p class="maincolor mb-0 font-weight-300">' + comment_reply + '</p>\
                                    <div class="edit_comment_reply_box_holder hide" style="display:none;">\
                                        <textarea class="cust-textarea edit-comment-reply-text" placeholder="Write Reply Here">' + comment_reply + '</textarea>\
                                        <a href="#" class="post-edit-comment-reply" data-id="' + voice_id + '" data-comment_id="' + comment_id + '" data-reply_id="' + comment_reply_id + '"><i class="sendicon fa fa-chevron-right" aria-hidden="true"></i></a>\
                                        <p class="error edit-comment-reply-error mb-0 ml-1" style="font-size: 14px;color: red;"></p>\
                                    </div>\
                                    <div class="d-flex justify-content-space">\
                                        ' + edit_comment + '\
                                    </div>\
                                </div>\
                            </div>';
            }

            _this.closest(".comment_container").find(".reply-container_" + comment_id + " .comment-reply-list").html(reply_html);

            if (result['is_available'] == "1") {
                var newoffset = offset + 5;
                view_more_replies_html = '<div class="row">\
                                            <div class="col-12 pt-1 text-right">\
                                                <a href="#" class="a-nostyle view-more-replies" data-id="' + voice_id + '" data-comment_id="' + comment_id + '" data-offset="' + newoffset + '"><small>View more replies</small></a>\
                                            </div>\
                                        </div>';
                _this.closest(".comment_container").find(".reply-container_" + comment_id).append(view_more_replies_html);
            }
        });

        _this.closest(".comment_container").find(".reply-container_" + comment_id).slideToggle();
    });

    /*delete Voice Comment - START */
    $(document).on("click", ".comment-delete", callback_delete_voice_comment);
    /*delete Voice Comment - END */

    $("textarea.comment-reply-text").on('keyup', function (e) {
        $(this).closest(".comment-reply-box-holder").find(".comment-reply-error").html('');
    });

    /* View More Comments of Voice*/
    $(document).on("click", ".view-more-replies", view_more_replies);

    /* Post Reply on comment - START */
    $(document).on("click", ".post-comment-reply", function (e) {
        e.preventDefault();
        if (uid == 0) {
            window.location.assign(base_url + "Login?section=voicedetail&vid=" + voiceid);
            return false;
        }
        var _this = $(this);

        var comment_reply = _this.closest(".comment-reply-box-holder").find("textarea.comment-reply-text").val();
        var comment_id = _this.attr("data-comment_id");
        var voice_id = _this.attr("data-id");

        if (comment_reply == "") {
            _this.closest(".comment-reply-box-holder").find(".comment-reply-error").html('Please enter reply.');
            return false;
        }
        _this.addClass("disabled");

        var comment_reply_html = '';

        $.ajax({
            url: base_url + "YourVoice/reply_on_comment_voice",
            method: "POST",
            data: {voice_id: voice_id, comment_id: comment_id, comment_reply: comment_reply}
        }).done(function (result) {
            result = JSON.parse(result);
            if (result.status) {
                _this.removeClass("disabled");
                _this.closest(".comment-reply-box-holder").find("textarea.comment-reply-text").val('');
                var alias = 'You';
                var new_reply_id = result.data.reply_id;

                comment_reply_html += '<div class="row reply_num_' + new_reply_id + '">\
                                            <div class="col-11 offset-1 pt-2 comment-reply-text-holder">\
                                                <h6 class="font-weight-bold mb-0 pt-2">' + alias + '</h6>\
                                                <p class="maincolor mb-0 font-weight-300">' + comment_reply + '</p>\
                                                <div class="edit_comment_reply_box_holder hide" style="display:none;">\
                                                    <textarea class="cust-textarea edit-comment-reply-text" placeholder="Write Reply Here">' + comment_reply + '</textarea>\
                                                    <a href="#" class="post-edit-comment-reply" data-id="' + voice_id + '" data-comment_id="' + comment_id + '" data-reply_id="' + new_reply_id + '"><i class="sendicon fa fa-chevron-right" aria-hidden="true"></i></a>\
                                                    <p class="error edit-comment-reply-error mb-0 ml-1" style="font-size: 14px;color: red;"></p>\
                                                </div>\
                                                <div class="d-flex justify-content-space">\
                                                    <p class="mx-2"><i class="fa fa-pencil-square-o"></i>\
                                                        <a href="#" class="a-nostyle edit-comment-reply" data-id="' + voice_id + '" data-comment_id="' + comment_id + '"  data-reply_id="' + new_reply_id + '"><small>Edit</small></a>\
                                                    </p>\
                                                    <p class="mx-2"><i class="fa fa-trash-o"></i>\
                                                        <a href="#" class="a-nostyle reply-delete" data-id="' + voice_id + '" data-comment_id="' + comment_id + '"  data-reply_id="' + new_reply_id + '"><small>Delete</small></a>\
                                                    </p>\
                                                </div>\
                                            </div>\
                                        </div>';
                _this.closest(".reply-container_" + comment_id).find(".comment-reply-list").prepend(comment_reply_html);
                //var increased_offset = parseInt(_this.closest(".comment_container").find(".row .view-more-comments").attr("data-offset")) + 1;
                //_this.closest(".comment_container").find(".comments-list").prepend(comment_html);
                //_this.closest(".comment_container").find(".row .view-more-comments").attr("data-offset", increased_offset);
            } else {
                _this.removeClass("disabled");
            }
        });
    });
    /* Post Reply on comment - END */

    /* Edit comment reply - START */
    $(document).on("click", ".edit-comment-reply", function (e) {
        e.preventDefault();
        var comment_reply_id = $(this).attr("data-reply_id");

        $(this).closest(".reply_num_" + comment_reply_id).find(".edit_comment_reply_box_holder").show();
        $(this).closest(".reply_num_" + comment_reply_id).find("p.maincolor").hide();
    });

    $(document).on("click", ".post-edit-comment-reply", function (e) {
        e.preventDefault();
        var _this = $(this);
        var voice_id = _this.attr("data-id");
        var comment_id = _this.attr("data-comment_id");
        var comment_reply_id = _this.attr("data-reply_id");

        var comment_reply = _this.closest(".edit_comment_reply_box_holder").find("textarea.edit-comment-reply-text").val().trim();

        if (comment_reply == "") {
            _this.closest(".edit_comment_reply_box_holder").find(".edit-comment-reply-error").html('Please enter reply');
            return false;
        }
        _this.addClass("disabled");
        $.ajax({
            url: base_url + "YourVoice/update_comment_reply_on_voice",
            method: "POST",
            data: {voice_id: voice_id, comment_id: comment_id, comment_reply_id: comment_reply_id, comment_reply: comment_reply}
        }).done(function (result) {
            result = JSON.parse(result);
            if (result.status) {
                _this.removeClass("disabled");
                _this.closest(".reply_num_" + comment_reply_id).find(".edit_comment_reply_box_holder").hide();
                _this.closest(".reply_num_" + comment_reply_id).find("p.maincolor").html(comment_reply).show();
            } else {
                _this.removeClass("disabled");
            }
        });
    });
    /* Edit comment reply - END */
});

/* Like Unlike Voice */
var callback_voice_like = function (e) {
    if (uid == 0) {
        window.location.assign(base_url + "Login?section=voicedetail&vid=" + voiceid);
        return false;
    }
    e.preventDefault();
    var _this = $(this);
    var is_user_like = $(this).attr("data-is_user_liked");
    var voice_id = $(this).attr("data-id");

    $.ajax({
        url: base_url + "YourVoice/like_unlike_voice",
        method: "POST",
        data: {voice_id: voice_id, is_user_like: is_user_like}
    }).done(function (result) {
        result = JSON.parse(result);
        if (result.status) {
            var user_like_status = (is_user_like == "0") ? "1" : "0";
            _this.attr("data-is_user_liked", user_like_status);
            /*Change thumb icon color */
            if (is_user_like == "0") {
                $(".like-icon").removeClass('fa-thumbs-o-up').addClass('fa-thumbs-up');
            } else {
                $(".like-icon").removeClass('fa-thumbs-up').addClass('fa-thumbs-o-up');
            }
            $("#comentbox .total-likes-count").html(result.data.total_likes);
            //$("#comentbox .total-comments-count").html();
        }
    });
}

/* Comment Delete */
var callback_delete_voice_comment = function (e) {
    e.preventDefault();
    var _this = $(this);
    var voice_id = $(this).attr("data-id");
    var comment_id = $(this).attr("data-comment_id");
    var total_comments = parseInt($("#comentbox .total-comments-count").html());

    $.ajax({
        url: base_url + "YourVoice/delete_voice_comment",
        method: "POST",
        data: {voice_id: voice_id, comment_id: comment_id}
    }).done(function (result) {
        result = JSON.parse(result);
        if (result.status) {
            _this.closest(".row.comment_num_" + comment_id).slideUp("slow", function () {});
            $("#comentbox .total-comments-count").html(total_comments - 1); //decrease total count from 1
        }
    });
}

/* Comment reply Delete */
var callback_delete_comment_reply = function (e) {
    e.preventDefault();
    var _this = $(this);
    var voice_id = $(this).attr("data-id");
    var comment_id = $(this).attr("data-comment_id");
    var comment_reply_id = $(this).attr("data-reply_id");

    $.ajax({
        url: base_url + "YourVoice/delete_voice_comment_reply",
        method: "POST",
        data: {voice_id: voice_id, comment_id: comment_id, comment_reply_id: comment_reply_id}
    }).done(function (result) {
        result = JSON.parse(result);
        if (result.status) {
            _this.closest(".row.reply_num_" + comment_reply_id).slideUp("slow", function () {});
        }
    });
}

function load_voices(offset) {
    $.ajax({
        url: base_url + "YourVoice/load_voices",
        method: "POST",
        data: {offset: offset, notin: voiceid}
    }).done(function (result) {
        result = JSON.parse(result);

        var html = '';
        var carousel = '';
        var slug = '';
        var class_active = '';

        if (result['data'].length > 0) {
            for (var i in result['data']) {
                slug = create_slug(result['data'][i].title);

                html += '<a href="' + base_url + 'YourVoice/blog_detail/' + result['data'][i].id + '/' + slug + '?t=' + timestamp + '" class="a-nostyle">\
                            <div class="cust-shadow border px-3 mb-4 a-special">\
                                <div class="row maincolor">\
                                    <div class="col-md-4 py-2">\
                                        <h5 class="maincolor font-weight-bold letterspacing05">' + result['data'][i].title + '</h5>\
                                        <small>' + result['data'][i].created_date + '</small>\
                                    </div>\
                                    <div class="col-md-4">\
                                        <p class="py-2 text-justify description ellipsis">' + result['data'][i].description + '</p>\
                                    </div>\
                                    <div class="col-md-4 py-2">\
                                        <div class="ad mt-2">\
                                            <img id="image-ad" class="img-fluid" src="' + base_url + 'images/blogs/' + result['data'][i].image + '"/>\
                                            <p id="ad-text">' + result['data'][i].category + '</p>\
                                        </div>\
                                    </div>\
                                </div>\
                            </div>\
                        </a>';

                if (i == 0) {
                    class_active = 'active';
                } else {
                    class_active = '';
                }
                carousel += '<div class="carousel-item ' + class_active + '">\
                            <a href="' + base_url + 'YourVoice/blog_detail/' + result['data'][i].id + '/' + slug + '?t=' + timestamp + '" class="a-nostyle">\
                                <div class="px-3 mb-4 a-special">\
                                    <div class="row maincolor">\
                                        <div class="col-md-4 py-2 ">\
                                            <div class="ad mt-2">\
                                                <img id="image-ad" src="' + base_url + 'images/blogs/' + result['data'][i].image + '" class="w-100"/>\
                                                <p id="ad-text">' + result['data'][i].category + '</p>\
                                            </div>\
                                        </div>\
                                        <div class="col-md-4 pt-2">\
                                            <h5 class="maincolor font-weight-bold letterspacing1">' + result['data'][i].title + '</h5>\
                                        </div>\
                                        <div class="col-md-4">\
                                            <p class="text-justify cust-text">' + result['data'][i].description + '<br><small class="d-block mt-2"><!--By Dorothly Gwller--> ' + result['data'][i].created_date + '</small>\
                                            </p>\
                                        </div>\
                                    </div>\
                                </div>\
                            </a>\
                        </div>';
            }

            if (offset == 0) {
                $(".trending-article-list").html(html);
            } else {
                $(".trending-article-list").append(html);
            }

            $("#mobile_carousel .carousel-inner").html(carousel);
            //show hide load-more-voice-list button
            if (result['is_available'] == "1") {
                $(".load-more-voice-list").closest('.load-btn-holder').removeClass('hide');
            } else {
                $(".load-more-voice-list").closest('.load-btn-holder').addClass('hide');
            }
            adddots();
        } else {
            $(".trending-article-list").html('<div class="row"><div class="col s11 m11 l11 offset-s1 offset-m1 offset-l1 center-align">No articles raised yet</div></div>');
        }
    });
    function adddots() {
        var data = $(".ellipsis");
        data.each(function (i, value) {
            var html = $(value).text();
            if (html !== '' && html.length >= 162) {
                html = html.substring(0, 162) + "...";
                $(this).text(html);
            }
        })
    }


}

/*Slug creation for blog */
function create_slug(string) {
    var slug_string = '';
    slug_string = string.replace(/[~`!@#$%^&*()_=+{}|\/;'<>?,]/g, ''); //remove special characters from slug
    slug_string = slug_string.split(' ').join('-'); //creating slug

    return slug_string;
}

var load_latest_voices = function (offset) {

    $.ajax({
        url: base_url + "YourVoice/load_latest_voices",
        method: "POST",
        data: {offset: offset, voiceid: voiceid}
    }).done(function (result) {
        result = JSON.parse(result);

        var html = '';
        var slug = '';

        if (result['data'].length > 0) {
            for (var i in result['data']) {
                slug = create_slug(result['data'][i].title);

                html += '<a href="' + base_url + 'YourVoice/blog_detail/' + result['data'][i].id + '/' + slug + '?t=' + timestamp + '" class="a-nostyle">\
                            <div id="ad" class="my-3">\
                                <h4 class="mt-4 font-weight-bold mb-0" id="adtitle">' + result['data'][i].title + '</h4>\
                                <small>' + result['data'][i].created_date + '</small>\
                                <div class="ad mt-2">\
                                    <img id="image-ad" src="' + base_url + 'images/blogs/' + result['data'][i].image + '" class="img-fluid w-100"/>\
                                    <p id="ad-text">' + result['data'][i].category + '</p>\
                                </div>\
                            </div>\
                        </a>';
            }

            $(".latest-voices-list").html(html);
        }
    });
}

var view_more_comments = function (e) {
    e.preventDefault();
    if (uid == 0) {
        window.location.assign(base_url + "Login?section=voicedetail&vid=" + voiceid);
        return false;
    }
    var _this = $(this);
    var voice_id = _this.attr("data-id");
    var offset = (_this.attr("data-offset") == 0) ? 2 : _this.attr("data-offset");
    var comment_html = '';

    $.ajax({
        url: base_url + "YourVoice/view_more_comments",
        method: "POST",
        data: {voice_id: voice_id, offset: offset}
    }).done(function (result) {
        result = JSON.parse(result);
        console.log(result);
        var new_offset = parseInt(result['data'].length) + parseInt(offset);
        console.log(new_offset);
        for (var i in result['data']) {
            var comment_id = result['data'][i].id;
            var alias = (uid == result['data'][i].user_id) ? "You" : result['data'][i].alias;
            var edit_comment = '';

            if (uid == result['data'][i].user_id) {
                edit_comment = '<p class="mx-2"><i class="fa fa-pencil-square-o"></i>\
                                    <a href="#" class="a-nostyle edit-comment" data-id="' + voice_id + '" data-comment_id="' + comment_id + '"><small>Edit</small></a>\
                                </p>\
                                <p class="mx-2"><i class="fa fa-trash-o"></i>\
                                    <a href="#" class="a-nostyle comment-delete" data-id="' + voice_id + '" data-comment_id="' + comment_id + '"><small>Delete</small></a>\
                                </p>'
            } else {
                edit_comment = '';
            }
            comment_html += '<div class="row comment_num_' + comment_id + '">\
                                    <div class="col-11 offset-1 pt-0 comment-text-holder">\
                                        <h6 class="font-weight-bold mb-0 pt-2">' + alias + '</h6>\
                                        <p class="maincolor p-comment mb-0 font-weight-300">' + result['data'][i].comment + '</p>\
                                        <div class="edit_comment_box_holder hide" style="display:none;">\
                                            <textarea class="cust-textarea edit-comment-text" placeholder="Write Comment Here">' + result['data'][i].comment + '</textarea>\
                                            <i class="sendicon fa fa-chevron-right post-edit-comment" aria-hidden="true" data-id="' + voice_id + '" data-comment_id="' + comment_id + '"></i>\
                                            <p class="error edit-comment-error mb-0 ml-1" style="font-size: 14px;color: red;"></p>\
                                        </div>\
                                        <div class="d-flex justify-content-space">\
                                            <p class="mx-2">\
                                                <i class="fa fa-reply"></i>\
                                                <a href="#" class="a-nostyle show-hide-reply" data-id="' + voice_id + '" data-comment_id="' + comment_id + '"><small>reply</small></a>\
                                            </p>\
                                            ' + edit_comment + '\
                                        </div>\
                                    </div>\
                                    <div class="col-11 border offset-1 reply-container_' + comment_id + '" style="display:none;">\
                                        <div class="row">\
                                            <div class="col-md-1 col-2 pr-0">\
                                                <img src="' + base_url + '/images/other/profile.png" class="img-fluid text-center pt-2">\
                                            </div>\
                                            <div class="col-11 pt-2 comment-reply-box-holder">\
                                                <textarea class="cust-textarea comment-reply-text" placeholder="Write Reply Here"></textarea>\
                                                <a href="#" class="post-comment-reply" data-id="' + voice_id + '" data-comment_id="' + comment_id + '"><i class="sendicon fa fa-chevron-right" aria-hidden="true"></i></a>\
                                                <p class="error comment-reply-error mb-0 ml-1" style="font-size: 14px;color: red;"></p>\
                                            </div>\
                                        </div>\
                                        <div class="comment-reply-list">\
                                            \
                                        </div>\
                                    </div>\
                                </div>';
        }

        _this.closest(".comment_container").find(".comments-list").append(comment_html);
        _this.attr("data-offset", new_offset);

        if (result['is_available'] == "1") {
            _this.closest(".row").show();
        } else {
            _this.closest(".row").hide();
        }
    });
}

var view_more_replies = function (e) {
    if (uid == 0) {
        window.location.assign(base_url + "Login?section=voicedetail&vid=" + voiceid);
        return false;
    }
    e.preventDefault();
    var _this = $(this);
    var voice_id = _this.attr("data-id");
    var comment_id = _this.attr("data-comment_id");
    var offset = _this.attr("data-offset");

    var reply_html = '';
    var edit_comment = '';
    var view_more_replies_html = '';

    $.ajax({
        url: base_url + "YourVoice/get_comment_replies",
        method: "POST",
        data: {voice_id: voice_id, comment_id: comment_id, offset: offset}
    }).done(function (result) {
        result = JSON.parse(result);

        for (var r in result['data']) {
            var comment_reply_id = result['data'][r].id;
            var alias = result['data'][r].alias;
            var comment_reply = result['data'][r].reply;

            if (uid == result['data'][r].user_id) {
                edit_comment = '<p class="mx-2"><i class="fa fa-pencil-square-o"></i>\
                                        <a href="#" class="a-nostyle edit-comment-reply" data-id="' + voice_id + '" data-comment_id="' + comment_id + '"  data-reply_id="' + comment_reply_id + '"><small>Edit</small></a>\
                                    </p>\
                                    <p class="mx-2"><i class="fa fa-trash-o"></i>\
                                        <a href="#" class="a-nostyle reply-delete" data-id="' + voice_id + '" data-comment_id="' + comment_id + '"  data-reply_id="' + comment_reply_id + '"><small>Delete</small></a>\
                                    </p>';
            } else {
                edit_comment = '';
            }

            reply_html += '<div class="row reply_num_' + comment_reply_id + '">\
                                <div class="col-11 offset-1 pt-2 comment-reply-text-holder">\
                                    <h6 class="font-weight-bold mb-0 pt-2">' + alias + '</h6>\
                                    <p class="maincolor mb-0 font-weight-300">' + comment_reply + '</p>\
                                    <div class="edit_comment_reply_box_holder hide" style="display:none;">\
                                        <textarea class="cust-textarea edit-comment-reply-text" placeholder="Write Reply Here">' + comment_reply + '</textarea>\
                                        <a href="#" class="post-edit-comment-reply" data-id="' + voice_id + '" data-comment_id="' + comment_id + '" data-reply_id="' + comment_reply_id + '"><i class="sendicon fa fa-chevron-right" aria-hidden="true"></i></a>\
                                        <p class="error edit-comment-reply-error mb-0 ml-1" style="font-size: 14px;color: red;"></p>\
                                    </div>\
                                    <div class="d-flex justify-content-space">\
                                        ' + edit_comment + '\
                                    </div>\
                                </div>\
                            </div>';
        }

        _this.closest(".comment_container").find(".reply-container_" + comment_id + " .comment-reply-list").append(reply_html);

        if (result['is_available'] == "1") {
            var newoffset = offset + 5;
            view_more_replies_html = '<div class="row">\
                                            <div class="col-12 pt-1 text-right">\
                                                <a href="#" class="a-nostyle view-more-replies" data-id="' + voice_id + '" data-comment_id="' + comment_id + '" data-offset="' + newoffset + '"><small>View more replies</small></a>\
                                            </div>\
                                        </div>';
            _this.closest(".comment_container").find(".reply-container_" + comment_id).append(view_more_replies_html);
        } else {
            _this.closest(".comment_container").find(".reply-container_" + comment_id + " .view-more-replies").closest(".row").hide();
        }
    });
}