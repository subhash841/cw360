$(function () {
    predictions_list();

    $('#info-popup').on('show.bs.modal', function (e) {
        var predictionid = $(e.relatedTarget).data('predictionid');
        var predictionname = $(e.relatedTarget).data('predictionname');
        var changepercent = $(e.relatedTarget).data('changepoint');
        if (changepercent == '-') {
            changepoint = '';
        } else {
            changepoint = changepercent;
        }
        var predictionclass = $(e.relatedTarget).data('predictionclass');
        var predictionicon = $(e.relatedTarget).data('predictionicon');
        var currentval = $(e.relatedTarget).data('currentval');

        //alert(changepoint);
        $(e.currentTarget).find('input[name="prediction_id"]').val(predictionid);
        $(e.currentTarget).find('.predictionname').html('<i class="flaticon-information-buttons"></i>' + predictionname);
        $(e.currentTarget).find('.changepoint').html('<span class="text-gray mr-2">' + currentval + '</span> ' + changepoint + '<i class="' + predictionicon + ' font07  ml-0"></i>');
        $(e.currentTarget).find('.changepoint').addClass(predictionclass);
    });
    //alert('hi');

});

setInterval(function () {
   // alert('hi');
   predictions_list();
}, 1000 * 60);



function hidepredectionloader() {
    $('.predectionlistloader').addClass('d-none');
    $('#position-list').removeClass('d-none');
}
function showpredectionloader() {
    $('.predectionlistloader').removeClass('d-none');
    $('#position-list').addClass('d-none');
}
function showviewmorepredectionloader() {
    $('.viewmorepredection').removeClass('d-none');
}
function hideviewmorepredectionloader() {
    $('.viewmorepredection').addClass('d-none');
}

function blank_value(value = "") {
    //alert(value)
    if (typeof (value) != '' && value != '0') {
        var iNum = value.toFixed(2);
        return iNum;
    } else {
        return value = '-';
}
}

var game_id = window.location.href.split("/").pop().replace('#', '');
function predictions_list() {
    $.ajax({
        method: 'POST',
        url: base_url + 'Games/predictions_list_api',
        data: {"game_id": game_id, "user_id": uid},

    }).done(function(response) {
        data = JSON.parse(response);
        hidepredectionloader();
        var table_html = "";
        if (data.total_point == null || data.total_point == '') {
            $(".total_avb_points").text('0');
        } else {
            $(".total_avb_points").text(data.total_point.game_points);
        } 
//        if (data.top_news == null || data.top_news == '') {
//            $("#top_news_vw").addClass('d-none');
//        } else {
//            $(".top_news_vw").text(data.top_news.news);
//        }
  
        $.each(data.predictions_data, function (key, val) {

            if (typeof (val['previous_closed']) != 0 && val['previous_closed'] != null) {
                var diff_of_values = (val['current_value'] - val['previous_closed']);
                if (diff_of_values != '0') {
                    var percentChange = blank_value(diff_of_values / val['previous_closed'] * 100);
                    if (percentChange < 0) {
                        percent_icon = "flaticon-download";
                        percent_class = "danger";
                    } else {
                        percent_icon = "flaticon-upload";
                        percent_class = "success";
                    }
                    percentChange = percentChange + '%';
                } else {
                    percentChange = '-';
                    percent_icon = "";
                    percent_class = "";
                }
            } else {
                var percentChange = '-';
                percent_icon = '';
                percent_class = '';
            }

            if (val['previous_closed'] == null) {
                var addclass = "";
                var icon = "";
                var change_point = "-";
            } else if ((val['current_value'] - val['previous_closed']) > 0) {
                var addclass = "success";
                var icon = "flaticon-upload";
                var change_point = blank_value(parseFloat(Math.abs(val['current_value'] - val['previous_closed'])));

            } else if ((val['current_value'] - val['previous_closed']) < 0) {
                var addclass = "danger";
                var icon = "flaticon-download";
                var change_point = blank_value(parseFloat(Math.abs(val['current_value'] - val['previous_closed'])));

            } else {
                var addclass = "";
                var icon = "";
                var change_point = "-";
            }
            if (val.volume<'0') {
                val.volume = '0';
            }

            table_html += "<tr data.href='" + base_url + "predictions/details/" + val["id"] + "' class='clikable cursor-pointer'>";
            table_html += "<td><a href='" + base_url + "predictions/details/" + val["id"] + "' class='no-text-decoration'>" + val.title + "</a></td>";
            table_html += "<td><i class='flaticon-money'></i><h6 class='" + addclass + " d-inline ml-2'>" + val.current_value + "<i class='" + icon + "'></i></h6></td>";
            table_html += "<td>" + change_point + "</td>";
            // table_html += "<td class='" + addclass + "'>" + val.current_value + "<i class='" + icon + "'></i></td>";
            //table_html += "<td class='" + addclass + "'> (" + percentChange == +" '-' ? " + percentChange + " : " + percentChange + "'%') </td>";
            table_html += "<td><h6 class='" + percent_class + ' ' + "d-inline ml-2'>" + percentChange + "<i class='" + percent_icon + "'></i></h6></td>";

            // table_html += "<td>" + blank_value(parseFloat(val.high_value)) + "</td>";
            // table_html += "<td>" + blank_value(parseFloat(val.low_value)) + "</td>";
            table_html += "<td class='d-none'></td>";
            table_html += "<td>" + val.volume + "</td>";

            table_html += "<td><a class='btn blue-btn' href='" + base_url + "predictions/details/" + val['id'] + "''>Trade</a>\n\
<i class='flaticon-information-buttons cursor-pointer ml-3' data-toggle='modal' data-target='#info-popup' title='Info' data-predictionname='" + val.title + "' data-changepoint='" + percentChange + "' data-currentval='" + val.current_value + "' data-predictionclass='" + percent_class + "' data-predictionicon='" + percent_icon + "''>\n\
<img src=" + base_url + "images/common/question.svg class='qimg'></i></td>";
            table_html += "</tr>";

        });
        // console.log(table_html);

        if (data.predictions_data != '') {
            $("#predictions_list").html(table_html);
            // $('.loadmorePrediction').removeClass('d-none');
        } else {
            $("#position-list").addClass('d-none');
            /*$(".loadmorePrediction").addClass('d-none');*/
            /*$('.loadmorepage').prop('disabled', true);*/
            $('.emptyrecords').removeClass('d-none');
        }
        /*if (data.predictions_data.length >= '10') {
            $('.loadmorePrediction').removeClass('d-none');
        }*/

    });
}

