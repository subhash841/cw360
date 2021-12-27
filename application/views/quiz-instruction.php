<div class="container-fluid">
    <div class="row ">
        <div class="col-md-8 theme-padding bg-blue main-height" id="quiz">
            <div>   
                <!-- <h6 class="question">asds</h6> -->
                <div id="quiz-instruction" class="mx-auto text-center">
                    <h6 class="title">Instructions</h6>
                    <h4 class="mt-4"><?php print_r($question_data['name']); ?></h4>
                    <p class="desc">Choose the appropriate answer from the multiple choice options to win coins.</p>
                    <form>
                    <span id="quiz_topic_id" data-topic_id="<?=base64_encode($topic_id)?>"></span>
                    <span id="data_quiz_id" data-quiz_id="<?=base64_encode($quiz_id)?>"></span>
                    <span id="quiz_coins_needed" data-coins_needed="<?=base64_encode($coins_needed)?>"></span>
                    <div class="answer position-relative">
                        <div class="d-flex justify-content-between">
                            <p>Correct Answer</p>
                            <div>
                                <img src="<?= base_url() ?>assets/img/coin.png">
                                    <span>&#43;<?=$question_data['correct_ans_coins']?></span>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <p>Wrong Answer</p>
                            <div>
                                <img src="<?= base_url() ?>assets/img/coin.png">
                                    <span>&#45;<?=$question_data['wrong_ans_coins']?></span>
                            </div>
                        </div>
                        <div class="d-flex position-absolute justify-content-between align-items-center">
                            <p class="mb-0">Coins needed to play</p>
                            <div>
                                <img src="<?= base_url() ?>assets/img/coin.png">
                                    <span><?= $coins_needed?></span>
                            </div>
                        </div>
                    </div>
                    </form>
                    <div class="mt-5">
                    <?php if($this->user_id != 0){ ?>
                        <button class="btn text-white mt-2 btnStartQuiz" id="start_quiz">Start Quiz</button>
                    <?php    }else{?>
                       <a href="<?= base_url() ?>login?section=instruction&section2=<?=base64_encode($quiz_id)?>&section3=<?=base64_encode($topic_id)?>"> 
                           <button id="startQuizBtn" class="btn mt-2">
                               Start Quiz
                           </button>
                        </a>
                        <?php }?>
                        <br>
                        <a href="<?= base_url() ?>home" class="d-inline-block mt-3 text-white text-decoration-none">Go to Home</a>
                    </div>
                    <div class="quiz_description bg-white text-dark px-3 py-4 my-3" style="border-radius: 15px;"><?= $question_data['description']?></div>
                </div>
            </div>
        </div>
        <!--right side game start-->
        <div class="col-md-4 theme-bg theme-padding main-height">
            <div class="predection-list">
                <h3 class="title">Explore More</h3>

                <div class="data-container">
                    <ul class="nav nav-pills mb-3" id="predection-list-menu" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home"
                               role="tab" aria-controls="pills-home" aria-selected="true">Games</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-blog-tab" data-toggle="pill" href="#pills-blog"
                               role="tab" aria-controls="pills-blog" aria-selected="true">Blogs</a>
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
                                        <!-- <div class="banner-img" style="background-image:url(<?= $value['image'] ?>)" title="<?= empty ( @$value['title'] ) ? 'game_img' : @$value['title']; ?>"></div> -->
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
                                                        <span class="font-weight-light ml-1">Game Ends : <span
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
                            if (!empty($sidebar_games) && count($sidebar_games) > 5) {

                                echo '<center><button id="sidegames" class="btn btn-danger mt-2 mb-5" data-offset=' . sidebar_card_limit() . '>Load more</button></center>';
                            }
                            ?>
                        </div>
                        <div class="tab-pane fade" id="pills-blog" role="tabpanel"
                             aria-labelledby="pills-blog-tab">
                             <?php
                                 if (!empty($sidebar_blogs)) {
                                     foreach ($sidebar_blogs as $key => $value) {
                                         ?>

                                    <a href="<?= base_url('blog/detail/' . $value['id']) ?>" class="card prediction-card text-decoration-none">
                                        <!-- <div class="banner-img" style="background-image:url(<?= $value['image'] ?>)"></div> -->
                                        <div class="card-body">
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


<!-- Modal -->
<div class="modal fade" id="quiz-instruction" tabindex="-1" role="dialog" aria-labelledby="quiz-instructionLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document" style="width: 411px;">
        <div class="modal-content border-15">
            <div class="modal-body bg-blue text-white text-center border-15">
                <h6 class="title">Instructions</h6>
                <p class="desc">Choose the appropriate answer from the multiple choice options to win coins.</p>
                <div class="answer position-relative">
                <form method="post">
                   <span id="quiz_topic_id" data-topic_id="<?=base64_encode($topic_id)?>"></span>
                    <span id="data_quiz_id" data-quiz_id="<?=base64_encode($quiz_id)?>"></span>
                    <span id="quiz_coins_needed" data-coins_needed="<?=base64_encode($coins_needed)?>"></span>
                    <div class="d-flex justify-content-between">
                        <p>Correct Answer</p>
                        <div>
                            <img src="<?= base_url() ?>assets/img/coin.png">
                                <span>&#43;<?=$question_data['correct_ans_coins']?></span>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <p>Wrong Answer</p>
                        <div>
                            <img src="<?= base_url() ?>assets/img/coin.png">
                                <span>&#45;<?=$question_data['wrong_ans_coins']?></span>
                        </div>
                    </div>
                    <div class="d-flex position-absolute justify-content-between align-items-center">
                        <p class="mb-0">Coins needed to play</p>
                        <div>
                            <img src="<?= base_url() ?>assets/img/coin.png">
                                <span><?= $coins_needed?></span>
                        </div>
                    </div>
                </div>
                </form>
                <div class="mt-5">
                    <button class="bg-red btn text-white mt-2" id="start_quiz">Start Quiz</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- <script src="<?= base_url() ?>assets/js/quiz.js"></script> -->
<script>
    // $(function () {
    //     $('#quiz-instruction').modal('show');
    // })

     $(document).on('click', '#start_quiz', function (e) {
        // alert($('#quiz_topic_id').attr('data-topic_id'));
            $.ajax({
               url: base_url+"Quiz/quiz_start_chk",
               type: "POST",
               dataType: "json",
               data: {topic_id:$('#quiz_topic_id').attr('data-topic_id'),quiz_id:$('#data_quiz_id').attr('data-quiz_id'),coins_needed:$('#quiz_coins_needed').attr('data-coins_needed')},
               success: function(data, textStatus, jqXHR) {               
                   // console.log(data.coin_limit);
                    if(data=="quiz_attempted"){
                        $('#modalText').html('Quiz already attempted');
                        $('#basicModal').modal('show');
                        setInterval(function () {
                            location.reload();
                        }, 2000);
                    }else if(data.coin_limit == '0'){
                        $('#modalText').html('You have reached maximum 1000 coin earn limit for Quiz . You can start earning coins from date '+ moment( data.limit_end_date).format('DD MMM, YYYY'));
                        $('#basicModal').modal('show');
                        setInterval(function () {
                            location.reload();
                        }, 2000);
                    }else if(data =='play_quiz'){
                        var location=base_url+"quiz/index/"+$('#data_quiz_id').attr('data-quiz_id')+"?topic_id="+$('#quiz_topic_id').attr('data-topic_id');
                        window.location.href=location;
                    }else if(data =='users_quiz_coin_limit'){
                        var location=base_url+"quiz/index/"+$('#data_quiz_id').attr('data-quiz_id')+"?topic_id="+$('#quiz_topic_id').attr('data-topic_id');                     
                        window.location.href=location;
                   }else{
                    $("#insufficientCoinsQuiz").modal("show");
                   }                  
                }
           });
       
 
    })

    $(function () {
        var topic_id = '<?= $topic_id; ?>';
        $('#sidegames').click(function () {
            var main_offset = parseInt('<?= sidebar_card_limit() ?>');
            var offset = $(this).data('offset');
            $(this).data('offset', offset + main_offset)
            $.ajax({
                url: "<?= base_url('Sidebar/load_games'); ?>",
                type: "POST",
                dataType: 'JSON',
                data: {offset: offset, topics: topic_id},
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
            // div += '<div class="banner-img" style="background-image:url(' + value.image + ')" title="'+value.title+'"></div>';
            div += '<div class="card-body">';
            div += '<button class="btn play-btn" style="bottom:-17px;top:unset;right:18px;">';
            div += 'Play Now';
            div += '</button>';
            div += '<h6 class="title text-left" >';
            div += value.title;
            div += '</h6>';
            div += '<div class="d-flex justify-content-between" >';
            div += '<div >';
            div += '<img src="' + base_url + 'assets/img/clock.svg" >';
            div += '<span class= "font-weight-light ml-1" > Game Ends : <span';
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
    $('#sideblog').click(function () {
            var topic_id = '<?= $topic_id; ?>';
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
                    div += '<a href="'+base_url+'blog/detail/'+value.id+'" class="card prediction-card text-decoration-none">';
                    //div += '<div class="banner-img" style="background-image:url(' + value.image + ')"></div>';
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
