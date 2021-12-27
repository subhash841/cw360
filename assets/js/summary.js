    $(document).on('click', '#loadMore', function (e) {

        game_id = $('#data-gameId').attr('data-gameId');
        offset = $(this).attr('data-offset');
        $.ajax({
            url: base_url + 'Games/get_executed_predictions',
            data: {game_id:game_id, offset:offset},
            type: 'POST',
            dataType: 'JSON', 
            success: function (res, textStatus, jqXHR) {
                // console.log(res);return;
                if (res.prediction_list!='' && res.prediction_list!=null) {
                    html = "";
                    $.each(res.prediction_list, function(key, val) { 
                        predictionInfo = predictionClassDetails(val);
                        current_pred_price = val.wrong_prediction=='1' ? '0' : val.current_price;
                        html += "<div class='predection pre-"+val.prediction_id+" row "+predictionInfo.className+"'>";
                        // html += "<div class='predection row bg-blue'>";                        
                        html += "<div class='main-title col-md-4 col-md-12 mb-3'>"+val.title+"</div>";
                        html += "<div class='c-price col border-right'>";
                        html += "<span class='title'>Current Value</span>";
                        html += "<b>"+current_pred_price+"</b><span></span>";
                        html += "</div>";
                        html += "<div class='c-profit col border-right'>";
                        html += "<span class='title'>Current Profit</span>";
                        html += "<b class='"+predictionInfo.price_fontColor+"'>"+predictionInfo.price_diff+"</b><span class='"+predictionInfo.price_fontColor+"'></span>";
                        html += "</div>";
                    if (val.swipe_status=='disagreed'){
                        html += "<div class='p-skipped col'>";
                        html += "<span class='title'>Skipped/<br>Predicted No</span>";
                        html += "</div>";
                    }else{
                        html += "<div class='p-price col'>";
                        html += "<span class='title'>Purchased Value</span>";
                        html += "<b>"+val.executed_points+"</b><span></span>";
                        html += "</div>";
                    }
                        html += "<div class='status'>";
                        if (predictionInfo.buttonName != 'Completed'){
                            html += '<button onclick="openpopup(\'' + predictionInfo.popup + '\',\'' + val.prediction_id + '\',\'' + val.game_id + '\',\'' + predictionInfo.condition + '\',\'' +val.created_date+ '\',\'' +res.change_prediction_time+ '\')">'+predictionInfo.buttonName+'</button>';                        
                        }else{
                            html += '<button>'+predictionInfo.buttonName+'</button>';
                        }
                        html += "</div>";
                        html += "<div class='col-12 pt-3 text-center end-date'>";
                        html += "<span class='font-weight-light'>Ends : </span>";
                        html += "<span class='font-weight-light'>"+moment(val.end_date).format('DD-MMM-YYYY hh:mm A')+"</span>";
                        html += "</div>";
                        html += "</div>";
                    })


                    $("#data-gameId").append(html);
                    offset = parseInt(offset) + 10;
                    $('#loadMore').attr('data-offset',offset);
                }else{
                    $('#loadMore').addClass('d-none');
                    return false;
                }
            }, error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR) 
            }
        })
    });



    function predictionClassDetails(prediction){

            if (prediction.agreed !=0) {
               
                
                if(prediction.fpt_end_datetime > prediction.current_dateTime){
                    //console.log('1')
                    var pre_current_price=parseInt(prediction.current_price);
                }else{
                    // console.log('1.2')
                    // console.log("(prediction.agreed"+prediction.agreed);
                    // console.log("(prediction.disagreed"+prediction.disagreed);
                    var pre_current_price = parseInt(prediction.agreed) / (parseInt(prediction.agreed) + parseInt(prediction.disagreed)) * 100;
                }
                // console.log('pre_current_price : '+pre_current_price );
                // console.log('prediction.current_dateTime : '+prediction.current_dateTime );
                // console.log('prediction.fpt_end_datetime : '+prediction.fpt_end_datetime );

               if(pre_current_price >100){
                //console.log('2')
                   var pre_current_price=100;
               }else if(pre_current_price > 0 && pre_current_price < 1){
                //console.log('4')
                   var pre_current_price=1;
               }else{
                //console.log('5')
                   var pre_current_price=pre_current_price;
               }
            }else{
                var pre_current_price=parseInt(prediction.current_price);
            }
            
            //console.log('pre_current_price 1nd time : '+pre_current_price );
            var pre_current_price = pre_current_price.toFixed(2);
            // console.log('pre_current_price 2nd time : '+pre_current_price );
            // console.log('executed_points : '+parseInt(prediction.executed_points));
            // console.log('executed_points : '+prediction.executed_points);

        price_diff = prediction.swipe_status =='disagreed' || prediction.wrong_prediction =='1' ? 0 : pre_current_price - prediction.executed_points;
        
        price_fontColor = price_diff<0 ? 'text-danger' : '';
        
        buttonName =  new Date(prediction.end_date)<new Date() ? 'Completed' : (prediction.swipe_status =='agreed' ? 'Change to No' : 'Change to YES');
        
        className =  new Date(prediction.end_date)<new Date() ? 'border-green' : (prediction.swipe_status =='disagreed' ? 'bg-blue' : '');
        
        popup =  new Date(prediction.end_date)<new Date() ? 'Completed' : (prediction.swipe_status =='agreed' ? 'Are You Sure You Want To Change The Prediction To No ? ' : 'Are You Sure You Want To Change The Prediction To Yes ?');
               
        condition =  new Date(prediction.end_date)<new Date() ? 'Completed' : (prediction.swipe_status =='agreed' ? 'No' : 'Yes');

        var result = [];
        //console.log(pre_current_price+"final pre_current_price");
        // console.log(Number.parseFloat(price_diff).toFixed(2));
        // console.log(price_diff.toFixed(2));
        // return;
        // var diff =parseInt(price_diff);
        var diff =price_diff.toFixed(2);
       // console.log(diff+"final diff");

        result['price_diff'] = isNaN(diff) ? 0 : diff; 
        result['price_fontColor'] = price_fontColor; 
        result['buttonName'] = buttonName; 
        result['className'] = className;
        result['popup'] = popup;
        result['condition'] = condition;
        result['current_price'] = pre_current_price;
        return result;
    }


