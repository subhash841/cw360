<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 theme-padding main-height">
            <!--<div class="bredcum-holder">
                <a href="<?= base_url() ?>Home">Home /</a>
                <a href="<?= base_url() ?>Games" class="active">Games </a>
            </div> -->
            <div id="games-container" class="my-4">
                <h1 class="title mb-5" style="font-size:1.5rem;">Quiz</h1>

                <!--quiz list start-->
                <div class="row" id="quiz_all_data_list">
                    <?php
                    // print_r($quiz_list);
                    if (!empty($quiz_list)) {
                        foreach ($quiz_list as $key => $value) {
                    ?>
                            <div class="col-md-6">
                                <a href="<?= base_url() ?>quiz/instruction/<?= base64_encode(@$value['quiz_id']) ?>?topic_id=<?= base64_encode(@$value['topic_id']) ?>" class="card prediction-card text-decoration-none no-hover">
                                    <div class="banner-img" style="background-image:url(<?= $value['image']; ?>)" title="<?= empty(@$value['name']) ? 'blog_img' : @$value['name']; ?>"></div>
                                    <div class="card-body">
                                        <button class="btn play-btn">
                                            Play Now
                                        </button>
                                        <h6 class="title text-dark">
                                            <?= $value['name']; ?>
                                        </h6>
                                        <!--      <div class="d-flex justify-content-between">
                                        <div>
                                            <img src="<?= base_url() ?>/assets/img/clock.svg">
                                            <span class="font-weight-light ml-1">Game Ends In : <span class="font-weight-normal">
                                                    49 Days left</span></span>
                                        </div>
                                        <div>
                                            <img src="<?= base_url() ?>assets/img/coin.png" class="img-fluid" style="width:14px;">
                                            <span class="font-weight-light ml-1">150.00</span>
                                            <br>
                                            <small>*required</small>
                                        </div>
                                        <img src="<?= base_url() ?>assets/img/share.svg" class="d-none">
                                    </div> -->
                                    </div>
                                </a>
                            </div>
                        <?php }
                    } else { ?>
                        <div class="col-md-12">
                            <!--empty infographics strat end-->
                            <div class="no-games text-center my-5 pt-3">
                                <h5 class="font-weight-bold cw-text-color-gray">
                                    No quiz available
                                </h5>
                                <img class="img-fluid my-5" src="<?= base_url(); ?>assets/img/no-prediction-games.svg">
                                <a href="<?= base_url() ?>Games">
                                    <h6 class="font-weight-bold try-games-text">
                                        Try out other Games
                                    </h6>
                                </a>
                            </div>
                        </div>
                    <?php
                    } ?>
                    <!--empty infographics  end-->
                </div>
                <?php

                if ((count($quiz_list) + 1) > 3) { ?>
                    <div class="col-12 text-center"><button class="cat_quiz_load btn btn-danger" data-offset="4">Load more</button></div>
                <?php
                }
                ?>
                <!--quiz list end-->

            </div>

        </div>

        <div class="col-md-4 theme-bg theme-padding main-height">
            <div class="predection-list">
                <h3 class="title">Explore More</h3>
                <div class="data-container">
                    <ul class="nav nav-pills mb-3" id="predection-list-menu" role="tablist">
                        <!--                        <li class="nav-item">
                            <a class="nav-link active d-none" id="pills-home-tab" data-toggle="pill" href="#pills-home"
                               role="tab" aria-controls="pills-home" aria-selected="true">Quiz</a>
                        </li>-->
                        <li class="nav-item">
                            <a class="nav-link active" id="pills-games-tab" data-toggle="pill" href="#pills-games" role="tab" aria-controls="pills-games" aria-selected="true">games</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-blogs-tab" data-toggle="pill" href="#pills-blogs" role="tab" aria-controls="pills-blogs" aria-selected="false">blogs</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show " id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                            <?php
                            if (!empty($topics_quiz_list)) {
                                foreach ($topics_quiz_list as $key => $value) {
                            ?>

                                    <a href="<?= base_url('quiz/instruction/' . base64_encode($value['quiz_id']) . '?topic_id=' . base64_encode($value['topic_id'])) ?>" class="card prediction-card text-decoration-none mb-5">
                                       <!--  <div class="banner-img" style="background-image:url(<?= $value['image'] ?>)" title="<?= empty(@$value['name']) ? 'quizsidebar' : @$value['name']; ?>"></div> -->
                                        <div class="card-body">
                                            <button class="btn play-btn" style="bottom:-17px;top:unset;right:18px;">
                                                Play Now
                                            </button>
                                            <h6 class="title">
                                                <?= $value['name'] ?>
                                            </h6>
                                            <div class="d-flex justify-content-between">
                                                <img src="<?= base_url(); ?>assets/img/share.svg">
                                            </div>
                                        </div>
                                    </a>

                            <?php
                                }
                            } else {
                                echo 'No Quiz available';
                            }
                            if (!empty($topics_quiz_list) && count($topics_quiz_list) > 5) {

                                echo '<center><button id="sidequiz" class="btn btn-danger mt-2 mb-5" data-offset="6">Load more</button></center>';
                            }
                            ?>
                        </div>
                        <div class="tab-pane active" id="pills-games" role="tabpanel" aria-labelledby="games-tab">

                            <?php
                            if (!empty($sidebar_games)) {
                                foreach ($sidebar_games as $key => $value) {
                            ?>

                                    <a href="<?= base_url('Predictions/prediction_game/' . $value['id']) ?>" class="card prediction-card text-decoration-none mb-5">
                                        <!-- <div class="banner-img" style="background-image:url(<?= $value['image'] ?>)" title="<?= empty(@$value['title']) ? 'sidebar_games' : @$value['title']; ?>"></div> -->
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
                        <div class="tab-pane" id="pills-blogs" role="tabpanel" aria-labelledby="blogs-tab">

                            <!--                           <a href="#" class="card prediction-card text-decoration-none">
                                <div class="banner-img" style="background-image:url(https://imgupload.crowdwisdom.co.in/images/7JBG61tbCN.jpg)"></div>
                                <div class="card-body">
                                    <button class="btn play-btn">
                                        Play Now
                                    </button>
                                    <h6 class="title">
                                        this is title
                                    </h6>
                                    <div class="d-flex justify-content-between">
                                            <div>
                                                <img src="https://www.crowdwisdom360.com/assets/img/clock.svg">
                                                <span class="font-weight-light ml-1">Game Ends In : <span class="font-weight-normal">
                                                        1 Week</span></span>
                                            </div>
                                        <img src="<?= base_url(); ?>assets/img/share.svg">
                                    </div>
                                </div>
                            </a>-->
                            <?php
                            //                            print('<pre>');
                            //                            print_r($sidebar_blogs);
                            if (!empty($sidebar_blogs)) {
                                foreach ($sidebar_blogs as $key => $value) {
                            ?>

                         <!--    <a href="<?= base_url('blog/' . $value['id'].'/'.rtrim(preg_replace('/[^a-zA-Z0-9]+/', '-', $value['title']),"-")).'/' ?>" class="card prediction-card text-decoration-none"> -->
                         <a href="<?= base_url('blog/detail/' . $value['id']) ?>" class="card prediction-card text-decoration-none">
                                        <!-- <div class="banner-img" style="background-image:url(<?= $value['image'] ?>)"></div> -->
                                        <div class="card-body">
                                            <h6 class="title">
                                                <?= $value['title'] ?>
                                            </h6>
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <img src="<?= base_url(); ?>assets/img/calendar.svg">
                                                    <span class="font-weight-light ml-1"><span class="font-weight-normal">
                                                            <?= $value['created_date'] ?></span></span>
                                                </div>
                                                <!-- <img src="<?php //= base_url(); 
                                                                ?>assets/img/share.svg"> -->
                                            </div>
                                        </div>
                                    </a>

                            <?php
                                }
                            } else {
                                echo 'No Blogs Available';
                            }
                            if (!empty($sidebar_blogs) && count($sidebar_blogs) > 5) {

                                echo '<center><button id="sideblog" class="btn btn-danger mt-2 mb-5" data-offset=' . sidebar_card_limit() . '>Load more</button></center>';
                            }
                            ?>
                        </div>
                    </div>
                </div>

                <!--         <div class="data-container">
                    <ul class="nav nav-pills mb-3" id="predection-list-menu" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home"
                               role="tab" aria-controls="pills-home" aria-selected="true">Quiz</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                             aria-labelledby="pills-home-tab">
                            <h5>Coming soon...</h5>
                            <img src="<?= base_url() ?>assets/img/Quiz.gif" class="img-fluid my-3">
                                                        <div class="card prediction-card">
                                                            <div class="banner-img "></div>
                                                            <div class="m-3 py-2">
                                                                <button class="btn play-btn">
                                                                    Play Now
                                                                </button>
                                                                <h6 class="title">
                                                                    Who will be the best bowler in ICC World Cup 2019 ?
                                                                </h6>
                                                            </div>
                                                        </div>
                        </div>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
</div>

<!--sidebar game load-->
<script>
    $(function() {
        var topic_id = '';
        $('#sidegames').click(function() {
            var topics = '';
            var main_offset = parseInt('<?= sidebar_card_limit() ?>');
            var offset = $(this).data('offset');
            $(this).data('offset', offset + main_offset)
            $.ajax({
                url: "<?= base_url('Sidebar/load_games'); ?>",
                type: "POST",
                dataType: 'JSON',
                data: {
                    offset: offset,
                    'topics': topics
                },
                success: function(data) {
                    //console.log(data.length);
                    if (data.length == 0 || data.length < main_offset) {
                        $('#sidegames').hide();
                    }
                    if (data.length != 0) {
                        add_game('sidegames', data);
                    }
                }
            });
        });
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
                    //console.log(data.length);
                    if (data.length == 0 || data.length < main_offset) {
                        $('#sideblog').hide();
                    }
                    if (data.length != 0) {
                        add_blog('sideblog', data);
                    }
                }
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

        function add_blog(selector, data) {
            var div = '';
            $.each(data, function(key, value) {
                /* var str=value.title;
                var string = str.replace(/[^A-Z0-9]+/ig, "-");
                var newString = string.replace(/-+$/,'/');              
                div += '<a href="' + base_url + 'blog/' + value.id + '/'+newString+ '" class="card prediction-card text-decoration-none">'; */
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

        var topic_id = '';
        $('#sidequiz').click(function() {
            var main_offset = 6;
            var offset = $(this).data('offset');
            $(this).data('offset', offset + main_offset)
            $.ajax({
                url: "<?= base_url('Quiz/all_quiz'); ?>",
                type: "POST",
                dataType: 'JSON',
                data: {
                    offset: offset,
                    topicid: topic_id
                },
                success: function(data) {
                    console.log(data);
                    if (data.length == 0 || data.length < main_offset) {
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
        $.each(data, function(key, value) {
            console.log(value);
            div += '<a href="' + base_url + 'quiz/instruction/' + value.quiz_id + '?topic_id=' + value.topic_id + '" class="card prediction-card text-decoration-none">';
            div += '<div class="banner-img" style="background-image:url(' + value.image + ')" title="' + value.name + '"></div>';
            div += '<div class="card-body" >';
            div += '<button class="btn play-btn">';
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
    $(document).ready(function() {
        active_second();
        var all_game_count = parseInt('<?= @$all_game_count ?>');
        var cat_game_count = parseInt('<?= @$cat_game_count ?>');

        var main_offset = parseInt("<?php echo get_game_limit() ?>");
        $('.game_load').click(function() {
            var offset = parseInt($(this).attr('data-offset'));
            $(this).attr('data-offset', (offset + main_offset));
            $.ajax({
                url: "<?= base_url('games/get_all_games'); ?>",
                type: "POST",
                dataType: 'JSON',
                data: {
                    offset: offset
                },
                success: function(data) {
                    if (data.length == 0) {
                        $('.game_load').hide();
                    } else {
                        if (data.length < main_offset) {
                            $('.game_load').hide();
                        }
                        add_topic('all-predection', data);
                        //                        hide_loadmore_btn(all_game_count, 'game_load', data.length);
                    }
                }
            });
        });

        $('.cat_quiz_load').click(function() {
            var offset = parseInt($(this).attr('data-offset'));
            $(this).attr('data-offset', (offset + 4));

            $.ajax({
                url: "<?= base_url('quiz/all_quiz'); ?>",
                type: "POST",
                dataType: 'JSON',
                data: {
                    offset: offset
                },
                success: function(data) {
                    if (data.length == 0) {
                        $('.cat_quiz_load').hide();
                    } else {
                        if (data.length < 4) {
                            $('.cat_quiz_load').hide();
                        }
                        //                        hide_loadmore_btn(cat_game_count, 'cat_quiz_load', data.length);
                        add_quiz('quiz_all_data_list', data);
                    }
                }
            });
        });

        //        function hide_loadmore_btn(all_game_count, selector, response_length) {
        //            var element_count = ($('.' + selector).closest('.tab-pane').find('.col-md-6').length);
        //            if (!(element_count < all_game_count)) {
        //                $('.' + selector).hide();
        //            }
        //        }

        function add_quiz(selector, data) {
            var div = "";
            $.each(data, function(key, value) {
                div += '<div class="col-md-6">';
                div += '<a href="' + base_url + 'quiz/instruction/' + btoa(value.quiz_id) + '?topic_id=' + btoa(value.topic_id) + '" class="card prediction-card text-decoration-none">';
                div += '<div class="banner-img" style="background-image:url(' + value.image + ')" title="' + value.name + '"></div>';
                div += '<div class="card-body">';
                div += '<button class="btn play-btn">';
                div += 'Play Now';
                div += '</button>';
                div += '<h6 class="title text-dark">';
                div += value.name;
                div += '</h6>';
                // div += '<div class="d-flex justify-content-between">';
                // div += '<div>';
                // div += '<img src="'+base_url+'assets/img/clock.svg">';
                // div += '<span class="font-weight-light ml-1">Game Ends In : <span class="font-weight-normal">';
                // div += value.end_date + "</span></span>";
                // div += '</div>';
                // div += '<img src="'+base_url+'assets/img/share.svg" class="d-none">';
                // div += '</div>';
                div += '</div>';
                div += '</a>';
                div += '</div>';
            });
            $('#' + selector).append(div);
        }

    });
</script>
