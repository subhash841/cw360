/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var flag = true;
$(function () {

    if (localStorage.id)
    {
        if (localStorage.id == id) {
            $("[value='" + localStorage.choice + "']").prop("checked", true)
            setTimeout(function () {
                $('.vote').trigger("click")
            }, 300);

        }
    }
    $("a.head-login").attr("href", base_url + "Login?section=MP");



    $(".choose-option").on("change", function (e) {
        var _this = $(this);

        $('.choice-cont').removeClass('bg-active');
        if (_this.prop("checked"))
            _this.closest('.choice-cont').addClass('bg-active');
    })
    $(".load-more").on("click", function (e) {
        e.preventDefault();
        load_sidebar($(this).closest(".bg-w-block").find(".article-list"), $(this).attr("data-load"), $(this).attr("data-offset"))
    });

    load_sidebar($(".voice-list"), "voices");
    load_sidebar($(".questions-list"), "questions");
    load_sidebar($(".rated-list"), "rated_articles");

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
                tt.width($('.blog-list-item', tt).length * $(".blog-list-item", tt).outerWidth() + 100)

            }
        });
    }

    function getblock(data, q) {

        if (q == "voices")
            q = "YourVoice/blog_detail/"
        else if (q == "questions")
            q = "AskQuestions/details/"
        else if (q == "rated_articles")
            q = "RatedArticle/details/"

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
        var likes = $("<small />", {class: "likes"}).html(total_likes + " Likes &nbsp;&nbsp;&#9679;&nbsp;&nbsp; " + total_views + " Views &nbsp;&nbsp;&#9679;&nbsp;&nbsp; " + total_comments + " Comments")
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

});
