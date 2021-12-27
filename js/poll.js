
$(function () {
    var login_redirect = $("#redirecturl").val();
    $(".head-login").attr("href", login_redirect);

    $(document).on('click', '.yesredeem', function (e) {
        $('#pointsModal').modal('close');
        $('.slide-on-mobile').slideDown();
        $('#polltopic').focus();
        $('.askvotebanner').css('display', 'none');
        $('.linkpreview').html('');
        setTimeout(function () {
            $('#polltopic').focus();
        }, 100);
    });
    $(document).on('click', '.noredeem', function (e) {
        $('#pointsModal').modal('close');
    });
    $(document).on('click', 'a#show-mobile-discussion', function () {
        $('#pointsModal').removeClass('small');
        if (!options.loggedin) {
            var redirecturl = $('#redirecturl').val();
            window.location.assign(redirecturl);
        } else {
            if (!options.alias) {
                Materialize.Toast.removeAll();
                Materialize.toast('Please enter your alias first.', 2000);
                setTimeout(function () {
                    var redirect_url = $("#redirecturl").val();
                    var redirect_sess = redirect_url.split("?");
                    window.location.href = options.baseurl + 'Profile?' + redirect_sess[1];
                }, 2000)

            } else {

                $.ajax({
                    "url": options.baseurl + "Poll/getsilverpoints",
                    "method": "POST",
                }).done(function (result) {

                    if (parseInt(result) > 500) {
                        $('#pointsModal #title').html('Your Balance Points');
                        $('#pointsModal #points').html(result);
                        $('#pointsModal #msg').html('Redeem 500 Points to ask');
                        $('#pointsModal #submsg').html('');
                        $('#pointsModal .optionsbtn').css('display', 'block');
                        $('#pointsModal').modal('open');
                    } else {
                        $('#pointsModal #title').html('Your Balance Points');
                        $('#pointsModal #points').html(result);
                        //$('#pointsModal #msg').html("<span style='color:#eb1000'>You can't raise any Poll</span>");
                        $('#pointsModal #msg').hide();
                        $('#pointsModal #submsg').html("You must have 500 silver points to ask a question");
                        $('#pointsModal .optionsbtn').css('display', 'none');
                        $('#pointsModal').modal('open');
                    }
                });
            }
        }

    })
    $(document).on('click', '#postpoll button[type="reset"]', function () {

        $('.slide-on-mobile').slideUp();
        $('#postpoll')[0].reset();
        //$('#polltopic').blur();
        var defaultchoice = '<div class="row choice mb10">\
                                <div class="col s11">\
                                    <input type="text" name="choice[]" maxlength="35" placeholder="Enter your choice here"/>\
                                </div>\
                                <div class="col s1 no-padding">\
                                    <i class="flaticon-plus addmorechoice"></i>\
                                    <i class="flaticon-delete removechoice hide"></i>\
                                </div>\
                            </div>\
                            <div class="row choice mb10">\
                                <div class="col s11">\
                                    <input type="text" name="choice[]" maxlength="35" placeholder="Enter your choice here"/>\
                                </div>\
                                <div class="col s1 no-padding">\
                                    <i class="flaticon-plus addmorechoice"></i>\
                                    <i class="flaticon-delete removechoice hide"></i>\
                                </div>\
                            </div>\
                            <div class="row choice mb10">\
                                <div class="col s11">\
                                    <input type="text" name="choice[]"  maxlength="35" placeholder="Enter your choice here"/>\
                                </div>\
                                <div class="col s1 no-padding">\
                                    <i class="flaticon-plus addmorechoice"></i>\
                                    <i class="flaticon-delete removechoice "></i>\
                                </div>\
                            </div>';
        $('#choiceslist').html(defaultchoice);
        $('.askvotebanner').css('display', 'block');
    })



    //$('#loginbtn').attr('href',options.baseurl+'Login?section=poll&p=gov')

    if (window.location.href) {
        var hash = window.location.href; //Puts hash in variable, and removes the # character

        $('#tabs-swipe-demo>li>a').removeClass('active');
        if (hash.indexOf("#elecpoll") != -1 || hash.indexOf("Governance") != -1) {
            $('input[name="pollcatergory"][value="1"]').prop('checked', true);
            $('#tabs-swipe-demo>li>a[href="#elecpoll"]').addClass('active');
            $('#elecpoll').addClass('active');
            $('#redirecturl').val(options.baseurl + 'Login?section=poll&p=gov');
            $("a.head-logout").attr("href", options.baseurl + "Login/logout/P_Governance");
        } else if (hash.indexOf("#stockpoll") != -1 || hash.indexOf("Money") != -1) {
            $('input[name="pollcatergory"][value="2"]').prop('checked', true);
            $('#tabs-swipe-demo>li>a[href="#stockpoll"]').addClass('active');
            $('#stockpoll').addClass('active');
            $('#redirecturl').val(options.baseurl + 'Login?section=poll&p=mon');
            $("a.head-logout").attr("href", options.baseurl + "Login/logout/P_Money");
        } else if (hash.indexOf("#sportpoll") != -1 || hash.indexOf("Sports") != -1) {
            $('input[name="pollcatergory"][value="3"]').prop('checked', true);
            $('#tabs-swipe-demo>li>a[href="#sportpoll"]').addClass('active');
            $('#sportpoll').addClass('active');
            $('#redirecturl').val(options.baseurl + 'Login?section=poll&p=spo');
            $("a.head-logout").attr("href", options.baseurl + "Login/logout/P_Sports");
        } else if (hash.indexOf("#moviepoll") != -1 || hash.indexOf("Entertainment") != -1) {
            $('input[name="pollcatergory"][value="4"]').prop('checked', true);
            $('#tabs-swipe-demo>li>a[href="#moviepoll"]').addClass('active');
            $('#moviepoll').addClass('active');
            $('#redirecturl').val(options.baseurl + 'Login?section=poll&p=ent');
            $("a.head-logout").attr("href", options.baseurl + "Login/logout/P_Entertainment");
        } else {
            $('input[name="pollcatergory"][value="1"]').prop('checked', true);
            $('#tabs-swipe-demo>li>a[href="#elecpoll"]').addClass('active');
            $('#elecpoll').addClass('active');
            $('#redirecturl').val(options.baseurl + 'Login?section=poll&p=gov');
            $("a.head-logout").attr("href", options.baseurl + "Login/logout/P_Governance");
        }
    } else {
        $('input[name="pollcatergory"][value="1"]').prop('checked', true);
        $('#tabs-swipe-demo>li>a[href="#elecpoll"]').addClass('active');
        $('#elecpoll').addClass('active');
        //$('#loginbtn').attr('href', options.baseurl+'Login?section=poll&p=gov')
        $('#redirecturl').val(options.baseurl + 'Login?section=poll&p=gov');
        $("a.head-logout").attr("href", options.baseurl + "Login/logout/P_Governance");
    }


    if (options.toast) {

        Materialize.Toast.removeAll();
        Materialize.toast(options.toast, 4000);
        return false;
    }


    //$("#tabs-swipe-demo1").tabs();



    $("#mobtabcategories").on('change', function () {
        var selectedCategory = $(this).val();
        //console.log(selectedCategory);
        //window.location.href=selectedCategory;
        window.location.assign(selectedCategory);
        window.location.reload();
    });
    $(document).on('click', '#tabs-swipe-demo.tabs > li > a', function (e) {
        loadflag = 1;
        var id = $(this).attr("href");
        var categoryid = $(this).attr('data-catid');
        var type = $(this).attr('data-type');
        if (typeof (id) != "undefined") {
            id = id.substr(1);
            var pageno = 0;
            var tendpage = 0;
            if (id == "elecpoll") {
                $('input[name="pollcatergory"][value="1"]').prop('checked', true);
                history.pushState(null, null, '?ct=Governance');
                $('#redirecturl').val(options.baseurl + 'Login?section=poll&p=gov');
                $(".head-login").attr("href", options.baseurl + 'Login?section=poll&p=gov');
                pageno = $('.loadmorepage[data-category="Governance"]').attr('data-pageid');
                $("a.head-logout").attr("href", options.baseurl + "Login/logout/P_Governance");
            } else if (id == "stockpoll") {
                $('input[name="pollcatergory"][value="2"]').prop('checked', true);
                history.pushState(null, null, '?ct=Money');
                $('#redirecturl').val(options.baseurl + 'Login?section=poll&p=mon');
                $(".head-login").attr("href", options.baseurl + 'Login?section=poll&p=mon');
                pageno = $('.loadmorepage[data-category="Money"]').attr('data-pageid');
                $("a.head-logout").attr("href", options.baseurl + "Login/logout/P_Money");
            } else if (id == "sportpoll") {
                $('input[name="pollcatergory"][value="3"]').prop('checked', true);
                history.pushState(null, null, '?ct=Sports');
                $('#redirecturl').val(options.baseurl + 'Login?section=poll&p=spo');
                $(".head-login").attr("href", options.baseurl + 'Login?section=poll&p=spo');
                pageno = $('.loadmorepage[data-category="Sports"]').attr('data-pageid');
                $("a.head-logout").attr("href", options.baseurl + "Login/logout/P_Sports");
            } else if (id == "moviepoll") {
                $('input[name="pollcatergory"][value="4"]').prop('checked', true);
                history.pushState(null, null, '?ct=Entertainment');
                $('#redirecturl').val(options.baseurl + 'Login?section=poll&p=ent');
                $(".head-login").attr("href", options.baseurl + 'Login?section=poll&p=ent');
                pageno = $('.loadmorepage[data-category="Entertainment"]').attr('data-pageid');
                $("a.head-logout").attr("href", options.baseurl + "Login/logout/P_Entertainment");
            } else {
                history.pushState(null, null, '?ct=Governance');
                $('#redirecturl').val(options.baseurl + 'Login?section=poll');
                $(".head-login").attr("href", options.baseurl + 'Login?section=poll');
                pageno = $('.loadmorepage[data-category="Governance"]').attr('data-pageid');
                $("a.head-logout").attr("href", options.baseurl + "Login/logout/P_Governance");
            }
            if (typeof (pageno) == "undefined") {
                pageno = 0;
            } else {
                pageno = 1;
            }
            tendpage = 0;
            loaddatafortrending(categoryid, tendpage, type);
            load_my_answered_prediction(categoryid, pageno);
            if (parseInt(pageno) < 1) {
                loaddatafortab(categoryid, pageno, type)
            }

        }
    });
    $(document).on('click', '.addmorechoice', function (e) {
//alert("one row added");
        if ($('#staticoption').css('display') == "none") {
            $('#staticoption').css('display', 'block');
        }
        var visible = $("#choiceslist .choice").length;
        var html = "";
        var addbtnstatus = "";
        if (visible < 10) {
            if (visible == 9) {
                addbtnstatus = "hide";
            }

            html = '<div class="row choice mb10">\
<div class="col s11">\
<input type="text" name="choice[]" maxlength="35" placeholder="Enter your choice here"/>\
</div>\
<div class="col s1 no-padding">\
<i class="flaticon-plus addmorechoice ' + addbtnstatus + '"></i>\
<i class="flaticon-delete removechoice"></i>\
</div>\
</div>';
            $('#choiceslist').append(html);
            if (visible < 2) {
                $('.choice .removechoice').addClass('hide');
            } else {
                $('.choice .removechoice').removeClass('hide');
            }
        }
    });
    $(document).on('click', '.removechoice', function (e) {
        if ($('.addmorechoice').hasClass('disabled')) {
            $('.addmorechoice').removeClass('disabled');
        }
        var visible = $("#choiceslist .choice").length;
        if (visible >= 2) {
            $(this).parent().parent().remove();
            if (visible <= 3) {
                $('.choice .removechoice').addClass('hide');
            } else {
                $('.choice .removechoice').removeClass('hide');
            }
        } else {
            $('.choice .removechoice').addClass('hide');
            //$('.choice:first-child .removechoice').css('display', 'none');
            Materialize.Toast.removeAll();
            Materialize.toast('Minimum two options should be there', 4000);
        }
    });
//    $(document).on('click', '.with-gap', function (e) {
//        $('.with-gap').closest('.card').addClass('votedpoll');
//        //$(this).closest('.btgray').addClass('activepollop');
//    });

    $(document).on('click', '.pollbtnvote', function (e) {
        var pollid = $(this).attr('data-pollid');
        var section = $(this).attr('data-type');
        var categoryid = $(this).attr('data-catid');
        var userchoice = $("input[name='pollchoice" + section + "_" + pollid + "']:checked").val();
        var _this = $(this);
        if (!options.loggedin) {
            localStorage.pollid = pollid;
            localStorage.choiseid = userchoice;
            localStorage.categoryid = categoryid;
            localStorage.section = section;
        }

        if ($("input[name='pollchoice" + section + "_" + pollid + "']").is(":checked")) {
            if (!options.loggedin) {
                var redirecturl = $('#redirecturl').val();
                redirecturl = redirecturl + "&t=2&pid=" + pollid;
                window.location.assign(redirecturl);
            }

            $.ajax({
                url: options.baseurl + "Poll/addpollchoice",
                method: "POST",
                data: {poll_id: pollid, choice: userchoice, category_id: categoryid}
            }).done(function (result) {
                result = JSON.parse(result);
                if (result['status'])
                {
                    _this.closest(".card#card_" + pollid).find(".expertsw").removeClass("hide");
                    $('.polloption_' + pollid).each(function () {
                        var html = "";
                        var tabname = $(this).attr('data-tabname');
                        for (var i in result['data']['options']) {
                            var isvoted = result['data']['options'][i]['choice_id'] == userchoice ? "checked" : "";
                            var totalavg = result['data']['options'][i]['choice'] != "See the Results" ? '<span class="avgpercount fs14px">' + result['data']['options'][i]['avg'] + ' %</span>' : "";
                            var userselected = result['data']['options'][i]['choice_id'] == userchoice ? "userselected" : "";
                            var isnoclickchoice = result['data']['options'][i]['choice'] == "See the Results" ? "fw600" : "";
                            html += '<div class = "col m12 s12"  data-choiceid="' + result['data']['options'][i]['choice_id'] + '">\
                                        <div class = "row mb7">\
                                            <div class="col m12 s12">\
                                                <label class = "polloption progress" style="position: relative;">\
                                                    <input class = "with-gap" class="pollchoice_' + pollid + '" name = "pollchoice' + tabname + '_' + pollid + '" data-type="' + tabname + '" data-total="' + result['data']['options'][i]['total'] + '" type = "radio" value="' + result['data']['options'][i]['choice_id'] + '" ' + isvoted + '/>\
                                                    <span class="customradio">\
                                                        <i class="flaticon-check selected"></i>\
                                                    </span>\
                                                    <span class="fs14px choicetext">' + (result['data']['options'][i]['choice'] == "Do not know or skip" || result['data']['options'][i]['choice'].toLowerCase() == "see the results" ? "<b>See The Results</b>" : result['data']['options'][i]['choice']) + '</span><!--style="position:absolute;" -->\
                                                    <div class = "determinate ' + userselected + '" style = "width: 0%" data-afterload="' + result['data']['options'][i]['avg'] + '"></div>\
                                                    ' + totalavg + '\
                                                </label>\
                                            </div>\
                                        </div>\
                                    </div>';
                        }

                        $("#polloption" + tabname + "_" + pollid).html(html);
                        $("#polloption" + tabname + "_" + pollid).addClass('votedpoll');
//$(".votedpoll input[type='radio']").attr('disabled', true);

                        setTimeout(function () {
                            var maxper = 0
                            $("#polloption" + tabname + "_" + pollid + " .determinate:first").parent().addClass('maxper');
                            $("#polloption" + tabname + "_" + pollid + " .determinate").each(function () {
                                var newper = $(this).attr('data-afterload');
                                $(this).css('width', newper + '%');
                                if (parseFloat(newper) > parseFloat(maxper)) {
                                    $("#polloption" + tabname + "_" + pollid + " .determinate").parent().removeClass('maxper');
                                    $(this).parent().addClass('maxper');
                                    maxper = newper;
                                }
                            });
                            $('.avgvotebox').each(function () {
                                var avgper = $(this).attr('data-avg');
                                if (parseFloat(avgper) > 0)
                                {
                                    //$(this).html('Avg: ' + parseInt(avgper));
                                    $(this).html('Avg: ' + avgper);
                                } else {
                                    $(this).addClass('hide');
                                }
                            });
                        }, 100)

                    });
//$('input[name ^=pollchoice][name $=' + pollid + '][value=' + userchoice + ']').attr('checked', true);
                    var changebtn = '<span class="votescountbox mr20 hide">\
<span class="flaticon-click ml0 mr5"></span>\
<span class="fs14px fw500">' + result['data']['total_votes'] + '</span>\
</span>';
//$('button[data-pollid="' + pollid + '"].pollbtnvote').parent().prepend(changebtn);
//$('button[data-pollid="' + pollid + '"].pollbtnvote').remove();
                    $('#togglecmtsec_' + section + '_' + pollid).slideDown('slow');
//$('#pointsModal').addClass('small');
//console.log(result['data']['total_votes']);
                    var votesword = result['data']['total_votes'] > 1 ? "Votes" : "Vote";
//console.log(pollid);
                    var votecount = result['data']['total_votes'];
                    if (result['data']['total_votes'] > 0 && result['data']['total_votes'] < 99) {
                        $('.votescountbox .votetext_' + pollid + '').addClass('twodigit');
                    } else if (result['data']['total_votes'] > 99) {
                        $('.votescountbox .votetext_' + pollid + '').addClass('threedigit');
                    }
                    if (result['data']['total_votes'] > 0 && result['data']['total_votes'] < 9) {
                        votecount = '0' + result['data']['total_votes'];
                    }
                    $('.votescountbox .votetext_' + pollid + '').html(votecount);
                    loaddatafortrending(categoryid, 0);
                    //loaddataformyraised(0, 0);
                    load_my_answered_prediction(categoryid, 0);
//$('.votescountbox .votetext_'+pollid+'').html(result['data']['total_votes']);
//$(this).closest('div.card').find('.votescountbox span:nth-child(2)').html(result['data']['total_votes']+' '+votesword);
                    if (result['isnew'] == 1) {
                        $('#pointsModal #title').html('Congratulations');
                        $('#pointsModal #points').html('1');
                        $('#pointsModal #msg').html("You earned 1 Silver point");
                        $('#pointsModal #submsg').html("");
                        $('#pointsModal .optionsbtn').css('display', 'none');
                        $('#pointsModal').modal('open');
                        setTimeout(function () {
                            $('#pointsModal').modal('close');
                        }, 3000)
                    }

//                    Materialize.Toast.removeAll();
//                    Materialize.toast(result['message'], 4000);
                }
            });
        } else {
            Materialize.Toast.removeAll();
            Materialize.toast('Please select choice', 4000);
        }


    });

    $(document).on("click", ".check_expert_result", function (e) {
        e.preventDefault();
        var _this = $(this);
        _this.closest(".swct").find('.tgl-ios').toggleClass("active");
        var id = $(this).attr("data-pollid") || 0;
        var polloptions = _this.closest(".card").find(".polloptions")

        if (!_this.hasClass("data-expert"))
            get_experts_result(id).done(function (result) {
                result = JSON.parse(result);
                $.each(result.data, function (a, b) {
                    var choice = $("[data-choiceid='" + b.choice + "']", polloptions);
                    choice.find(".determinate").attr("data-expert", b.expert_percent);
                    switchexpert(choice);
                    _this.addClass("data-expert");
                })
            });
        else {
            $("[data-choiceid]", polloptions).each(function () {
                switchexpert($(this));
            })
        }
    });

});

