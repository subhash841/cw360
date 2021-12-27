$(function () {
    order_book_list();
});

setInterval(function () {
    order_book_list();
}, 1000 * 60);

var game_id = window.location.href.split("/").pop().replace('#', '');

function hideorderbookpageloader() {
    $('.orderbookloader').addClass('d-none');
    $('#games-detail').removeClass('d-none');
}
function showorderbookpageloader() {
    $('.orderbookloader').removeClass('d-none');
    $('#games-detail').addClass('d-none');
}

function show_order_loadmore() {
    $('.loadmoreorderbook').removeClass('d-none');
}
function hide_order_loadmore() {
    $('.loadmoreorderbook').addClass('d-none');
}

function order_book_list() {
    showorderbookpageloader();
    limit = '10';
    offset = '0';
    $.ajax({
        method: 'POST',
        url: base_url + 'Games/order_book_api',
        data: {game_id: game_id, user_id: uid, limit: limit, offset: offset},
        dataType: 'JSON',
        success: function (res, textStatus, jqXHR) {
            hideorderbookpageloader();
            var table_html = "";
            //console.log(res);return;
            if (res.total_point == null || res.total_point == '') {
                $(".total_points").text('0');
            } else {
                $(".total_points").text(res.total_point.game_points);
            }

            if (res.order_book_list != '') {

                $.each(res.order_book_list, function (key, val) {

                    /*if (val.wrong_prediction == '0' && val.prediction_executed == '1') {
                        status = 'Right Prediction';
                        status_color = 'status_completed';
                    }else if (val.wrong_prediction == '1' && val.prediction_executed == '1') {
                        status = 'Wrong Prediction';
                        status_color = 'status_sell';
                    }*/ 

                    if (val.remaining_qty == '0' && val.is_active != '0') {
                        status = 'Completed';
                        status_color = 'status_completed';
                    } else if (val.order_qty == val.remaining_qty && val.is_active != '0') {
                        status = 'Active';
                        status_color = 'status_active';
                    } else if (val.is_active == '0') {
                        status = 'Cancelled';
                        status_color = 'status_cancelled';
                    } else {
                        status = 'Partially Completed';
                        status_color = 'status_partially_completed';
                    }
                    if (val.transaction_type == 'buy') {
                        trans_type = 'Buy';
                        order_status = 'status_buy';
                    }else if(val.is_shortsell == '1' && val.transaction_type == 'sell'){
                        trans_type = 'Short Sell';
                        order_status = 'status_sell';
                    }else if(val.is_shortsell == '0' && val.transaction_type == 'sell'){
                        trans_type = 'Sell';
                        order_status = 'status_sell';
                    }
                    if (status=='Active' && trans_type=='Buy') {
                        status_of_order = 'Waiting for Seller at your price';
                    }else if(status=='Active' && (trans_type=='Short Sell' || trans_type=='Sell')){
                        status_of_order = 'Waiting for Buyer at your price';
                    }else{
                        status_of_order = status;                       
                    }
                    game_id = val.game_id;

                    deducted_points = val.order_qty * val.order_price;
                    table_html += "<tr>";
                    table_html += "<td>" + val.order_id + "</td>";
                    table_html += "<td>" + val.title + "</td>";
                    table_html += "<td class='" + order_status + "'>" + trans_type + "</td>";
                    table_html += "<td>" + val.order_qty + "</td>";
                    table_html += "<td class='" + order_status + "'>" + val.order_price + "</td>";
                    table_html += "<td class='" + status_color + "'>" + status_of_order + "</td>";
                    if (val.title.indexOf('\'') > 0) {
                        val.title = val.title.replace('\'', '');
                    }
                    if (val.wrong_prediction == '1' && val.prediction_executed == '1') {
                        table_html += '<td><button class="btn btn-outline-primary-blue-new rounded-btn shadow-none order-btn" disabled="true">VIEW</button></td>';
                    }else{
                        table_html += '<td><button class="btn btn-outline-primary-blue rounded-btn shadow-none order-btn" onclick="get_transaction_details(\'' + val.order_id + '\',\'' + val.predictions_id + '\',\'' + val.title + '\',\'' + deducted_points + '\',\'' + game_id + '\',\'' + val.transaction_type + '\',\'' + val.is_shortsell + '\',\'' + val.remaining_qty + '\')">VIEW</button></td>';
                    }
                    
                })
                $("#order_book_table").html(table_html);
                $('#orderBook_load').attr({'data-limit': 0});
                $('#orderBook_load').attr({'data-offset': 0});
                if (res.order_book_list.length >= '10') {
                    $('#load_more_orderbook').show();
                }

            } else {
                $('#games-detail').addClass('d-none');
                $('.emptyorderbook').removeClass('d-none');
            }


        },
        error: function (jqXHR, textStatus, errorThrown) { }
    })
}

