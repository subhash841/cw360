let i = 1;
let duration = 15;
ql="";
var answered = false;
qtn_list_id="";
current_id=0;
answer_clicked = false;

    var progressValue = $('#progressCircle')[0];
    var RADIUS = 54;
    var CIRCUMFERENCE = 2 * Math.PI * RADIUS;

$(function () { 
var topic_id =$('#quiz_topic_id').attr('data-topic_id');   
var quiz_id =$('#data_quiz_id').attr('data-quiz_id');
  // alert(topic_id);
  // alert(quiz_id);
    //question_list();
    question_list_id(topic_id,quiz_id);
    // ticker =setInterval(function () {
    //     countdown_ticker();
    //     // if (i <= duration) {
    //     //     progress(i);
    //     //     let ticklength = i.toString().length;
    //     //     ticklength < 2 ? $('#tickervalue').html('&nbsp;' + i++) : $('#tickervalue').html(i++);
    //     // }else{
    //     //     clearInterval(ticker);
    //     //     question_time_out(qtn_list_id[current_id].id);
    //     // }
    // }, 1000);

   

    

});

function countdown_ticker(){
        if (i <= duration) {
            progress(i);
            let ticklength = i.toString().length;
             if (answered) {
                  $('#tickervalue').html('');
              } else {
                  ticklength < 2 ? $('#tickervalue').html('&nbsp;' + i++) : $('#tickervalue').html(i++);
              }
        }else{
            // clearInterval(ticker);
            answer_clicked = true;
            answered = true;
            if(typeof id != 'undefined'){
                 answer_clicked = true;
                 answered = true;
                question_time_out(qtn_list_id[current_id].id);
            }else{
                 answer_clicked = true;
                 answered = true;
              question_time_out(atob($('.answer').attr('data-quid'))); 
                // alert(atob($('.answer').attr('data-quid')));

            }
        }
}

function progress(value) {
    var progress = value / duration;
    var dashoffset = CIRCUMFERENCE * (1 - progress);
    $(progressValue).animate({ strokeDashoffset: dashoffset }, "linear");
    if(dashoffset == '0'){}
}

function question_time_out(id) {
  // console.log('question_time_out');
   // console.log(current_id+"answer current_id");
   // console.log(qtn_list_id.length+"length current_id");
    var pick = $(this);
    var quiz_id = $('#data_quiz_id').attr('data-quiz_id'); 
    var topic_id =$('#quiz_topic_id').attr('data-topic_id'); 
    // alert(quiz_id);
    if(typeof quiz_id != 'undefined'){
      answer_clicked = true;
       $.ajax({
         url: base_url+"Quiz/question_time_out",
         type: "POST",
         dataType: "json",
         data: {id: id,quiz_id:quiz_id},
         success: function(data, textStatus, jqXHR) {               
             // console.log(data);
             // qtn_list_id=data.question;
             // pick.removeClass('active');                  
              clearInterval(ticker);
              wronganswer();
              // pick.addClass('right');
              //setInterval(ticker, 1000);
          /*     setTimeout(function(){
                  timerreset();
                  i=1;
                  ticker =setInterval(function () {countdown_ticker();}, 1000);
                  show_question(qtn_list_id[current_id].id)
               }, 3000);*/

                setTimeout(function(){
                    timerreset();
                    // i=1;
                    // ticker =setInterval(function () {countdown_ticker();}, 1000);
                     if(qtn_list_id.length != current_id){
                    show_question(qtn_list_id[current_id].id);
                    answer_clicked = false;
                       }else{
                            window.location.href=base_url+"quiz/quiz_answer_summary/"+btoa(quiz_id)+"?topic_id="+btoa(topic_id);
                          
                      }
                    
                 }, 3000);

           }
   });
   }else{
          alert('done');
  }
}