function switchexpert(choice) {
    var original = choice.find(".determinate").attr("data-afterload");
    var expert = choice.find(".determinate").attr("data-expert");
    if (!choice.hasClass("expert"))
    {
        choice.find(".determinate").css('width', expert + '%');
        choice.find(".avgpercount").html(expert + " %");

        choice.addClass("expert");
    } else {

        choice.find(".determinate").css('width', original + '%')
        choice.find(".avgpercount").html(original + " %");

        choice.removeClass("expert");
    }
    console.log(choice);
}

function get_experts_result(id) {
    return $.ajax({
        url: options.baseurl + "Poll/experts_result",
        method: "POST",
        data: {id: id}
    })
}

function showComments(id) {
    //$('div[class^="replies"]').slideUp();
    $('.replies' + id).slideToggle();
}


function validateForm() {
    var topic = $("#polltopic").val();
    var polldescri = $('#polldescription').val();
    var enddate = $('#enddate').val();
    //var pollcategory = $("#pollcatergory").val();
    var pollcategory = $('input[name="pollcatergory"]:checked').val() ? true : false
    var choicearray = $("input[name='choice[]']")
            .map(function () {
                return $(this).val();
            }).get();
    var choiceelement = checkArray(choicearray);
    if (topic == "") {
        Materialize.Toast.removeAll();
        Materialize.toast('Please enter question topic', 4000);
        return false;
    }
    if (enddate == "") {
        Materialize.Toast.removeAll();
        Materialize.toast('Please enter the date', 4000);
        return false;
    }
    if (polldescri == "") {
        Materialize.Toast.removeAll();
        Materialize.toast('Please enter question description', 4000);
        return false;
    }
    if (!pollcategory) {
        Materialize.Toast.removeAll();
        Materialize.toast('Please Select Category', 4000);
        return false;
    }
    if (choiceelement == 0) {
        Materialize.Toast.removeAll();
        Materialize.toast('Please enter Choice', 4000);
        return false;
    }
    if (choiceelement < 2) {
        Materialize.Toast.removeAll();
        Materialize.toast('Please enter atleast two choices', 4000);
        return false;
    }
    var previewdata = $('.linkpreview').html();
    $('#poll_preview').val(previewdata);
}

function checkArray(my_arr) {
    var count = 0;
    for (var i = 0; i < my_arr.length; i++) {
        if (my_arr[i] != "")
            count++;
    }
    return count;
}
function readURL(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            //$('#falseinput').attr('src', e.target.result);
            //$('#base').val(e.target.result);
            $("#imgPrime").attr("src", e.target.result);
            $('#imgPrime').css('display', 'block');
            $('.dz-preview').remove();
            $('#removethumb').css('display', 'block');
            //$('#cwimg').val(e.target.result)
            document.getElementById('removethumb').addEventListener('click', function () {
                //_this.removeAllFiles();
                $("#imgPrime").attr("src", '');
                $('#imgPrime').css('display', 'none');
                $('#removethumb').css('display', 'none');
                $('input[type=file]').val(null);
            });
        };
        reader.readAsDataURL(input.files[0]);
    }
}

var getDateString = function (date, format) {

    var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            getPaddedComp = function (comp) {
                return ((parseInt(comp) < 10) ? ('0' + comp) : comp)
            }, formattedDate = format,
            o = {
                "y+": date.getFullYear(), // year
                "M+": months[date.getMonth()], //month
                "d+": getPaddedComp(date.getDate()), //day
                "h+": getPaddedComp((date.getHours() > 12) ? date.getHours() % 12 : date.getHours()), //hour
                "H+": getPaddedComp(date.getHours()), //hour
                "m+": getPaddedComp(date.getMinutes()), //minute
                "s+": getPaddedComp(date.getSeconds()), //second
                "S+": getPaddedComp(date.getMilliseconds()), //millisecond,
                "b+": (date.getHours() >= 12) ? 'PM' : 'AM'
            };
    for (var k in o) {
        if (new RegExp("(" + k + ")").test(format)) {
            formattedDate = formattedDate.replace(RegExp.$1, o[k]);
        }
    }
    return formattedDate;
};





