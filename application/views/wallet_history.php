<div class="container-fluid">
    <div class="row ">
        <div class="col-md-8 theme-padding main-height">
            <div id="wallet_history">
                



            <div class="user-wallet-history">
                <div>
                    <h4 class="mt-4">Wallet History</h4>
                    <div class="py-3">
                        <div class="wallet-point-bg border-radius-15 text-center text-white py-4">
                            <h6>Available Coins</h6>
                            <h3 class="mb-0"><img src="<?= base_url(); ?>assets/img/coin.png" width="21px" class="img-fluid"> <?= get_User_Coins(); ?></h3>
                        </div>
                    </div>        
                    <!-- wallet list start here  -->
                    <div>
                        <div class="mt-2 mb-3 px-0 py-2">
                            <div class="sub-history-list">
                               <?php
                                function get_title($package_name,$quiz_name,$game_name,$type,$coins){
                                    if($type == '0'){
                                        return array('title'=>'Free initial game coins','type'=>'Admin','class'=>'text-greencolor','coins'=>'+'.$coins);
                                    }else if($type == '1'){
                                        return array('title'=>$package_name,'type'=>'subscription','class'=>'text-greencolor','coins'=>'+'.$coins);
                                    }else if($type == '2'){
                                        return array('title'=>'Gift game coins','type'=>'Gift','class'=>'text-greencolor','coins'=>'+'.$coins);
                                    }else if($type == '3'){
                                        return array('title'=>$game_name,'type'=>'Require game coins','class'=>'text-red','coins'=>'-'.$coins);
                                    }else if($type == '4'){
                                        return array('title'=>'Deducted coins','type'=>'Deduction admin','class'=>'text-red','coins'=>'-'.$coins);
                                    }else if($type == '5'){
                                        return array('title'=>'You Won '.$quiz_name,'type'=>'Quiz right ans','class'=>'text-greencolor','coins'=>'+'.$coins);
                                    }else if($type == '6'){
                                        return array('title'=>'You Lost '.$quiz_name,'type'=>'Quiz wrong ans','class'=>'text-red','coins'=>'-'.$coins);
                                    }else if($type == '7'){
                                        return array('title'=>'Coins redeemed','type'=>'On','class'=>'text-red','coins'=>'-'.$coins);
                                    }else if($type == '9'){
                                        return array('title'=>$game_name,'type'=>'Transfer Wallet Coins to Game Coins','class'=>'text-red','coins'=>'-'.$coins);
                                    }else{
                                        return array('title'=>'Coins','type'=>'','class'=>'','coins'=>$coins);
                                    }
                                    
                                    // else if(empty($quiz_name) && empty($game_name) ){
                                    //     return array('title'=>$predection_title,'type'=>'Predection','class'=>'','coins'=>$coins);
                                    // }else if(empty($game_name) && empty($predection_title)){
                                    //     return array('title'=>$quiz_name,'type'=>'Quiz','class'=>'','coins'=>$coins);
                                    // }else{
                                    //     return array('title'=>$game_name,'type'=>'Game','class'=>'','coins'=>$coins);
                                    // }
                                }

                               if(!empty($wallet_history)){
                                    foreach($wallet_history as $key => $value){
                                        $data = get_title($value['package_name'],$value['quiz_name'],$value['game_name'],$value['type'], $value['coins'])
                                    ?>
                                    <div class="row mx-0 mb-3 py-3 px-2 theme-bg border-15 border-15">
                                        <div class="col-8">
                                            <h6 class="fs09"><?= $data['title']; ?></h6>
                                            <h6 class="fs08 cw-text-color-gray mb-0"><?= $data['type']?> . <?= $value['date']?></h6>
                                        </div>
                                        <div class="col-4">
                                            <h6 class="text-right <?= $data['class']?> font-weight-normal"><?= $data['coins']?></h6>
                                        </div>
                                    </div>

                                    <?php 
                                }
                               }else{
                                   echo 'No History Available ';
                               }
                               ?>
                               
                                
            
                                <!-- <div class="row mx-0 mb-3 py-3 px-2 theme-bg border-15">
                                    <div class="col-8">
                                        <h6 class="fs09">You won the World Cup prediction game.</h6>
                                        <h6 class="fs08 cw-text-color-gray mb-0">Game . 16 July 2019</h6>
                                    </div>
                                    <div class="col-4">
                                        <h6 class="text-right text-red font-weight-normal">- 20000</h6>
                                    </div>
                                </div> -->
            
                                
            
                            </div>

                            <?php 
                                if(count($wallet_history) > 18){
                                    echo '<div class="text-center"><button class="btn btn-danger load-wallet-history" data-offset="20" >Load more</button></div>';
                                }
                            ?>

                        </div>
                    <!-- wallet list end here  -->
                </div>
            </div>
            </div>

            </div>
        </div>
        <!--right side game start-->
        <div class="col-md-4 theme-bg border-15 theme-padding main-height">
            <div class="predection-list">
                <h3 class="title">Explore More</h3>

                <div class="data-container">
                    <ul class="nav nav-pills mb-3" id="predection-list-menu" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home"
                               role="tab" aria-controls="pills-home" aria-selected="true">Games</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                             aria-labelledby="pills-home-tab">
                                 <?php
                                 if (!empty($sidebar_games)) {
                                     foreach ($sidebar_games as $key => $value) {
                                         ?>

                                    <a href="<?= base_url('Predictions/prediction_game/' . $value['id']) ?>" class="card prediction-card text-decoration-none mb-5">
                                        <!-- <div class="banner-img" style="background-image:url(<?= $value['image'] ?>)"></div> -->
                                        <div class="card-body">
                                            <button class="btn play-btn" style="bottom:-17px;top:unset;right:18px;">
                                                Play Now
                                            </button>
                                            <h6 class="title">
                                                <?= $value['title'] ?>
                                            </h6>
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <img src="<?= base_url(); ?>assets/img/clock.svg">
                                                        <span class="font-weight-light ml-1"><span
                                                                class="font-weight-normal">
                                                                <?= $value['end_date'] ?></span></span>
                                                </div>
                                                <!-- <img src="<?= base_url(); ?>assets/img/share.svg"> -->
                                            </div>
                                        </div>
                                    </a>

                                    <?php
                                }
                            } else {
                                echo 'No Games available';
                            }
                            if (!empty($sidebar_games) && count($sidebar_games) > 2) {

                                echo '<center><button id="sidegames" class="btn btn-danger mt-2 mb-5" data-offset=' . get_right_side_game_limit() . '>Load more</button></center>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--right side game end-->
    </div>
</div>



<!-- <script src="<?= base_url() ?>assets/js/quiz.js"></script> -->
<script>

    $(function () {

        $('.load-wallet-history').on('click',function(){
            var main_offset = parseInt(20);
            var offset = parseInt($(this).attr('data-offset'));
            $(this).attr('data-offset', offset + main_offset);
            $.ajax({
                url:base_url +"Wallet_history/get_history",
                type: "POST",
                dataType: 'JSON',
                data: {offset: offset},
            }).done(function(e){
                console.log(e);
                if(e.data){
                    add_histrory(e.data);
                }else{
                    console.log('else');
                    $('.load-wallet-history').hide();
                }
            })
        })

        $('#sidegames').click(function () {
            var main_offset = parseInt('<?= get_right_side_game_limit() ?>');
            var offset = $(this).data('offset');
            $(this).data('offset', offset + main_offset)
            $.ajax({
                url: "<?= base_url('Wallet_history/load_games'); ?>",
                type: "POST",
                dataType: 'JSON',
                data: {offset: offset},
                success: function (data) {
                    console.log(data.length);
                    if (data.length == 0 || data.length < main_offset ) {
                        $('#sidegames').hide();
                    } 
                    if(data.length != 0){
                        add_game('sidegames', data);
                    }
                }
            });
        });
    });
    function add_game(selector, data) {
        var div = '';
        $.each(data, function (key, value) {
            div += '<a href="'+base_url+'Predictions/prediction_game/'+value.id+'" class="card prediction-card text-decoration-none mb-5">';
            // div += '<div class="banner-img" style="background-image:url(' + value.image + ')"></div>';
            div += '<div class="card-body" >';
            div += '<button class="btn play-btn" style="bottom:-17px;top:unset;right:18px;">';
            div += 'Play Now';
            div += '</button>';
            div += '<h6 class="title text-left" >';
            div += value.title;
            div += '</h6>';
            div += '<div class="d-flex justify-content-between" >';
            div += '<div >';
            div += '<img src="' + base_url + 'assets/img/clock.svg" >';
            div += '<span class= "font-weight-light ml-1" ><span';
            div += 'class="font-weight-normal" >';
            div += value.end_date + "</span></span>";
            // div += '"+value.end_date+" < /span></span >';
            div += '</div>';
            // div += '<img src="' + base_url + 'assets/img/share.svg" >';
            div += '</div>';
            div += '</div>';
            div += '</a>';
        });
        $('#' + selector).before(div);
    }

    function add_histrory(data){
        var div = '';
        
        $(data).each(function(key, value){
            var data = get_title(value.package_name,value.quiz_name,value.game_name,value.type,value.coins);
            div +='<div class="row mx-0 mb-3 py-3 px-2 theme-bg border-15">';
            div +='<div class="col-8">';
            div +='<h6 class="fs09">'+data.title+'</h6>';
            div +='<h6 class="fs08 cw-text-color-gray mb-0">'+data.type+' . ' +value.date+'</h6>';
            div +='</div>';
            div +='<div class="col-4">';
            div +='<h6 class="text-right '+data.class+' font-weight-normal">'+data.coins+'</h6>';
            div +='</div>';
            div +='</div>';
        });
        $('.sub-history-list').append(div);
    }
   
    function get_title($package_name,$quiz_name,$game_name,$type,$coins) {
        if($type == '0'){
            return {'title':'free initial game coins','type':'Admin','class':'text-greencolor','coins':'+'+$coins} ;
        }else if($type == '1'){
            return {'title':$package_name,'type':'subscription','class':'text-greencolor','coins':'+'+$coins} ;
        }else if($type == '2'){
            return {'title':'Gift game coins','type':'Gift','class':'text-greencolor','coins':'+'+$coins} ;
        }else if($type == '3'){
            return {'title':$game_name,'type':'Require game coins','class':'text-red','coins':'-'+$coins} ;
        }else if($type == '4'){
            return {'title':'Deducted coins','type':'Deduction admin','class':'text-red','coins':'-'+$coins} ;
        }else if($type == '5'){
            return {'title':$quiz_name,'type':'Quiz right ans','class':'text-greencolor','coins':'+'+$coins} ;
        }else if($type == '6'){
            return {'title':$quiz_name,'type':'Quiz wrong ans','class':'text-red','coins':'-'+$coins} ;
        }else if($type == '7'){
            return {'title':'Coins redeemed','type':'On','class':'text-red','coins':'-'+$coins} ;
        }else{
            return {'title':'Coins','type':'','class':'','coins':$coins} ;
        }
        // else if($quiz_name == null && $game_name == null ){
        //     return {'title':$predection_title,'type':'Predection','class':'','coins':$coins} ;
        // }else if($game_name == null && $predection_title==null ){
        //     return {'title':$quiz_name,'type':'Quiz','class':'','coins':$coins} ;
        // }else{
        //     return {'title':$game_name,'type':'Game','class':'','coins':$coins} ;
        // }
    }
</script>
