/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//var uploadUrl = "https://imageupload.localhost.com"; //local URL
var uploadUrl = "https://imgupload.crowdwisdom.co.in";  //Live URL

function ajax_call(url, method, params, cb) {
    $.ajax({
        url: url,
        method: method,
        data: params
    }).done(function (result) {
        cb(result);
    });
}

function ajax_call_multipart(url, method, params, cb) {
    $.ajax({
        url: url,
        method: method,
        data: params,
        cache: false,
        contentType: false,
        processData: false
    }).done(function (result) {
        cb(result);
    });
}

function findUrls(string) {
    var urls = string.match(/(https?:\/\/[^\s]+)/g);
    return urls;
}
    
function error_msg(data) {
    $(".text-danger").each(function (index) {
        $(this).html("");
    });
    var i = 0;

    for (var key in data) {

        if ($("#" + key + "_error").length) {
            $("#" + key + "_error").html(data[key]);
            if (i == 0) {
                $('html, body').animate({
                    scrollTop: $("#" + key + "_error").offset().top - ($(".nav").height() + 100)
                }, 1200);
            }
            i++;

        }
    }
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

function close_toast_popup(success_url) {
    window.location.href = success_url;
}
