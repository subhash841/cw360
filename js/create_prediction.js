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

            $("#is_choice_change").val('1');
            i++;
        }
    });

    //while add new prediction this block of code should execute
    if (options.prediction_id == 0) {
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
    $("form#frm_prediction").on("submit", function (e) {
        e.preventDefault();
        var data = $(this).serialize();
//        var topics = $("input[name='topics[]']").length;
//
//        if (topics == 0) {
//            $("#search_topics").focus();
//            $(".show-error").html(
//                    $("<div>", {class: "alert alert-warning alert-dismissible fade show", role: "alert"})
//                    .append($("<strong>").html("Please select Topics"))
//                    .append($("<button>", {type: "button", class: "close", "data-dismiss": "alert", "aria-label": "Close"})
//                            .append($("<span>", {"aria-hidden": "true"}).html("&times;"))
//                            )
//                    );
//
//            return false;
//        } else {
//            $(".alert").alert('close');
//        }
        ajax_call(options.base_url + "Predictions/create_update_prediction", "POST", data, function (result) {
            result = JSON.parse(result);
            if (result.status) {
                window.location.assign(options.base_url + "Predictions");
            } else {
                //result.data.title;
                //result.data.description;
                //result.data.choices;
                //result.data.emails;
                //result.data.uploaded_filename;
            }
        });
    });

    //$.fn.datepicker.defaults.format = "dd-mm-yyyy";
    var end = $(".input-daterange").find('[name="end_date"]');
    $(".input-daterange").datepicker({
        useCurrent: true,
        format: 'dd-mm-yyyy',
        orientation: "bottom left",
        minDate: moment().millisecond(0).second(0).minute(0).hour(0),
        autoclose: true,
    });
    end.datepicker('setDate', new Date());


    /* Search Topic - START */
    var selectedTopicId = [];
    if (options.prediction_id > 0) {
        $('.selected_topics').show();
        //selectedTopicId = options.selectedTopicIds;
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