function showdescription(id, type, ele) {

    $(ele).toggleClass('active');
    $('#description_' + type + id).slideToggle('slow');
}


$(function () {
    var pollid = localStorage.pollid;
    var userchoice = localStorage.choiseid;
    var categoryid = localStorage.categoryid;
    var section = localStorage.section;
    if (typeof (localStorage.pollid) != "undefined" && typeof (localStorage.choiseid) != "undefined" && typeof (localStorage.categoryid) != "categoryid") {
        $.ajax({
            "url": options.baseurl + "Poll/addpollchoice",
            "method": "POST",
            "data": {"poll_id": pollid, "choice": userchoice, "category_id": categoryid}
        }).done(function (result) {
            result = JSON.parse(result);
            if (result['status'])
            {
                localStorage.clear();
                $('.polloption_' + pollid).each(function () {
                    var html = "";
                    var tabname = $(this).attr('data-tabname');
                    for (var i in result['data']['options']) {
                        var isvoted = result['data']['options'][i]['choice_id'] == userchoice ? "checked" : "";
                        var totalavg = result['data']['options'][i]['choice'] != "See the Results" ? '<span class="avgpercount fs14px">' + result['data']['options'][i]['avg'] + ' %</span>' : "";
                        var userselected = result['data']['options'][i]['choice_id'] == userchoice ? "userselected" : "";
                        var isnoclickchoice = result['data']['options'][i]['choice'] == "See the Results" ? "fw600" : "";
                        html += '<div class = "col m12 s12" data-choiceid="' + result['data']['options'][i]['choice_id'] + '">\
                                        <div class = "row mb7">\
                                            <div class="col m12 s12">\
                                                <label class = "polloption progress" style="position: relative;">\
                                                    <input class = "with-gap" class="pollchoice_' + pollid + '" name = "pollchoice' + tabname + '_' + pollid + '" data-type="' + tabname + '" data-total="' + result['data']['options'][i]['total'] + '" type = "radio" value="' + result['data']['options'][i]['choice_id'] + '" ' + isvoted + '/>\
                                                    <span class="customradio">\
                                                        <i class="flaticon-check selected"></i>\
                                                    </span>\
                                                    <span class="fs14px choicetext">' + (result['data']['options'][i]['choice'] == "Do not know or skip" || result['data']['options'][i]['choice'].toLowerCase() == "see the results" ? "<b>See The Results</b>" : result['data']['options'][i]['choice']) + '</span><!--style="position:absolute;" -->\
                                                    <div class = "determinate ' + userselected + '" style = "width: 0%" data-afterload="' + result['data']['options'][i]['avg'] + '"></div>\
                                                    ' + totalavg + '\
                                                </label>\
                                            </div>\
                                        </div>\
                                    </div>';
                    }
                    $("#polloption" + tabname + "_" + pollid).html(html);
                    $("#polloption" + tabname + "_" + pollid).addClass('votedpoll');
//$(".votedpoll input[type='radio']").attr('disabled', true);

                    setTimeout(function () {
                        var maxper = 0
                        $("#polloption" + tabname + "_" + pollid + " .determinate:first").parent().addClass('maxper');
                        $("#polloption" + tabname + "_" + pollid + " .determinate").each(function () {
                            var newper = $(this).attr('data-afterload');
                            $(this).css('width', newper + '%');
                            if (parseFloat(newper) > parseFloat(maxper)) {
                                $("#polloption" + tabname + "_" + pollid + " .determinate").parent().removeClass('maxper');
                                $(this).parent().addClass('maxper');
                                maxper = newper;
                            }
                        });
                        $('.avgvotebox').each(function () {
                            var avgper = $(this).attr('data-avg');
                            if (parseFloat(avgper) > 0)
                            {
                                //$(this).html('Avg: ' + parseInt(avgper));
                                $(this).html('Avg: ' + avgper);
                            } else {
                                $(this).addClass('hide');
                            }
                        });
//                            $("#polloption" + tabname + "_" + pollid + " .determinate").each(function () {
//                                var newper = $(this).attr('data-afterload');
//                                $(this).css('width', newper + '%');
//                            });
                    }, 100)
                });
                var changebtn = '<span class="votescountbox mr20 hide">\
<span class="flaticon-click ml0 mr5"></span>\
<span class="fs14px fw500">' + result['data']['total_votes'] + '  Votes</span>\
</span>';
//$('button[data-pollid="' + pollid + '"].pollbtnvote').parent().prepend(changebtn);
//$('button[data-pollid="' + pollid + '"].pollbtnvote').remove();
                var votesword = result['data']['total_votes'] > 1 ? "Votes" : "Vote";
                var votecount = result['data']['total_votes'];
                if (result['data']['total_votes'] > 0 && result['data']['total_votes'] < 99) {
                    $('.votescountbox .votetext_' + pollid + '').addClass('twodigit');
                } else if (result['data']['total_votes'] > 99) {
                    $('.votescountbox .votetext_' + pollid + '').addClass('threedigit');
                }
                if (result['data']['total_votes'] > 0 && result['data']['total_votes'] < 9) {
                    votecount = '0' + result['data']['total_votes'];
                }
                $('.votescountbox .votetext_' + pollid + '').html(votecount);
                loaddatafortrending(categoryid, 0);
                //loaddataformyraised(0, 0);
                load_my_answered_prediction(categoryid, 0);
                $('#togglecmtsec_' + section + '_' + pollid).slideDown('slow');
                if (result['isnew'] == 1) {
                    $('#pointsModal').addClass('small');
                    $('#pointsModal #title').html('Congratulations');
                    $('#pointsModal #points').html('1');
                    $('#pointsModal #msg').html("You earned 1 Silver point");
                    $('#pointsModal #submsg').html("");
                    $('#pointsModal .optionsbtn').css('display', 'none');
                    $('#pointsModal').modal('open');
                    setTimeout(function () {
                        $('#pointsModal').modal('close');
                    }, 3000);
                }
            }
        });
    }
    $(document).on('click', '.share', function (e) {
        //e.preventDefault();
        var url = decodeURIComponent($(this).attr('data-shareurl'));
        if (navigator.share) {
            navigator.share({
                url: url
            })
        } else {
            var poll_id = $(this).attr('data-pollid');
            var section = $(this).attr('data-section');
            var $this = $(this),
                    $tooltip = $this.find('.tooltip');
            //alert(poll_id);

            if (!$tooltip.hasClass('In')) {
                $('.tooltip').stop(true, true).fadeOut(500);
                $('.share_' + section + poll_id).fadeIn(100);
                $tooltip.addClass('In');
            } else {
                $tooltip.removeClass('In');
                $('.share_' + section + poll_id).stop(true, true).fadeOut(500);
            }
        }
    });
    $('.avgvotebox').each(function () {
        var avgper = $(this).attr('data-avg');
        if (parseFloat(avgper) > 0)
        {
            //$(this).html('Avg: ' + parseInt(avgper));
            $(this).html('Avg: ' + avgper);
        } else {
            $(this).addClass('hide');
        }
    });
    var currentpollid = $(".determinate:first").parent().find('input').attr('data-pollid');
    var maxper = 0;
    $(".determinate").each(function () {
        var newper = $(this).attr('data-afterload');
        $(this).css('width', newper + '%');
        var pollid = $(this).parent().find('input').attr('data-pollid');
        if (parseInt(currentpollid) == parseInt(pollid))
        {
            if (parseFloat(newper) > parseFloat(maxper)) {
                $('.polloption_' + pollid + ' .determinate').parent().removeClass('maxper');
                $(this).parent().addClass('maxper');
                maxper = newper;
            }
        } else {
            maxper = newper;
            $(this).parent().addClass('maxper');
            currentpollid = $(this).parent().find('input').attr('data-pollid');
        }
    });
    setTimeout(function () {
        $(".choicedisabled input[type='radio']").attr('disabled', true);
    }, 100)


    $(document).on('click', '.commentedit', function (e) {
        var cmtid = $(this).attr('data-cmtid');
        $(this).parent().addClass('active');
        $('#cmt_' + cmtid).removeAttr('readonly');
        $('#cmt_' + cmtid).focus();
    })
    $(document).on('blur', '.commentedit', function (e) {
        var cmtid = $(this).attr('data-cmtid');
        $('#cmt_' + cmtid).attr('readonly', true);
        //$(this).parent().removeClass('active');
    })
    $.each($('textarea[data-autoresize]'), function () {
        var offset = this.offsetHeight - this.clientHeight;
        var resizeTextarea = function (el) {
            var newvalue = el.scrollHeight + offset;
            $(el).css('height', 'auto').css('height', newvalue);
            $(el).next('span').css('height', 'auto').css('height', newvalue);
        };
        $(this).on('keyup input', function () {
            resizeTextarea(this);
        }).removeAttr('data-autoresize');
    });
    $(document).on('keypress', '.commentedit', function (e) {
        if (e.which == 13 && e.which == 13) {
            $(this).val($(this).val() + "\n");
        } else if (e.which == 13) {
            var poll_comment = $(this).val();
            var poll_id = $(this).attr('data-pollid');
            var poll_cmt_id = $(this).attr('data-cmtid');
            $.ajax({
                url: options.baseurl + 'Poll/add_comment',
                method: "POST",
                data: {poll_comment: poll_comment, poll_id: poll_id, poll_cmt_id: poll_cmt_id},
            }).done(function (result) {
                if (!options.loggedin) {
//                    window.location.assign(options.baseurl+"Login?section=poll");
                    var redirecturl = $('#redirecturl').val();
                    redirecturl = redirecturl + "&t=2&pid=" + poll_id;
                    window.location.assign(redirecturl);
                }
                result = JSON.parse(result);
                if (result['status']) {
                    $('.cmteditbox').removeClass('active');
//                    Materialize.Toast.removeAll();
//                    Materialize.toast("Comment updated Successfully", 4000);
                }
            });
        }
    })

    $('html').click(function (e) {
        var classused = e.target.className;
        if (!classused.indexOf(" share") != -1) {
            $('.tooltip').removeClass('In');
            $('.tooltip').stop(true, true).fadeOut(500);
        }
        if (classused.indexOf("material-icons prefix sendarrow") != -1) {

        } else if (classused.indexOf("textareaicon1") != -1) {
//
        } else if (classused.indexOf("commentedit") != -1) {

        } else {
            $('.cmteditbox').removeClass('active');
            $(".commentedit").each(function (index) {
                var oldval = $(this).attr('data-value');
                $(this).val(oldval);
                $(this).css('height', '35px');
                $(this).next().css('height', '35px');
                $(this).closest('.cmteditbox').find('.whitespacepre').removeClass('hide');
                $(this).removeClass('active');
                $(this).parent().addClass('hide');
            });
        }
    });
//.textareaicon1
    $(document).on('click', '.textareaicon1', function (e) {
        var cmt_id = $(this).attr('data-cmtid');
        var poll_comment = $("#cmt_" + cmt_id).val();
        var original_cmt = $("#cmt_" + cmt_id).val();
        var poll_id = $("#cmt_" + cmt_id).attr('data-pollid');
        var poll_cmt_id = $("#cmt_" + cmt_id).attr('data-cmtid');
        if (poll_comment == "") {
            Materialize.Toast.removeAll();
            Materialize.toast("Please enter your comment", 4000);
        }

        $.ajax({
            url: options.baseurl + 'Poll/add_comment',
            method: "POST",
            data: {poll_comment: poll_comment, poll_id: poll_id, poll_cmt_id: poll_cmt_id},
        }).done(function (result) {
            if (!options.loggedin) {
//window.location.assign(options.baseurl+"Login?section=poll");
                var redirecturl = $('#redirecturl').val();
                redirecturl = redirecturl + "&t=2&pid=" + poll_id;
                window.location.assign(redirecturl);
            }
            result = JSON.parse(result);
            if (result['status']) {
                $('#cmt_' + poll_cmt_id).attr('data-value', poll_comment)
                $('.cmteditbox').removeClass('active');
//                Materialize.Toast.removeAll();
//                Materialize.toast("Comment updated Successfully", 4000);
            }
        });
    });
    $(document).on('click', '.sendarrow', function (e) {
        e.stopPropagation();
        var cmt_id = $(this).parent().attr('data-cmtid');
        var poll_comment = $("#cmt_" + cmt_id).val();
        var original_cmt = $("#cmt_" + cmt_id).val();
        var poll_id = $("#cmt_" + cmt_id).attr('data-pollid');
        var poll_cmt_id = $("#cmt_" + cmt_id).attr('data-cmtid');
        if (poll_comment == "") {
            Materialize.Toast.removeAll();
            Materialize.toast("Please enter your comment", 4000);
        }



        $.ajax({
            url: options.baseurl + 'Poll/add_comment',
            method: "POST",
            data: {poll_comment: poll_comment, poll_id: poll_id, poll_cmt_id: poll_cmt_id},
        }).done(function (result) {
            if (!options.loggedin) {
//window.location.assign(options.baseurl+"Login?section=poll");
                var redirecturl = $('#redirecturl').val();
                redirecturl = redirecturl + "&t=2&pid=" + poll_id;
                window.location.assign(redirecturl);
            }
            result = JSON.parse(result);
            if (result['status']) {
                $('#cmt_' + poll_cmt_id).attr('data-value', poll_comment);
                var height = $('#cmt_' + cmt_id).closest('.cmteditbox').find('p').height();
                $('#cmt_' + cmt_id).closest('.cmteditbox').find('.whitespacepre').html(poll_comment);
                $('#cmt_' + cmt_id).closest('.cmteditbox').find('.whitespacepre').toggleClass('hide');
                $('#cmt_' + cmt_id).css('height', height);
                $('#cmt_' + cmt_id).next().css('height', height);
                $('.cmteditbox').removeClass('active');
                $('#cmt_' + poll_cmt_id).parent().toggleClass('hide');
//                Materialize.Toast.removeAll();
//                Materialize.toast("Comment updated Successfully", 4000);
            }
        });
    });

    $(document).on('click', '.showritecmt', function (e) {
        var poll_id = $(this).attr('data-pollid');
        var type = $(this).attr('data-section');
        var id = $(this).attr('data-pollid');
        $('#togglecmtsec_' + type + '_' + id).slideToggle('slow');
    });
    $(document).on('click', '.showreplies,.showreplies_icon', function (e) {
        var pollid = $(this).attr('data-pollid');
        var commentid = $(this).attr('data-cmtid');
        if (!options.loggedin) {
//window.location.assign(options.baseurl+"Login");
            var redirecturl = $('#redirecturl').val();
            redirecturl = redirecturl + "&t=2&pid=" + pollid + "&cmt=" + commentid;
            window.location.assign(redirecturl);
        } else {

            var pagelimit = $(this).attr('data-replyset');
            var currentcontent = $('#replylist_' + commentid).text();
            var totalreply = $('.showreplies[data-cmtid="' + commentid + '"]').attr('data-totalreply');
            var totalshow = parseInt(pagelimit) + 1;
            totalshow = parseInt(totalshow) * 5;
            $.ajax({
                url: options.baseurl + "Poll/get_comment_replies",
                method: "POST",
                data: {pollid: pollid, commentid: commentid, pagelimit: pagelimit},
            }).done(function (result) {
                result = JSON.parse(result);
                var html = "";
                if (result.status) {
                    var groupLength = result['data'].length;
                    for (var i in result['data']) {

                        var replyby = result['data'][i]['user_id'] == options.uid ? "You" : result['data'][i]['byuser'];
                        var formattedDate = getDateString(new Date(result['data'][i]['created_date'].replace(' ', 'T')), "d M y");
                        var cmtedit = "";
                        var iscmtedit = result['data'][i]['user_id'] == options.uid ? "commentedit" : "";
                        html += '<div class="row mb0">\
    <div class="col m11 s11">\
        <h6 class="forumsubhead fs12px tastart mt5 lightgray fw500"><span class="flaticon-social-2 ml10 mr0"></span><i>By ' + replyby + ', ' + formattedDate + '</i></h6>\
    </div>\
    <div class="col m1 s1">\
        ' + cmtedit + '</div>\
</div>\n\
<div class="ml45">\
    <div class="mr35 whitespacepre">' + result['data'][i]['reply'] + '</div>\
    <div class="cmteditbox hide posrela">\
        <input type="text" id="cmt_' + commentid + '" data-value="' + result['data'][i]['reply'] + '" data-pollid="' + pollid + '" data-cmtid="' + commentid + '" readonly="readonly" class="' + cmtedit + ' mb0" value="' + result['data'][i]['reply'] + '">\
        <span data-cmtid="' + commentid + '" class="material-icons prefix textareaicon1">send</span>\
    </div>\
</div>';
                        html += '<hr class="commentseprator">';
                    }
                    if (totalreply > totalshow) {
                        html += '<a class="morereplies fs12px fw500 lightgray" data-replyset="' + (parseInt(pagelimit) + 1) + '" data-pollid="' + pollid + '" data-cmtid="' + commentid + '">view more replies</a>';
                    }

                    $('#replylist_' + commentid).html(html);
                }

                $('.replies' + commentid).slideToggle();
            });
        }
    });
    $(document).on('click', '.morereplies', function (e) {
        var pollid = $(this).attr('data-pollid');
        var commentid = $(this).attr('data-cmtid');
        var pagelimit = $(this).attr('data-replyset');
        $('.replies' + commentid + ' .morereplies').remove();
        var totalreply = $('.showreplies[data-cmtid="' + commentid + '"]').attr('data-totalreply');
        var totalshow = parseInt(pagelimit) + 1;
        totalshow = parseInt(totalshow) * 5;
        $.ajax({
            url: options.baseurl + "Poll/get_comment_replies",
            method: "POST",
            data: {pollid: pollid, commentid: commentid, pagelimit: pagelimit},
        }).done(function (result) {
            result = JSON.parse(result);
            var html = "";
            if (result.status) {
                var groupLength = result['data'].length;
                for (var i in result['data']) {

                    var replyby = result['data'][i]['user_id'] == options.uid ? "By" : result['data'][i]['byuser'];
                    var formattedDate = getDateString(new Date(result['data'][i]['created_date'].replace(' ', 'T')), "d M y");
                    var iscmtedit = result['data'][i]['user_id'] == options.uid ? "commentedit" : "";
                    var cmtedit = "";
                    html += '<div class="row mb0">\
    <div class="col m11 s11">\
        <h6 class="forumsubhead fs12px tastart mt5 lightgray fw500"><span class="flaticon-social-2 ml10 mr0"></span><i>' + replyby + ', ' + formattedDate + '</i></h6>\
    </div>\
    <div class="col m1 s1">\
        ' + cmtedit + '</div>\
</div>\n\
<div class="ml45">\
    <div class="mr35 whitespacepre">' + result['data'][i]['reply'] + '</div>\
    <div class="cmteditbox hide posrela">\
        <input type="text" data-value="' + result['data'][i]['reply'] + '" id="cmt_' + commentid + '" data-pollid="' + pollid + '" data-cmtid="' + commentid + '" readonly="readonly" class="' + cmtedit + ' mb0" value="' + result['data'][i]['reply'] + '">\
        <span data-cmtid="' + commentid + '" class="material-icons prefix textareaicon1">send</span>\
    </div>\n\
</div>';
                    html += '<hr class="commentseprator">';
                }

                if (totalreply > totalshow) {
                    html += '<a class="morereplies fs12px fw500 lightgray" data-replyset="' + (parseInt(pagelimit) + 1) + '" data-pollid="' + pollid + '" data-cmtid="' + commentid + '">view more replies</a>';
                }

                $('#replylist_' + commentid).append(html);
//$('.replies' + commentid).slideToggle();
            }
//$('.replies' + commentid).slideToggle();
        });
    });
    $(document).on('click', '.loadmore', function (e) {

        var loadlimit = $(this).attr('data-pageid');
        var poll_id = $(this).attr('data-pollid');
        var type = $(this).attr('data-sectype');
        var total_comments = $(this).attr('data-totalcomments');
        var endDate = new Date(Date.parse($(this).attr('data-enddate')));
        if (!options.loggedin) {
            var redirecturl = $('#redirecturl').val();
            redirecturl = redirecturl + "&t=2&pid=" + poll_id
            window.location.assign(redirecturl);
        } else {

            $.ajax({
                url: options.baseurl + "Poll/load_more_comments",
                method: "POST",
                data: {pollid: poll_id, pagelimit: loadlimit},
            }).done(function (result) {
                result = JSON.parse(result);
                var html = "";
                if (result.status) {

                    for (var i in result['data']) {
                        var replyby = result['data'][i]['user_id'] == options.uid ? "You" : result['data'][i]['byuser'];
                        var cmtedit = "";
                        var TodayDate = new Date();
                        var editcmts = false;
                        var postreply = "";
                        if (endDate <= TodayDate) {
                            editcmts = true;
                            // throw error here..
                        }
                        var iscmtedit = "";
                        if (result['data'][i]['user_id'] == options.uid && !editcmts) {
                            var iscmtedit = result['data'][i]['user_id'] == options.uid ? "commentedit" : "";
                            cmtedit = '<a materialize="dropdown" class="dropdown-button pollubhead right" data-activates="mypollcmt' + result['data'][i]['id'] + '">\
    <i class="flaticon-three-1 lightgray is20px"></i>\
</a>\
<ul id="mypollcmt' + result['data'][i]['id'] + '" class="dropdown-content mpcmt">\
    <li>\
        <a class="fs16px editcmt" data-cmtid="' + result['data'][i]['id'] + '" data-cmttxt="' + result['data'][i]['comment'] + '" >Edit</a>\
    </li>\
    <li>\
        <a class="fs16px deletecmt" data-cmtid="' + result['data'][i]['id'] + '">Delete</a>\
    </li>\
</ul>';
                        }
                        if (!editcmts) {
                            postreply = '<form id="postpollcommentrply" method="POST">\
                                                    <div class="col m12 s12">\
                                                        <div style="position:relative">\
                                                            <textarea type="text" id="textarea1" class="writereply textarea-scrollbar" data-autoresize name="poll_comment_reply" placeholder="Write a reply"></textarea>\
                                                            <span onclick="$(this).submit()" class="textareaicon"><span class="material-icons prefix sendarrowreply">send</span></span>\
                                                            <input type="hidden" name="poll_id" value="' + result['data'][i]['poll_id'] + '"/>\
                                                            <input type="hidden" name="comment_id" value="' + result['data'][i]['id'] + '"/>\
                                                        </div>\
                                                    </div>\
                                                </form>';
                        }

                        var isuserlike = result['data'][i]['userlike'] == 0 ? "like.png" : "like1.png";
                        var formattedDate = getDateString(new Date(result['data'][i]['created_date'].replace(' ', 'T')), "d M y")
                        var replyword = parseInt(result['data'][i]['total_replies']) > 1 ? " Replies" : " Reply";
                        html += '<div class="col s12">\
    <div class="commentsection" id="cm_' + result['data'][i]['id'] + '">\
        <div class="pollcardlist p-0">\
            <div class="row mb0">\
                <div class="col m11 s11">\
                    <h6 class="forumsubhead fs12px tastart mt5 lightgray fw500"><span class="flaticon-social-2 ml10 mr0"></span><i>By ' + replyby + ', ' + formattedDate + ' </i></h6>\
                </div>\
                <div class="col m1 s1">\
                    ' + cmtedit + '\
                </div>\
            </div>\
            <div class="ml45">\
                <div class="cmteditbox positir">\
                    <div class="mr35 whitespacepre">' + result['data'][i]['comment'] + '</div>\
                    <div class="hide posrela">\
                        <textarea type="text" data-autoresize rows="1" id="cmt_' + result['data'][i]['id'] + '" data-value="' + result['data'][i]['comment'] + '" data-pollid="' + poll_id + '" data-cmtid="' + result['data'][i]['id'] + '" readonly class="' + iscmtedit + ' mb0 textarea-scrollbar">' + result['data'][i]['comment'] + '</textarea>\
                        <span data-cmtid="' + result['data'][i]['id'] + '" class="textareaicon1"><span class="material-icons prefix sendarrow">send</span></span>\
                    </div>\
                </div>\
                <div class="row txtbluegray cmtop mb0">\
                    <div class="col m7 s7"><h6 class="fs12px linkpointer showreplies_icon fs12px fw500 lightgray" data-cmtid="' + result['data'][i]['id'] + '" data-pollid="' + result['data'][i]['poll_id'] + '" data-replyset="0"><i class="flaticon-arrow-1 lightgray"></i>Reply</h6></div>\
                    <div class="col m5 s5 right right-align">\
                        <span class="mr10 lightgray fs12px fw500 linkpointer showreplies" data-cmtid="' + result['data'][i]['id'] + '" data-pollid="' + result['data'][i]['poll_id'] + '" data-replyset="0" data-totalreply="' + result['data'][i]['total_replies'] + '">' + result['data'][i]['total_replies'] + ' ' + replyword + '</span>\
                    </div>\
                </div>\
                <div class="replies' + result['data'][i]['id'] + '" style="display:none;">\
                    <div class="row m10">\
                        ' + postreply + '</div>\
                    <div id="replylist_' + result['data'][i]['id'] + '">\
                    </div>\
                </div>\
            </div>\
        </div>\
        <hr class="commentseprator">\
    </div>\
</div>';
                    }
                    $('#togglecmtsec_' + type + '_' + poll_id + ' .commentbox').append(html);
//var newtotalcmts = $('#togglecmtsec_' + type + '_' + poll_id + ' .commentbox .commentsection').length;
                    var newtotalcmts = parseInt(loadlimit) + 1;
                    //console.log(newtotalcmts);
                    newtotalcmts = newtotalcmts * 10;
                    //console.log(newtotalcmts);
                    if (newtotalcmts < total_comments) {
                        $('#togglecmtsec_' + type + '_' + poll_id + ' .loadmore').attr('data-pageid', parseInt(loadlimit) + 1);
                    } else {
                        $('#togglecmtsec_' + type + '_' + poll_id + ' .loadmore').css('display', 'none');
                    }
                    setTimeout(function () {
                        $('.dropdown-button').dropdown({
                            inDuration: 300,
                            outDuration: 225,
                            constrain_width: false, // Does not change width of dropdown to that of the activator
                            hover: false, // Activate on hover
                            gutter: 0, // Spacing from edge
                            belowOrigin: false, // Displays dropdown below the button
                            alignment: 'left' // Displays dropdown with edge aligned to the left of button
                        }
                        )
                    }, 100)

                    flag = 0;
                } else {
//                    Materialize.Toast.removeAll();
//                    Materialize.toast("No more comments", 4000);
//                    return false;
                    flag = 1;
                }
            });
//}
        }
    });
    $(document).on('submit', 'form[name="postpollcmt"]', function (e) {
        e.preventDefault();
        e.stopPropagation();
        //$('.loadersmall').css('display', 'block');
        var poll_id = $('input[name="poll_id"]', this).val();
        var redirecturl = $('#redirecturl').val();
        redirecturl = redirecturl + "&t=2&pid=" + poll_id;
        if (!options.loggedin) {
            window.location.assign(redirecturl);
        } else {
            if (!options.alias) {
                Materialize.Toast.removeAll();
                Materialize.toast('Please enter your alias first.', 2000);
                setTimeout(function () {
                    var redirect_url = $("#redirecturl").val();
                    var redirect_sess = redirect_url.split("?");
                    window.location.href = options.baseurl + 'Profile?' + redirect_sess[1];
                }, 2000)
            } else {
                $.ajax({
                    url: $(this).attr('action'),
                    method: "POST",
                    data: $(this).serialize(),
                }).done(function (result) {

                    result = JSON.parse(result);
                    if (result['status']) {

//                Materialize.Toast.removeAll();
//                Materialize.toast(result['message'], 4000);
                        var html = "";
                        var isuserlike = result['data']['userlike'] == 0 ? "like.png" : "like1.png";
                        var formattedDate = getDateString(new Date(result['data']['created_date'].replace(' ', 'T')), "d M y")
                        var replyby = result['data']['user_id'] == options.uid ? "You" : result['data']['byuser'];
                        var iscmtedit = result['data']['user_id'] == options.uid ? "commentedit" : "";
                        var cmtedit = "";
                        if (result['data']['user_id'] == options.uid) {
                            cmtedit = '<a materialize="dropdown" class="dropdown-button1 pollubhead right" id="cmtdrop_' + result['data']['id'] + '" data-activates="mypollcmt' + result['data']['id'] + '">\
                                                            <i class="flaticon-three-1 lightgray is20px"></i>\
                                                        </a>\
                                                        <ul id="mypollcmt' + result['data']['id'] + '" class="dropdown-content mpcmt">\
                                                            <li>\
                                                                <a class="fs16px editcmt" data-cmtid="' + result['data']['id'] + '" data-cmttxt="' + result['data']['comment'] + '" >Edit</a>\
                                                            </li>\
                                                            <li>\
                                                                <a class="fs16px deletecmt" data-cmtid="' + result['data']['id'] + '">Delete</a>\
                                                            </li>\
                                                        </ul>';
                        }
                        var replyword = parseInt(result['data']['total_replies']) > 1 ? " Replies" : " Reply";
                        html = '<div class="col s12">\
<div class="commentsection" id="cm_' + result['data']['id'] + '">\
<div class="pollcardlist p-0">\
<div class="row mb0">\
<div class="col m11 s11">\
<h6 class="forumsubhead fs12px tastart mt5 lightgray fw500"><span class="flaticon-social-2 ml10 mr0"></span><i>By ' + replyby + ', ' + formattedDate + ' </i></h6>\
</div>\
<div class="col m1 s1">\
' + cmtedit + '</div>\
</div>\
<div class="ml45">\
<div class="cmteditbox positir">\
<div class="mr35 whitespacepre">' + result['data']['comment'] + '</div>\
<div class="hide posrela">\
<textarea type="text" data-autoresize rows="1" id="cmt_' + result['data']['id'] + '" data-value="' + result['data']['comment'] + '" data-pollid="' + poll_id + '" data-cmtid="' + result['data']['id'] + '" readonly class="' + iscmtedit + ' mb0 textarea-scrollbar">' + result['data']['comment'] + '</textarea>\
<span data-cmtid="' + result['data']['id'] + '" class="textareaicon1"><span class="material-icons prefix sendarrow">send</span></span>\
</div>\
</div>\
<div class="row txtbluegray cmtop mb0">\
<div class="col m7 s7"><h6 class="fs12px linkpointer showreplies_icon fs12px fw500 lightgray" data-cmtid="' + result['data']['id'] + '" data-pollid="' + result['data']['poll_id'] + '" data-replyset="0"><i class="flaticon-arrow-1 lightgray"></i>Reply</h6></div>\
<div class="col m5 s5 right right-align">\
<span class="mr10 lightgray fs12px fw500 linkpointer showreplies" data-cmtid="' + result['data']['id'] + '" data-pollid="' + result['data']['poll_id'] + '" data-replyset="0" data-totalreply="' + result['data']['total_replies'] + '">' + result['data']['total_replies'] + ' ' + replyword + '</span>\
</div>\
</div>\
<div class="replies' + result['data']['id'] + '" style="display:none;">\
<div class="row m10">\
<form id="postpollcommentrply" method="POST">\
<div class="col m12 s12">\
<div style="position:relative">\
<textarea type="text" id="textarea1" class="writereply textarea-scrollbar" data-autoresize name="poll_comment_reply" placeholder="Write a reply"></textarea>\
<span onclick="$(this).submit()" class="textareaicon"><span class="material-icons prefix sendarrowreply">send</span></span>\
<input type="hidden" name="poll_id" value="' + result['data']['poll_id'] + '"/>\
<input type="hidden" name="comment_id" value="' + result['data']['id'] + '"/>\
</div>\
</div>\
</form>\
</div>\
<div id="replylist_' + result['data']['id'] + '">\
</div>\
</div>\
</div>\
</div>\
<hr class="commentseprator">\
</div>\
</div>';
                        $('[id^="togglecmtsec_"][id$="_' + result['data']['poll_id'] + '"] .commentbox').prepend(html);
                        $('textarea[name="poll_comment"]').val("");
                        $('textarea[name="poll_comment"]').css('height', '35px');
                        $('textarea[name="poll_comment"]').next().css('height', '35px');
                        var comments = $('.showcmtcount[data-pollid=' + result['data']['poll_id'] + ']').attr('data-totalcomments');
                        if (parseInt(comments) == 0) {
                            $('[id^="togglecmtsec_"][id$="_' + result['data']['poll_id'] + '"] .nocmtdata').css('display', 'none');
                        }
                        var newcommentscount = parseInt(comments) + 1;
                        $('.showcmtcount[data-pollid=' + result['data']['poll_id'] + ']').attr('data-totalcomments', newcommentscount);
                        var commentword = newcommentscount > 1 ? "Comments" : "Comment"
                        $('.showcmtcount[data-pollid=' + result['data']['poll_id'] + ']').html(newcommentscount + " " + commentword); //cmtbadge
//$('.showcmtcount[data-pollid=' + result['data']['poll_id'] + ']').html(newcommentscount + " Comments");//cmtbadge
                        $('.show-on-small .showritecmt[data-pollid=' + result['data']['poll_id'] + ']').html(commentword + "<span class='cmtbadge red-text'>" + newcommentscount + "</span>");
                        setTimeout(function () {
                            $('#cmtdrop_' + result['data']['id'] + '').dropdown({
                                inDuration: 300,
                                outDuration: 225,
                                constrain_width: true, // Does not change width of dropdown to that of the activator
                                hover: false, // Activate on hover
                                gutter: 0, // Spacing from edge
                                belowOrigin: false, // Displays dropdown below the button
                                alignment: 'left' // Displays dropdown with edge aligned to the left of button
                            }
                            )
                        }, 100);
                        $.each($('textarea[data-autoresize]'), function () {
                            var offset = this.offsetHeight - this.clientHeight;
                            var resizeTextarea = function (el) {
                                var newvalue = el.scrollHeight + offset;
                                $(el).css('height', 'auto').css('height', newvalue);
                                $(el).next('span').css('height', 'auto').css('height', newvalue);
                            };
                            $(this).on('keyup input', function () {
                                resizeTextarea(this);
                            }).removeAttr('data-autoresize');
                        });
//                $('.mypollcmt' + result['data']['id'] + '').dropdown({
                        //                    inDuration: 300,
                        //                    outDuration: 225,
                        //                    constrain_width: false, // Does not change width of dropdown to that of the activator
                        //                    hover: false, // Activate on hover
                        //                    gutter: 0, // Spacing from edge
                        //                    belowOrigin: false, // Displays dropdown below the button
                        //                    alignment: 'left' // Displays dropdown with edge aligned to the left of button
                        //                });
                    } else {
                        Materialize.Toast.removeAll();
                        Materialize.toast(result['message'], 4000);
                    }
                });
            }
        }

    });
    $(document).on('submit', '#postpollcommentrply', function (e) {
        e.preventDefault();
        e.stopPropagation();
        var _this = $(this);
        var poll_id = $('#postpollcommentrply input[name="poll_id"]').val();
        var redirecturl = $('#redirecturl').val();
        redirecturl = redirecturl + "&t=2&pid=" + poll_id;
        if (!options.loggedin) {
            window.location.assign(redirecturl);

        } else {

            if (!options.alias) {
                Materialize.Toast.removeAll();
                Materialize.toast('Please enter your alias first.', 2000);
                setTimeout(function () {
                    var redirect_url = $("#redirecturl").val();
                    var redirect_sess = redirect_url.split("?");
                    window.location.href = options.baseurl + 'Profile?' + redirect_sess[1];
                }, 2000)

            } else {

                //$('.loadersmall').css('display', 'block');
                $.ajax({
                    url: options.baseurl + 'Poll/add_comment_reply',
                    method: "POST",
                    data: $(this).serialize(),
                }).done(function (result) {

                    result = JSON.parse(result);
                    if (result['status']) {
                        var html = "";
                        var formattedDate = getDateString(new Date(result['data']['created_date'].replace(' ', 'T')), "d M y");
                        var cmtedit = "";
                        html = '<div class="row mb0">\
                                                            <div class="col m11 s11">\
                                                                <h6 class="forumsubhead fs12px tastart mt5 lightgray fw500"><span class="flaticon-social-2 ml10 mr0"></span><i>By You, ' + formattedDate + '</i></h6>\
                                                            </div>\
                                                            <div class="col m1 s1">\
                                                            ' + cmtedit + '</div>\
                                                        </div>\
                                                        <div class="ml45">\
                                                            <div class="mr35 whitespacepre">' + result['data']['reply'] + '</div>\
                                                            <div class="cmteditbox hide posrela">\
                                                                <input type="text" id="cmt_16" data-pollid="5" data-cmtid="' + result['data']['comment_id'] + '" readonly="readonly" class="mb0" value="' + result['data']['reply'] + '">\
                                                                <span data-cmtid="16" class="material-icons prefix textareaicon1">send</span>\
                                                            </div>\
                                                        </div><hr class="commentseprator">';
                        $('#replylist_' + result['data']['comment_id']).prepend(html);
                        //$('#postpollcommentrply')[0].reset();
                        $('Form#postpollcommentrply').trigger("reset");
                        var currentreplies = $('.showreplies[data-cmtid=' + result['data']['comment_id'] + ']').html();
                        $('.writereply').css('height', '35px');
                        $('.writereply').next().css('height', '35px');
                        totalreply = parseInt(currentreplies) + 1;
                        var replyword = totalreply > 1 ? "Replies" : "Reply";
                        $('.showreplies[data-cmtid=' + result['data']['comment_id'] + ']').html(totalreply + " " + replyword);
                    } else {
                        Materialize.Toast.removeAll();
                        Materialize.toast(result['message'], 4000);
                    }
                    var cmt_id = result['data']['comment_id'];

                    adv = Math.round($('#pollreact .commentbox').scrollTop() + $("#replylist_" + cmt_id + " > div:last").position().top) - 70;

                    $('.commentbox').animate({
                        scrollTop: adv
                    }, 2000);
                });
            }
        }
    });
    $(document).on('click', '.editcmt', function (e) {
        var cmt_id = $(this).attr('data-cmtid');
        $('#cmt_' + cmt_id).removeAttr('readonly');
        $('#cmt_' + cmt_id).parent().addClass('active');
        $('#cmt_' + cmt_id).parent().toggleClass('hide');
        var height = $('#cmt_' + cmt_id).closest('.cmteditbox').find('p').height();
        $('#cmt_' + cmt_id).closest('.cmteditbox').find('.whitespacepre').toggleClass('hide');
        $('#cmt_' + cmt_id).css('height', height);
        $('#cmt_' + cmt_id).next().css('height', height);
        //$('#cmt_' + cmt_id).parent().addClass('active');
        $('#cmt_' + cmt_id).focus();
    });
    $(document).on('click', '.deletecmt', function (e) {
        var cmt_id = $(this).attr('data-cmtid');
        var loadpageno = $(this).closest('div.card').find('.loadmore').attr('data-pageid')

        $.ajax({
            url: options.baseurl + 'Poll/deactivecmt',
            method: "POST",
            data: {comment: cmt_id, pageno: loadpageno},
        }).done(function (result) {

            result = JSON.parse(result);
            $('#pollreact .commentbox #cm_' + cmt_id).slideUp('slow');
            var commentsword = result['total'] > 1 ? "Comments" : "Comment";
            $('.showcmtcount[data-pollid=' + result['ques_no'] + ']').html(result['total'] + ' ' + commentsword);
            $('.show-on-small .showritecmt[data-pollid="' + result['ques_no'] + '"]').html(commentsword + "<span class='cmtbadge red-text'>" + result['total'] + "</span>");
            $('.showcmtcount[data-pollid=' + result['ques_no'] + ']').attr('data-totalcomments', result['total']);
            var comments = $('.showcmtcount[data-pollid=' + result['ques_no'] + ']').attr('data-totalcomments');
            if (parseInt(comments) == 0) {
                $('[id^="togglecmtsec_"][id$="_' + result['data']['poll_id'] + '"] .nocmtdata').css('display', 'none');
            }
            var pageno = $('.loadmore[data-pollid=' + result['ques_no'] + ']').attr('data-pageid');
            /*if (parseInt(pageno) > 0) {
             //console.log(result['total']);
             //console.log(parseInt(pageno) * 10);
             if (result['total'] >= parseInt(pageno) * 10) {
             $('.loadmore[data-pollid=' + result['ques_no'] + ']').css('display', 'block');
             } else {
             $('.loadmore[data-pollid=' + result['ques_no'] + ']').css('display', 'none');
             }
             } else { */
            if (result['total'] > parseInt(pageno) * 10) {
                $('.loadmore[data-pollid=' + result['ques_no'] + ']').css('display', 'block');
            } else {
                $('.loadmore[data-pollid=' + result['ques_no'] + ']').css('display', 'none');
            }
            if (result['total'] < 2) {
                $('.loadmore[data-pollid=' + result['ques_no'] + ']').css('display', 'none');
            }
            setTimeout(function () {
                var html = "";
                for (var i in result['data']) {
                    var replyby = result['data'][i]['user_id'] == options.uid ? "You" : result['data'][i]['byuser'];
                    var iscmtedit = result['data'][i]['user_id'] == options.uid ? "commentedit" : "";
                    var cmtedit = "";
                    if (result['data'][i]['user_id'] == options.uid) {
                        cmtedit = '<a materialize="dropdown" class="dropdown-button pollubhead right" data-activates="mypollcmt' + result['data'][i]['id'] + '">\
         <i class="flaticon-three-1 lightgray is20px"></i>\
         </a>\
         <ul id="mypollcmt' + result['data'][i]['id'] + '" class="dropdown-content mpcmt">\
         <li>\
         <a class="fs16px editcmt" data-cmtid="' + result['data'][i]['id'] + '" data-cmttxt="' + result['data'][i]['comment'] + '" >Edit</a>\
         </li>\
         <li>\
         <a class="fs16px deletecmt" data-cmtid="' + result['data'][i]['id'] + '">Delete</a>\
         </li>\
         </ul>';
                    }
                    var isuserlike = result['data'][i]['userlike'] == 0 ? "like.png" : "like1.png";
                    var formattedDate = getDateString(new Date(result['data'][i]['created_date'].replace(' ', 'T')), "d M y")
                    var replyword = parseInt(result['data'][i]['total_replies']) > 1 ? " Replies" : " Reply";
                    html += '<div class="col s12">\
         <div class="commentsection" id="cm_' + result['data'][i]['id'] + '">\
         <div class="pollcardlist p-0">\
         <div class="row mb0">\
         <div class="col m11 s11">\
         <h6 class="forumsubhead fs12px tastart mt5 lightgray fw500"><span class="flaticon-social-2 ml10 mr0"></span><i>By ' + replyby + ', ' + formattedDate + ' </i></h6>\
         </div>\
         <div class="col m1 s1">\
         ' + cmtedit + '\
         </div>\
         </div>\
         <div class="ml45">\
         <div class="cmteditbox positir">\
         <div class="mr35 whitespacepre">' + result['data'][i]['comment'] + '</div>\
         <div class="hide posrela">\
         <textarea type="text" data-autoresize rows="1" id="cmt_' + result['data'][i]['id'] + '" data-value="' + result['data'][i]['comment'] + '" data-pollid="' + result['ques_no'] + '" data-cmtid="' + result['data'][i]['id'] + '" readonly class="' + iscmtedit + ' mb0 textarea-scrollbar">' + result['data'][i]['comment'] + '</textarea>\
         <span data-cmtid="' + result['data'][i]['id'] + '" class="textareaicon1"><span class="material-icons prefix sendarrow">send</span></span>\
         </div>\
         </div>\
         <div class="row txtbluegray cmtop mb0">\
         <div class="col m7 s7"><h6 class="fs12px linkpointer showreplies_icon fs12px fw500 lightgray" data-cmtid="' + result['data'][i]['id'] + '" data-pollid="' + result['data'][i]['poll_id'] + '"><i class="flaticon-arrow-1 lightgray"></i>Reply</h6></div>\
         <div class="col m5 s5 right right-align">\
         <span class="mr10 lightgray fs12px fw500 linkpointer showreplies" data-cmtid="' + result['data'][i]['id'] + '" data-pollid="' + result['data'][i]['poll_id'] + '" data-replyset="0" data-totalreply="' + result['data'][i]['total_replies'] + '">' + result['data'][i]['total_replies'] + ' ' + replyword + '</span>\
         </div>\
         </div>\
         <div class="replies' + result['data'][i]['id'] + '" style="display:none;">\
         <div class="row m10">\
         <form id="postpollcommentrply" method="POST">\
         <div class="col m12 s12">\
         <div style="position:relative">\
         <textarea type="text" id="textarea1" class="writereply textarea-scrollbar" data-autoresize name="poll_comment_reply" placeholder="Write a reply"></textarea>\
         <span onclick="$(this).submit()" class="textareaicon"><span class="material-icons prefix sendarrowreply">send</span></span>\
         <input type="hidden" name="poll_id" value="' + result['data'][i]['poll_id'] + '"/>\
         <input type="hidden" name="comment_id" value="' + result['data'][i]['id'] + '"/>\
         </div>\
         </div>\
         </form>\
         </div>\
         <div id="replylist_' + result['data'][i]['id'] + '">\
         </div>\
         </div>\
         </div>\
         </div>\
         <hr class="commentseprator">\
         </div>\
         </div>';
                }
                $('[id^="togglecmtsec_"][id$="_' + result['ques_no'] + '"] .commentbox').html(html);
                setTimeout(function () {
                    $('.dropdown-button').dropdown({
                        inDuration: 300,
                        outDuration: 225,
                        constrain_width: false, // Does not change width of dropdown to that of the activator
                        hover: false, // Activate on hover
                        gutter: 0, // Spacing from edge
                        belowOrigin: false, // Displays dropdown below the button
                        alignment: 'left' // Displays dropdown with edge aligned to the left of button
                    }
                    )
                }, 100);
            }, 1000);
            //}
        });
    });


    $(document).on('click', '#editpoll', function (e) {
        $('.linkpreview').remove();
        $('.slide-on-mobile').slideDown('slow');
        var pollid = $(this).attr('data-pollid');
        var data = $(this).attr('data-rowjson');
        data = JSON.parse(data);
        $("#pollcatergory input[value=" + data['category_id'] + "]").attr('checked', true);
        $('#polldescription').val(data['description']);
        $('#poll_id').val(pollid);
        $('#polltopic').val(data['poll']);
        $('#detailurl').val(data['url']);
        $('#poll_preview').val($(this).attr('data-preview'));
        $('#polldescription').parent().append('<div class="linkpreview">' + $(this).attr('data-preview') + '</div>');
        var choiceid = data['choice_id'];
        var choice = data['choice'];
        var html = "";
        var choiceidarr = choiceid.split(',');
        var choicearr = choice.split(',');
        var dbDate = data['end_date'];
        var date2 = getDateString(new Date(data['end_date'].replace(' ', 'T')), "d M y");
        $('#enddate').datepicker('setDate', date2);
        for (var i = 0; i < choiceidarr.length - 2; i++)
        {

            var ishown = i == choiceidarr.length - 1 ? "" : "shown";
            if (i > 9) {
                break;
            }
            html += '<div class="row choice mb10">\
         <div class="col s11">\
         <input type="text" name="choice[]" maxlength="35" placeholder="Enter your choice here" value="' + choicearr[i] + '" class="' + ishown + '"/>\
         </div>\
         <div class="col s1 no-padding">\
         <i class="flaticon-plus addmorechoice"></i>\
         <i class="flaticon-delete removechoice"></i>\
         </div>\
         </div>';
        }

        $('#choiceslist').html(html);
        $('#staticoption').css('display', 'block');
        if (choiceidarr.length > 2) {
            $('.choice:first-child .removechoice').css('display', 'block');
        } else {
            $('.choice:first-child .removechoice').css('display', 'none');
        }

        $('html, body').animate({scrollTop: $('.slide-on-mobile').offset().top - 100}, 1000);
    });
    $(document).on('click', '.confdelete', function (e) {
        var pollid = $(this).attr('data-pollid');
        $('#confirmdelete .yes').attr('data-pollid', pollid);
        //alert("hello");
    });
    $(document).on('click', '.yes', function (e) {
        var pollid = $(this).attr('data-pollid');
        $.ajax({
            url: options.baseurl + 'Poll/deactive_poll',
            method: "POST",
            data: {pollid: pollid},
        }).done(function (result) {

            result = JSON.parse(result);
            if (result['status']) {
                Materialize.Toast.removeAll();
                Materialize.toast(result['message'], 4000);
                $('#card_' + pollid).slideUp('slow');
                $('#confirmdelete').modal('close');
                var categoryid = $('#tabs-swipe-demo>li>a.active').attr('data-catid');
                loaddatafortrending(categoryid, 0);
                //loaddataformyraised(categoryid, 0);
                load_my_answered_prediction(categoryid, 0);
                //                setTimeout(function () {
                //                    window.location.assign(options.baseurl+"Poll");
                //                }, 2000)
            }
        });
    });

    $(document).on('keypress', '#polltopic,.choice input', function (e) {
        if (e.which == 13) {
            e.preventDefault();
        }
    })

    var searchInput = $(".commentedit");
    searchInput
            .putCursorAtEnd() // should be chainable
            .on("focus", function () { // could be on any event
                searchInput.putCursorAtEnd()
            });


    $(document).on('click', '.loadmorepage', function (e) {
        var categoryid = $(this).attr('data-catid');
        var pageno = $(this).attr('data-pageid');
        var type = $('#tabs-swipe-demo>li>a.active').attr('data-type');
        $(this).replaceWith("<div class='lds-roller pageloader' id='pageloader'><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>");
        loaddatafortab(categoryid, pageno, type)
    });

//    var loadflag=1;
//    $(window).scroll(function() {
//        if(loadflag>0){
//           var newscroll = $('#footer').innerHeight()+$('#pointsModal').innerHeight()+$('#confirmdelete').innerHeight();
//           if(isMobile.any()){
//               newscroll=newscroll + $('.col.l4.show-on-medium-and-down').innerHeight();
//           }
//            if ($(window).scrollTop() >= (($(document).height() - $(window).height()) - newscroll)) {
//                loadflag=0;
//                var currentpage=$('#tabs-swipe-demo>li>a.active').attr('href');
//                //var currentpage = currentpage.substring(1, currentpage.length);
//                ismoredata=$(currentpage+' .loadmorepage').attr('data-pageid');
//                
//                if(ismoredata>0){
//                    var categoryid = $(currentpage+' .loadmorepage').attr('data-catid');
//                    var pageno = $(currentpage+' .loadmorepage').attr('data-pageid');
//                    var type = $('#tabs-swipe-demo>li>a.active').attr('data-type');
//                    
//                    $('.loadmorepage').replaceWith("<div class='lds-roller pageloader' id='pageloader'><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>");
//                    loaddatafortab(categoryid, pageno, type);
//                    loadflag=1;
//                    setTimeout(function(){
//                        var newpage=$(currentpage+' .loadmorepage').attr('data-pageid');
//                      //console.log(newpage);
//                        if(parseInt(newpage)==0){
//                            loadflag=0;
//                        }
//                    },800)
//                   
//                    
//                }
//            }
//        }
//      });

    var isMobile = {
        Android: function () {
            return navigator.userAgent.match(/Android/i);
        },
        BlackBerry: function () {
            return navigator.userAgent.match(/BlackBerry/i);
        },
        iOS: function () {
            return navigator.userAgent.match(/iPhone|iPad|iPod/i);
        },
        Opera: function () {
            return navigator.userAgent.match(/Opera Mini/i);
        },
        Windows: function () {
            return navigator.userAgent.match(/IEMobile/i) || navigator.userAgent.match(/WPDesktop/i);
        },
        any: function () {
            return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
        }
    };
    $('.trend').on('scroll', function () {
        if ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {
            var categoryid = $('.loadmoretrending').attr('data-catid');
            var pageno = $('.loadmoretrending').attr('data-page');
            loaddatafortrending(categoryid, pageno)

        }
    })
    $('.myraised').on('scroll', function () {
        if ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {
            var categoryid = $('.loadmoremyraised').attr('data-catid');
            var pageno = $('.loadmoremyraised').attr('data-page');
            //loaddataformyraised(categoryid, pageno);
            load_my_answered_prediction(categoryid, pageno);
        }
    })



    $(window).scroll(function () {
        if ($(this).scrollTop() >= 50) {        // If page is scrolled more than 50px
            $('#return-to-top').fadeIn(200); // Fade in the arrow
        } else {
            $('#return-to-top').fadeOut(200); // Else fade out the arrow
        }
    });
    $('#return-to-top').click(function () {      // When arrow is clicked
        $('body,html').animate({
            scrollTop: 0                       // Scroll to top of body
        }, 500);
    });
    /*------------Uncommment this for Preview Functionality --------------------*/
    $(document).bind("paste", "#polldescription", function (e) {
        //$('.linkpreview').remove();

        var pastedData = e.originalEvent.clipboardData.getData('text');
        //getpreview(pastedData);
        var linkpreviewcount = $('#polldescription + .linkpreview').length;
        if (linkpreviewcount == 0) {
            var urls = findUrls(pastedData);
            if (urls != null && urls != "null") {
                //console.log(urls.length);
                getpreview(urls[0]);
//                for (var i = 0; i < parseInt(urls.length);i++) {
//                    var linkpreviewcount= $('.linkpreview').length;
//                    getpreview(urls[i]);
//                }
            }
            setTimeout(function () {
                var target = $('#polldescription').val();
                $('#polldescription').attr('data-oldtext', target);
            }, 100);
        }

    });
    $(document).on('keyup', '#polldescription', function (e)
    {
        var target = $(this).val();
        if (target == "") {
            $('.linkpreview').remove();
            $(this).attr('data-oldtext', '');
        } else {
            var urls = findUrls(target);
            if (urls != null && urls != "null") {
                var linkpreviewcount = $('#polldescription + .linkpreview').length;
                if (parseInt(linkpreviewcount) > parseInt(urls.length)) {
                    $('.linkpreview:last').remove();
                }
            }
        }
    });
    $(document).on('keypress', '#polldescription', function (e)
    {
        var linkpreviewcount = $('#polldescription + .linkpreview').length;
        if (linkpreviewcount == 0) {
            if (e.which == 32 || e.which == 13) {
                var target = $(this).val();
                var oldtext = $(this).attr('data-oldtext');
                $(this).attr('data-oldtext', target);
                //console.log(target);
                //console.log(oldtext);
                if (oldtext != "") {
                    target = target.replace(oldtext, '');
                    //console.log(target);
                }
                var urls = findUrls(target);
                //console.log(urls);
                if (urls != null && urls != "null") {
                    getpreview(urls[0]);
                    //$('.linkpreview').remove();
                    //for (var i = 0; i < parseInt(urls.length);i++) {
                    //getpreview(urls[i]);
                    //}
                    //$(this).attr('data-oldtext',target);
                }
            }
        }
    });



    /* Uncomment this to see more results without login */
//     $(document).on('change','input[type=radio]',function(){
//         if($(this).hasClass('showresults')){
//             var pollid=$(this).attr('data-pollid');
//             $('.polloption_'+pollid).addClass('votedpoll');
//             setTimeout(function () {
//                var maxper=0
//                $("polloption_"+pollid+" .determinate:first").parent().addClass('maxper');
//                $("polloption_"+pollid+" .determinate").each(function () {
//                    var newper = $(this).attr('data-afterload');
//                    $(this).css('width', newper + '%');
//                    if(parseFloat(newper)>parseFloat(maxper)){
//                        $('.polloption_'+pollid+' .determinate').parent().removeClass('maxper');
//                        $(this).parent().addClass('maxper');
//                        maxper=newper;
//                    }
//                });
//                $('.avgvotebox').each(function(){
//                    var avgper=$(this).attr('data-avg');
//                    if(parseFloat(avgper)>0)
//                    {
//                        $(this).html('Avg: '+parseInt(avgper));
//                        
//                    } else {
//                        $(this).addClass('hide');
//                    }
//                });
//            }, 100);
//         }
//         
//     });

    var url1 = /(^|&lt;|\s)(www\..+?\..+?)(\s|&gt;|$)/g,
            url2 = /(^|&lt;|\s)(((https?|ftp):\/\/|mailto:).+?)(\s|&gt;|$)/g,
            linkifyThis = function () {
                var childNodes = this.childNodes,
                        i = childNodes.length;
                while (i--)
                {
                    var n = childNodes[i];
                    if (n.nodeType == 3) {
                        var html = $.trim(n.nodeValue);
                        if (html)
                        {
                            html = html.replace(/&/g, '&amp;')
                                    .replace(/</g, '&lt;')
                                    .replace(/>/g, '&gt;')
                                    .replace(url1, '$1<a target="_blank" href="http://$2">$2</a>$3')
                                    .replace(url2, '$1<a target="_blank" href="$2">$2</a>$5');
                            $(n).after(html).remove();
                        }
                    } else if (n.nodeType == 1 && !/^(a|button|textarea)$/i.test(n.tagName)) {
                        linkifyThis.call(n);
                    }
                }
            };
    $.fn.linkify = function () {
        return this.each(linkifyThis);
    };


});
function GetURLParameter(sParam) {
    var sPageURL = window.location.href;
    var sURLVariables = sPageURL.split('&');
    for (var i = 0; i < sURLVariables.length; i++)
    {
        var sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] == sParam)
        {
            return sParameterName[1];
        }
    }
}

