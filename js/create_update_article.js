/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var i = 4 + options.other_options;

function remove_choices(e) {
    e.preventDefault();
    $(this).closest("div.row").remove();
    i--;

    if (i == 5) {
        $("div.form-group").find(".remove-choices").hide();
    } else {
        $("div.form-group").find(".remove-choices").show();
    }
}

$(function () {

    if (i > 4) {
        $('.choices-list div.form-group:nth-child(2)').find(".col-md-1 a").removeClass("add-more-choices").addClass("remove-choices").html('<span>&minus;</span>');
    }

    $(document).on("click", ".add-more-choices", function (e) {
        var _this = $(this);
        e.preventDefault();

        if (i < 13) {
            var choice_input = $('<input />', {type: "text", class: "form-control", required: "", name: "choices[]", id: "choice" + i});
            var remove_choice = $("<a>", {href: "#", class: "remove-choices"})
                    .append($("<span>").html("&minus;"));

            var choice = $("<div>", {class: "form-group"})
                    .append($("<div>", {class: "row"})
                            .append($("<div>", {class: "col-md-11"})
                                    .append(choice_input)
                                    )
                            .append($("<div>", {class: "col-md-1"})
                                    .append($("<a>", {href: "#", class: "add-more-choices"})
                                            .append($("<span>").html("&#x2b;"))
                                            )
                                    )
                            );

            $(".choices-list").append(choice);

            _this.closest("div").html(remove_choice);

            if (i == 4) {
                $("div.form-group").find(".remove-choices").hide();
            } else {
                $("div.form-group").find(".remove-choices").show();
            }

            i++;
        }
    });

    //while add new prediction this block of code should execute
    if (options.article_id == 0) {
        $(".add-more-choices").trigger("click");
    }

    //Remove Choices click event
    $(document).on("click", ".remove-choices", remove_choices);

    /* Image upload */
    $("#uploadImage").on("change", function () {
        var file = $(this)[0].files[0];

        var imageData = new FormData();
        imageData.append('file', file);

        ajax_call_multipart(uploadUrl, "POST", imageData, function (result) {
            $("#uploadImage").closest(".form-group").find("#uploadFile").val(result);
            //$(".uploaded-img-preview").html('<div class="" style="height:90px; background:url(' + result + ') center center no-repeat;background-size:contain;"></div>');
        });
    });

    /* Create update prediction submit */
    $("form#frm_article").on("submit", function (e) {
        e.preventDefault();
        var preview = $(".generated-preview").html();
        var data = $(this).serialize();

        console.log(data);

        ajax_call(options.base_url + "RatedArticle/create_update_article", "POST", data, function (result) {

            if (result.status) {
                window.location.assign(options.base_url + "RatedArticle");
            } else {
                //result.data.title;
                //result.data.description;
                //result.data.choices;
                //result.data.uploaded_filename;
            }
        });
    });

    $("textarea#description").on("paste", function (e) {
        var pastedData = e.originalEvent.clipboardData.getData('text');
        var url = findUrls(pastedData);

        console.log(url[0]);
        if (url != null && url != "null") {
            getpreview(url[0]);
        }
    });

    function getpreview(target) {

        $.ajax({
            url: options.base_url + "RatedArticle/generate_preview",
            method: "POST",
            data: {url: target},
        }).done(function (result) {
            result = JSON.parse(result);
            console.log(result);
            if (result['status']) {
                var url = result['data']['url'];
                var title = result['data']['title'];
                var image = result['data']['image'];
                var description = result['data']['description'];
                var cell = {
                    link: target,
                    img: image,
                    domain: target,
                    title: title,
                    description: description
                }

                var html = $("<div>");
                var remove_a = $("<a>", {href: "#", target: "_blank", class: "remove-preview-cls close"}).html("&times;")
                        .on("click", function (e) {
                            e.preventDefault();
                            $(".generated-preview").html('');
                            $("#uploadImage").attr("required");
                        });

                var preview = $("<a>", {href: target, target: "_blank", class: "text-dark nav-link"}).append($("<div>", {class: "row"})
                        .append($("<div>", {class: "col-sm-4"})
                                .append($("<div>", {style: "height: 200px; background:url(" + image + ") center center no-repeat"}))
                                )
                        .append($("<div>", {class: "col-sm-8"})
                                .append($("<div>", {class: "contain-title"}).html(title))
                                .append($("<div>", {class: "contain-description mt-2"}).html(description))
                                )
                        );
                html.append(remove_a).append(preview);

                $(".generated-preview").html(html);
                $("#uploadImage").removeAttr("required");
                $("#json_data").val(JSON.stringify(cell));
            }
        });
        return true;
    }
});

