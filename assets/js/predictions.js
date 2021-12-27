        var status_container = $('.status-holder')[0];
        var maincard = $('.card-holder.visible')[0];
        var cards = $('.card-holder');
        let hammertime;
        var predictionIds=[];
        var slidedistance = 300;
                init_hammer(cards);
                
//                function init_hammer(data){
//                    $.each(data, function (key, element) {
//                        hammertime = new Hammer(element);
//                        console.log(hammertime);
//                        predictionIds.push({"id": atob($(element).find('.pred-id').html()), "is_log_called": "0"});
//                    });   
//                }
                
            function init_hammer(cards){
                $.each(cards, function (key, element) {
//                    console.log('init called');
//                    console.log(element);
                    hammertime = new Hammer(element);
//                    console.log(atob($(element).find('.pred-id').html()));
//                    console.log('finish');
//                    console.log('======================================================================================================');
                    predictionIds.push({"id": atob($(element).find('.pred-id').html()), "is_log_called": "0"});

                    hammertime.on('panright', function (event) {
                        let target = event.target;
                        let parent = $(target).closest('.card-holder');
                        if (parent.hasClass('visible')) {
                            // let parent = $(target).closest('.visible');
                            if (event.deltaX === 0) return;
                            if (event.center.x === 0 && event.center.y === 0) return;
                            parent[0].classList.toggle('like', event.deltaX > 0);
                            parent[0].classList.toggle('nope', event.deltaX < 0);

                            var rotate = event.deltaX / 15;
                            if (event.deltaX <= 300) {
                                $(parent).css('transform', 'translate(' + event.deltaX + 'px) rotate(' + rotate + 'deg)');
                            }
                            if (event.deltaX >= slidedistance) {
                                var checkIsCalled = predictionIds.filter((p) => p.id == atob(parent.find('.pred-id').html()) );
                                
                                if (checkIsCalled[0].is_log_called == 0) {
//                                    log_function('right', event, getVisibleCArd(), atob(parent.find('.pred-id').html()));
                                    swipe_prediction('right','mouse_event',parent,atob(parent.find('.pred-id').html()));
                                }
                                // $(parent).addClass('rotate-right').removeClass("visible first").next().addClass("visible first").removeClass('second').next().removeClass('third').addClass('second').next().addClass('third');

                            }
                        }
                    });

                    hammertime.on('panleft', function (event) {
//                        console.log(event.deltaX);
                        let target = event.target;
                        let parent = $(target).closest('.visible');
                        if (parent.hasClass('visible')) {
                            if (event.deltaX === 0) return;
                            if (event.center.x === 0 && event.center.y === 0) return;
                            parent[0].classList.toggle('like', event.deltaX > 0);
                            parent[0].classList.toggle('nope', event.deltaX < 0);

                            var rotate = event.deltaX / 15;
                            if (event.deltaX >= -300) {
                                $(parent).css('transform', 'translate(' + event.deltaX + 'px) rotate(' + rotate + 'deg)');
                            }
                            if (event.deltaX <= -slidedistance) {
                                // parent.addClass('rotate-left').removeClass("visible first").next().addClass("visible first").removeClass('second').next().removeClass('third').addClass('second').next().addClass('third');
//                                swipe_prediction('left','mouse_event',parent);
                                var checkIsCalled = predictionIds.filter((p) => p.id == atob(parent.find('.pred-id').html()) );
                                
                                if (checkIsCalled[0].is_log_called == 0) {
//                                    log_function('right', event, getVisibleCArd(), atob(parent.find('.pred-id').html()));
                                    swipe_prediction('left','mouse_event',parent,atob(parent.find('.pred-id').html()));
                                }
                            }
                        }

                    });
                    hammertime.on('panend', function (event) {

                        let target = event.target;
                        let parent = $(target).closest('.visible');
                        $(parent).removeClass('like').removeClass('nope');
                        if (event.deltaX <= 350 || event.deltaX <= -350) {
                            $(parent).css('transform', 'translate(0px) rotate(0deg)');
                        }
                    });
                });
            }

                function getVisibleCArd() {
                    return $('.card-holder.visible');
                }
                
                function log_function(direction,event, parent, currentCardId) {
                       for (var i in predictionIds) {
                           if (predictionIds[i].id == currentCardId) {
                               predictionIds[i].is_log_called = "1";
                           }
                       }
                       console.log(direction);
                    $(parent).addClass('rotate-right').removeClass("visible first").next().addClass("visible first").removeClass('second').next().removeClass('third').addClass('second').next().addClass('third');
                }
               
   
                function sellEvent() {
                    parent = getVisibleCArd();
                    swipe_prediction('left','btn_event',parent,atob(parent.find('.pred-id').html()));     //ajax call for left swipe

                }

                $('.btn-yes').click(function () {
                    buyEvent();
                });
   
                 function buyEvent() {
                    parent = getVisibleCArd();
                    swipe_prediction('right','btn_event',parent,atob(parent.find('.pred-id').html()));      //ajax call for right swipe
                }

                $('.btn-no').click(function () {
                    sellEvent();
                })

                function set_slidedistance(){
                    if(window.innerWidth <= 500){
                            slidedistance=150;
                    }else{
                        slidedistance=300;
                    }
                }
            $(document).ready(function(){
                $(window).resize(function(){
                   set_slidedistance();
                });
                set_slidedistance();
                countDown();                              //to display fpt or end date immidiately for first prediction
                if (check_null(user_id)==false) {
                    game_player_limit();        //to check if max player limit has been reached to its level for game
                }

                /*if (show_rewards==true) {                   //to display rewards popup
                    $('#rulesrewards').on('shown.bs.modal', function (e) {
                        $('.modal-backdrop').css('background-color','black');
                    })
                    $('#rulesrewards').on('hidden.bs.modal', function (e) {
                        $('.modal-backdrop').css('background-color','#fff');
                    })
                    $('#rulesrewards').modal('show');
                }*/

                // $('.predectionButtons').removeClass('d-none');      //display Yes/Skip/Share buttons on document load
            })

            setInterval(function() {
                type = 'fpt';
                currentPrice_countDown(type);
                countDown();                              //to display fpt or end date in 1 second of interval for first prediction 
            }, 1000);
    
            setInterval(function () {
                type = 'price';
               currentPrice_countDown(type);              //function for displaying current price
            }, 5000);


            function swipe_prediction(swipe_type,event_type,parent,currentCardId){
                    for (var i in predictionIds) {
                        if (predictionIds[i].id == currentCardId) {
                            predictionIds[i].is_log_called = "1";
                        }
                    }
                    // console.log(swipe_type);
                    $('.btn-yes').attr('disabled', true);
                    $('.btn-no').attr('disabled', true);
                    
                    if (check_null(user_id)==false) {
                        game_player_limit();        //to check if max player limit has been reached to its level for game
                    }
                    if (show_rewards_popup()==true) {                                   //to display rewards popup
                        $(parent).css('transform', 'translate(0px) rotate(0deg)');
                        $('#rulesrewards').on('shown.bs.modal', function (e) {
                            $('.modal-backdrop').css('background-color','black');
                        })
                        $('#rulesrewards').on('hidden.bs.modal', function (e) {
                            $('.modal-backdrop').css('background-color','#fff');
                        })
                        $('#rulesrewards').modal('show');

                        for (var i in predictionIds) {
                            if (predictionIds[i].id == currentCardId) {
                                predictionIds[i].is_log_called = "0";
                            }
                        }
                        return;
                    }
                    var game_id = $('#data-id-pred').attr('data-gameId');
                    var topic_id = $('#data-id-pred').attr('data-tipicId');
                    var offset = $('#data-id-pred').attr('data-offset-pred');
                    var current_prediction_id = $(parent).find('.pred-id').html();
                    var next_prediction_id = $(parent).next().find('.pred-id').html();
                    if (next_prediction_id!=null && typeof next_prediction_id!=='undefined' && next_prediction_id!='') {
                        var next_prediction_id = atob(next_prediction_id);
                    }else{
                        var next_prediction_id = '';
                    }
                    if (current_prediction_id!=null && typeof current_prediction_id!=='undefined' && current_prediction_id!='') {
                        var current_prediction_id = atob(current_prediction_id);
                    }else{
                        var current_prediction_id = '';
                    }

                    if (game_id==null || typeof game_id==='undefined' || game_id=='') {
                        location.reload();          //if unable to get game_id then reload page
                    }

                    $.ajax({
                        url: base_url + 'Predictions/prediction_action',
                        data: {game_id:game_id,topic_id:topic_id,current_prediction_id:current_prediction_id, next_prediction_id:next_prediction_id, swipe_type:swipe_type, offset:offset},
                        type: 'POST',
                        dataType: 'JSON',
                        
                        success: function (res, textStatus, jqXHR) {
                           // console.log(res);return;
                            if (res.action == 'view_the_game') {
                                view_the_game(res,swipe_type,event_type,parent,next_prediction_id,offset);    //process for users who just want to view the game
                            }else if(res.game_points_require=='yes'){
                                $('#reqGamePoints').modal('show');
                            }else{
                                if(res.status == 'failure'){
                                    if (res.errorShow=='modal' && res.reload=='no') {
                                        $('#modalText').html(res.message);
                                        $('#basicModal').modal('show');    
                                    }else if (res.errorShow=='modal' && res.reload=='yes') {
                                        $('#modalText').html(res.message);
                                        $('#basicModal').modal('show');
                                        setTimeout(function(){ 
                                            location.reload(); 
                                        }, 3000);    
                                    }else if(res.errorShow=='console' && res.reload=='no'){
                                        console.log(res.message);
                                    }else{
                                        location.reload();
                                    }
                                    $('.btn-yes').removeAttr('disabled');
                                    $('.btn-no').removeAttr('disabled');
                                }else if(res.status == 'success'){

                                    loadNextPrediction(res.load_prediction_data);    //to load next prediction

                                    if (next_prediction_id!=null && typeof next_prediction_id!=='undefined' && next_prediction_id!='') {
                                        // fpt_end_datetime_convert = moment(res.fpt_end_datetime).format('MM/DD/YYYY HH:mm:ss');
                                        // countDownDate = new Date(fpt_end_datetime_convert).getTime();
                                        countDownDate = moment(res.fpt_end_datetime).format('x');
                                        prediction_end_date = res.prediction_end_date;
                                        $(parent).next().find('.price').html(res.current_price);
                                    }

                                    if (event_type=='btn_event') {
                                        $(parent).addClass('btn-rotate-'+swipe_type).removeClass("visible first").next().addClass("visible first").removeClass('second').next().removeClass('third').addClass('second').next().addClass('third');
                                        if (res.available_points!=''&& res.available_points!=null && typeof res.available_points!=='undefined'){
                                            $('#availablePoints').html(res.available_points);
                                        }
                                        var card1 = $(".visible").length;
                                        var card2 = $(".second").length;
                                        var card3 = $(".third").length;
                                        if (card1==0 && card2==0 && card3==0) {
                                            $('.predectionButtons').addClass('d-none');
                                            setTimeout(function(){ 
                                                window.location.replace(base_url+"Predictions/summary/"+game_id); 
                                            }, 1000);
                                        }
                                    }else{
                                        $(parent).addClass('rotate-'+swipe_type).removeClass("visible first").next().addClass("visible first").removeClass('second').next().removeClass('third').addClass('second').next().addClass('third');
                                        if (res.available_points!=''&& res.available_points!=null && typeof res.available_points!=='undefined'){
                                            $('#availablePoints').html(res.available_points);
                                        }
                                        var card1 = $(".visible").length;
                                        var card2 = $(".second").length;
                                        var card3 = $(".third").length;
                                        if (card1==0 && card2==0 && card3==0) {
                                            $('.predectionButtons').addClass('d-none');
                                            setTimeout(function(){ 
                                                window.location.replace(base_url+"Predictions/summary/"+game_id); 
                                            }, 1000);
                                        }
                                    }
                                    $('.btn-yes').removeAttr('disabled');
                                    $('.btn-no').removeAttr('disabled');

                                    countDown();    //to display fpt or end date immidiately for next prediction
                                }
                            }
                          },
                          error: function (jqXHR, textStatus, errorThrown) { }
                    })
            }


            function loadNextPrediction(predictionData){
                // alert(predictionData);return;
                var card = "";
                // console.log(predictionData);
                if (predictionData!='' && predictionData!=null) {
                    // current_price = get_current_price(predictionData,currentDatetime);
                    current_price = predictionData.current_price;
                    round_current_price = Math.round(current_price);
                    card += "<div class='card-holder'>";
                    card += "<h6 class='pred-title'>"+predictionData.title+"</h6>";
                    card += "<div class='d-none pred-id' data-pred_id="+btoa(predictionData.id)+" >"+btoa(predictionData.id)+"</div>";
                    card += "<div class='predection-price-container'>";
                    card += "<h6 class='cur-val'>Current Value</h6>";
                    card += "<div class='cur-price  d-flex justify-content-center align-items-center'>";
                    // card += "<span><img src='"+base_url+"assets/img/card-coin.png' class='img-fluid float-left'></span>";
                    card += "<h5 class='mb-0 price'>"+round_current_price+"</h5>&nbsp;&nbsp;";
                    card += "<h6>Coins</h6>";
                    card += "</div>";
                    card += "</div>";         
                if (predictionData.agreed > 0 || predictionData.disagreed > 0){
                    possibility = get_possibility_percentage(predictionData);
                    card += "<div class='possibilityText "+possibility.fontClass+"'>"+possibility.textPossibility+"</div>";
                }
                    card += "<div class='predection-time mt-4'>";
                    card += "<div class='d-flex justify-content-center'>";
                    card += "<img src='"+base_url+"assets/img/reddot.svg'>";
                    card += "<p class='mb-0 time-title'></p>";
                    card += "</div>";
                    card += "<span class='time'></span>";
                    card += "</div>";
                    card += "</div>";
                    // console.log(card);return;
                    var new_card_obj = $(".card-animation-holder").append(card);
                    newly_added_card_obj = $(".card-animation-holder").find('[data-pred_id="'+btoa(predictionData.id)+'"]').closest('.card-holder');
//                    console.log({'the newly added element':new_card_obj,'element code': $(card),'newly_added_card_obj':newly_added_card_obj});
                    init_hammer(newly_added_card_obj);
                }else{
                    return false;
                }
            }


            function countDown(){
                var now = new Date().getTime();           // Get today's date and time
                var distance = countDownDate - now;       // Find the distance between now and the count down date

                // Time calculations for days, hours, minutes and seconds
                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                if (distance < 0) { 
                    $('.visible').find('.time-title').html('Prediction ends on: &nbsp;'); 
                    $('.visible').find('.time').html(prediction_end_date);
                    // $('.card-holder.visible').removeClass('fpt-stamp');
                }else{
                    $('.visible').find('.time-title').html('Fixed Price Ends in: &nbsp;');
                    $('.visible').find('.time').html(days + "d: " + hours + "h: " + minutes + "m: " + seconds + "s");
                    // $('.card-holder.visible').addClass('fpt-stamp');
                }
            }

            function currentPrice_countDown(type){
                var pred_id = $('.visible').find('.pred-id').html();
                
                if (pred_id!='' && pred_id != null) {
                    var pred_id = atob(pred_id);
                }else{
                    var pred_id = '';
                }

                $.ajax({
                    url: base_url + 'Predictions/get_predictions_data',
                    data: {prediction_id: pred_id, type:type},
                    type: 'POST',
                    dataType: 'JSON',
                    success: function (res, textStatus, jqXHR) { 
                        if (res.status=='success') {
                            if (type=='price') {
                                $('.visible').find('.price').html(res.prediction_price);
                            }else{
                                // first_prediction_fpt = moment(res.fpt_end_datetime).format('MM/DD/YYYY HH:mm:ss')
                                // countDownDate = new Date(first_prediction_fpt).getTime();
                                countDownDate = moment(res.fpt_end_datetime).format('x')
                                prediction_end_date = moment(res.end_date).format('DD MMM, YYYY');
                            }
                        }/*else{
                            console.log(res.status);
                        }*/
                      
                      // $('#current_price').html('');
                    },
                    error: function (jqXHR, textStatus, errorThrown) { }
                })
            }


        /*function get_current_price(prediction_data,current_datetime){

            // console.log(prediction_data);return;
            if (current_datetime >= prediction_data.start_date && current_datetime <= prediction_data.fpt_end_datetime){
                current_price = prediction_data.current_price;
            }else if (prediction_data.agreed=='0') {
                current_price = prediction_data.current_price;
            }else{
                current_price = prediction_data.current_price; 
            }
            return current_price;
        }*/

        /*loadfirsttime();


        function loadfirsttime(){
            $('#v-pills-rewards').tab('show');
        }*/


        $('#deductCoins').click(function(){
            $('#deductCoins').attr('disabled', true);
            var game_id = $('#data-id-pred').attr('data-gameId');
            if (req_game_points!='' && req_game_points!=null && typeof game_id!=='undefined' && game_id!=null && game_id!='') {
                $.ajax({
                    url: base_url + 'Predictions/deduct_coins',
                    data: {game_id: game_id,req_game_points:req_game_points},
                    type: 'POST',
                    dataType: 'JSON',
                    success: function (res, textStatus, jqXHR) { 
                        if (res.status=='success') {
                            $('#reqGamePoints').modal('hide');
                            // $('#modalText').html(res.message);
                            // $('#basicModal').modal('show');
                            // setTimeout(function(){ 
                                location.reload(); 
                            // }, 3000);
                        }else if (res.status=='failure' && res.type=='not_enough_coins'){
                            $('#deductCoins').attr('disabled', false);
                            $('#reqGamePoints').modal('hide');
                            $('#modalText').html(res.message);
                            $('#basicModal').modal('show');
                            setTimeout(function(){ 
                                window.location.href = base_url+ 'Subscriptions';
                            }, 3000);
                        }else{
                            $('#reqGamePoints').modal('hide');
                            $('#modalText').html(res.message);
                            $('#basicModal').modal('show');
                            setTimeout(function(){ 
                                location.reload(); 
                            }, 3000);
                        }
                        
                    },
                    error: function (jqXHR, textStatus, errorThrown) { }
                })

            }
        })

        function get_possibility_percentage(predictionData){
            data = [];
            if (predictionData.agreed>0) {
                TotalCount = parseInt(predictionData.agreed) + parseInt(predictionData.disagreed);
                total_percentage =  parseInt(predictionData.agreed) * 100 / TotalCount;
            }else{
                total_percentage = '0';
            }

            if (total_percentage <= 30) {
                data['textPossibility'] = 'Low Predictor Interest';
                data['fontClass'] = 'low-predect';
            }else if(total_percentage > 30 && total_percentage < 75){
                data['textPossibility'] = 'Moderate Predictor Interest';
                data['fontClass'] = 'mod-predect';
            }else{
                data['textPossibility'] = 'High Predictor Interest';
                data['fontClass'] = 'high-predect';
            }
            // console.log(data);return;
            return data;
        }

        /*$(document).on('click','#v-pills-leaderbsoard', function(){
            var game_id = $('#data-id-pred').attr('data-gameId');
                $.ajax({
                    url: base_url + 'Games/leaderboard',
                    data: {game_id: game_id},
                    type: 'POST',
                    dataType: 'JSON',
                    success: function (res, textStatus, jqXHR) { 
                        if (res.status=='success') {
                            
                        }else if (res.status=='failure' && res.message=='redirect_to_home'){
                            window.location.href = base_url;
                        }else{
                            console.log(res.message);
                        }
                        
                    },
                    error: function (jqXHR, textStatus, errorThrown) { }
                })
        })*/


       /* $('#v-pills-leaderboard').on('shown.bs.tab', function (e) {
            var game_id = $('#data-id-pred').attr('data-gameId');
                $.ajax({
                    url: base_url + 'Games/leaderboard',
                    data: {game_id: game_id},
                    type: 'POST',
                    dataType: 'JSON',
                    success: function (res, textStatus, jqXHR) { 
                        if (res.status=='success') {
                            create_leaderboard(res);
                        }else if (res.status=='failure' && res.message=='redirect_to_home'){
                            window.location.href = base_url;
                        }else if (res.status=='failure' && res.message=='redirect_to_login'){
                            window.location.href = base_url + 'Login?section=predictions&gid='+game_id;
                        }else if (res.status=='failure' && res.message=='empty_records'){
                            window.location.href = base_url+'Predictions/prediction_game/'+game_id;
                        }else{
                            console.log(res.message);
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) { }
                })
        })

        function create_leaderboard(res){
            $('#your_points').html(check_null(res.user_points));
            $('#your_rank').html('#'+check_null(res.user_rank));
            users_ranking = '';
            if (res.leaderboard_data!='') {
                singleRank = res.leaderboard_data.length==1 ? 'single-rank' : '';
                $.each(res.leaderboard_data, function (key, value) {
                    rank = '#'+parseInt(key + 1);
                    if (res.sess_user_id == value.user_id) {
                        self_rank_class = 'active';
                        self_position = 'YOU';
                    }else{
                        self_rank_class = '';
                        self_position = '';
                    }
                    users_ranking += '<div class="rankall '+self_rank_class+' '+singleRank+'">';
                    users_ranking += '<div class="w-15 pb">';
                    users_ranking += '<small>'+rank+'</small>';
                    users_ranking += '</div>';
                    users_ranking += '<div class="w-15 pb">';
                    users_ranking += '<img class="profilepic" src="'+null_image(value.image)+'" />';
                    users_ranking += '</div>';
                    users_ranking += '<div class="innerdiv w-70">';
                    users_ranking += '<span class="w-70 float-left">';
                    users_ranking += '<small>'+check_null(value.name)+'</small><br>';
                    users_ranking += '<small class="num">'+value.total_points+'</small>';
                    users_ranking += '</span>';
                    users_ranking += '<div class="w-30 float-right justify-content-center">';
                    users_ranking += '<small class="text-whites">'+self_position+'</small>';
                    users_ranking += '</div>';
                    users_ranking += '</div>';
                    users_ranking += '</div>';
                })
                // console.log(users_ranking);
                $("#users_ranking").html(users_ranking);
            }else{
                console.log('No records found');
            }
        }

        function check_null(string){
            if (string==null || string=='' || typeof string==='undefined') {
                return '0';
            }else{
                return string;
            }
        }
        function null_image(image){
            if (image==null || image=='' || typeof image==='undefined') {
                return base_url+'assets/img/profile_avatar.png';
            }else{
                return image;
            }
        }*/

        /*$('#v-pills-game-tab').on('shown.bs.tab', function (e) {
            if ((gamePoints == '' || gamePoints == null || typeof gamePoints === 'undefined')) {
                if ($('a[data-toggle="pill"].active').attr('id')!='v-pills-rewards') {
                  $('#reqGamePoints').modal('show');
                }
                if (session_active==true) {
                   $('#reqGamePoints').modal('show'); 
               }
            }
        })*/

       /*$('#rulesrewards').on('shown.bs.modal', function (e) {
            $('.modal-backdrop').css('background-color','black');
        })
        $('#rulesrewards').on('hidden.bs.modal', function (e) {
            $('.modal-backdrop').css('background-color','#fff');
        })
        // $('#rulesrewards').modal('show');*/
        $('.play_or_view_game').on('click', function (e) {
            $('.play_or_view_game').attr('disabled',true);
            if ($(this).attr('data-action-type')=='play_game') {
                $(this).find('small').text('Please Wait..');
            }
            var game_id = $('#data-id-pred').attr('data-gameId');
            var cookie_type = $(this).attr('data-action-type');
            if (cookie_type=='proceed_without_login' || cookie_type=='view_the_game') {
                $('.btn-yes').removeAttr('disabled');
                $('.btn-no').removeAttr('disabled');
                $('.play_or_view_game').removeAttr('disabled');
                $('#rulesrewards').modal('hide');
                showRewardsPopup = 'View the game';
            }else{
                $.ajax({
                    url: base_url + 'Predictions/set_rewards_cookie',
                    data: {game_id: game_id, cookie_type: cookie_type, req_game_points: req_game_points},
                    type: 'POST',
                    dataType: 'JSON',
                    success: function (res, textStatus, jqXHR) { 
                        if (res.status=='success') {
                            $('.btn-yes').removeAttr('disabled');
                            $('.btn-no').removeAttr('disabled');
                            $('#rulesrewards').modal('hide');
                            location.reload();
                        }else if(res.status=='failure'){
                            $('#modalText').html(res.message);
                            $('#basicModal').modal('show');
                            if (res.type=='not_enough_coins'){
                                setTimeout(function(){ 
                                    window.location.href = base_url+ 'Subscriptions';
                                }, 2000);
                            }else{
                                setTimeout(function(){ 
                                    location.reload();
                                }, 2000);
                            }   
                        }else{
                            $('#modalText').html('Something went wrong');
                            $('#basicModal').modal('show');
                            setTimeout(function(){ 
                                location.reload();
                            }, 2000);   
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) { }
                })
            }
        })

        function view_the_game(res,swipe_type,event_type,parent,next_prediction_id,offset){
            if(res.status == 'failure'){
                if (res.errorShow=='modal' && res.reload=='no') {
                    $('#modalText').html(res.message);
                    $('#basicModal').modal('show');    
                }if (res.errorShow=='modal' && res.reload=='yes') {
                    $('#modalText').html(res.message);
                    $('#basicModal').modal('show');
                    setTimeout(function(){ 
                        location.reload(); 
                    }, 3000);
                }else if(res.errorShow=='console' && res.reload=='no'){
                    console.log(res.message);
                }else{
                    location.reload();
                }
                $('.btn-yes').removeAttr('disabled');
                $('.btn-no').removeAttr('disabled');
            }else if(res.status == 'success'){

                loadNextPrediction(res.load_prediction_data);    //to load next prediction

                if (next_prediction_id!=null && typeof next_prediction_id!=='undefined' && next_prediction_id!='') {
                    // fpt_end_datetime_convert = moment(res.fpt_end_datetime).format('MM/DD/YYYY HH:mm:ss');
                    // countDownDate = new Date(fpt_end_datetime_convert).getTime();
                    countDownDate = moment(res.fpt_end_datetime).format('x');
                    prediction_end_date = res.prediction_end_date;
                    $(parent).next().find('.price').html(res.current_price);
                    var new_offset = parseInt(offset) + 1;          //set offset for next prediction
                    $('#data-id-pred').attr('data-offset-pred',new_offset);
                }

                if (event_type=='btn_event') {
                    $(parent).addClass('btn-rotate-'+swipe_type).removeClass("visible first").next().addClass("visible first").removeClass('second').next().removeClass('third').addClass('second').next().addClass('third');
                    
                    var card1 = $(".visible").length;
                    var card2 = $(".second").length;
                    var card3 = $(".third").length;
                    if (card1==0 && card2==0 && card3==0) {
                        $('.predectionButtons').addClass('d-none');
                        setTimeout(function(){ 
                            window.location.replace(base_url); 
                        }, 1000);
                    }
                }else{
                    $(parent).addClass('rotate-'+swipe_type).removeClass("visible first").next().addClass("visible first").removeClass('second').next().removeClass('third').addClass('second').next().addClass('third');
                    var card1 = $(".visible").length;
                    var card2 = $(".second").length;
                    var card3 = $(".third").length;
                    if (card1==0 && card2==0 && card3==0) {
                        $('.predectionButtons').addClass('d-none');
                        setTimeout(function(){ 
                            window.location.replace(base_url); 
                        }, 1000);
                    }
                }
                $('.btn-yes').removeAttr('disabled');
                $('.btn-no').removeAttr('disabled');

                countDown();    //to display fpt or end date immidiately for next prediction
            }
        }
        
        function show_rewards_popup(){
            if (check_null(user_id)==true && check_null(showRewardsPopup)==true) {
                return true;
            }else if (check_null(user_id)==false && check_null(showRewardsPopup)==true && check_null(play_game_cookie)==true) {
                return true;
            }else{
                return false;
            }
        }

        function check_null(string){
            if (string==null || string=='' || string==0 || typeof string==='undefined') {
                return true;
            }else{
                return false;
            }
        }

        function game_player_limit() {
            var game_id = $('#data-id-pred').attr('data-gameId');
            var game_player_count = $('#max_players').attr('data-gamePlayer-limit');
            
                $.ajax({
                    url: base_url + 'Games/check_game_player_limit',
                    data: {game_id: game_id, game_player_count: game_player_count},
                    type: 'POST',
                    dataType: 'JSON',
                    success: function (res, textStatus, jqXHR) {
                    // console.log(res);return; 
                        if (res.result==false) {
                            $('#max_players').modal('show');return;
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) { }
                })
        }
