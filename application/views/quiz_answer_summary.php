<div class="container-fluid">
    <div class="row ">
        <div class="col-md-8 theme-padding bg-blue main-height" id="quiz">
            <div>
                <!-- sumarry start -->
                <div id="quiz-summary" class="my-5">
                    <div class="row border border-10 mb-5 no-gutters" id="quiz_state">
                        <?php $player_level = quiz_player_statistic($count_correct, $count_wrong); ?>
                        <div class="col-md-2 col-12 trophyimg" style="background-image: url('<?= base_url() ?>assets/img/<?= $player_level['type'] ?>.svg');" title="<?= empty ( @$player_level['type'] ) ? 'player_level' : @$player_level['type']; ?>">
                            <!-- <img src="<?= base_url() ?>assets/img/<?= $player_level['type'] ?>.svg"> -->
                        </div>
                        <div class="col ml-2 profile_info">
                            <h4 class="text-dark mt-3"><?= empty($user_name['name']) ? 'CW360#' . $this->user_id : $user_name['name']; ?></h4>
                            <h6 class="title">You have been rated <?= $player_level['article'] ?> <span class="<?= $player_level['class'] ?> text-white"><?= strtoupper($player_level['type']); ?></span> on <?= $attempt_question_quiz_ans[0]['quiz_title'] ?></h6>
                            <button class="btn btn-quiz-share p-0 mt-2 mb-2 px-3 py-1" data-toggle="modal" data-target="#shareModal" style="border-radius:7px">
                                <!-- <img src="<?= base_url() ?>assets/img/share-btn.svg" class="img-fluid mr-1"> -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="15.227" height="18.23" viewBox="0 0 11.227 11.23"><defs><style>.a{fill:#2ba1cc;}</style></defs><path style="fill:white" class="a" d="M11.227,5.612,6.108,0V3.362H5.514A5.514,5.514,0,0,0,0,8.876V11.23l.982-1.076A7.048,7.048,0,0,1,6.108,7.863v3.362ZM.658,9.539V8.876A4.856,4.856,0,0,1,5.514,4.02H6.766V1.7l3.569,3.914L6.766,9.526V7.2h-.59A7.708,7.708,0,0,0,.658,9.539Zm0,0"/></svg>
                                 <span id="quiz_state_shareBtn" class="text-white">Challenge Friends</span>
                            </button>
                        </div>
                    </div>
                    <h4 class="mb-4"><?= $attempt_question_quiz_ans[0]['quiz_title'] ?></h4>

                    <div class="d-flex pt-2 mb-5">
                        <div class="mr-5 d-flex flex-column justify-content-center">
                            <h6 class="mb-2">Total Earnings</h6>
                            <div class="d-flex align-items-center">
                                <img src="<?= base_url() ?>assets/img/coin.png" class="mr-2">
                                <h4 class="mb-0"><?= $sum_correct - $sum_wrong; ?></h4>
                            </div>
                        </div>
                        <div class="row border  bg-white border-15 ml-5" id="sumaary-records">
                            <div class="col-6 text-center border-right">
                                <p class="title">Correct Ans.</p>
                                <h6 class="text-dark ans-count"><?= $count_correct ?></h6>
                                <div>
                                    <img src="<?= base_url() ?>assets/img/coin.png">
                                    <span class="text-green score">&#43;<?= $sum_correct ?></span>
                                </div>
                            </div>
                            <div class="col-6 text-center">
                                <p class="title">Wrong Ans.</p>
                                <h6 class="text-dark ans-count"> <?= $count_wrong ?></h6>
                                <div>
                                    <img src="<?= base_url() ?>assets/img/coin.png">
                                    <span class="text-red score">&#45;<?= $sum_wrong ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h5 class="mb-3">QUIZ SUMMARY</h5>
                    <div class="quiz-summary-list">
                        <?php
                        foreach ($attempt_question_quiz_ans as $key => $value) {
                            if ($value['ans_status'] == 'right') {
                                $cls_right = $value['ans_status'];
                                $svg_right = 'rightanswer.svg';
                                $get_ans_coin = "+" . $value['coins'];
                                $ans_type = "Correct Answer";
                            } else {
                                $cls_right = 'wrong';
                                $svg_right = 'wrong_answer.svg';
                                $get_ans_coin = "-" . $value['coins'];
                                $ans_type = "Wrong Answer";
                            }
                        ?>
                            <!-- <div class="list <?= $cls_right ?> border-15">
                            <h6 class="question-title"><?= $value['question'] ?></h6>
                            <div class="d-flex justify-content-between">
                                <div class="d-flex align-items-center">
                                    <img src="<?= base_url() ?>assets/img/<?= $svg_right ?>">
                                    <span class="answer-type"><?= $ans_type; ?></span
                                </div>
                                <div class="d-flex align-items-center">
                                    <img src="<?= base_url() ?>assets/img/coin.png">
                                    <span class="points"><?= $get_ans_coin; ?></span>
                                </div>
                            </div>
                        </div> -->
                            <div class="list <?= $cls_right ?> border-15 row no-gutters">
                                <div class="col">
                                    <h6 class="question-title"><?= $value['question'] ?></h6>
                                    <div class="d-flex align-items-center">
                                        <span class="right-answer">Correct Answer</span>
                                        <span class="right-answer"> : <?= $value['correct_ans'] ?></span>
                                    </div>
                                </div>

                                <div class="text-right">
                                    <div class="d-flex justify-content-between flex-column h-100 align-items-end">
                                        <div>
                                            <span class="answer-type"><img class="mr-1" src="<?= base_url() ?>assets/img/<?= $svg_right ?>"><?php $ans = explode(" ", $ans_type);
                                                                                                                                            echo $ans[0]; ?></span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <img src="<?= base_url() ?>assets/img/coin.png">
                                            <span class="points"><?= $get_ans_coin; ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php  } ?>

                        <!-- old refrence div start -->
                        <!-- <div class="list wrong border-15">
                            <h6 class="question-title">Lorem ipsum dolor sit amet, consectetur adipiscing elit sed? do eiusmod tempor incididunt ut labore et dolore magna aliqua.</h6>
                            <div class="d-flex justify-content-between">
                                <div class="d-flex align-items-center">
                                    <img src="<?= base_url() ?>assets/img/wrong_answer.svg">
                                    <span class="answer-type">Correct Answer</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <img src="<?= base_url() ?>assets/img/coin.png">
                                    <span class="points">+10</span>
                                </div>
                            </div>
                        </div>
                        <div class="list right border-15">
                            <h6 class="question-title">Lorem ipsum dolor sit amet, consectetur adipiscing elit sed? do eiusmod tempor incididunt ut labore et dolore magna aliqua.</h6>
                            <div class="d-flex justify-content-between">
                                <div class="d-flex align-items-center">
                                    <img src="<?= base_url() ?>assets/img/rightanswer.svg">
                                    <span class="answer-type">Wrong Answer</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <img src="<?= base_url() ?>assets/img/coin.png">
                                    <span class="points">+10</span>
                                </div>
                            </div>
                        </div> -->
                        <!-- old refrence div end -->

                        <!-- new design start -->
                        <!-- <div class="list right border-15 row no-gutters">
                                <div class="col">
                                    <h6 class="question-title">Lorem ipsum dolor sit amet, consectetur adipiscing elit sed? do eiusmod tempor incididunt ut labore et dolore magna aliqua.</h6>
                                    <div class="d-flex align-items-center">
                                        <span class="right-answer">Correct Answer</span>
                                        <span class="right-answer"> : Lorem Ipsum</span>
                                    </div>
                                </div>

                                <div class="text-right">
                                <div class="d-flex justify-content-between flex-column h-100 align-items-end">
                                    <div>
                                        <span class="answer-type"><img class="mr-1" src="<?= base_url() ?>assets/img/rightanswer.svg">correct</span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <img src="<?= base_url() ?>assets/img/coin.png">
                                        <span class="points">+10</span>
                                    </div>
                                </div>
                                </div>
                            </div>
                            <div class="list wrong border-15 row no-gutters">
                                <div class="col">
                                    <h6 class="question-title">Lorem ipsum dolor sit amet, consectetur adipiscing elit sed? do eiusmod tempor incididunt ut labore et dolore magna aliqua.</h6>
                                    <div class="d-flex align-items-center">
                                        <span class="right-answer">Wrong Answer</span>
                                        <span class="right-answer"> : Lorem Ipsum</span>
                                    </div>
                                </div>

                                <div class="text-right">
                                <div class="d-flex justify-content-between flex-column h-100 align-items-end">
                                    <div>
                                        <span class="answer-type"><img class="mr-1" src="<?= base_url() ?>assets/img/wrong_answer.svg">wrong</span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <img src="<?= base_url() ?>assets/img/coin.png">
                                        <span class="points">-10</span>
                                    </div>
                                </div>
                                </div>
                            </div> -->
                        <!-- new design end -->


                    </div>
                </div>
                <!-- sumarry end -->

            </div>
        </div>
        <!--right side game start-->
        <div class="col-md-4 theme-bg theme-padding main-height">
            <div class="predection-list">
                <h3 class="title">Explore More</h3>

                <div class="data-container">
                    <ul class="nav nav-pills mb-3" id="predection-list-menu" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Games</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-blogs-tab" data-toggle="pill" href="#pills-blogs" role="tab" aria-controls="pills-blogs" aria-selected="true">Blogs</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                            <?php
                            if (!empty($sidebar_games)) {
                                foreach ($sidebar_games as $key => $value) {
                            ?>

                                    <a href="<?= base_url('Predictions/prediction_game/' . $value['id']) ?>" class="card prediction-card text-decoration-none mb-5">
                                        <!-- <div class="banner-img" style="background-image:url(<?= $value['image'] ?>)" title="<?= empty ( @$value['title'] ) ? 'sidebargames_img' : @$value['title']; ?>"></div> -->
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
                                                    <span class="font-weight-light ml-1"><span class="font-weight-normal">
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

                        <div class="tab-pane fade" id="pills-blogs" role="tabpanel" aria-labelledby="pills-blogs-tab">
                            <?php
                            /*if (!empty($topics_quiz_list)) {
                                     foreach ($topics_quiz_list as $key => $value) {
                                         ?>

                                    <a href="<?= base_url('quiz/instruction/' .base64_encode($value['quiz_id']).'?topic_id='.base64_encode($value['topic_id'])) ?>" class="card prediction-card text-decoration-none">
                                        <div class="banner-img" style="background-image:url(<?= $value['image'] ?>)"></div>
                                        <div class="card-body">
                                            <button class="btn play-btn">
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
                            if (!empty($topics_quiz_list) && count($topics_quiz_list) > 5) {
                                
                                echo '<center><button id="sideblog" class="btn btn-danger mt-2 mb-5" data-offset=' . sidebar_card_limit() . '>Load more</button></center>';
                            }*/

                            if (!empty($sidebar_blogs)) {
                                foreach ($sidebar_blogs as $key => $value) {
                            ?>

                                   <!--  <a href="<?= base_url('blog/' . $value['id'].'/'.rtrim(preg_replace('/[^a-zA-Z0-9]+/', '-', $value['title']),'-').'/') ?>" class="card prediction-card text-decoration-none mb-5"> -->
                                   <a href="<?= base_url('blog/detail/' . $value['id']) ?>" class="card prediction-card text-decoration-none">
                                        <!-- <div class="banner-img" style="background-image:url(<?= $value['image'] ?>)" title="<?= empty ( @$value['title'] ) ? 'blog_img' : @$value['title']; ?>"></div> -->
                                        <div class="card-body">
                                            <h6 class="title">
                                                <?= $value['title'] ?>
                                            </h6>
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <img src="<?= base_url(); ?>assets/img/calendar.svg">
                                                    <span class="font-weight-light ml-1"><span class="font-weight-normal">
                                                            <?= $value['created_date']; ?></span></span>
                                                </div>
                                                <!-- <img src="<?php //= base_url(); 
                                                                ?>assets/img/share.svg"> -->
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
                    <div class="d-flex justify-content-between">
                        <p>Correct Answer</p>
                        <div>
                            <img src="<?= base_url() ?>assets/img/coin.png">
                            <span>+10</span>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <p>Wrong Answer</p>
                        <div>
                            <img src="<?= base_url() ?>assets/img/coin.png">
                            <span>-5</span>
                        </div>
                    </div>
                    <div class="d-flex position-absolute justify-content-between align-items-center">
                        <p class="mb-0">Coins needed to play</p>
                        <div>
                            <img src="<?= base_url() ?>assets/img/coin.png">
                            <span>50</span>
                        </div>
                    </div>
                </div>
                <div class="mt-5">
                    <button class="bg-red btn text-white mt-2">Start Quiz</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
var topicId = '<?= str_replace(',', '-', $topic_id); ?>';
var quiz_id = '<?= $quiz_id;?>';
var userId = '<?= $this->user_id;?>';
    $(function() {
        var topic_id = '<?= $topic_id; ?>';
        $('#sideblog').click(function() {
            var main_offset = parseInt('<?= sidebar_card_limit() ?>');
            var offset = $(this).data('offset');
            $(this).data('offset', offset + main_offset)
            $.ajax({
                url: "<?= base_url('Sidebar/load_blogs'); ?>",
                type: "POST",
                dataType: 'JSON',
                data: {
                    offset: offset,
                    topics: topic_id
                },
                success: function(data) {
                    console.log(data);
                    if (data.length == 0 || data.length < main_offset) {
                        $('#sideblog').hide();
                    }
                    if (data.length != 0) {
                        add_blog('sideblog', data);
                    }

                }
            });
        });
    });
    //    function add_quiz_list(selector, data) {
    //        var div = '';
    //        $.each(data, function (key, value) {
    //            console.log(value);
    //            div += '<a href="'+base_url+'quiz/instruction/'+btoa(value.quiz_id)+'?topic_id='+btoa(value.topic_id)+'" class="card prediction-card text-decoration-none">';
    //            div += '<div class="banner-img" style="background-image:url(' + value.image + ')"></div>';
    //            div += '<div class="card-body" >';
    //            div += '<button class="btn play-btn">';
    //            div += 'Play Now';
    //            div += '</button>';
    //            div += '<h6 class="title text-left" >';
    //            div += value.name;
    //            div += '</h6>'; 
    //            div += '</div>';
    //            div += '</a>';
    //        });
    //        $('#' + selector).before(div);
    //    }

    function add_blog(selector, data) {
        var div = '';
        $.each(data, function(key, value) {
           /*  var str=value.title;
            var string = str.replace(/[^A-Z0-9]+/ig, "-");
            var newString = string.replace(/-+$/,'/');
            div += '<a href="' + base_url + 'blog/' + value.id + '/'+newString+'" class="card prediction-card text-decoration-none">'; */
            div += '<a href="' + base_url + 'blog/detail/' + value.id+'" class="card prediction-card text-decoration-none">';
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

    $(function() {
        var topic_id = '<?= $topic_id; ?>';
        var game_id = '';
        $('#sidegames').click(function() {
            var main_offset = parseInt('<?= sidebar_card_limit() ?>');
            var offset = $(this).data('offset');
            $(this).data('offset', offset + main_offset)
            $.ajax({
                url: "<?= base_url('Sidebar/load_games'); ?>",
                type: "POST",
                dataType: 'JSON',
                data: {
                    offset: offset,
                    topics: topic_id
                },
                success: function(data) {
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
        $.each(data, function(key, value) {
            div += '<a href="' + base_url + 'Predictions/prediction_game/' + value.id + '" class="card prediction-card text-decoration-none mb-5">';
            // div += '<div class="banner-img" style="background-image:url(' + value.image + ')" title="'+value.title+'"></div>';
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
