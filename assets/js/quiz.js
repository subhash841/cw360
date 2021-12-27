let i = 1;
let duration = 15;
var answer_click = false;
var progressValue = $('#progressCircle')[0];
var RADIUS = 54;
var CIRCUMFERENCE = 2 * Math.PI * RADIUS;
qtn_list_id = "";
current_id = 0;

$(function () {
    var quiz_id = $('#data_quiz_id').attr('data-quiz_id');
    question_list_id(quiz_id);
});


function countdown_ticker() {
    if (i <= duration) {
        progress(i);
        let ticklength = i.toString().length;
        if (answer_click) {
            $('#tickervalue').html('');
        } else {
            ticklength < 2 ? $('#tickervalue').html('&nbsp;' + i++) : $('#tickervalue').html(i++);
        }
    } else {
        // console.log({ 'timeout loop enters': '', 'value of answered is': answer_click });
        if (answer_click != true) {
            timeout();
            question_time_out(atob($('.answer').attr('data-quid')));
        }
        // answer_click = true;
        // manage_timer(false);
    }
}


function progress(value) {
    var progress = value / duration;
    var dashoffset = CIRCUMFERENCE * (1 - progress);
    $(progressValue).animate({ strokeDashoffset: dashoffset }, "linear");
    if (dashoffset == '0') { }
}


function question_list_id(quiz_id) {
    $.ajax({
        url: base_url + "/quiz/question_bank_id",
        type: "POST",
        dataType: "json",
        data: { quiz_id: quiz_id },
        success: function (data, textStatus, jqXHR) {
            qtn_list_id = data.question;
            console.log(data);
            if (data.question == "finish-quiz") {
                window.location.href = base_url + "quiz/quiz_answer_summary/" + btoa(quiz_id);
            }else if (data.coin_limit == '0') {              
                        $('#modalText').html('You have reached maximum 1000 coin earn limit for Quiz . You can start earning coins from date '+ moment( data.limit_end_date).format('DD MMM, YYYY'));
                        $('#basicModal').modal('show');
                        setInterval(function () {                            // location.reload();
                         window.location.href = base_url + "quiz/quiz_answer_summary/" + btoa(quiz_id);
                        }, 2000);
            }else if (data.question != "") {
                show_question(qtn_list_id[current_id].id);
            } else {
                console.log("no in question_list_id");
            }

        }
    });
}

function show_question(question_id) {
    if (typeof question_id != 'undefined') {
        $.ajax({
            url: base_url + "/Quiz/question_bank",
            type: "POST",
            dataType: "json",
            data: { question_id: question_id },
            success: function (data, textStatus, jqXHR) {
                // ticker =setInterval(function () {countdown_ticker();}, 1000);
                if (data.coin_limit == '0') { 
                var quiz_id = $('#data_quiz_id').attr('data-quiz_id');             
                        $('#modalText').html('You have reached maximum 1000 coin earn limit for Quiz . You can start earning coins from date '+ moment( data.limit_end_date).format('DD MMM, YYYY'));
                        $('#basicModal').modal('show');
                        setInterval(function () {                            // location.reload();
                         window.location.href = base_url + "quiz/quiz_answer_summary/" + btoa(quiz_id);
                        }, 2000);
            }else{
                generateQuiz(data.question.question, data.question_ans, data.question.quiz_id);
                current_id++;
            }
            }
        });
    } else {
        console.log("show_question error");
    }
}

function generateQuiz(question, answer, quiz_id) {
    $('.question').html(question);
    $('#answer-holder').html('');
    var answer;
    $.each(answer, function (key, value) {
        answer = $('<div />', { class: 'answer', id: btoa(value.id), 'data-quid': btoa(value.question_id), 'data-quiz_id': btoa($('#data_quiz_id').attr('data-quiz_id')) })
            .append($('<div />', { class: 'progressbar' }))
            .append($('<div />', { class: 'd-flex justify-content-between' })
                .append($('<span />').html(value.choice))
            );

        $('#answer-holder').append(answer);
        //  i=1;
    });
    answer_click = false;
    // timerreset();
    manage_timer(true);
}

