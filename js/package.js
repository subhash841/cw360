/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(function () {


    $(document).on("click", ".package-holder .carousel-control-prev", function (e) {
        e.preventDefault();
        if ($(".package-item").length > 1)
            $(".package-cont").animate({scrollLeft: $(".package-cont").scrollLeft() - 170}, {duration: 100, queue: false});

    })
    $(document).on("click", ".package-holder .carousel-control-next", function (e) {
        e.preventDefault();
        if ($(".package-item").length > 1)
            $(".package-cont").animate({scrollLeft: $(".package-cont").scrollLeft() + 170}, {duration: 100, queue: false});

    })

    /*Redirect to package info*/
    $(document).on("click", ".gotopackage", function (e) {
        e.preventDefault();
        var _this = $(this);
        var id = _this.attr('data-pkg');
        location.assign("Packages/package_info/" + id);
    });

    $("#silverPointsCheck").on("show.bs.modal", function (e) {
        if (uid == 0) {
            window.location.assign("/Login");
        }
        var btn = $(e.relatedTarget);
        var id = btn.attr("data-pkg");
        $('#silverPointsCheck .err').html("").removeClass("show");
        $("#silverPointsCheck .play").removeClass("disabled");
        $("#silverPointsCheck .play").attr("href", base_url + "Packages/purchase_package/" + id);
        $("#silverPointsCheck .spp").html(btn.attr("data-price"));
        if (parseInt(btn.attr("data-price")) > parseInt($("body").attr("data-silver_points")))
        {
            $('#silverPointsCheck .err').html("You do not have sufficient Silver Points").addClass("show");
            $("#silverPointsCheck .play").addClass("disabled");
        }
    })


    get_topic_list();

});

function get_topic_list() {
    $.post(base_url + "Packages/lists").done(function (d) {
        var cont = $(".packages-list");
        var cont2 = $(".featured-list");
        if (d.data.length > 0)
            $(".package-holder").removeClass("d-none").addClass("show");
        $.each(d.data, function (a, b) {
            if (a < 10)
                cont.append(getpackage(b));
            else
                cont2.append(getfeaturedpackage(b));
        })
        cont.css("width", ($(".package-item").length + 1) * $(".package-item").first().outerWidth())

    });
}

function getpackage(data) {
    var btn;
    if (data.is_follow == "0")
        btn = $("<button />", {class: "btn btn-outline-primary rounded-btn followme z-depth-2", "data-topic": data.id, "data-follow": !data.is_follow}).html("Play Now")
    else
        btn = $("<button />", {class: "btn btn-primary rounded-btn z-depth-2", "data-topic": data.id, "data-follow": !data.is_follow}).html("Play Now")
    var div = $('<div/>', {class: "col-sm-4 col-6 package-item"}) //wide-list-item 
            .append($("<div />", {class: " bg-w-block "})
                    .append($("<div/>", {class: "holder", style: "background-image:url(" + data.image + ")"}))
                    .append($("<div/>", {class: "text-center py-3 "})
                            .append($('<p />').html(data.name))
                            .append($('<button />', {href: "", class: "rounded-btn btn btn-primary gotopackage", "data-pkg": data.id, "data-price": parseInt(data.price)}).html("Play Now")))) //"data-toggle": "modal", "data-target": "#silverPointsCheck", 
            ;
    return div;

}

function getfeaturedpackage(data) {
    var btn;


    btn = $('<button />', {class: "rounded-btn btn btn-primary", "data-toggle": "modal", "data-target": "#silverPointsCheck", "data-pkg": data.id, "data-price": parseInt(data.price)}).html("Play Now")

    var div = $("<div />", {class: "col-md-6 pt-3 text-center"})

            .append($("<div />", {class: "bg-w-block rounded container p-4", style: "min-height: 105px;"})
                    .append($("<div />", {class: "row"})
                            .append($("<div />", {class: "col-lg-8 text-lg-left text-md-center"}).append($('<a class="d-block text-body" href=' + base_url + 'HotTopics/detail/' + data.id + ' />').append($("<img />", {
                                class: "mr-lg-3 mr-sm-0",
                                src: data.image,
                                style: "width: 50px;"
                            }))
                                    .append($('<h6 />', {class: "col-lg-8 align-middle ftt text-lg-left text-sm-center d-inline-block"}).html(data.name))))
                            .append($("<small />", {class: "col-lg-4 d-flex align-items-center justify-content-center"})
                                    .append(btn))));
    return div;
}