$(document).on('click', '.loadmorepage', function (e) {
    showviewmorepredectionloader();
    // if ($('.limit_offset').val() == '') {
    //     limit_offset = 10;
    // } else {
    //     limit_offset = parseInt($('.limit_offset').val()) + 10;
    // }
    formdata = $('#filter_prediction').serializeArray();
    formdata.push({name: 'game_id', value: game_id});
    formdata.push({name: 'user_id', value: uid});
    //formdata.push({name: 'limit', value: limit_offset});
    //formdata.push({name: 'offset', value: limit_offset});

    $.ajax({
        method: 'POST',
        url: base_url + 'Games/predictions_list_api',
        // data: {"game_id": game_id, "user_id": uid, "limit": limit_offset, "offset": limit_offset},
        data: formdata,

    }).done(function (response) {
        hidepredectionloader();
        hideviewmorepredectionloader();
        response = JSON.parse(response);
        var table_html = "";
        $.each(response.predictions_data, function (key, val) {
            //console.log(response)

            if (typeof (val['previous_closed']) != 0 && val['previous_closed'] != null) {
                var diff_of_values = (val['current_value'] - val['previous_closed']);
                if (diff_of_values != '0') {
                    var percentChange = blank_value(diff_of_values / val['previous_closed'] * 100);
                    if (percentChange < 0) {
                        percent_icon = "flaticon-download";
                        percent_class = "danger";
                    } else {
                        percent_icon = "flaticon-upload";
                        percent_class = "success";
                    }
                    percentChange = percentChange + '%';
                } else {
                    percentChange = '-';
                    percent_icon = "";
                    percent_class = "";
                }
            } else {
                var percentChange = '-';
                percent_icon = '';
                percent_class = '';
            }
            if (val['previous_closed'] == null) {
                var addclass = "";
                var change_point = "-";
            } else if ((val['current_value'] - val['previous_closed']) > 0) {
                var addclass = "success";
                var icon = "flaticon-upload";
                var change_point = blank_value(parseFloat(Math.abs(val['current_value'] - val['previous_closed'])));

            } else if ((val['current_value'] - val['previous_closed']) < 0) {
                var addclass = "danger";
                var icon = "flaticon-download";
                var change_point = blank_value(parseFloat(Math.abs(val['current_value'] - val['previous_closed'])));

            } else {
                var addclass = "";
                var icon = "";
                var change_point = "-";
            }
            if (val.volume<'0') {
                val.volume = '0';
            }

            table_html += "<tr data.href='" + base_url + "predictions/details/" + val["id"] + "' class='clikable cursor-pointer'>";
            table_html += "<td><a href='" + base_url + "predictions/details/" + val["id"] + "' class='no-text-decoration'>" + val.title + "</a></td>";
            table_html += "<td><i class='flaticon-money'></i><h6 class='" + addclass + " d-inline ml-2'>" + val.current_value + "<i class='" + icon + "'></i></h6></td>";
            table_html += "<td>" + change_point + "</td>";
            // table_html += "<td class='" + addclass + "'>" + val.current_value + "<i class='" + icon + "'></i></td>";
            //table_html += "<td class='" + addclass + "'> (" + percentChange == +" '-' ? " + percentChange + " : " + percentChange + "'%') </td>";
            table_html += "<td><h6 class='" + percent_class + ' ' + "d-inline ml-2'>" + percentChange + "<i class='" + percent_icon + "'></i></h6></td>";

            // table_html += "<td>" + blank_value(parseFloat(val.high_value)) + "</td>";
            // table_html += "<td>" + blank_value(parseFloat(val.low_value)) + "</td>";
            table_html += "<td class='d-none'></td>";
            table_html += "<td>" + val.volume + "</td>";

            table_html += "<td><a class='btn blue-btn' href='" + base_url + "predictions/details/" + val['id'] + "''>Trade</a>\n\
<i class='flaticon-information-buttons cursor-pointer ml-3' data-toggle='modal' data-target='#info-popup' title='Info' data-predictionname='" + val.title + "' data-changepoint='" + percentChange + "' data-currentval='" + val.current_value + "' data-predictionclass='" + percent_class + "' data-predictionicon='" + percent_icon + "''><img src=" + base_url + "images/common/question.svg class='qimg'></i></td>";
            table_html += "</tr>";

        })

        if (response != '') {
            $("#predictions_list").append(table_html);
            // $('.limit_offset').val(limit_offset);

        } else {
            $("#predictions_list").html("<tr><td colspan='7' class='text-center' >Prediction not found</td>");
            // $('.loadmorepage').prop('disabled', true);
        }
        /*if (response.predictions_data.length < '10') {
            $('.loadmorePrediction').addClass('d-none');
        }*/

    });

});

