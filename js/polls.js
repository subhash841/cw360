/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var flag = true;
var obj = [];
$(function () {

    if (votestatus) {
        $('.choice-cont').each(function () {
            obj.push({avg: $('.activity', this).attr('data-avg'), htmlval: $(this)});
        });
        rearrange_element(obj);
    }

    function rearrange_element(data) {

        var keys = data.sort(function (a, b) {
            return b.avg - a.avg
        });
        $('.form').html('');
        $(keys).each(function (key, value) {
            $('.form').append(value.htmlval);
        });

        $('.avgval').each(function (key, value) {
            $(value).html(parseFloat($(value).html()).toFixed(2) + '%');
        });

        $('.option-name').each(function (key, value) {
            if ($(value).html() == 'See the Results') {
                $(this).next().html('');
            }
        })

    }

    if (localStorage.id)
    {
        if (localStorage.id == id) {
            $("[value='" + localStorage.choice + "']").prop("checked", true)
            setTimeout(function () {
                $('.vote').trigger("click")
            }, 300);

        }
    }
    $("a.head-login").attr("href", base_url + "Login?section=poll");

    /* This is for detail view */
    if (id != "") {
        $("a.head-login").attr("href", base_url + "Login?section=predictiondetail&vid=" + id);
    }

    $(".choose-option").on("change", function (e) {
        var _this = $(this);

        $('.choice-cont').removeClass('bg-active');
        if (_this.prop("checked"))
            _this.closest('.choice-cont').addClass('bg-active');
    })


    $(".comment").each(function () {
        $(this).find('.userimg').css("background-color", getrandomcolor());
    })

    $(".vote").on('click', function (e) {
        e.preventDefault();
        var p = $(this).closest(".pollcont");

        var choice = $("input.choose-option:checked", p).val()
        if (uid == 0) {
            localStorage.id = id;
            localStorage.choice = choice;
            window.location.assign(base_url + "Login?section=predictiondetail&vid=" + id);
            return false;
        }
        $.post(base_url + "Predictions/vote_action", {id: id, choice: choice}).done(function (d) {
            $(".choice-cont.bg-active", p).removeClass("bg-active");

            if (d.status) {
                if (localStorage.id) {
                    if (localStorage.id == id)
                        localStorage.clear();
                }
                if (d.isnew) {
                    $("#earnedpoints").modal("show")
                    setTimeout(function () {
                        $("#earnedpoints").modal("hide")
                    }, 3000);
                }
                $(".expertsw", p).removeClass("invisible");
                $(".check_expert_result").removeClass("data-expert");
//                obj = [];
                $.each(d.data.options, function (a, b) {
                    var c = $("#choiceradio" + b.choice_id).closest(".choice-cont")
                    c.removeClass("expert");
                    $(".tgl.tgl-ios").removeClass("active");
                    $(".activity", c).css("width", b.avg + "%").attr('data-avg', b.avg).removeClass("d-none");
                    $(".avgval", c).removeClass("d-none");
                    counter($(".avgval", c), b.avg)
                    obj.push({avg: b.avg, htmlval: c});
                })
                rearrange_element(obj);
            }
        })
    })
    $(".post-comment").on("click", function (e) {
        e.preventDefault();
        if (uid == 0) {
            window.location.assign(base_url + "Login?section=predictiondetail&vid=" + id);
            return false;
        }
        var _this = $(this);
        var comment = _this.closest(".comment-box-holder").find("textarea.comment-text").val().trim();
        var id = _this.attr("data-id");
        var comment_html = $(document.createDocumentFragment());
        var total_comments = parseInt($("#comentbox .total-comments-count").html());
        if (comment == "") {
            _this.closest(".row").find(".comment-error").html('Please enter comment');
            return false;
        }
        _this.addClass("disabled");
        $.ajax({
            url: base_url + "Predictions/add_comment",
            method: "POST",
            data: {id: id, comment: comment}
        }).done(function (result) {
            if (result.status) {


                _this.removeClass("disabled");

                _this.closest(".comment-box-holder").find("textarea.comment-text").val('');
                var data = [];

                data.comment_id = result.data.comment_id;
                data.alias = $('body').attr("data-alias") ? $('body').attr("data-alias") : "You";
                data.comment = comment;

                data.user_id = uid;
                data.total_replies = 0;

                _this.removeClass("disabled");
                _this.closest(".comment-reply-box-holder").find("textarea.comment-reply-text").val('');

                comment_html = generatecommentbox(data)


                $("#comentbox .total-comments-count").html(total_comments + 1);  //increase total count from 1

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

        $(this).closest(".comment_num_" + comment_id)
                .find(".edit_comment_box_holder")
                .toggleClass("d-none")
                .find("textarea")
                .val($(this).closest(".comment_num_" + comment_id).find("p.p-comment").text());
        $(this).closest(".comment_num_" + comment_id).find("p.p-comment").toggleClass("d-none");
    });

    $(document).on("click", ".post-edit-comment", function (e) {
        e.preventDefault();
        var _this = $(this);
        var id = _this.attr("data-id");
        var comment_id = _this.attr("data-comment_id");
        var comment = _this.closest(".edit_comment_box_holder").find("textarea.edit-comment-text").val().trim();

        if (comment == "") {
            _this.closest(".edit_comment_box_holder").find(".edit-comment-error").html('Please enter comment');
            return false;
        }
        _this.addClass("disabled");
        $.ajax({
            url: base_url + "Predictions/update_comment",
            method: "POST",
            data: {id: id, comment_id: comment_id, comment: comment}
        }).done(function (result) {

            if (result.status) {
                _this.removeClass("disabled");
                _this.closest(".comment_num_" + comment_id).find(".edit_comment_box_holder").toggleClass("d-none");
                _this.closest(".comment_num_" + comment_id).find("p.p-comment").html(comment).toggleClass("d-none");
            } else {
                _this.removeClass("disabled");
            }
        });
    });



    $(document).on("click", ".show-hide-reply", function (e) {
        e.preventDefault();
        var _this = $(this);
        var id = _this.attr("data-id");
        if (uid == 0) {
            window.location.assign(base_url + "Login?section=predictiondetail&vid=" + id);
            return false;
        }
        var comment_id = _this.attr("data-comment_id");
        var offset = 0;
        var reply_html = $(document.createDocumentFragment());
        var edit_comment = '';
        var view_more_replies_html = '';
        $.ajax({
            url: base_url + "Predictions/get_comment_replies",
            method: "POST",
            data: {id: id, comment_id: comment_id, offset: offset}
        }).done(function (result) {

            console.log(result);
            for (var r in result['data']) {
                var data = [];
                data.comment_reply_id = result['data'][r].id;
                data.comment_id = result['data'][r].comment_id;
                data.alias = result['data'][r].alias;
                data.comment_reply = result['data'][r].reply;
                data.user_id = result['data'][r].user_id;

                data.total_replies = result['data'][r].total_replies
                reply_html.append(generatecommentbox(data, true));
            }

            _this.closest(".comment_container").find(".reply-container_" + comment_id + " .comment-reply-list").html(reply_html);
            if (result['is_available'] == "1") {
                var newoffset = offset + 5;
                view_more_replies_html = '<div class="row">\
                                            <div class="col-12 pt-1 text-right">\
                                                <a href="#" class="a-nostyle view-more-replies" data-id="' + id + '" data-comment_id="' + comment_id + '" data-offset="' + newoffset + '"><small>View more replies</small></a>\
                                            </div>\
                                        </div>';


                _this.closest(".comment_container").find(".reply-container_" + comment_id).append(view_more_replies_html);
            }
        });
        _this.closest(".comment_container").find(".reply-container_" + comment_id).toggleClass("d-none");
    });
    /*delete Voice Comment - START */
    $(document).on("click", ".comment-delete", callback_delete_comment);
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
            window.location.assign(base_url + "Login?section=predictiondetail&vid=" + id);
            return false;
        }
        var _this = $(this);

        var comment_reply = _this.closest(".comment-reply-box-holder").find("textarea.comment-reply-text").val();
        var comment_id = _this.attr("data-comment_id");
        var id = _this.attr("data-id");
        if (comment_reply == "") {
            _this.closest(".comment-reply-box-holder").find(".comment-reply-error").html('Please enter reply.');
            return false;
        }
        _this.addClass("disabled");
        var comment_reply_html = '';
        $.ajax({
            url: base_url + "Predictions/add_comment_reply",
            method: "POST",
            data: {id: id, comment_id: comment_id, comment_reply: comment_reply}
        }).done(function (result) {

            if (result.status) {

                var data = [];
                data.comment_reply_id = result.data.comment_reply_id;
                data.comment_id = comment_id;
                data.alias = $('body').attr("data-alias") ? $('body').attr("data-alias") : "You";
                data.comment_reply = comment_reply;

                data.user_id = uid;

                _this.removeClass("disabled");
                _this.closest(".comment-reply-box-holder").find("textarea.comment-reply-text").val('');

                comment_reply_html = generatecommentbox(data, true)

                _this.closest(".reply-container_" + comment_id).find(".comment-reply-list").prepend(comment_reply_html);

            } else {
                _this.removeClass("disabled");
            }
        });
    });
    /* Post Reply on comment - END */

    $(document).on("click", ".post-edit-comment-reply", function (e) {
        e.preventDefault();
        var _this = $(this);
        var id = _this.attr("data-id");
        var comment_id = _this.attr("data-comment_id");
        var comment_reply_id = _this.attr("data-reply_id");
        var comment_reply = _this.closest(".edit_comment_reply_box_holder").find("textarea.edit-comment-reply-text").val().trim();
        if (comment_reply == "") {
            _this.closest(".edit_comment_reply_box_holder").find(".edit-comment-reply-error").html('Please enter reply');
            return false;
        }
        _this.addClass("disabled");
        $.ajax({
            url: base_url + "Predictions/update_comment_reply",
            method: "POST",
            data: {id: id, comment_id: comment_id, comment_reply_id: comment_reply_id, comment_reply: comment_reply}
        }).done(function (result) {

            if (result.status) {
                _this.removeClass("disabled");
                _this.closest(".reply_num_" + comment_reply_id).find(".edit_comment_reply_box_holder").toggleClass("d-none");
                _this.closest(".reply_num_" + comment_reply_id).find("p.maincolor").html(comment_reply).toggleClass("d-none");
            } else {
                _this.removeClass("disabled");
            }
        });
    });
    /* Edit comment reply - END */




    /*delete Comment reply*/
    $(document).on("click", ".reply-delete", callback_delete_comment_reply);



    /* View More Comments of Voice*/
    $(".view-more-comments").on("click", view_more_comments);
    /* Edit comment reply - START */
    $(document).on("click", ".edit-comment-reply", function (e) {
        e.preventDefault();
        var comment_reply_id = $(this).attr("data-reply_id");

        $(this).closest(".reply_num_" + comment_reply_id)
                .find(".edit_comment_reply_box_holder")
                .toggleClass("d-none")
                .find("textarea")
                .val($(this).closest(".reply_num_" + comment_reply_id).find("p.maincolor").text());
        $(this).closest(".reply_num_" + comment_reply_id).find("p.maincolor").toggleClass("d-none");
    });

    /* Show Delete voice confirmation modal */
    $("#cnfDeleteModal").on("show.bs.modal", function (event) {
        var relatedTarget = $(event.relatedTarget);
        var id = relatedTarget.attr("data-id");
        $("#cnfDeleteModal #del_id").val(id);
    });

    /* Delete voice confirmation - Yes*/
    $("#cnfDeleteModal button#btn_delete_yes").on("click", function (event) {
        var _this = $(this);
        var id = $("#cnfDeleteModal #del_id").val();

        _this.attr("disabled", "disabled").html('Processing...');
        $.ajax({
            url: base_url + "Predictions/deactive_poll",
            method: "POST",
            data: {id: id}
        }).done(function (result) {
            setTimeout(function () {
                _this.removeAttr("disabled").html('Yes');
                window.location.assign(base_url + "Predictions");
            }, 2000);
        });
    });

    $(document).on("click", ".check_expert_result", function (e) {
        e.preventDefault();
        var _this = $(this);
        _this.parent().find('.tgl-ios').toggleClass("active");

        var polloptions = _this.closest(".poll").find(".poll-options")

        if (!_this.hasClass("data-expert"))
            get_experts_result(id).done(function (d) {
                if (d.status) {
                    $.each(d.data, function (a, b) {
                        var c = $("#choiceradio" + b.choice).closest(".choice-cont")
                        $(".activity", c).attr('data-expert', b.expert_percent);
                        switchexpert(c);
                        _this.addClass("data-expert");
                    })
                }
            });
        else {
            $("[data-avg]", polloptions).each(function () {
                var c = $(this).closest(".choice-cont");
                switchexpert(c);
            })
        }
    });
    $(".btn_create_prediction").on("click", function (e) {

        e.preventDefault();
        var uid = $("body").attr("data-uid");
        if (uid == 0) {
            window.location.assign(base_url + "Login?section=predictions");
        } else {
            window.location.assign(base_url + "Predictions/raise_prediction");
        }
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
    $(".load-more").on("click", function (e) {
        e.preventDefault();
        load_sidebar($(this).closest(".bg-w-block").find(".article-list"), $(this).attr("data-load"), $(this).attr("data-offset"))
    })
    /*Click yes button*/
    $('#silverPointsCheck button#create_yes').on("click", function () {
        window.location.assign(base_url + "Predictions/raise_prediction");
    });
    load_sidebar($(".voice-list"), "voices");
    load_sidebar($(".questions-list"), "questions");
    load_sidebar($(".rated-list"), "rated_articles");
    load_sidebar($(".predictions-list"), "predictions");
    load_sidebar($(".wall-list"), "wall");

});


function switchexpert(c) {
    var expert = $(".activity", c).attr("data-expert") + "%";
    var avg = $(".activity", c).attr("data-avg") + "%";
    if (!c.hasClass("expert"))
    {
        $(".activity", c).css("width", expert);
        //$(".avgval", c).html(expert);
        counter($(".avgval", c), expert)
    } else {

        $(".activity", c).css("width", avg);
        //$(".avgval", c).html(avg);
        counter($(".avgval", c), avg)
    }
    c.toggleClass("expert");
}

function get_experts_result(id) {
    return $.ajax({
        url: base_url + "Predictions/experts_result",
        method: "POST",
        data: {id: id}
    })
}
function counter(el, a) {
    var i = 1;
    pr = el.text().replace("%", "")
    if (a != pr) {
        el.prop('Counter', pr).animate({
            Counter: a
        }, {
            duration: 400,
            easing: 'swing',
            step: function (now) {
                el.text((Math.round(now * 100) / 100) + "%");

            }
        });

    }
    return true;
}
function generatecommentbox(data, reply = false) {

    var commentactioncont = $("<div />", {class: "d-flex justify-content-space"})
    var commentactions = $("<p />", {class: "m-0 comment-action mr-auto"})
    if (!reply) {
        commentactions
                .append($("<a />", {
                    href: "#",
                    class: "show-hide-reply",
                    "data-id": id,
                    "data-comment_id": data.comment_id,
                    "data-reply_id": data.comment_reply_id
                })
                        .append($('<small />', {
                            class: ""
                        })
                                .html("Reply")))
    }
    if (uid == data.user_id) {
        if (!reply) {
            commentactions.append($("<span />")
                    .html("&nbsp;&nbsp;&#9679;&nbsp;&nbsp;"))

        }
        commentactions
                .append($("<a />", {
                    href: "#",
                    class: reply ? "edit-comment-reply" : "edit-comment",
                    "data-id": id,
                    "data-comment_id": data.comment_id,
                    "data-reply_id": data.comment_reply_id
                })
                        .append($('<small />', {
                            class: ""
                        })
                                .html("Edit")))
                .append($("<span />")
                        .html("&nbsp;&nbsp;&#9679;&nbsp;&nbsp;"))
                .append($("<a />", {
                    href: "#",
                    class: reply ? "reply-delete" : "comment-delete",
                    "data-id": id,
                    "data-comment_id": data.comment_id,
                    "data-reply_id": data.comment_reply_id
                })
                        .append($('<small />')
                                .html("Delete")))


    }

    var totalreplies = $("<p />", {
        class: "m-0 comment-action ml-auto"
    })
            .append($("<small />", {
                class: "text-black-50"
            })
                    .html(data.total_replies + (data.total_replies == 1 ? " Reply" : " Replies")));

    commentactioncont.append(commentactions)

    if (!reply) {
        commentactioncont.append(totalreplies);
    }

    var row = $("<div />", {
        class: reply ?
                "row reply_num_" + data.comment_reply_id :
                "row comment mb-3 comment_num_" + data.comment_id
    });
    var cont = $('<div />', {
        class: reply ?
                "col-10 col-md-11 pt-0 comment-reply-text-holder" :
                "col-10 col-md-11 pt-0 comment-text-holder"
    })

    var img = $("<div />", {
        class: " col-md-1 col-2 p-2  d-flex"
    })
            .append($("<div />", {
                class: "userimg position-relative",
                "data-line": data.alias[0]
            })
                    .css("background-color", getrandomcolor()))

    var alias = $("<h6 />", {
        class: "font-weight-bold mb-2 pt-2 text-capitalize"
    })
            .html(data.alias);

    var replydesc = $("<p />", {
        class: reply ? "maincolor mb-2 font-weight-300" : "p-comment maincolor mb-2 font-weight-300"
    })
            .html(reply ? data.comment_reply : data.comment)

    var editholder = makereplybox(data, reply);

    var replyboxholder = $("<div />", {
        class: "col-10 col-md-11 offset-md-1 offset-2 mb-3 d-none reply-container_" + data.comment_id
    })
            .append($("<div />", {
                class: "row"
            })
                    .append(makereplybox(data, false, true)))

            .append($("<div />", {class: "comment-reply-list"}));


    cont.append(alias)
            .append(replydesc)
            .append(editholder)
            .append(commentactioncont)
    row.append(img).append(cont);
    if (!reply)
        row.append(replyboxholder);

    return row;



}

function makereplybox(data, reply = false, replybox = false) {

    var rowclass = "edit_comment_box_holder d-none input-group";
    var submitclass = "post-edit-comment";
    var textareaclass = "cust-textarea edit-comment-text form-control"

    if (reply)
    {
        rowclass = "edit_comment_reply_box_holder d-none input-group";
        submitclass = "post-edit-comment-reply";
        textareaclass = "cust-textarea edit-comment-reply-text form-control"
    }
    if (replybox)
    {
        rowclass = "col pt-2 comment-reply-box-holder input-group";
        submitclass = "post-comment-reply";
        textareaclass = "cust-textarea comment-reply-text form-control"
    }


    var row = $("<div />", {
        class: rowclass
    })

    row.append($("<textarea />", {
        class: textareaclass,
        placeholder: "Write Reply"
    }))
            .append($("<div />", {
                class: "input-group-append"
            })
                    .append($("<a />", {
                        href: "#",
                        class: submitclass,
                        "data-id": id,
                        "data-comment_id": data.comment_id,
                        "data-reply_id": data.comment_reply_id
                    }).append($("<span />", {
                        class: "d-block sendicon"
                    })
                            .html('<svg viewBox="0 0 20 20"><path fill="rgb(255, 255, 255)" d="M0.000,18.000 L22.000,9.000 L0.000,0.000 L0.000,7.000 L15.714,9.000 L0.000,11.000 L0.000,18.000 Z"/></svg>'))))
            .append($("<p />", {
                class: replybox ? "error comment-error mb-0 ml-1 text-danger" : "error edit-comment-reply-error mb-0 ml-1 text-danger"
            }))
    return row;


}


/* Comment Delete */


var callback_delete_comment = function (e) {
    e.preventDefault();
    var _this = $(this);
    var id = $(this).attr("data-id");
    var comment_id = $(this).attr("data-comment_id");
    var total_comments = parseInt($("#comentbox .total-comments-count").html());
    $.ajax({
        url: base_url + "Predictions/delete_comment",
        method: "POST",
        data: {id: id, comment_id: comment_id}
    }).done(function (result) {

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
    var id = $(this).attr("data-id");
    var comment_id = $(this).attr("data-comment_id");
    var comment_reply_id = $(this).attr("data-reply_id");
    $.ajax({
        url: base_url + "Predictions/delete_comment_reply",
        method: "POST",
        data: {id: id, comment_id: comment_id, comment_reply_id: comment_reply_id}
    }).done(function (result) {

        if (result.status) {
            _this.closest(".row.reply_num_" + comment_reply_id).slideUp("slow", function () {});
        }
    });
}



var view_more_comments = function (e) {
    e.preventDefault();
    if (uid == 0) {
        window.location.assign(base_url + "Login?section=predictiondetail&vid=" + id);
        return false;
    }
    var _this = $(this);
    var id = _this.attr("data-id");
    var offset = (_this.attr("data-offset") == 0) ? 2 : _this.attr("data-offset");
    var comment_html = '';
    $.ajax({
        url: base_url + "Predictions/view_more_comments",
        method: "POST",
        data: {id: id, offset: offset}
    }).done(function (result) {

        console.log(result);
        var new_offset = parseInt(result['data'].length) + parseInt(offset);
        console.log(new_offset);
        var reply_html = $(document.createDocumentFragment());
        for (var i in result['data']) {

            var data = [];
            data.comment_id = result['data'][i].comment_id;
            data.alias = result['data'][i].alias;
            data.comment = result['data'][i].comment;
            data.user_id = result['data'][i].user_id;
            data.total_replies = result['data'][i].total_replies;

            reply_html.append(generatecommentbox(data));


        }

        _this.closest(".comment_container").find(".comments-list").append(reply_html);
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
        window.location.assign(base_url + "Login?section=predictiondetail&vid=" + id);
        return false;
    }
    e.preventDefault();
    var _this = $(this);
    var id = _this.attr("data-id");
    var comment_id = _this.attr("data-comment_id");
    var offset = parseInt(_this.attr("data-offset"));

    var reply_html = $(document.createDocumentFragment());
    var edit_comment = '';
    var view_more_replies_html = '';
    $.ajax({
        url: base_url + "Predictions/get_comment_replies",
        method: "POST",
        data: {id: id, comment_id: comment_id, offset: offset}
    }).done(function (result) {

        for (var r in result['data']) {
            var data = [];
            data.comment_reply_id = result['data'][r].id;
            data.comment_id = result['data'][r].comment_id;
            data.alias = result['data'][r].alias;
            data.comment_reply = result['data'][r].reply;
            data.user_id = result['data'][r].user_id;

            reply_html.append(generatecommentbox(data, true));
        }


        _this.closest(".comment_container").find(".reply-container_" + comment_id + " .comment-reply-list").append(reply_html);
        if (result['is_available'] == "1") {
            var newoffset = offset + 5;
            view_more_replies_html = '<div class="row">\
                                            <div class="col-12 pt-1 text-right">\
                                                <a href="#" class="a-nostyle view-more-replies" data-id="' + id + '" data-comment_id="' + comment_id + '" data-offset="' + newoffset + '"><small>View more replies</small></a>\
                                            </div>\
                                        </div>';

            _this.closest(".comment_container").find(".reply-container_" + comment_id).append(view_more_replies_html);

            _this.closest(".row").remove();
        } else {
            _this.closest(".comment_container").find(".reply-container_" + comment_id + " .view-more-replies").closest(".row").hide();
        }
    });
}


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
function getrandomcolor() {
    var colors = [
        "#1abc9c",
        "#2ecc71",
        "#3498db",
        "#9b59b6",
        "#e67e22",
        "#e74c3c",
        "#d35400",
        "#f1c40f",
        "#2c3e50",
        "#16a085",
        "#34495e",
        "#2980b9",
        "#12CBC4",
        "#EE5A24",
        "#009432",
        "#ED4C67",
        "#FFC312",
        "#5758BB"
    ]

    return colors[Math.floor(Math.random() * colors.length)];
}

/*Slug creation for blog */
function create_slug(string) {
    var slug_string = '';
    slug_string = string.replace(/[~`!@#$%^&*()_=+{}|\/;'<>?,]/g, ''); //remove special characters from slug
    slug_string = slug_string.split(' ').join('-'); //creating slug

    return slug_string;
}


function load_sidebar(b, q = "voices", offset = 0) {
    $.ajax({
        url: base_url + "Common/get_trending_" + q,
        method: "POST",
        data: {offset: offset, notin: 0, relatedTopics: relatedTopicIds}
    }).done(function (result) {

        var data = result['data'];
        var html = b;
        if (data.length > 0) {

            for (var i in data) {
                html.append(getblock(data[i], q));
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
            tt.width($('.blog-list-item', tt).length * $(".blog-list-item", tt).outerWidth() + 320); //100

        }
    });
}

function getblock(data, q) {
    var total_votes = '';
    if (q == "voices")
        q = "YourVoice/blog_detail/"
    else if (q == "questions")
        q = "AskQuestions/details/"
    else if (q == "rated_articles")
        q = "FromTheWeb/detail/"
    else if (q == "predictions")
        q = "Predictions/details/"
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