$(document).on('click','#btn_yes',function(){
    $('.btn-yes').attr('disabled', true);
    var id=$("#contentpre_id").val();
    // console.log('sudhir');
    var parent = $('.pre-'+id);

    var game_id=$("#contentGameId").val();
    var condition=$("#contentcondition").val();
    var dateTime=$("#contentdateTime").val();
    var change_prediction_time=$("#change_prediction_time").val();
    if (change_prediction_time==1) {
        time_msg = 'Wait until '+change_prediction_time+' minute get over!';
    }else{
        time_msg = 'Wait until '+change_prediction_time+' minutes get over!';
    }
    // console.log(change_prediction_time);
    var today = new Date();
    // var skip_pred_time = new Date(dateTime);
    var skip_pred_time = moment(dateTime).format('MM/DD/YYYY HH:mm:ss');
    var diff = Math.abs(new Date(today) - new Date(skip_pred_time));
    var minutes = Math.abs((diff/1000)/60);
    // alert("today "+today+" skip_pred_time "+skip_pred_time + " diff "+diff + " minutes " +minutes);
    // alert(condition);
    // return;
    if(minutes > change_prediction_time){
        $.ajax({
                url: base_url + "games/summary_chanages_predictions",
                type: "POST",
                dataType: "json",
                data: {
                    id: id,
                    game_id:game_id,
                    condition:condition
                },
                success: function (data, textStatus, jqXHR) {
                    //console.log(data);
                    if(data=='end'){
                        $('.btn-yes').removeAttr('disabled'); 
                        $('#summaryModal').modal('hide');
                        $("#modalText").html('Sorry! This prediction has been ended or not available now.');
                        $('#basicModal').modal('show');
                        setTimeout(function(){ 
                            location.reload(); 
                        }, 3000);   
                     }/*else if(minutes <= 10){
                        $('#summaryModal').modal('hide');
                        $("#modalText").html('Wait until 10 minutes get over!');
                        $('#basicModal').modal('show');
                    }*/else if(data=='error'){
                        $('.btn-yes').removeAttr('disabled'); 
                        // location.reload();
                        console.log(data);   
                    }else if(data==false){  
                    $('.btn-yes').removeAttr('disabled');                   
                        $("#insufficientPoints").modal('show');
                    }else if(data=='exists_prediction'){  
                        $('.btn-yes').removeAttr('disabled');                   
                        $("#summaryModal").modal('hide');
                    }else{
                        // alert(data);
                            // console.log(data);  
                            $('#summaryModal').modal('hide');
                            $(".avlb-points").html(data.points)
                            predictionInfo = predictionClassDetails(data);
                            // console.log(predictionInfo);
                            parent.find('.c-price').children('b').html(predictionInfo.current_price);
                            parent.find('.c-profit').children('b').html(predictionInfo.price_diff);
                            if(data.swipe_status=="disagreed"){

                                parent.find('.p-price').removeClass('p-price').addClass('p-skipped').html('<span class="title">Skipped/<br>Predicted No</span>');

                                 parent.find('.c-price').children('b').removeClass('text-danger');
                                 $(parent).removeClass('bg-blue');
                    
                            }else{

                                //console.log(predictionInfo);  
                                parent.find('.p-skipped').addClass('p-price').removeClass('p-skipped').html('<span class="title">Purchased Value</span><b>'+data.executed_points+'</b><span></span>');
                                parent.removeClass('bg-blue').addClass(predictionInfo.className);
                                }
                            parent.find('button').attr('onclick','openpopup(\'' + predictionInfo.popup + '\',\'' + data.prediction_id + '\',\'' + data.game_id + '\',\'' + predictionInfo.condition + '\',\'' +data.created_date+ '\',\'' +parseInt(data.change_prediction_time)+ '\')' );
                               
                            parent.find('button').html(predictionInfo.buttonName);

                            // console.log(parent.find('.c-profit').children('b').html(predictionInfo.price_diff));
                            parent.addClass(predictionInfo.className);
                                $('.btn-yes').removeAttr('disabled'); 
                    }
                                               
                        
                },

            });
    }else{
         $('.btn-yes').removeAttr('disabled');         
        $('#summaryModal').modal('hide');
        $("#modalText").html(time_msg);
        $('#basicModal').modal('show');
            
    }
    
    
});