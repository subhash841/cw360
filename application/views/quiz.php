<div class="container-fluid">
    <div class="row ">
        <div class="col-md-8 theme-padding bg-blue main-height" id="quiz">
            <div class="timer text-center">
                <div class="circular-progess ticker position-relative p-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="124" height="124" viewBox="0 0 124 124" ">
                        <g id=" Group_2428" data-name="Group 2428" transform="translate(-364 -154)">
                            <circle id="Ellipse_160" data-name="Ellipse 160" cx="60" cy="60" r="54"
                                    transform="translate(366 156)" opacity="0.2" stroke="#fff" stroke-linecap="round"
                                    stroke-width="4" stroke="red" stroke-width="2" fill="none" />
                            <circle id="Ellipse_161" data-name="Ellipse 161" cx="46" cy="46" r="46"
                                    transform="translate(380 169)" fill="#395cc5" />
                            <circle id="Ellipse_162" data-name="Ellipse 162" cx="36" cy="36" r="36"
                                    transform="translate(390 179)" fill="#4d6dcb" />
                            <g id="Group_2164" data-name="Group 2164" transform="translate(275.455 -275.06)">
                                <path id="Path_7863" data-name="Path 7863" transform="translate(6281 -2332.83)"
                                      d="M-6142.456,2825.67l6.93,6.433,19.018-19.018" fill="none" stroke="#fff"
                                      stroke-linecap="round" stroke-width="4" />
                            </g>
                            <path xmlns="http://www.w3.org/2000/svg" id="wrong1" data-name="Path 7863"
                                  d="M-6147.828,2820.06l20.213,20.214" transform="translate(6563.829 -2615.06)"
                                  fill="none" stroke="#fff" stroke-linecap="round" stroke-width="4" />
                            <path xmlns="http://www.w3.org/2000/svg" id="wrong2" data-name="Path 7864"
                                  d="M0,0,20.213,20.214" transform="translate(436.214 205) rotate(90)" fill="none"
                                  stroke="#fff" stroke-linecap="round" stroke-width="4" />
                            <text id="_7" data-name="7" text-anchor="initial" transform="translate(416 228)"
                                  fill="#fff" font-size="38" font-family="Poppins-Regular, Poppins">
                                <tspan x="-8%" y="2%" id="tickervalue"></tspan>
                            </text>
                        </g>
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" width="124" height="124" viewBox="0 0 124 124"
                         class="position-absolute" style="top: 0;left: 0;transform: rotate(-94deg) translate(2px, 2px);">
                        <circle cx="60" cy="60" r="54" id="progressCircle" stroke-dasharray="339.292"
                                stroke-dashoffset="339.292" stroke-linecap="round" stroke-width="4" stroke="#51e485"
                                stroke-dasharray="0 7" fill="none" />
                    </svg>
                </div>
            </div>
            <div>   
            <span id="quiz_topic_id" data-topic_id="<?=$topic_id?>"></span>
            <span id="data_quiz_id" data-quiz_id="<?=$quiz_id?>"></span>
                <h6 class="question"></h6>
                <div id="answer-holder">
                    
                    <!-- <div class="answer ">
                        <div class="progressbar success"></div>
                        <div class="d-flex justify-content-between">
                            <span>mitchell starc</span>
                              <span class="percent">16%</span>
                        </div>
                    </div>
                    
                    <div class="answer ">
                        <div class="progressbar"></div>
                        <div class="d-flex justify-content-between">
                            <span>mitchell starc</span>
                        </div>
                    </div>
                    
                    <div class="answer active">
                        <div class="progressbar"></div>
                        <div class="d-flex justify-content-between">
                            <span>mitchell starc</span>
                        </div>
                    </div>

                    <div class="answer danger">
                        <div class="progressbar "></div>
                        <div class="d-flex justify-content-between">
                            <span>mitchell starc</span>
                        </div>
                    </div>

                    <div class="answer right">
                        <div class="progressbar "></div>
                        <div class="d-flex justify-content-between">
                            <span>mitchell starc</span>
                        </div>
                    </div> -->

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
                            <a class="nav-link" id="pills-blogs-tab" data-toggle="pill" href="#pills-blogs"
                               role="tab" aria-controls="pills-blogs" aria-selected="false">Blogs</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                             aria-labelledby="pills-home-tab">
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
                            if (!empty($topics_quiz_list) && count($topics_quiz_list) > 2) {
                                
                                echo '<center><button id="sidequiz" class="btn btn-danger mt-2 mb-5" data-offset="6">Load more</button></center>';
                            }*/
                                 
                            if (!empty($sidebar_games)) {
                                     foreach ($sidebar_games as $key => $value) {
                                         ?>

                                    <a href="<?= base_url('Predictions/prediction_game/' . $value['id']) ?>" class="card prediction-card text-decoration-none mb-5">
                                     <!--    <div class="banner-img" style="background-image:url(<?= $value['image'] ?>)" title="<?= empty ( @$value['title'] ) ? 'game_img' : @$value['title']; ?>"></div> -->
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
                            if (!empty($sidebar_games) && count($sidebar_games) > 5) {

                                echo '<center><button id="sidegames" class="btn btn-danger mt-2 mb-5" data-offset=' . sidebar_card_limit() . '>Load more</button></center>';
                            }
                            
                            ?>
                        </div>
                        <div class="tab-pane fade" id="pills-blogs" role="tabpanel"
                             aria-labelledby="pills-blogs-tab">
                             <?php
                                 if (!empty($sidebar_blogs)) {
                                     foreach ($sidebar_blogs as $key => $value) {
                                         ?>

                                    <!-- <a href="<?= base_url('blog/' . $value['id'].'/'.rtrim(preg_replace('/[^a-zA-Z0-9]+/', '-', $value['title']),'-').'/') ?>" class="card prediction-card text-decoration-none"> -->
                                    <a href="<?= base_url('blog/detail/' . $value['id']) ?>" class="card prediction-card text-decoration-none">
                                        <!-- <div class="banner-img" style="background-image:url(<?= $value['image'] ?>)" title="<?= empty ( @$value['title'] ) ? 'blog_img' : @$value['title']; ?>"></div> -->
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
            <div class="d-flex justify-content-between">
                <p>Correct Answer</p>
                <div>
                    <img src="<?= base_url()?>assets/img/coin.png">
                    <span>+10</span>
                </div>
            </div>
            <div class="d-flex justify-content-between mb-3">
                <p>Wrong Answer</p>
                <div>
                    <img src="<?= base_url()?>assets/img/coin.png">
                    <span>-5</span>
                </div>
            </div>
            <div class="d-flex position-absolute justify-content-between align-items-center">
                <p class="mb-0">Coins needed to play</p>
                <div>
                    <img src="<?= base_url()?>assets/img/coin.png">
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

<script src="<?= base_url()?>assets/js/quiz.js?v=2.2"></script>
<script>
    $(function () {
    if (window.IsDuplicate()) {
        // alert user the tab is duplicate
        window.location.href=base_url+'/home';
    
    }
         window.onload = function () {  
        document.onkeydown = function (e) {  
            return (e.which || e.keyCode) != 116;  
        };  
    }
        var topic_id = '<?= @$topic_id; ?>';       
        $('#sidequiz').click(function () {
            var main_offset = 6;
            var offset = $(this).data('offset');
            $(this).data('offset', offset + main_offset)
            $.ajax({
                url: "<?= base_url('Quiz/all_quiz'); ?>",
                type: "POST",
                dataType: 'JSON',
                data: {offset: offset, topicid: topic_id},
                success: function (data) {
                    //console.log(data);
                    if (data.length == 0 || data.length < main_offset ) {
                        $('#sidequiz').hide();
                    } 
                    // if (data.length != 0) {
                        add_quiz_list('sidequiz', data);
                    // }
                    
                }
            });
        });
    });
    function add_quiz_list(selector, data) {
        var div = '';
        $.each(data, function (key, value) {
            // console.log(value);
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
        //    div += '<div class="banner-img" style="background-image:url(' + value.image + ')" title="'+value.title+'"></div>';
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
                if (data.length != 0) {
                    add_blog('sideblog', data);
                }
            }
        });
    });

    function add_blog(selector, data) {
        var div = '';
        $.each(data, function (key, value) {
            /* var str=value.title;
            var newString = str.replace(/[^A-Z0-9]+/ig, "-");
            div += '<a href="'+base_url+'blog/'+value.id+'/'+newString+'" class="card prediction-card text-decoration-none">'; */
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
</script>
