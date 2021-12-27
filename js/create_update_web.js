/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(function () {

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

    /* Create update from the web submit */
    $("form#frm_web").on("submit", function (e) {
        e.preventDefault();
        var data = $(this).serialize();
        var topics = $("input[name='topics[]']").length;

        if (topics == 0) {
            $("#search_topics").focus();
            $(".show-error").html(
                    $("<div>", {class: "alert alert-warning alert-dismissible fade show", role: "alert"})
                    .append($("<strong>").html("Please select Topics"))
                    .append($("<button>", {type: "button", class: "close", "data-dismiss": "alert", "aria-label": "Close"})
                            .append($("<span>", {"aria-hidden": "true"}).html("&times;"))
                            )
                    );

            return false;
        } else {
            $(".alert").alert('close');
        }

        ajax_call(options.base_url + "FromTheWeb/create_update_article", "POST", data, function (result) {
            if (result.status) {
                window.location.assign(options.base_url + "Index");
            } else {
                //result.data.title;
                //result.data.description;
                //result.data.choices;
                //result.data.uploaded_filename;
            }
        });
    });

    /* Search Topic - START */
    var selectedTopicId = [];
    if (options.web_id > 0) {
        $('.selected_topics').show();
        selectedTopicId = options.selectedTopicIds;
    } else {
        $('.selected_topics').hide();
        selectedTopicId = [];
    }

    //search Topics
    $("#search_topics").on('keyup', function (e) {
        var topic = $(this).val();
        var html = '';

        if (topic != "" && topic.length > 2) {
            $.ajax({
                url: options.base_url + "HotTopics/search_topics",
                method: "POST",
                data: {topic: topic, excludetopic: JSON.stringify(selectedTopicId)}
            }).done(function (result) {

                $(".searched_topics").html("");
                for (var i in result) {

                    html = $("<div />", {class: "col-sm-4"})
                            .append($("<a />", {class: "foundtopic nav-link", href: "#", "data-id": result[i].id, "data-name": result[i].topic}).html(result[i].topic)

                                    );

                    $(".searched_topics").append(html);
                }

            });
        } else {

            $(".searched_topics").html("");
        }
    });

    $(document).on('click', 'a.foundtopic', function (e) {
        e.preventDefault();

        var selected = $("<div>", {class: "float-left alert alert-secondary p-2 mr-3 selected-topic"})
                .append('<input type="hidden" name="topics[]" value="' + $(this).attr('data-id') + '" data-id="' + $(this).attr('data-id') + '">' + $(this).attr('data-name'))
                .append($("<i>", {class: "cancel", style: "cursor:pointer"}).html('&nbsp; &times;')
                        )


        $(this).closest('.searched_topic').parent().remove();
        $('.selected_topics').show();
        $('.selected_topics .row').append(selected);
        $("#search_topics").val('').trigger("keyup");
        $("#is_topic_change").val('1');
        selectedTopicId.push($(this).attr('data-id'));
    });

    $(document).on('click', '.selected_topics .cancel', function (e) {
        $(this).closest('.selected-topic').remove();
        var index = selectedTopicId.indexOf($(this).prev().attr('data-id'));
        if (index > -1) {
            selectedTopicId.splice(index, 1);
            $("#is_topic_change").val('1');
        }
    });

    /* Search Topic - END */

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
            url: options.base_url + "Common/generate_preview",
            method: "POST",
            data: {url: target},
        }).done(function (result) {
            //result = JSON.parse(result);
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
                var remove_a = $("<a>", {href: "#", target: "_blank", class: "remove-preview-cls close", "style": "z-index: 2;position: relative;"}).html("&times;");
//                        .on("click", function (e) {
//                            e.preventDefault();
//                            $(".generated-preview").html('');
//                            $("#uploadImage").attr("required");
//                            $("#uploadImage").closest(".form-group").removeClass("d-none");
//                        });

                var preview = $("<a>", {href: target, target: "_blank", class: "text-dark nav-link"}).append($("<div>", {class: "row"})
                        .append($("<div>", {class: "col-sm-4"})
                                .append($("<div>", {style: "height: 200px; background:url(" + image + ") center center no-repeat; background-size: cover;"}))
                                )
                        .append($("<div>", {class: "col-sm-8"})
                                .append($("<div>", {class: "contain-title"}).html(title))
                                .append($("<div>", {class: "contain-description mt-2"}).html(description))
                                )
                        );
                html.append(remove_a).append(preview);

                $(".generated-preview").html(html);
                $("#uploadImage").removeAttr("required");
                $("#uploadImage").closest(".form-group").addClass("d-none");
                $("#json_data").val(JSON.stringify(cell));
            }
        });
        return true;
    }

    $(document).on("click", ".remove-preview-cls", function (e) {
        e.preventDefault();
        $(".generated-preview").html('');
        $("#uploadImage").attr("required", "required");
        $("#uploadImage").closest(".form-group").removeClass("d-none");
    });
});