jQuery.fn.putCursorAtEnd = function () {
    return this.each(function () {
        // Cache references
        var $el = $(this),
                el = this;
        // Only focus if input isn't already
        if (!$el.is(":focus")) {
            $el.focus();
        }
        // If this function exists... (IE 9+)
        if (el.setSelectionRange) {
            // Double the length because Opera is inconsistent about whether a carriage return is one character or two.
            var len = $el.val().length * 2;
            // Timeout seems to be required for Blink
            setTimeout(function () {
                el.setSelectionRange(len, len);
            }, 1);
        } else {
            // As a fallback, replace the contents with itself
            // Doesn't work in Chrome, but Chrome supports setSelectionRange
            $el.val($el.val());
        }
        // Scroll to the bottom, in case we're in a tall textarea
        // (Necessary for Firefox and Chrome)
        this.scrollTop = 999999;
    });
};

function loaddatafortrending(categoryid, pageno) {
    $.ajax({
        url: options.baseurl + 'Poll/loadmoretrending',
        method: "POST",
        data: {categoryid: categoryid, pageno: pageno},
    }).done(function (result) {

        result = JSON.parse(result);
        var html = "";
        //$('.loadersmall').css('display','none');
        if (result['status']) {
            $('.loadmoretrending').remove();
            var catname = "";
            if (categoryid == "1") {
                catname = "Governance";
            } else if (categoryid == "2") {
                catname = "Money";
            } else if (categoryid == "3") {
                catname = "Sports";
            } else if (categoryid == "4") {
                catname = "Entertainment";
            } else {
                catname = "Governance";
            }
            for (var i in result['data']) {
                html += '<div class="blogs p15_20">\
         <div class="row">\
         <a href="' + options.baseurl + 'Poll/polldetail/' + result['data'][i]['id'] + '?t=&ct=' + catname + '&pid=">\
         <div class="col s12">\
         <div class="blog-title truncate">' + result['data'][i]['poll'] + '</div>\
         <div class="left fs11px fw600 blog-details mt10 text-upper category-display category ' + result['data'][i]['category_name'].toLowerCase() + '">' + result['data'][i]['category_name'] + '</div>\
         <div class="right blog-details lightgray">\
         <i class="lightgray flaticon-click ml0"></i>\
         <span class="lightgray fs12px">' + result['data'][i]['total_votes'] + ' Votes</span></div>\
         </div>\
         </a>\
         </div>\
         </div>';
            }
            html += '<div class="loadmoretrending" data-page="' + (parseInt(pageno) + 1) + '" data-catid="' + categoryid + '"></div>';
            //console.log(pageno);
            if (parseInt(pageno) < 1) {
                $('.trend .bindtrend').html(html)
            } else {
                $('.trend .bindtrend').append(html)
            }

        }
    });
}