function filter() {
    var formdata = $('#filter_prediction').serialize();
    var url = base_url + "Games/predictions_list_api";
    var price = $('#price').val();
    var predection_list = $('#predection_list').val();
    if (price == '') {
        $('#price_error').html('Please select price type');

    }
    if (predection_list == '') {
        $('#predection_list_error').html('Please select predection list');

    }
    $('#price_error').html('');
    $('#predection_list_error').html('');
    $.ajax({
        url: url,
        dataType: 'JSON',
        data: formdata,
        type: 'post',
        success: function (data, textStatus, jqXHR) {

            if (data.status == 'failure') {
                error_msg(data.error);
            } else {

                response = data.predictions_data;

                var table_html = "";
                $.each(response, function (key, val) {
                    //console.log(response)
                    if (typeof (val['previous_closed']) != 0 && val['previous_closed'] != null) {
                        var diff_of_values = (val['current_value'] - val['previous_closed']);
                        if (diff_of_values != '0') {
                            var percentChange = blank_value(diff_of_values / val['previous_closed'] * 100);
                            if (percentChange < 0) {
                                percent_icon = "flaticon-download";
                                percent_class = "danger";
                            } else {
                                percent_icon = "flaticon-upload";
                                percent_class = "success";
                            }
                            percentChange = percentChange + '%';
                        } else {
                            var percentChange = '-';
                            percent_icon = '';
                            percent_class = '';
                        }
                    } else {
                        var percentChange = '-';
                        percent_icon = '';
                        percent_class = '';
                    }
                    if (val['previous_closed'] == null) {
                        var addclass = "";
                        var change_point = "-";
                    } else if ((val['current_value'] - val['previous_closed']) > 0) {
                        var addclass = "success";
                        var icon = "flaticon-upload";
                        var change_point = blank_value(parseFloat(Math.abs(val['current_value'] - val['previous_closed'])));

                    } else if ((val['current_value'] - val['previous_closed']) < 0) {
                        var addclass = "danger";
                        var icon = "flaticon-download";
                        var change_point = blank_value(parseFloat(Math.abs(val['current_value'] - val['previous_closed'])));

                    } else {
                        var addclass = "";
                        var icon = "";
                        var change_point = "-";
                    }
                    if (val.volume<'0') {
                        val.volume = '0';
                    }

                    table_html += "<tr data.href='" + base_url + "predictions/details/" + val["id"] + "' class='clikable cursor-pointer'>";
                    table_html += "<td><a href='" + base_url + "predictions/details/" + val["id"] + "' class='no-text-decoration'>" + val.title + "</a></td>";
                    table_html += "<td><i class='flaticon-money'></i><h6 class='" + addclass + " d-inline ml-2'>" + val.current_value + "<i class='" + icon + "'></i></h6></td>";
                    table_html += "<td>" + change_point + "</td>";
                    // table_html += "<td class='" + addclass + "'>" + val.current_value + "<i class='" + icon + "'></i></td>";
                    //table_html += "<td class='" + addclass + "'> (" + percentChange == +" '-' ? " + percentChange + " : " + percentChange + "'%') </td>";
                    table_html += "<td><h6 class='" + percent_class + ' ' + "d-inline ml-2'>" + percentChange + "<i class='" + percent_icon + "'></i></h6></td>";

                    // table_html += "<td>" + blank_value(parseFloat(val.high_value)) + "</td>";
                    // table_html += "<td>" + blank_value(parseFloat(val.low_value)) + "</td>";
                    table_html += "<td class='d-none'></td>";
                    table_html += "<td>" + val.volume + "</td>";
                    table_html += "<td><a class='btn blue-btn' href='" + base_url + "predictions/details/" + val['id'] + "''>Trade</a><i class='flaticon-information-buttons cursor-pointer ml-3' data-toggle='modal' data-target='#info-popup' title='Info' data-predictionname='" + val.title + "' data-changepoint='" + percentChange + "' data-currentval='" + val.current_value + "' data-predictionclass='" + percent_class + "' data-predictionicon='" + percent_icon + "''><img src=" + base_url + "images/common/question.svg class='qimg'></i></td>";
                    table_html += "</tr>";

                })

                if (response != '') {
                    $("#sort-filter-popup").modal('hide');
                    $("#predictions_list").html("");
                    $("#predictions_list").html(table_html);

                } else {
                    $("#sort-filter-popup").modal('hide');
                    $("#predictions_list").html("<tr><td colspan='7' class='text-center' >Prediction not found</td>");
                    // $('.loadmorepage').prop('disabled', true);
                }
                /*if (response.length < '10') {
                    $('.loadmorePrediction').addClass('d-none');
                }*/


            }

        },
        error: function (jqXHR, textStatus, errorThrown) {

        }
    });
    //}
}