function order_book_list_load_more() {
    show_order_loadmore();
    // limit = Number($('#orderBook_load').attr('data-limit')) + 10;
    limit = 10;
    offset = Number($('#orderBook_load').attr('data-offset')) + 10;
    // alert('limit= '+limit);/*alert(offset);*/
    $.ajax({
        method: 'POST',
        url: base_url + 'Games/order_book_api',
        data: {game_id: game_id, user_id: uid, limit: limit, offset: offset},
        dataType: 'JSON',

        success: function (res, textStatus, jqXHR) {
            hide_order_loadmore();
            var table_html = "";
            // console.log(res.order_book_list);
            if (res.order_book_list != '') {

                $.each(res.order_book_list, function (key, val) {

                    /*if (val.wrong_prediction == '0' && val.prediction_executed == '1') {
                        status = 'Right Prediction';
                        status_color = 'status_completed';
                    }else if (val.wrong_prediction == '1' && val.prediction_executed == '1') {
                        status = 'Wrong Prediction';
                        status_color = 'status_sell';
                    }*/
                    if (val.remaining_qty == '0' && val.is_active != '0') {
                        status = 'Completed';
                        status_color = 'status_completed';
                    } else if (val.order_qty == val.remaining_qty && val.is_active != '0') {
                        status = 'Active';
                        status_color = 'status_active';
                    } else if (val.is_active == '0') {
                        status = 'Cancelled';
                        status_color = 'status_cancelled';
                    } else {
                        status = 'Partially Completed';
                        status_color = 'status_partially_completed';
                    }
                    if (val.transaction_type == 'buy') {
                        trans_type = 'Buy';
                        order_status = 'status_buy';
                    }else if(val.is_shortsell == '1' && val.transaction_type == 'sell'){
                        trans_type = 'Short Sell';
                        order_status = 'status_sell';
                    }else if(val.is_shortsell == '0' && val.transaction_type == 'sell'){
                        trans_type = 'Sell';
                        order_status = 'status_sell';
                    }

                    if (status=='Active' && trans_type=='Buy') {
                        status_of_order = 'Waiting for Seller at your price';
                    }else if(status=='Active' && (trans_type=='Short Sell' || trans_type=='Sell')){
                        status_of_order = 'Waiting for Buyer at your price';
                    }else{
                        status_of_order = status;                       
                    }
                    
                    game_id = val.game_id;
                    deducted_points = val.order_qty * val.order_price;

                    table_html += "<tr>";
                    table_html += "<td>" + val.order_id + "</td>";
                    table_html += "<td>" + val.title + "</td>";
                    table_html += "<td class='" + order_status + "'>" + trans_type + "</td>";
                    table_html += "<td>" + val.order_qty + "</td>";
                    table_html += "<td class='" + order_status + "'>" + val.order_price + "</td>";
                    table_html += "<td class='" + status_color + "'>" + status_of_order + "</td>";
                    if (val.title.indexOf('\'') > 0) {
                        val.title = val.title.replace('\'', '');
                    }
                    if (val.wrong_prediction == '1' && val.prediction_executed == '1') {
                        table_html += '<td><button class="btn btn-outline-primary-blue-new rounded-btn shadow-none order-btn" disabled="true">VIEW</button></td>';
                    }else{
                        table_html += '<td><button class="btn btn-outline-primary-blue rounded-btn shadow-none order-btn" onclick="get_transaction_details(\'' + val.order_id + '\',\'' + val.predictions_id + '\',\'' + val.title + '\',\'' + deducted_points + '\',\'' + game_id + '\',\'' + val.transaction_type + '\',\'' + val.is_shortsell + '\',\'' + val.remaining_qty + '\')">VIEW</button></td>';
                    }
                })
                $("#order_book_table").append(table_html);
                $('#orderBook_load').attr({'data-limit': Number(limit)});
                $('#orderBook_load').attr({'data-offset': Number(offset)});
                if (res.order_book_list.length < 10) {
                    $('#load_more_orderbook').hide();
                }

            } else {
                $('#load_more_orderbook').hide();
            }



        },
        error: function (jqXHR, textStatus, errorThrown) { }
    })
}