function load_my_answered_prediction(categoryid, pageno) {
    $.ajax({
        url: options.baseurl + 'Poll/load_my_answered_prediction',
        method: "POST",
        data: {categoryid: categoryid, pageno: pageno},
    }).done(function (result) {
        result = JSON.parse(result);
        var html = "";
        //$('.loadersmall').css('display','none');
        if (result['status']) {
            $('.loadmoremyraised').remove();
            var catname = "";
            if (categoryid == "1") {
                catname = "Governance";
            } else if (categoryid == "2") {
                catname = "Money";
            } else if (categoryid == "3") {
                catname = "Sports";
            } else if (categoryid == "4") {
                catname = "Entertainment";
            } else {
                catname = "Governance";
            }
            for (var i in result['data']) {
                html += '<div class="blogs p15_20">\
                            <div class="row">\
                                <a href="' + options.baseurl + 'Poll/polldetail/' + result['data'][i]['id'] + '?t=&ct=' + catname + '&pid=">\
                                    <div class="col s12">\
                                        <div class="blog-title truncate">' + result['data'][i]['poll'] + '</div>\
                                        <div class="left fs11px fw600 blog-details mt10 text-upper category-display category ' + result['data'][i]['category_name'].toLowerCase() + '">' + result['data'][i]['category_name'] + '</div>\
                                        <div class="right blog-details lightgray">\
                                            <i class="lightgray flaticon-click ml0"></i>\
                                            <span class="lightgray fs12px">' + result['data'][i]['total_votes'] + ' Votes</span></div>\
                                        </div>\
                                </a>\
                            </div>\
                        </div>';
            }
            html += '<div class="loadmoremyraised" data-page="' + (parseInt(pageno) + 1) + '" data-catid="' + categoryid + '"></div>';
            //console.log(html);
            if (parseInt(pageno) < 1) {
                $('.myraised .bindraised').html(html);
            } else {
                $('.myraised .bindraised').append(html);
            }
        }
    });
}
function loaddataformyraised(categoryid, pageno) {
    //console.log(categoryid);
    //console.log(pageno);
    $.ajax({
        url: options.baseurl + 'Poll/loadmoremyraised',
        method: "POST",
        data: {categoryid: categoryid, pageno: pageno},
    }).done(function (result) {

        result = JSON.parse(result);
        //console.log(result);
        var html = "";
        if (result['status']) {
            $('.loadmoremyraised').remove();
            //    categoryid=result['data'][i]['category_id'];
            //    var catname="";
            //    if(categoryid=="1"){
            //       catname="Governance"; 
            //    } else if(categoryid=="2"){
            //       catname="Money"; 
            //    } else if(categoryid=="3"){
            //        catname="Sports";
            //    } else if(categoryid=="4"){
            //        catname="Entertainment";
            //    } else {
            //        catname="Governance"; 
            //    }
            for (var i in result['data']) {
                html += '<div class="blogs p15_20">\
         <div class="row">\
         <a href="' + options.baseurl + 'Poll/polldetail/' + result['data'][i]['id'] + '?t=&ct=' + result['data'][i]['category_name'] + '&pid=">\
         <div class="col s12">\
         <div class="blog-title truncate">' + result['data'][i]['poll'] + '</div>\
         <div class="left fs11px fw600 blog-details mt10 text-upper category-display category ' + result['data'][i]['category_name'].toLowerCase() + '">' + result['data'][i]['category_name'] + '</div>\
         <div class="right blog-details lightgray">\
         <i class="lightgray flaticon-click ml0"></i>\
         <span class="lightgray fs12px">' + result['data'][i]['total_votes'] + ' Votes</span></div>\
         </div>\
         </a>\
         </div>\
         </div>';
            }
            html += '<div class="loadmoremyraised" data-page="' + (parseInt(pageno) + 1) + '" data-catid="myraised"></div>';
            //console.log(html);
            if (parseInt(pageno) < 1) {
                $('.myraised .bindraised').html(html)
            } else {
                $('.myraised .bindraised').append(html)
            }

        } else {
            //$('.loaddataformyraised').remove();
        }
    });
}
function loaddatafortab(categoryid, pageno, type) {

    var pollid = getUrlVars()["pid"];
    $('.loadersmall').css('display', 'block');
    $.ajax({
        url: options.baseurl + 'Poll/loadmorepolldata',
        method: "POST",
        data: {categoryid: categoryid, pageno: pageno, type: type, pollid: pollid},
    }).done(function (result) {
        //console.log(result);

        if (parseInt(categoryid) == 1) {
            if (parseInt(pageno) > 0) {
                $('#elecpoll').append(result);
            } else {
                $('#elecpoll').html(result);
            }
        } else if (parseInt(categoryid) == 2) {
            if (parseInt(pageno) > 0) {
                $('#stockpoll').append(result);
            } else {
                $('#stockpoll').html(result);
            }
        } else if (parseInt(categoryid) == 3) {
            if (parseInt(pageno) > 0) {
                $('#sportpoll').append(result);
            } else {
                $('#sportpoll').html(result);
            }
        } else {
            if (parseInt(pageno) > 0) {
                $('#moviepoll').append(result);
            } else {
                $('#moviepoll').html(result);
            }
        }
        $('.dropdown-button').dropdown({
            inDuration: 300,
            outDuration: 225,
            constrain_width: false, // Does not change width of dropdown to that of the activator
            hover: false, // Activate on hover
            gutter: 0, // Spacing from edge
            belowOrigin: false, // Displays dropdown below the button
            alignment: 'left' // Displays dropdown with edge aligned to the left of button
        })
        setTimeout(function () {
            var currentpollid = $(".determinate:first").parent().find('input').attr('data-pollid');
            jQuery('h6.tastart').linkify();
            var maxper = 0;
            $(".determinate").each(function () {
                var newper = $(this).attr('data-afterload');
                $(this).css('width', newper + '%');
                var pollid = $(this).parent().find('input').attr('data-pollid');
                if (parseInt(currentpollid) == parseInt(pollid))
                {
                    if (parseFloat(newper) > parseFloat(maxper)) {
                        $('.polloption_' + pollid + ' .determinate').parent().removeClass('maxper');
                        $(this).parent().addClass('maxper');
                        maxper = newper;
                    }
                } else {
                    maxper = newper;
                    $(this).parent().addClass('maxper');
                    currentpollid = $(this).parent().find('input').attr('data-pollid');
                }
            });
            $('.avgvotebox').each(function () {
                var avgper = $(this).attr('data-avg');
                if (parseFloat(avgper) > 0)
                {
                    //$(this).html('Avg: ' + parseInt(avgper));
                    $(this).html('Avg: ' + avgper);
                } else {
                    $(this).addClass('hide');
                }
            });


        }, 100)
        $('.loadersmall').css('display', 'none');

        $('.pageloader').hide();
    });
}
/* till this Uncomment this to see more results without login */
function getUrlVars() {
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for (var i = 0; i < hashes.length; i++)
    {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}

function getpreview(target) {
    //console.log(target);
    var loader = '<div id="videoloader">\
                            <div class="lds-spinner">\
                                <div></div>\
                                <div></div>\
                                <div></div>\
                                <div></div>\
                                <div></div>\
                                <div></div>\
                                <div></div>\
                                <div></div>\
                                <div></div>\
                                <div></div>\
                                <div></div>\
                                <div></div>\
                            </div>\
                            <label>Fetching preview</label>\
                        </div>';
    $('#polldescription').parent().append(loader);
    $.ajax({
        url: options.baseurl + 'Poll/getmetatags',
        method: "POST",
        data: {url: target},
    }).done(function (result) {
        result = JSON.parse(result);
        //console.log(result);
        if (result['status']) {
            //$('.linkpreview').remove();
            var url = result['data']['url'];
            var title = result['data']['title'];
            var image = result['data']['image'];
            var description = result['data']['description'];
            var html = '<div class="linkpreview">\
                                    <div class="row">\
                                        <div class="col m4 s12">\
                                            <div class="previewimg">\n\
                                            <img src="' + image + '" class="linkpreviewimg"/></div>\
                                        </div>\
                                        <div class="col m8 s12">\
                                            <div class="previewtext">\
                                                <h3 class="fs14px lightgray tastart">' + title + '</h3>\
                                                <h5 class="fs12px lightgray tastart">' + description + '</h5>\
                                                <a class="fs12px" target="_blank" href=http://' + url + '>' + url + '</a>\
                                            </div>\
                                        </div>\
                                    </div>\
                                </div>';
            $('#polldescription').parent().append(html);
        }
        $('#videoloader').remove();
    });
    return true;
}


function showcommentsec(id, type)
{
    $('#togglecmtsec_' + type + '_' + id).slideToggle('slow');
}


function findUrls(text) {
    //urls = text.match(/(\b(?:(?:https?|ftp|file|[A-Za-z]+):\/\/|www\.|ftp\.)(?:\([-A-Z0-9+&@#\/%=~_|$?!:,.]*\)|[-A-Z0-9+&@#\/%=~_|$?!:,.])*(?:\([-A-Z0-9+&@#\/%=~_|$?!:,.]*\)|[A-Z0-9+&@#\/%=~_|$]))/i);
    urls = text.match(/(https?:\/\/[^\s]+)/g);
    return urls;
}
/*------------Uncommment this for Preview Functionality till this--------------------*/