//web prediction search
var ispredictionsearchopen = false;
$('.searchprediction').on('click', function () {
    if (ispredictionsearchopen) {
        predictions_list();
        $('.webpredictionsearch').animate({left: '800px'}, 900, function () {
            $('.webpredictionsearch').addClass('d-none');
            $('body').css('overflow-x', 'initial');
        });
        $('.cancelwebpredictionsearch').addClass('d-none');
        $('.webprdictionseacrhicon').removeClass('d-none');

        ispredictionsearchopen = false;
    } else {
        $('body').css('overflow-x', 'hidden');
        $('#predictionseacrh').focus();
        $('.webpredictionsearch').animate({left: '-43px'}, 900);
        $('.webpredictionsearch, .cancelwebpredictionsearch').removeClass('d-none');
        $('.webprdictionseacrhicon').addClass('d-none');
        ispredictionsearchopen = true;
    }
});
$('#predictionseacrh, #mobsearchpredectionfield').on('keyup', function (e) {
    showpredectionloader();
    if ($(this).val().length > 2) {
        $.ajax({
            url: base_url + 'Games/predictions_list_api',
            method: "POST",
            data: {game_id: game_id, "user_id": uid, 'keywords': $(this).val()},
        }).done(function (e) {
            var prediction = JSON.parse(e);

            hidepredectionloader();
            response = prediction.predictions_data;
            console.log(response);

            var table_html = "";
            $.each(response, function (key, val) {
                if (typeof (val['previous_closed']) != 0 && val['previous_closed'] != null) {
                    var diff_of_values = (val['current_value'] - val['previous_closed']);
                    if (diff_of_values != '0') {
                        var percentChange = blank_value(diff_of_values / val['previous_closed'] * 100);
                        if (percentChange < 0) {
                            percent_icon = "flaticon-download";
                            percent_class = "danger";
                        } else {
                            percent_icon = "flaticon-upload";
                            percent_class = "success";
                        }
                        percentChange = percentChange + '%';
                    } else {
                        percentChange = '-';
                        percent_icon = "";
                        percent_class = "";
                    }
                } else {
                    var percentChange = '-';
                    percent_icon = '';
                    percent_class = '';
                }
                if (val['previous_closed'] == null) {
                    var addclass = "";
                    var change_point = "-";
                } else if ((val['current_value'] - val['previous_closed']) > 0) {
                    var addclass = "success";
                    var icon = "flaticon-upload";
                    var change_point = blank_value(parseFloat(Math.abs(val['current_value'] - val['previous_closed'])));

                } else if ((val['current_value'] - val['previous_closed']) < 0) {
                    var addclass = "danger";
                    var icon = "flaticon-download";
                    var change_point = blank_value(parseFloat(Math.abs(val['current_value'] - val['previous_closed'])));

                } else {
                    var addclass = "";
                    var icon = "";
                    var change_point = "-";
                }
                if (val.volume<'0') {
                    val.volume = '0';
                }

                table_html += "<tr data.href='" + base_url + "predictions/details/" + val["id"] + "' class='clikable cursor-pointer'>";
                table_html += "<td><a href='" + base_url + "predictions/details/" + val["id"] + "' class='no-text-decoration'>" + val.title + "</a></td>";
                table_html += "<td><i class='flaticon-money'></i><h6 class='" + addclass + " d-inline ml-2'>" + val.current_value + "<i class='" + icon + "'></i></h6></td>";
                table_html += "<td>" + change_point + "</td>";
                // table_html += "<td class='" + addclass + "'>" + val.current_value + "<i class='" + icon + "'></i></td>";
                //table_html += "<td class='" + addclass + "'> (" + percentChange == +" '-' ? " + percentChange + " : " + percentChange + "'%') </td>";
                table_html += "<td><h6 class='" + percent_class + ' ' + "d-inline ml-2'>" + percentChange + "<i class='" + percent_icon + "'></i></h6></td>";

                // table_html += "<td>" + blank_value(parseFloat(val.high_value)) + "</td>";
                // table_html += "<td>" + blank_value(parseFloat(val.low_value)) + "</td>";
                table_html += "<td class='d-none'></td>";
                table_html += "<td>" + val.volume + "</td>";
                table_html += "<td><a class='btn blue-btn' href='" + base_url + "predictions/details/" + val['id'] + "''>Trade</a><i class='flaticon-information-buttons cursor-pointer ml-3' data-toggle='modal' data-target='#info-popup' title='Info' data-predictionname='" + val.title + "' data-changepoint='" + percentChange + "' data-currentval='" + val.current_value + "' data-predictionclass='" + percent_class + "' data-predictionicon='" + percent_icon + "''><img src=" + base_url + "images/common/question.svg class='qimg'></i></td>";
                table_html += "</tr>";

            })

            if (response != '') {
                $("#sort-filter-popup").modal('hide');
                $("#predictions_list").html("");
                $("#predictions_list").html(table_html);

            } else {
                $("#sort-filter-popup").modal('hide');
                $("#predictions_list").html("<tr><td colspan='7' class='text-center' >Prediction not found</td>");
                // $('.loadmorepage').prop('disabled', true);
            }
            /*if (response.length < '10') {
                $('.loadmorePrediction').addClass('d-none');
            }*/


        });
    } else {
        predictions_list();
    }
})
//web prediction end

$(document).on('click', 'tr.clikable td:not(:last-child),tr.clikable td:last-child', function (e) {
    e.preventDefault();
//        console.log($(this).attr('data.href'));
    if (e.target.className !== "qimg") {
        window.location = $(this).parent().attr('data.href');
    }
//        console.log($(this).parent().attr('data.href') + 'from 1st ');
});

//$(document).on('click', 'tr.clikable td:last-child', function (e) {
//    e.preventDefault();
//    if (e.target.className !== "flaticon-information-buttons cursor-pointer")
////        console.log($(this).parent().attr('data.href') + 'from 2nd ');
//        window.location = $(this).parent().attr('data.href');
//});