function order_book_list_filter() {
    showorderbookpageloader();
    limit = '10';
    offset = '0';

    var filter_status = $('#status').val();

    if(filter_status=='select_status'){
        $("#status_error").text('Please select status');
    }else{
        $("#status_error").text('');
    }


    $.ajax({
        method: 'POST',
        url: base_url + 'Games/order_book_api',
        data: {game_id: game_id, user_id: uid, limit: limit, offset: offset},
        dataType: 'JSON',
        success: function (res, textStatus, jqXHR) {
            hideorderbookpageloader();
            var table_html = "";
            //console.log(res);return;

            if (res.order_book_list != '') {

                $.each(res.order_book_list, function (key, val) {

                    /*if (val.wrong_prediction == '0' && val.prediction_executed == '1') {
                        status = 'Right Prediction';
                        status_color = 'status_completed';
                    }else if (val.wrong_prediction == '1' && val.prediction_executed == '1') {
                        status = 'Wrong Prediction';
                        status_color = 'status_sell';
                    }*/ 

                    if (val.remaining_qty == '0' && val.is_active != '0') {
                        status = 'Completed';
                        status_color = 'status_completed';
                    } else if (val.order_qty == val.remaining_qty && val.is_active != '0') {
                        status = 'Active';
                        status_color = 'status_active';
                    } else if (val.is_active == '0') {
                        status = 'Cancelled';
                        status_color = 'status_cancelled';
                    } else {
                        status = 'Partially Completed';
                        status_color = 'status_partially_completed';
                    }
                    if (val.transaction_type == 'buy') {
                        trans_type = 'Buy';
                        order_status = 'status_buy';
                    }else if(val.is_shortsell == '1' && val.transaction_type == 'sell'){
                        trans_type = 'Short Sell';
                        order_status = 'status_sell';
                    }else if(val.is_shortsell == '0' && val.transaction_type == 'sell'){
                        trans_type = 'Sell';
                        order_status = 'status_sell';
                    }
                    if (status=='Active' && trans_type=='Buy') {
                        status_of_order = 'Waiting for Seller at your price';
                    }else if(status=='Active' && (trans_type=='Short Sell' || trans_type=='Sell')){
                        status_of_order = 'Waiting for Buyer at your price';
                    }else{
                        status_of_order = status;                       
                    }
                    game_id = val.game_id;

                    deducted_points = val.order_qty * val.order_price;
                    
                    if(filter_status==status_of_order){
                        table_html += "<tr>";
                        table_html += "<td>" + val.order_id + "</td>";
                        table_html += "<td>" + val.title + "</td>";
                        table_html += "<td class='" + order_status + "'>" + trans_type + "</td>";
                        table_html += "<td>" + val.order_qty + "</td>";
                        table_html += "<td class='" + order_status + "'>" + val.order_price + "</td>";
                        table_html += "<td class='" + status_color + "'>" + status_of_order + "</td>";
                        if (val.title.indexOf('\'') > 0) {
                            val.title = val.title.replace('\'', '');
                        }
                        if (val.wrong_prediction == '1' && val.prediction_executed == '1') {
                            table_html += '<td><button class="btn btn-outline-primary-blue-new rounded-btn shadow-none order-btn" disabled="true">VIEW</button></td>';
                        }else{
                            table_html += '<td><button class="btn btn-outline-primary-blue rounded-btn shadow-none order-btn" onclick="get_transaction_details(\'' + val.order_id + '\',\'' + val.predictions_id + '\',\'' + val.title + '\',\'' + deducted_points + '\',\'' + game_id + '\',\'' + val.transaction_type + '\',\'' + val.is_shortsell + '\',\'' + val.remaining_qty + '\')">VIEW</button></td>';
                        }
                    }
                    
                })
                if (table_html=='') {
                    table_html += "<td rowspan='8' colspan='12' class='mx-auto text-center'>No records found..</td>";
                }
                $("#order_book_table").html('');
                $("#order_book_table").html(table_html);
                if (filter_status!='select_status') {
                    $("#sort-filter-popup").modal('hide');
                }
                $('#orderBook_load').attr({'data-limit': 0});
                $('#orderBook_load').attr({'data-offset': 0});
                if (res.order_book_list.length >= '10') {
                    $('#load_more_orderbook').show();
                }

            } else {
                $('#games-detail').addClass('d-none');
                $('.emptyorderbook').removeClass('d-none');
            }


        },
        error: function (jqXHR, textStatus, errorThrown) { }
    })
}

   