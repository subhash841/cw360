/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(function () {



    /* Search Topic - START */
    var selectedTopicId = [];


    //search Topics
    $(".cust-search").on('keyup', function (e) {
        var topic = $(this).val();
        var html = '';

        $(".header-searched-topics .results").html(
                $("<div />", {class: "col-sm-12"})
                .append($("<p />", {class: "my-2"}).html("Searching"))
                );
        if (topic != "" && topic.length > 1) {
            $.ajax({
                url: base_url + "HotTopics/search_topics",
                method: "POST",
                data: {topic: topic, excludetopic: JSON.stringify(selectedTopicId)}
            }).done(function (result) {
                if (result.length < 1)
                    $(".header-searched-topics .results").html(
                            $("<div />", {class: "col-sm-12"})
                            .append($("<p />", {class: "my-2"}).html("No Results Found"))
                            );
                else
                    $(".header-searched-topics .results").html("");
                for (var i in result) {
                    html = $("<div />", {class: "col-sm-12"})
                            .append($("<a />", {class: "foundtopic nav-link text-left", href: base_url + "HotTopics/detail/" + result[i].id, "data-id": result[i].id, "data-name": result[i].topic}).html(result[i].topic)

                                    );
                    $(".header-searched-topics .results").append(html);
                }
            });
        } else {
            $(".header-searched-topics .results").html("");
        }
    });
    $(document).on("click", function () {

        $(".header-searched-topics .results").html("");
    })

});