$(document).on('click', '.answer', function (e) {
  // alert(current_id);
   // console.log(current_id+"answer current_id");
   // console.log(qtn_list_id.length+"length current_id");
  // if(qtn_list_id.length != current_id){
    var pick = $(this);
    if(!answered){
      // alert('hi');
        $(this).addClass('active');
        answer_clicked = true;
        // console.log($(this).attr('id'));
        // console.log($(this).attr('data-quid'));
        $.ajax({
           url: base_url+"Quiz/question_check_process",
           type: "POST",
           dataType: "json",
           data: {id: atob($(this).attr('id')),question_id:atob($(this).attr('data-quid')),topic_id:atob($(this).attr('data-topic_id')),quiz_id:atob($(this).attr('data-quiz_id'))},
           success: function(data, textStatus, jqXHR) {               
              console.log(data);
              var topic_id =$('#quiz_topic_id').attr('data-topic_id');   
              var quiz_id =$('#data_quiz_id').attr('data-quiz_id');
               // qtn_list_id=data.question;
               // console.log(qtn_list_id[current_id].id);
               // console.log(data);
                pick.removeClass('active');
               if(data.answer_chk == '1'){
                clearInterval(ticker);
                rightanswer();
                 pick.addClass('right');
                 setTimeout(function(){
                    timerreset();
                    // i=1;
                    // ticker =setInterval(function () {countdown_ticker();}, 1000);
                if(qtn_list_id.length != current_id){
                    show_question(qtn_list_id[current_id].id);
                    answer_clicked = false;
                       }else{
                            window.location.href=base_url+"quiz/quiz_answer_summary/"+btoa(quiz_id)+"?topic_id="+btoa(topic_id);
                 
                      }
                 }, 3000);
                 
               }else{
                pick.addClass('danger');
                clearInterval(ticker);
                wronganswer();
                     
                setTimeout(function(){
                    timerreset();                    // i=1;
                    // ticker =setInterval(function () {countdown_ticker();}, 1000);
                     if(qtn_list_id.length != current_id){
                        show_question(qtn_list_id[current_id].id);
                        answer_clicked = false;
                       }else{
                            window.location.href=base_url+"quiz/quiz_answer_summary/"+btoa(quiz_id)+"?topic_id="+btoa(topic_id);
                          
                      }
                    
                 }, 3000);
              }
              
           }
       });
    }
  // }else{
  //      window.location.href=base_url+"quiz/quiz_answer_summary/"+$(this).attr('data-quiz_id')+"?topic_id="+$(this).attr('data-topic_id');
  // }
    
    //alert($(this).attr('id'))
    //answered = true;
})


function question_list_id(topic_id,quiz_id) {
  // alert(quiz_id+"question_list_id");
      $.ajax({
           url: base_url+"/quiz/question_bank_id",
           type: "POST",
           dataType: "json",
           data: {topic_id: topic_id,quiz_id:quiz_id},
           success: function(data, textStatus, jqXHR) {               
               // console.log(data.question);
               qtn_list_id=data.question;
               // console.log(qtn_list_id[current_id].length+"qtn_list_id[current_id]");
               // console.log(current_id+"current_id");
               // console.log(data.question.length+"no in question_list_id");
               if(data.question == "finish-quiz"){
                window.location.href=base_url+"quiz/quiz_answer_summary/"+btoa(quiz_id)+"?topic_id="+btoa(topic_id);
               }else if(data.question != ""){
                // console.log(qtn_list_id[current_id].id);
                    show_question(qtn_list_id[current_id].id);
                  // console.log(base_url+"quiz/quiz_answer_summary/"+quiz_id+"topic_id="+topic_id);
               }else{
                console.log("no in question_list_id");
               }
              
           }
       });
}

function show_question(question_id) {
  // alert(question_id);
    if(typeof question_id != 'undefined'){
          $.ajax({
               url: base_url+"/Quiz/question_bank",
               type: "POST",
               dataType: "json",
               data: {question_id:question_id},
               success: function(data, textStatus, jqXHR) {               
                   // console.log(data);
                           answered = false;
        ticker =setInterval(function () {countdown_ticker();}, 1000);
                   ql=data.question_limit;
                   // alert(data.question.quiz_id);
                   generateQuiz(data.question.question, data.question_ans,data.question.topic_id,data.question.quiz_id);
                   current_id++; 
               }
           });
    }else{
        console.log("show_question error");
    }
}

function generateQuiz(question, answer,topic_id,quiz_id) {
    $('.question').html(question);
    // var quiz_id =$('#data_quiz_id').attr('data-quiz_id');
    $('#answer-holder').html('');
    var answer;
    $.each(answer, function (key, value) {
        answer = $('<div />', { class: 'answer' ,id:btoa(value.id), 'data-topic_id':btoa(topic_id), 'data-quid':btoa(value.question_id),'data-quiz_id':btoa($('#data_quiz_id').attr('data-quiz_id'))})
            .append($('<div />', { class: 'progressbar' }))
            .append($('<div />', { class: 'd-flex justify-content-between' })
                .append($('<span />').html(value.choice))
            );

        $('#answer-holder').append(answer);
        i=1;
        timerreset();
    });
}



function rightanswer() {
    i = duration;
    answered = true;
    $('#tickervalue').html('');
    $('#progressCircle').css('stroke', '#51E485');
    $('.circular-progess').removeClass('ticker wrong timeout').addClass('right');
}

function wronganswer() {
    i = duration;
    answered = true;
    $('#tickervalue').html('');
    $('#progressCircle').css('stroke', '#FE6055');
    $('.circular-progess').removeClass('ticker right timeout').addClass('wrong');
}

function timeout() {
    i = duration;
    answered = true;
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