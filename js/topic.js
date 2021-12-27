/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(function () {
    
    $(document).on("click", ".topics .carousel-control-prev", function (e) {
        e.preventDefault();
        if ($(".topic-item").length > 1)
            $(".topic-cont").animate({scrollLeft: $(".topic-cont").scrollLeft() - 170}, {duration: 100, queue: false});

    })
    $(document).on("click", ".topics .carousel-control-next", function (e) {
        e.preventDefault();
        if ($(".topic-item").length > 1)
            $(".topic-cont").animate({scrollLeft: $(".topic-cont").scrollLeft() + 170}, {duration: 100, queue: false});

    })
    
    $(document).on("click", ".topics .followme", function (e) {
        e.preventDefault();
        var _this = $(this);
        $.post(base_url + "Index/follow_topic", {topic_id: $(this).attr("data-topic"), is_follow: $(this).attr("data-follow")}).done(function (d) {
            _this.attr("data-follow", !d.is_follow)

            if (d.is_follow)
                _this.removeClass("btn-outline-danger").addClass("btn-danger").html("Following")
            else
                _this.removeClass("btn-danger").addClass("btn-outline-danger").html("+ Follow")
        });

    })
    
    get_topic_list();
    
    function get_topic_list() {
        $.post(base_url + "Index/topic_list").done(function (d) {
            var cont = $(".topic-list");
            var cont2 = $(".featured-topic-list");
            if (d.data.length > 0)
                $(".topics").removeClass("d-none").addClass("show");
            $.each(d.data.slice(0,10), function (a, b) {
                cont.append(gettopic(b));
            })
            $.each(d.data.slice(10), function (a, b) {
                cont2.append(getfeaturedtopic(b));
            })
            cont.css("width", (d.data.slice(0,10).length + 1) * $(".topic-item").first().outerWidth())

        });
    }
    
    function gettopic(data) {
        var btn;
        if (data.is_follow == "0")
            btn = $("<button />", {class: "btn btn-outline-danger rounded-btn followme z-depth-2", "data-topic": data.id, "data-follow": !data.is_follow}).html("+ Follow")
        else
            btn = $("<button />", {class: "btn btn-danger rounded-btn followme z-depth-2", "data-topic": data.id, "data-follow": !data.is_follow}).html("Following")
        var div = $("<div />", {class: "col-sm-2 col-6 blog-list-item pt-3 topic-item text-center wide-list-item"})
                .append($("<div />", {class: "bg-w-block rounded pb-3"})
                    .append($('<a href='+base_url +'HotTopics/detail/'+data.id+  ' />')
                        .append($("<div />", {
                            class: "voiceimg p-5",
                            style: "background: url('" + data.image + "')  no-repeat center center;"
                        }))
                        .append($('<h6 />', {class: "pl-1"}).html(data.topic)))
                        .append($("<small />")
                                .append(btn)))
        return div;



    }

    function getfeaturedtopic(data) {
        var btn;
        if (data.is_follow == "0")
            btn = $("<button />", {class: "btn btn-outline-danger rounded-btn followme z-depth-2", "data-topic": data.id, "data-follow": !data.is_follow}).html("+ Follow")
        else
            btn = $("<button />", {class: "btn btn-danger rounded-btn followme z-depth-2", "data-topic": data.id, "data-follow": !data.is_follow}).html("Following")
        var div = $("<div />", {class: "col-md-6 pt-3 text-center"})
                    
                    .append($("<div />", {class: "bg-w-block rounded container p-4", style: "min-height: 105px;"})
                    .append($("<div />", {class: "row"})
                        .append($("<div />", {class: "col-lg-8 text-lg-left text-md-center"}).append($('<a class="d-block text-body" href='+base_url +'HotTopics/detail/'+data.id+  ' />').append($("<img />", {
                            class: "mr-lg-3 mr-sm-0",
                            src: data.icon,
                            style: "width: 50px;"
                        }))
                        .append($('<h6 />', {class: "col-lg-8 align-middle ftt text-lg-left text-sm-center d-inline-block"}).html(data.topic))))
                        .append($("<small />", {class: "col-lg-4 d-flex align-items-center justify-content-center"})
                                .append(btn))))
        return div;



    }


    
})


