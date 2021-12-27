/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(function () {
    
    var searchterm = "";
    
    $(document).on("click", ".cancel-search", function (e) {
        e.preventDefault();
        $(".search").val('');
        $(".topic-list").html('');
        $(".result-info").text('No results');
    })
    
    $(document).on("keyup", ".search", function (e) {
        e.preventDefault();
        $(".topic-list").html('');
        searchterm = $(this).val();
        if(searchterm.length >= 2){
            //alert($(this).val());
            get_topic_list(searchterm);
        }
        
        if(searchterm.length <= 2){
            $(".result-info").text('No results');
        }

    })
    
    
    function get_topic_list(s) {
        $.post(base_url + "Search/topic_list",{sterm: s}).done(function (d) {
            var cont = $(".topic-list");
            if (d.data.length > 0)
                //$(".topics").removeClass("d-none").addClass("show");
            $.each(d.data, function (a, b) {
                cont.append(getfeaturedtopic(b));
            })
            //cont.css("width", (d.data.slice(0,10).length + 1) * $(".topic-item").first().outerWidth())
            $(".result-info").text(d.data.length+' results for '+searchterm);

        });
    }
    
    
    function getfeaturedtopic(data) {
        var btn;
        if (data.is_follow == "0")
            btn = $("<button />", {class: "btn btn-outline-danger rounded-btn followme z-depth-2", "data-topic": data.id, "data-follow": !data.is_follow}).html("+ Follow")
        else
            btn = $("<button />", {class: "btn btn-danger rounded-btn followme z-depth-2", "data-topic": data.id, "data-follow": !data.is_follow}).html("Following")
        var div = $("<div />", {class: "col-md-6 pt-3 text-center"})
                    
                    .append($("<div />", {class: "bg-w-block rounded container", style: "padding: 2rem;"})
                    .append($("<div />", {class: "row"})
                        .append($("<div />", {class: "col-lg-12 align-middle text-lg-left text-md-center"}).append($('<a class="d-block text-body" href='+base_url +'HotTopics/detail/'+data.id+  ' />').append($("<img />", {
                            class: "mr-lg-3 mr-sm-0",
                            src: data.icon,
                            style: "width: 50px;"
                        }))
                        .append($('<h6 />', {class: "col-lg-8 align-middle ftt text-lg-left text-sm-center d-inline-block"}).html(data.topic))))
                        ))
        return div;

    }
    
    
});

