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
    $("#is_choice_change").val('1');
    if (i == 5) {
        $("div.form-group").find(".remove-choices").hide();
    } else {
        $("div.form-group").find(".remove-choices").show();
    }
}

$(function () {

    if (i > 4) {
        $('.choices-list div.form-group:nth-child(2)').find(".col-md-1 a").removeClass("add-more-choices").addClass("remove-choices").html('<?xml version="1.0" encoding="iso-8859-1"?><!-- Generator: Adobe Illustrator 16.0.0, SVG Export Plug-In . SVG Version: 6.00 Build 0)  --><!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd"><svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="22px" height="22px" viewBox="0 0 612 612" style="enable-background:new 0 0 612 612;" xml:space="preserve"><g><g><g><g><g><path d="M306.336,611.994c-8.544,0-17.218-0.362-25.777-1.077c-81.445-6.794-155.37-44.898-208.157-107.296 C19.613,441.225-5.711,362.007,1.083,280.56C7.506,203.594,42.393,132.5,99.32,80.377 C155.926,28.548,229.205,0.006,305.659,0.006c8.544,0,17.217,0.361,25.776,1.076c81.449,6.795,155.376,44.9,208.162,107.297 c52.786,62.396,78.114,141.613,71.319,223.061c-6.421,76.967-41.309,148.061-98.235,200.182 C456.076,583.451,382.795,611.994,306.336,611.994z M305.659,8.036c-74.443,0-145.794,27.797-200.915,78.264 C49.312,137.054,15.341,206.28,9.085,281.228C2.47,360.537,27.131,437.676,78.534,498.435 c51.4,60.759,123.384,97.865,202.693,104.48c8.337,0.694,16.786,1.049,25.109,1.049c74.446,0,145.801-27.795,200.922-78.266 c55.435-50.755,89.404-119.98,95.658-194.929c6.615-79.309-18.046-156.448-69.448-217.206 c-51.4-60.759-123.387-97.863-202.699-104.48C322.43,8.39,313.981,8.036,305.659,8.036z"/></g></g><g><rect x="346.039" y="240.694" width="8.031" height="185.702"/><rect x="296.787" y="240.694" width="8.031" height="185.702"/><rect x="247.534" y="240.694" width="8.031" height="185.702"/><path d="M454.603,190.513H353.84c0.723-1.946,0.938-3.935,0.939-5.568l0.014-21.646c0.006-11.456-9.311-20.784-20.766-20.791 l-72.34-0.037c-0.005,0-0.008,0-0.011,0c-11.448,0-20.772,9.317-20.775,20.77l-0.016,21.642 c-0.001,2.246,0.384,4.086,0.975,5.629h-84.748v8.031h27.135v237.006c0,18.778,15.271,34.04,34.04,34.04H389.42 c18.766,0,34.037-15.26,34.037-34.04V198.544h31.144v-8.031H454.603z M248.933,163.243c0.002-7.025,5.72-12.743,12.745-12.743 h0.006l72.34,0.039c7.027,0.005,12.742,5.728,12.738,12.756l-0.013,21.642c-0.005,5.115-3.097,5.551-7.171,5.555l-5.432-0.103 l-0.079-0.001h-0.08l-77.862,0.059c-1.866-0.001-3.958-0.115-5.287-0.941c-0.527-0.33-1.924-1.203-1.922-4.618L248.933,163.243z M415.428,435.552c0,14.341-11.667,26.009-26.006,26.009H218.29c-14.342,0-26.009-11.668-26.009-26.009V198.841h223.147V435.552 L415.428,435.552z"/></g></g></g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>');
    }

    $(document).on("click", ".add-more-choices", function (e) {
        var _this = $(this);
        e.preventDefault();

        if (i < 51) { //13
            var choice_input = $('<input />', {type: "text", class: "form-control", required: "", name: "choices[]", id: "choice" + i});
            var remove_choice = $("<a>", {href: "#", class: "remove-choices"})
                    .append($("<span>").html('<?xml version="1.0" encoding="iso-8859-1"?><!-- Generator: Adobe Illustrator 16.0.0, SVG Export Plug-In . SVG Version: 6.00 Build 0)  --><!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd"><svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="22px" height="22px" viewBox="0 0 612 612" style="enable-background:new 0 0 612 612;" xml:space="preserve"><g><g><g><g><g><path d="M306.336,611.994c-8.544,0-17.218-0.362-25.777-1.077c-81.445-6.794-155.37-44.898-208.157-107.296 C19.613,441.225-5.711,362.007,1.083,280.56C7.506,203.594,42.393,132.5,99.32,80.377 C155.926,28.548,229.205,0.006,305.659,0.006c8.544,0,17.217,0.361,25.776,1.076c81.449,6.795,155.376,44.9,208.162,107.297 c52.786,62.396,78.114,141.613,71.319,223.061c-6.421,76.967-41.309,148.061-98.235,200.182 C456.076,583.451,382.795,611.994,306.336,611.994z M305.659,8.036c-74.443,0-145.794,27.797-200.915,78.264 C49.312,137.054,15.341,206.28,9.085,281.228C2.47,360.537,27.131,437.676,78.534,498.435 c51.4,60.759,123.384,97.865,202.693,104.48c8.337,0.694,16.786,1.049,25.109,1.049c74.446,0,145.801-27.795,200.922-78.266 c55.435-50.755,89.404-119.98,95.658-194.929c6.615-79.309-18.046-156.448-69.448-217.206 c-51.4-60.759-123.387-97.863-202.699-104.48C322.43,8.39,313.981,8.036,305.659,8.036z"/></g></g><g><rect x="346.039" y="240.694" width="8.031" height="185.702"/><rect x="296.787" y="240.694" width="8.031" height="185.702"/><rect x="247.534" y="240.694" width="8.031" height="185.702"/><path d="M454.603,190.513H353.84c0.723-1.946,0.938-3.935,0.939-5.568l0.014-21.646c0.006-11.456-9.311-20.784-20.766-20.791 l-72.34-0.037c-0.005,0-0.008,0-0.011,0c-11.448,0-20.772,9.317-20.775,20.77l-0.016,21.642 c-0.001,2.246,0.384,4.086,0.975,5.629h-84.748v8.031h27.135v237.006c0,18.778,15.271,34.04,34.04,34.04H389.42 c18.766,0,34.037-15.26,34.037-34.04V198.544h31.144v-8.031H454.603z M248.933,163.243c0.002-7.025,5.72-12.743,12.745-12.743 h0.006l72.34,0.039c7.027,0.005,12.742,5.728,12.738,12.756l-0.013,21.642c-0.005,5.115-3.097,5.551-7.171,5.555l-5.432-0.103 l-0.079-0.001h-0.08l-77.862,0.059c-1.866-0.001-3.958-0.115-5.287-0.941c-0.527-0.33-1.924-1.203-1.922-4.618L248.933,163.243z M415.428,435.552c0,14.341-11.667,26.009-26.006,26.009H218.29c-14.342,0-26.009-11.668-26.009-26.009V198.841h223.147V435.552 L415.428,435.552z"/></g></g></g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>'));

            var choice = $("<div>", {class: "form-group"})
                    .append($("<div>", {class: "row"})
                            .append($("<div>", {class: "col-md-11"})
                                    .append(choice_input)
                                    )
                            .append($("<div>", {class: "col-md-1 pt-2"})
                                    .append($("<a>", {href: "#", class: "add-more-choices"})
                                            .append($("<span>").html('<?xml version="1.0" encoding="iso-8859-1"?><!-- Generator: Adobe Illustrator 16.0.0, SVG Export Plug-In . SVG Version: 6.00 Build 0) --><!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd"><svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"width="22px" height="22px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve"><g><g><polygon points="272,128 240,128 240,240 128,240 128,272 240,272 240,384 272,384 272,272 384,272 384,240 272,240"/><path d="M256,0C114.609,0,0,114.609,0,256c0,141.391,114.609,256,256,256c141.391,0,256-114.609,256-256C512,114.609,397.391,0,256,0z M256,472c-119.297,0-216-96.703-216-216S136.703,40,256,40s216,96.703,216,216S375.297,472,256,472z"/></g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>')))
                                    )
                            );

            $(".choices-list").append(choice);

            _this.closest("div").html(remove_choice);

            if (i == 4) {
                $("div.form-group").find(".remove-choices").hide();
            } else {
                $("div.form-group").find(".remove-choices").show();
            }

            $("#is_choice_change").val('1');
            i++;
        }
    });

    //while add new prediction this block of code should execute
    if (options.question_id == 0) {
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
    $("form#frm_question").on("submit", function (e) {
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

        ajax_call(options.base_url + "AskQuestions/create_update_question", "POST", data, function (result) {
            if (result.status) {
                window.location.assign(options.base_url + "AskQuestions");
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
    if (options.question_id > 0) {
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

});