$(document).on('click', '.answer', function (e) {
    // console.log({ 'when click on answer value of answer_click': answer_click });
    var pick = $(this);
    if (answer_click != true) {
        // console.log({ 'it come under if condition that time value of answer click must be false': answer_click });
        answer_click = true;
        $(this).addClass('active');
        $.ajax({
            url: base_url + "Quiz/question_check_process",
            type: "POST",
            dataType: "json",
            data: { id: atob($(this).attr('id')), question_id: atob($(this).attr('data-quid')), quiz_id: atob($(this).attr('data-quiz_id')) },
            success: function (data, textStatus, jqXHR) {
                var quiz_id = $('#data_quiz_id').attr('data-quiz_id');
                var topic_id = $('#quiz_topic_id').attr('data-topic_id');
                pick.removeClass('active');
                if (data.answer_chk == '1') {
                    // clearInterval(ticker);
                    rightanswer();
                    // timerreset();
                    pick.addClass('right');
                    setTimeout(function () {
                        manage_timer(false);

                        if (qtn_list_id.length != current_id) {
                            show_question(qtn_list_id[current_id].id);
                            answer_click = false;
                        } else {
                            window.location.href = base_url + "quiz/quiz_answer_summary/" + btoa(quiz_id) + "?topic_id=" + btoa(topic_id);
                        }
                    }, 3000);

                } else {
                    pick.addClass('danger');
                    // timerreset();
                    // manage_timer(false);
                    wronganswer();
                    setTimeout(function () {
                        manage_timer(false);

                        if (qtn_list_id.length != current_id) {
                            answer_click = false;
                            show_question(qtn_list_id[current_id].id);
                        } else {
                            window.location.href = base_url + "quiz/quiz_answer_summary/" + btoa(quiz_id) + "?topic_id=" + btoa(topic_id);
                        }

                    }, 3000);
                }

            }
        });
    }
});

function question_time_out(id) {
    var pick = $(this);
    var quiz_id = $('#data_quiz_id').attr('data-quiz_id');
    var topic_id = $('#quiz_topic_id').attr('data-topic_id');
    if (typeof quiz_id != 'undefined') {
        answer_clicked = true;
        $.ajax({
            url: base_url + "Quiz/question_time_out",
            type: "POST",
            dataType: "json",
            data: { id: id, quiz_id: quiz_id },
            success: function (data, textStatus, jqXHR) {
                clearInterval(ticker);
                wronganswer();
                setTimeout(function () {
                    timerreset();
                    if (qtn_list_id.length != current_id) {
                        // console.log('new question will load after timeout');
                        show_question(qtn_list_id[current_id].id);
                        answer_click = false;
                    } else {
                        window.location.href = base_url + "quiz/quiz_answer_summary/" + btoa(quiz_id) + "?topic_id=" + btoa(topic_id);
                    }
                }, 3000);

            }
        });
    } else {
        console.log('done');
    }
}

function rightanswer() {
    i = duration;
    answer_click = true;
    $('#tickervalue').html('');
    $('#progressCircle').css('stroke', '#51E485');
    $('.circular-progess').removeClass('ticker wrong timeout').addClass('right');
}

function wronganswer() {
    i = duration;
    answer_click = true;
    $('#tickervalue').html('');
    $('#progressCircle').css('stroke', '#FE6055');
    $('.circular-progess').removeClass('ticker right timeout').addClass('wrong');
}

function timeout() {
    i = duration;
    answer_click = true;
    $('#tickervalue').html('');
    $('#progressCircle').css('stroke', '#FE6055');
    $('.circular-progess').removeClass('ticker right wrong').addClass('timeout');
}

function timerreset() {
    i = 1;
    $('.circular-progess').removeClass('ticker right wrong timeout');
    $('#tickervalue').html('&nbsp;0');
    $('#progressCircle').css('stroke', '#51E485');
    $('#progressCircle').animate({ strokeDashoffset: 339.292, strokeDasharray: 339.292 }, "linear");
}


function manage_timer(timer) {
    if (timer) {
        i = 0;
        // console.log('----------------------------------');
        // console.log({'timeer started value of i is ': i});
        // console.timeStamp();
        ticker = setInterval(function () { countdown_ticker(); }, 1000);
    } else {
        timerreset();
        clearInterval(ticker);
    }

}