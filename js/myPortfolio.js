$(function () {
    myPortfolio();

});

function hideportfolioloader() {
    $('.portfolioloader').addClass('d-none');
    $('#tbl_portfolio').removeClass('d-none');
}
function showportfolioloader() {
    $('.portfolioloader').removeClass('d-none');
    $('#tbl_portfolio').addClass('d-none');
}

function show_loadmore_portfolio() {
    $('.loadmoreportfolio').removeClass('d-none');
}
function hide_loadmore_portfolio() {
    $('.loadmoreportfolio').addClass('d-none');
}

// setInterval(function () {
//     // alert('hi');
//     myPortfolio();
// }, 1000 * 60);

function myPortfolio() {
    showportfolioloader();
     limit = '10';
     offset = '0';
    var game_id = window.location.href.split("/").pop();
    $.ajax({
        method: 'POST',
        url: base_url + 'Games/MyPortfolio_Api',
        data: {"game_id": game_id, "user_id": uid, "limit": limit, "offset": offset},

    }).done(function (response) {
        hideportfolioloader();
        data = JSON.parse(response);
        //console.log(data);
        if (data.total_point != null) {
            $('.total_points').text(data.total_point.game_points);
        }
        // console.log(data.myportfolio_data);return;
        var table_html = "";
        $.each(data.myportfolio_data, function (key, val) {
            if (val.total_avg_units!='0' && val.total_avg_units!=null) {
                if ((val['current_value'] - val['previous_closed']) > 0) {
                    var addclass = "success";
                    var icon = "flaticon-upload";

                } else if ((val['current_value'] - val['previous_closed']) < 0) {

                    var addclass = "danger";
                    var icon = "flaticon-download";

                }else{
                    var addclass = "";
                    var icon = "";                
                }

                table_html += "<tr data.href='" + base_url + "predictions/details/" + val.pid + "' class='clikable cursor-pointer'>";
                table_html += "<td><a href='"+base_url+"predictions/details/"+val.pid+" 'class='no-text-decoration'>" + val.title + "<a></td>";
                // table_html += "<td>" + val.executed_qty + "</td>";
                table_html += "<td>" + val.total_avg_units + "</td>";
                table_html += "<td><span class='" + addclass + " d-inline mr-2'>" + val.current_value + "</span><i class='" + icon + " size14 ml-0'></i></td>";
                // table_html += "<td>" + val.per_qty_points + "</td>";
                // table_html += "<td>" + blank_value(parseFloat(val.avg_purchased_price)) + "</td>";
                table_html += "</tr>";
            }

        })
      
            $(".portfolio_total_points").text(blank_value(parseFloat(data.portfolio_points)));
            if (data.rank!='0') {
                if (data.rank < 10) {
                    $('.game_rank').text('0'+data.rank);
                }else{
                    $('.game_rank').text(data.rank);
                }
            }else{
                $('.game_rank').text('-');
            }
        if (data.myportfolio_data != '') {
            // $('.rank_dis').addClass('d-block');
            $("#portfolio").html(table_html);
            $('#portFolio_load').attr({'data-limit': 0});
            $('#portFolio_load').attr({'data-offset': 0});
        } else {
            $('.border-dashed').addClass('d-none');
            $('.emptyportfolio').removeClass('d-none');
            $('.blue-tr ').children().children().addClass('py-3');
            /*$('.loadmorepage').prop('disabled', true);*/
        }
        if (data.myportfolio_data.length >= '10') {
            $('#loadmorePortfolio').show();
        }

    });
}

/*$(document).on('click', '.loadmorepage', function (e) {

    if ($('.limit_offset').val() == '') {
        limit_offset = 10;
    } else {
        limit_offset = parseInt($('.limit_offset').val()) + 10;
    }

    var game_id = window.location.href.split("/").pop();
    $.ajax({
        method: 'POST',
        url: base_url + 'Games/MyPortfolio_Api',
        data: {"game_id": game_id, "user_id": uid, "limit": limit_offset, "offset": limit_offset},

    }).done(function (response) {
        response = JSON.parse(response);
        $('.total_points').text(data.total_point.game_points);
        var table_html = "";
        $.each(response, function (key, val) {
            //console.log(response)
            if (typeof (val['change_value']) == '') {
                var addclass = "";
                var change_point = "";
            } else if ((val['current_value'] - val['change_value']) > 0) {
                var addclass = "success";
                var icon = "flaticon-up-arrow";

            } else if ((val['current_value'] - val['change_value']) < 0) {

                var addclass = "danger";
                var icon = "flaticon-download-1";


            }

            table_html += "<tr>";
            table_html += "<td>" + val.title + "</td>";
            table_html += "<td>" + val.executed_qty + "</td>";
            table_html += "<td class='" + addclass + "'>" + val.current_value + "<i class='" + icon + "'></i></td>";
            table_html += "<td>" + val.per_qty_points + "</td>";
            table_html += "</tr>";

        })

        if (response != '') {
            $("#portfolio").append(table_html);
            $('.limit_offset').val(limit_offset);
            $('.game_rank').text(data.total_point.rank);

        } else {
            $('.loadmorepage').prop('disabled', true);
        }

    });

});*/

function port_folio_list_load(){
    show_loadmore_portfolio();
    // limit = Number($('#portFolio_load').attr('data-limit')) + 10;
    limit = 10;
    offset = Number($('#portFolio_load').attr('data-offset')) + 10;

    var game_id = window.location.href.split("/").pop();
    $.ajax({
        method: 'POST',
        url: base_url + 'Games/MyPortfolio_Api',
        data: {"game_id": game_id, "user_id": uid, "limit": limit, "offset": offset},

    }).done(function (response) {
        hide_loadmore_portfolio();
        data = JSON.parse(response);
        var table_html = "";

        if (data.myportfolio_data != '') {
            $.each(data.myportfolio_data, function (key, val) {
                if (val.total_avg_units!='0' && val.total_avg_units!=null) {
                    if ((val['current_value'] - val['previous_closed']) > 0) {
                        var addclass = "success";
                        var icon = "flaticon-upload";

                    } else if ((val['current_value'] - val['previous_closed']) < 0) {

                        var addclass = "danger";
                        var icon = "flaticon-download";

                    }else{
                        var addclass = "";
                        var icon = "";                
                    }

                    table_html += "<tr data.href='" + base_url + "predictions/details/" + val.pid + "' class='clikable cursor-pointer'>";
                    table_html += "<td><a href='"+base_url+"predictions/details/"+val.pid+" 'class='no-text-decoration'>" + val.title + "<a></td>";
                    // table_html += "<td>" + val.executed_qty + "</td>";
                    table_html += "<td>" + val.total_avg_units + "</td>";
                    table_html += "<td><span class='" + addclass + " d-inline mr-2'>" + val.current_value + "</span><i class='" + icon + " size14 ml-0'></i></td>";
                    // table_html += "<td>" + val.per_qty_points + "</td>";
                    // table_html += "<td>" + blank_value(parseFloat(val.avg_purchased_price)) + "</td>";
                    table_html += "</tr>";
                }

            })
            
            $("#portfolio").append(table_html);
            $('#portFolio_load').attr({'data-limit': Number(limit)});
            $('#portFolio_load').attr({'data-offset': Number(offset)});

            if (data.myportfolio_data.length < 10) {
                $('#loadmorePortfolio').hide();
            }

        }else{
            $('#loadmorePortfolio').hide();
        }
    });

}

$(document).on('click', 'tr.clikable td', function (e) {
    e.preventDefault();
        window.location = $(this).parent().attr('data.href');
});