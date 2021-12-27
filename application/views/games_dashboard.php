<div class="container-fluid">
    <div class="row ">
        <div class="col-md-8 theme-padding main-height">
            <div id="game_dashboard">
                <div class="user-wallet-history">
                    <div>
                        <h4 class="mt-4">Game Dashboard</h4>
                        <div class="row">
                <div class="col-12 py-3">
                    <h6 class="mb-2 font-weight-500 text-uppercase">Active Games</h6>
                </div>
                <?php 
                    if(empty($active_game_data)){ ?>
                                       <!--empty infographics strat end-->
                                        <div class="col-md-12 gamedashboardcard mb-4">
                                <div class="no-games text-center my-5 pt-3">
                                    <h5 class="font-weight-bold cw-text-color-gray">
                                        No Active Games Available
                                    </h5>
                                    <img class="img-fluid my-5" src="<?= base_url(); ?>assets/img/no-prediction-games.svg">
                                    
                                </div>
                                </div>
                                <!--empty infographics  end-->
                        <?php }else{
                    foreach($active_game_data as $key =>$value){                
                    ?>
                <div class="col-md-6 gamedashboardcard mb-4">
                    <div class="border shadow radious15 p-1">
                  <a href="<?php echo base_url() ?>Predictions/prediction_game/<?= $value['id'] ?>" class="no-hover">
                        <div class="img-fluid radious15 mb-4 w-100 h-278" style="background-image:url(<?= $value['image'] ?>);background-size: cover;background-position: center center;" title="<?= empty ( @$value['title'] ) ? 'active_game_data' : @$value['title']; ?>"
>
                        </div>
                    </a>    
                        <div class="px-3">
                            <h5 style="min-height: 42px;">
                                <a href="<?php echo base_url() ?>Predictions/prediction_game/<?= $value['id'] ?>" class="no-hover">
                                <?=$value['title']?></a></h5>
                            <h6 class="dateEnds">Ends : <?= $value['endDate'];?></h6>
                        </div>
                        <div class="d-flex justify-content-between mx-n1 align-items-center my-3">
                            <div class="pl-3 ml-1">
                                <img class="img-fluid" src="<?php echo base_url() ?>/assets/img/trophy.png">
                                <h6 class="d-inline font-weight-normal ml-1">Rank <?=$value['user_rank']?></h6>
                            </div>
                            <div class="py-2 <?=$value['game_status_class']?>"><?php if($value['game_status']=="Completed"){ ?><img src="assets/img/gray-circle-tick.png"><span class="ml-3"><?=$value['game_status']?></span><?php }else{ echo $value['game_status']; }?></div>
                        </div>
                        <div class="d-flex justify-content-between p-3">
                            <div class="col pl-0 ">
                                <p class="smallBold">Portfolio</p>
                                <h5><?=$value['user_points']?> <small class="font-weight-bold">Coins</small></h5>
                            </div>
                            <div class="col px-0 pl-4 border-left">
                                <p class="smallBold">Available</p>
                                <h5><?=$value['available_points']?> <small class="font-weight-bold">Coins</small></h5>
                            </div>
                        </div>
                        <div class="text-center twosize <?= $value['current_profit'] < '0' ? 'text-danger' : ''?>"><span class="font-weight-bold fontsize20">Profit : <?=$value['current_profit']?></span> <span>Coins</span></div>
                        <div class="twoDivMerge mx-1 position-relative p-2 mt-3">
                            <div class="updiv">
                                <div class="inside-updiv text-center">
                                    <div>TOTAL PREDICTIONS : <?=$value['total_predictions']?></div>
                                </div>
                            </div>
                            <div class="downdiv">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <p class="text-red mb-1 font-14">Not Swiped</p>
                                        <p class="text-red font-weight-bold mb-0 h5"><?=$value['not_swipped']?></p>
                                    </div>
                                    <div>
                                        <p class="mb-1 font-14">Yes</p>
                                        <p class="font-weight-bold mb-0 h5"><?=$value['count_agreed']?></p>
                                    </div>
                                    <div>
                                        <p class="mb-1 font-14">No/Skip</p>
                                        <p class="font-weight-bold mb-0 h5"><?=$value['count_disagreed']?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>

                <?php } }?>
                
                <div class="col-12 py-3">
                    <h6 class="mb-2 font-weight-500 text-uppercase">Completed Games</h6>
                </div>
                
                <?php 
                    if(empty($completed_game_data)){ ?>
                                       <!--empty infographics strat end-->
                                        <div class="col-md-12 gamedashboardcard mb-4">
                                <div class="no-games text-center my-5 pt-3">
                                    <h5 class="font-weight-bold cw-text-color-gray">
                                        No Completed Games Available
                                    </h5>
                                    <img class="img-fluid my-5" src="<?= base_url(); ?>assets/img/no-prediction-games.svg">
                                    
                                </div>
                                </div>
                                <!--empty infographics  end-->
                        <?php }else{ 
                    foreach($completed_game_data as $key =>$value){ 
                    ?>
                <div class="col-md-6 gamedashboardcard mb-4">
                    <div class="border shadow radious15 p-1">
                  <a href="<?php echo base_url() ?>Predictions/prediction_game/<?= $value['id'] ?>" class="no-hover">
                        <img class="img-fluid radious15 mb-4 w-100 h-278" style="background-image:url(<?= $value['image'] ?>);background-size: cover;background-position: center center;" title="<?= empty ( @$value['title'] ) ? 'completed_game_data' : @$value['title']; ?>"
>
                        <div class="px-3">
                        </a>
                            <h5>
                                <a href="<?php echo base_url() ?>Predictions/prediction_game/<?= $value['id'] ?>" class="no-hover">
                                <?=$value['title']?></a></h5>
                            <h6 class="dateEnds">Ends : <?= $value['endDate'];?></h6>
                        </div>
                        <div class="d-flex justify-content-between mx-n1 align-items-center my-3">
                            <div class="pl-3 ml-1">
                                <img class="img-fluid" src="<?= base_url()?>/assets/img/trophy.png">
                                <h6 class="d-inline font-weight-normal ml-1">Rank <?=$value['user_rank']?></h6>
                            </div>
                            <div class="py-2 <?=$value['game_status_class']?>"><?php if($value['game_status']=="Completed"){ ?><img src="assets/img/gray-circle-tick.png"><span class="ml-3"><?=$value['game_status']?></span><?php }else{ echo $value['game_status']; }?></div>
                        </div>
                        <div class="d-flex justify-content-between p-3">
                            <div class="col pl-0 ">
                                <p class="smallBold">Portfolio</p>
                                <h5><?=$value['user_points']?> <small class="font-weight-bold">Coins</small></h5>
                            </div>
                            <div class="col px-0 pl-4 border-left">
                                <p class="smallBold">Available</p>
                                <h5><?=$value['available_points']?> <small class="font-weight-bold">Coins</small></h5>
                            </div>
                        </div>
                        <div class="text-center twosize <?= $value['current_profit'] < '0' ? 'text-danger' : ''?>"><span class="font-weight-bold fontsize20">Profit : <?=$value['current_profit']?></span> <span>Coins</span></div>
                        <div class="twoDivMerge mx-1 position-relative p-2 mt-3">
                            <div class="updiv">
                                <div class="inside-updiv text-center">
                                    <div>TOTAL PREDICTIONS : <?=$value['total_predictions']?></div>
                                </div>
                            </div>
                            <div class="downdiv">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <p class="text-red mb-1 font-14">Not Swiped</p>
                                        <p class="text-red font-weight-bold mb-0 h5"><?=$value['not_swipped']?></p>
                                    </div>
                                    <div>
                                        <p class="mb-1 font-14">Yes</p>
                                        <p class="font-weight-bold mb-0 h5"><?=$value['count_agreed']?></p>
                                    </div>
                                    <div>
                                        <p class="mb-1 font-14">No/Skip</p>
                                        <p class="font-weight-bold mb-0 h5"><?=$value['count_disagreed']?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>                    
                </div>
                <?php } } ?>
                
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
                               role="tab" aria-controls="pills-home" aria-selected="true">Quiz</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-blogs-tab" data-toggle="pill" href="#pills-blogs"
                               role="tab" aria-controls="pills-blogs" aria-selected="false">Blogs</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                             aria-labelledby="pills-home-tab">
                                 <?php
                            if (!empty($sidebar_quiz)) {
                                     foreach ($sidebar_quiz as $key => $value) {
                                         ?>

                                    <a href="<?= base_url('quiz/instruction/' .base64_encode($value['quiz_id']).'?topic_id='.base64_encode($value['topic_id'])) ?>" class="card prediction-card text-decoration-none mb-5">
                                        <!-- <div class="banner-img" style="background-image:url(<?= $value['image'] ?>)" title="<?= empty ( @$value['name'] ) ? 'sidebar_quiz' : @$value['name']; ?>"></div> -->
                                        <div class="card-body">
                                            <button class="btn play-btn" style="bottom:-17px;top:unset;right:18px;">
                                                Play Now
                                            </button>
                                            <h6 class="title">
                                                <?= $value['name'] ?>
                                            </h6>
                                            <div class="d-flex justify-content-between">
                                        
                                                <!-- <img src="<?= base_url(); ?>assets/img/share.svg"> -->
                                            </div>
                                        </div>
                                    </a>

                                    <?php
                                }
                            } else {
                                echo 'No Quiz available';
                            }
                            
                        if (!empty($sidebar_quiz) && count($sidebar_quiz) > 5) {
                                                        
                            echo '<center><button id="sidequiz" class="btn btn-danger mt-2 mb-5" data-offset=' . sidebar_card_limit() . '>Load more</button></center>';
                        }
                            ?>
                        </div>
                        <div class="tab-pane fade" id="pills-blogs" role="tabpanel"
                             aria-labelledby="pills-blogs-tab">
                             <?php
                                 if (!empty($sidebar_blogs)) {
                                     foreach ($sidebar_blogs as $key => $value) {
                                         ?>

                                  <!--   <a href="<?= base_url('blog/'. $value['id'].'/'.rtrim(preg_replace('/[^a-zA-Z0-9]+/', '-', $value['title']),'-').'/') ?>" class="card prediction-card text-decoration-none mb-5"> -->
                                    <a href="<?= base_url('blog/detail/'. $value['id']) ?>" class="card prediction-card text-decoration-none mb-5">
                                        <!-- <div class="banner-img" style="background-image:url(<?= $value['image'] ?>)" title="<?= empty ( @$value['title'] ) ? 'blog_img' : @$value['title']; ?>"></div> -->
                                        <div class="card-body" >
                                            <h6 class="title">
                                                <?= $value['title'] ?>
                                            </h6>
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <img src="<?= base_url(); ?>assets/img/calendar.svg">
                                                        <span class="font-weight-light ml-1"><span
                                                                class="font-weight-normal">
                                                                <?= $value['created_date']; ?></span></span>
                                                </div>
                                                <!-- <img src="<?php //= base_url(); ?>assets/img/share.svg"> -->
                                            </div>
                                        </div>
                                    </a>

                                    <?php
                                }
                            } else {
                                echo 'No Blogs available';
                            }
                            if (!empty($sidebar_blogs) && count($sidebar_blogs) > 5) {

                                echo '<center><button id="sideblog" class="btn btn-danger mt-2 mb-5" data-offset=' . sidebar_card_limit() . '>Load more</button></center>';
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

        $('.load-wallet-history').on('click', function () {
            var main_offset = parseInt(20);
            var offset = parseInt($(this).attr('data-offset'));
            $(this).attr('data-offset', offset + main_offset);
            $.ajax({
                url: base_url + "Wallet_history/get_history",
                type: "POST",
                dataType: 'JSON',
                data: {offset: offset},
            }).done(function (e) {
                console.log(e);
                if (e.data) {
                    add_histrory(e.data);
                } else {
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
                    if (data.length == 0 || data.length < main_offset) {
                        $('#sidegames').hide();
                    }
                    if (data.length != 0) {
                        add_game('sidegames', data);
                    }
                }
            });
        });
    });
    function add_game(selector, data) {
        var div = '';
        $.each(data, function (key, value) {
            div += '<a href="' + base_url + 'Predictions/prediction_game/' + value.id + '" class="card prediction-card text-decoration-none">';
            div += '<div class="banner-img" style="background-image:url(' + value.image + ')" title="'+value.title+'"></div>';
            div += '<div class="card-body" >';
            div += '<button class="btn play-btn">';
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

    function add_histrory(data) {
        var div = '';

        $(data).each(function (key, value) {
            var data = get_title(value.package_name, value.quiz_name, value.game_name, value.type, value.coins);
            div += '<div class="row mx-0 mb-3 py-3 px-2 theme-bg border-15">';
            div += '<div class="col-8">';
            div += '<h6 class="fs09">' + data.title + '</h6>';
            div += '<h6 class="fs08 cw-text-color-gray mb-0">' + data.type + ' . ' + value.date + '</h6>';
            div += '</div>';
            div += '<div class="col-4">';
            div += '<h6 class="text-right ' + data.class + ' font-weight-normal">' + data.coins + '</h6>';
            div += '</div>';
            div += '</div>';
        });
        $('.sub-history-list').append(div);
    }

    function get_title($package_name, $quiz_name, $game_name, $type, $coins) {
        if ($type == '0') {
            return {'title': 'free initial game coins', 'type': 'Admin', 'class': 'text-greencolor', 'coins': '+'.$coins};
        } else if ($type == '1') {
            return {'title': $package_name, 'type': 'subscription', 'class': 'text-greencolor', 'coins': '+'.$coins};
        } else if ($type == '2') {
            return {'title': 'Gift game coins', 'type': 'Gift', 'class': 'text-greencolor', 'coins': '+'.$coins};
        } else if ($type == '3') {
            return {'title': $game_name, 'type': 'Require game coins', 'class': 'text-red', 'coins': '-' + $coins};
        } else if ($type == '4') {
            return {'title': 'Deducted coins', 'type': 'Deduction admin', 'class': 'text-red', 'coins': '-' + $coins};
        } else if ($type == '5') {
            return {'title': $quiz_name, 'type': 'Quiz right ans', 'class': 'text-greencolor', 'coins': '+'.$coins};
        } else if ($type == '6') {
            return {'title': $quiz_name, 'type': 'Quiz wrong ans', 'class': 'text-red', 'coins': '-' + $coins};
        } else if ($type == '7') {
            return {'title': 'Coins redeemed', 'type': 'On', 'class': 'text-red', 'coins': '-' + $coins};
        } else {
            return {'title': 'Coins', 'type': '', 'class': '', 'coins': $coins};
        }
        // else if($quiz_name == null && $game_name == null ){
        //     return {'title':$predection_title,'type':'Predection','class':'','coins':$coins} ;
        // }else if($game_name == null && $predection_title==null ){
        //     return {'title':$quiz_name,'type':'Quiz','class':'','coins':$coins} ;
        // }else{
        //     return {'title':$game_name,'type':'Game','class':'','coins':$coins} ;
        // }
    }
    
    $(function () {
        var topic_id = '';       
        $('#sidequiz').click(function () {
            var main_offset = parseInt('<?= sidebar_card_limit() ?>');
            var offset = $(this).data('offset');
            $(this).data('offset', offset + main_offset)
            $.ajax({
                url: "<?= base_url('Sidebar/load_quiz'); ?>",
                type: "POST",
                dataType: 'JSON',
                data: {offset: offset, topics: topic_id},
                success: function (data) {
                    //console.log(data);
                    if (data.length == 0 || data.length < main_offset ) {
                        $('#sidequiz').hide();
                    } 
                     if (data.length != 0) {
                        add_quiz_list('sidequiz', data);
                     }
                    
                }
            });
        });
    });
    function add_quiz_list(selector, data) {
        var div = '';
        $.each(data, function (key, value) {
            //console.log(value);
            div += '<a href="'+base_url+'quiz/instruction/'+btoa(value.quiz_id)+'?topic_id='+btoa(value.topic_id)+'" class="card prediction-card text-decoration-none mb-5">';
            // div += '<div class="banner-img" style="background-image:url(' + value.image + ')" title="'+value.name+'"></div>';
            div += '<div class="card-body" >';
            div += '<button class="btn play-btn" style="bottom:-17px;top:unset;right:18px;">';
            div += 'Play Now';
            div += '</button>';
            div += '<h6 class="title text-left" >';
            div += value.name;
            div += '</h6>'; 
            div += '</div>';
            div += '</a>';
        });
        $('#' + selector).before(div);
    }
    $('#sideblog').click(function () {
        var topic_id = '';
        var main_offset = parseInt('<?= sidebar_card_limit() ?>');
        var offset = $(this).data('offset');
        $(this).data('offset', offset + main_offset)
        $.ajax({
            url: "<?= base_url('Sidebar/load_blogs'); ?>",
            type: "POST",
            dataType: 'JSON',
            data: {offset: offset, topics: topic_id},
            success: function (data) {
                //console.log(data.length);
                if (data.length == 0 || data.length < main_offset ) {
                    $('#sideblog').hide();
                }
                if(data.length != 0){
                    add_blog('sideblog', data);
                }
            }
        });
    });

    function add_blog(selector, data) {
        var div = '';
        $.each(data, function (key, value) {
            var str=value.title;
            var string = str.replace(/[^A-Z0-9]+/ig, "-");
            var newString = string.replace(/-+$/,'/');
            div += '<a href="'+base_url+'blog/'+value.id+'/'+newString+'" class="card prediction-card text-decoration-none mb-5">';
            // div += '<div class="banner-img" style="background-image:url(' + value.image + ')" title="'+value.title+'"></div>';
            div += '<div class="card-body" >';
            div += '<h6 class="title text-left" >';
            div += value.title;
            div += '</h6>';
            div += '<div class="d-flex justify-content-between" >';
            div += '<div >';
            div += '<img src="' + base_url + 'assets/img/calendar.svg" >';
            div += '<span class= "font-weight-light ml-1" ><span ';
            div += 'class="font-weight-normal" > ';
            div += value.created_date + "</span></span>";
            //                                                                div += '"+value.end_date+" < /span></span >';
            div += '</div>';
            // div += '<img src="' + base_url + 'assets/img/share.svg" >';
            div += '</div>';
            div += '</div>';
            div += '</a>';
        });
        $('#' + selector).before(div);
    }
</script>
