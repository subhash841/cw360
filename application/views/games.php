<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 theme-padding main-height">
            <!--<div class="bredcum-holder">
                <a href="<?= base_url() ?>Home">Home /</a>
                <a href="<?= base_url() ?>Games" class="active">Games </a>
            </div> -->
            <div id="games-container" class="my-4">
                <h1 class="title" style="font-size:1.5rem">Fantasy and Prediction Games</h1>

                <!--game list start-->
                <ul class="nav nav-pills mb-3 theme-nav theme-gray-nav" id="pills-tab" role="tablist">
                    <?php
                    if (!empty($category)) {

                        foreach ($category as $key => $value) {
                            if (!$key) {

                                echo '
                <li class="nav-item">
                <a class="nav-link active" id="pills-' . preg_replace('/[^A-Za-z0-9]/', '', str_replace(' ', '', $value)) . '-tab" data-toggle="pill" href="#pills-' . $value . '" role="tab" aria-selected="true">' .  preg_replace('/[^A-Za-z0-9]/', '', str_replace(' ', '', $value)) . '</a>
                </li>';
                            } else {
                                if ($value)
                                    echo '
                <li class="nav-item">
                <a class="nav-link" id="pills-' . preg_replace('/[^A-Za-z0-9]/', '', str_replace(' ', '', $value)) . '-tab" data-toggle="pill" href="#pills-' . preg_replace('/[^A-Za-z0-9]/', '', str_replace(' ', '', $value)) . '" role="tab" aria-selected="true">' . $value . '</a>
                </li>';
                            }
                        }
                    }
                    ?>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <?php

                    if (!empty($category) && !empty($topics)) {
                    ?>

                        <div class="tab-pane fade show active" id="pills-<?= str_replace(' ', '', $category['0']) ?>" role="tabpanel" aria-labelledby="pills-<?= $category['0'] ?>-tab">
                            <div class="row" id="all-predection">
                                <?php
                                foreach ($topics[$category['0']] as $key => $value) {
                                ?>
                                    <div class="col-md-6">
                                        <a href="<?= base_url() ?>Predictions/prediction_game/<?= $value['id'] ?> " class="card prediction-card text-decoration-none no-hover mb-5">
                                            <div class="banner-img" style="background-image:url(<?= $value['image'] ?>)" title="<?= empty(@$value['title']) ? 'topic_img' : @$value['title']; ?>"></div> 
                                            <div class="card-body">
                                                <button class="btn play-btn" style="bottom:-17px;top:unset;right:18px;">
                                                    Play Now
                                                </button>
                                                <h6 class="title text-dark">
                                                    <?= $value['title'] ?>
                                                </h6>
                                                <div class="d-flex justify-content-between">
                                                    <div>
                                                        <img src="<?= base_url() ?>assets/img/clock.svg">
                                                        <span class="font-weight-light ml-1"><span class="font-weight-normal">
                                                                <?= $value['end_date'] ?></span></span>
                                                    </div>
                                                    <div>
                                                        <img src="<?= base_url() ?>assets/img/coin.png" class="img-fluid" style="width:14px;">
                                                        <span class="font-weight-light ml-1"><?= $value['req_game_points'] ?></span>
                                                        <br>
                                                        <small>*Required</small>
                                                    </div>
                                                    <img src="<?= base_url() ?>assets/img/share.svg" class="d-none">
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                <?php
                                }
                                $game_btn = '';
                                $game_limit = get_game_limit();
                                //                                    echo '<hr>';
                                //                                    echo $a = count($topics[$category['0']]);
                                //                                    die;
                                if ((count($topics[$category['0']]) + 1) > $game_limit) {
                                    $game_btn = '<div class="col-12 text-center"><button class="game_load btn btn-danger" data-offset=' . get_game_limit() . '>Load more</button></div>';
                                }
                                ?>
                            </div>
                            <?= $game_btn ?>
                            <?php if (count($topics[$category['0']]) == 0) {
                            ?>
                                <!--empty infographics strat end-->
                                <div class="no-games text-center my-5 pt-3">
                                    <h5 class="font-weight-bold cw-text-color-gray">
                                        No Games available
                                    </h5>
                                    <img class="img-fluid my-5" src="<?= base_url(); ?>assets/img/no-prediction-games.svg">
                                    <!--  <a href="javascript:void(0)">
                                        <h6 class="font-weight-bold try-games-text">
                                            Try out other Games
                                        </h6>
                                    </a> -->
                                </div>
                                <!--empty infographics  end-->
                            <?php }
                            ?>
                        </div>

                        <div class="tab-pane fade " id="pills-<?= preg_replace('/[^A-Za-z0-9]/', '', str_replace(' ', '', @$category['1'])) ?>" role="tabpanel" aria-labelledby="pills-<?= preg_replace('/[^A-Za-z0-9]/', '', str_replace(' ', '', @$category['1'])) ?>-tab">
                            <div class="row" id="category-predection">
                                <?php
                                foreach ($topics[$category['1']] as $key => $value) {
                                ?>
                                    <div class="col-md-6">
                                        <a href="<?= base_url() ?>Predictions/prediction_game/<?= $value['id'] ?> " class="card prediction-card text-decoration-none no-hover mb-5">
                                            <div class="banner-img" style="background-image:url(<?= $value['image'] ?>)" title="<?= empty(@$value['title']) ? 'game_img' : @$value['title']; ?>"></div> 
                                            <div class="card-body">
                                                <button class="btn play-btn" style="bottom:-17px;top:unset;right:18px;">
                                                    Play Now
                                                </button>
                                                <h6 class="title text-dark">
                                                    <?= $value['title'] ?>
                                                </h6>
                                                <div class="d-flex justify-content-between">
                                                    <div>
                                                        <img src="<?= base_url() ?>assets/img/clock.svg">
                                                        <span class="font-weight-light ml-1"><span class="font-weight-normal">
                                                                <?= $value['end_date'] ?></span></span>
                                                    </div>
                                                    <div>
                                                        <img src="<?= base_url() ?>assets/img/coin.png" class="img-fluid" style="width:14px;">
                                                        <span class="font-weight-light ml-1"><?= $value['req_game_points'] ?></span>
                                                        <br>
                                                        <small>*Required</small>
                                                    </div>
                                                    <img src="<?= base_url() ?>assets/img/share.svg" class="d-none">
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                <?php
                                }
                                ?>
                                <?php
                                $category_btn = '';
                                $game_limit = get_game_limit();
                                if ((count($topics[$category['1']]) + 1) > $game_limit) {
                                    $category_btn = '<div class="col-12 text-center"><button id="cat_game_load_id" class="cat_game_load btn btn-danger" data-category=' . $category_id . ' data-offset=' . get_game_limit() . '>Load more</button></div>';
                                }
                                ?>
                            </div>

                            <?= $category_btn ?>
                            <?php if (count($topics[$category['1']]) == 0) {
                            ?>
                                <!--empty infographics strat end-->
                                <div class="no-games text-center my-5 pt-3 ">
                                    <h5 class="font-weight-bold cw-text-color-gray">
                                        No Games available
                                    </h5>
                                    <img class="img-fluid my-5" src="<?= base_url(); ?>assets/img/no-prediction-games.svg">
                                    <a href="javascript:void(0)">
                                        <h6 class="font-weight-bold try-games-text">
                                            Try out other Games
                                        </h6>
                                    </a>
                                </div>
                                <!--empty infographics  end-->
                            <?php }
                            ?>
                        </div>
                    <?php
                    }
                    ?>
                    <!--                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                    
                                        </div>-->
                </div>
                <!--game list end-->


                <!--game html list start -->
                <!--<ul class="nav nav-pills mb-3 theme-nav theme-gray-nav" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-selected="true">All</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-selected="false">Cricket World Cup</a>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card prediction-card ">
                                    <div class="banner-img "></div>
                                    <div class="card-body">
                                        <button class="btn play-btn">
                                            Play Now
                                        </button>
                                        <h6 class="title">
                                            World Cup Semi Finals Phase 2
                                        </h6>
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <img src="<?= base_url(); ?>assets/img/clock.svg">
                                                <span class="font-weight-light ml-1"><span
                                                        class="font-weight-normal">
                                                        1 Week</span></span>
                                            </div>
                                            <img src="<?= base_url(); ?>assets/img/share.svg">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card prediction-card ">
                                    <div class="banner-img "></div>
                                    <div class="card-body">
                                        <button class="btn play-btn">
                                            Play Now
                                        </button>
                                        <h6 class="title">
                                            World Cup Semi Finals Phase 2
                                        </h6>
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <img src="<?= base_url(); ?>assets/img/clock.svg">
                                                <span class="font-weight-light ml-1"><span
                                                        class="font-weight-normal">
                                                        1 Week</span></span>
                                            </div>
                                            <img src="<?= base_url(); ?>assets/img/share.svg">
                                        </div>
                                    </div>
                                </div>
                            </div>
                           

                        </div>

                    </div>
                    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">b...</div>
                </div> -->
                <!--game html list end-->


            </div>
            <!--empty infographics strat end-->
            <div class="no-games text-center my-5 pt-3 d-none">
                <h5 class="font-weight-bold cw-text-color-gray">
                    No Games available
                </h5>
                <img class="img-fluid my-5" src="<?= base_url(); ?>assets/img/no-prediction-games.svg">
                <a href="#!">
                    <h6 class="font-weight-bold try-games-text">
                        Try out other Games
                    </h6>
                </a>
            </div>
            <!--empty infographics  end-->
        </div>

        <div class="col-md-4 theme-bg theme-padding main-height">
            <div class="predection-list">
                <h3 class="title">Explore More</h3>
                <div class="data-container">
                    <ul class="nav nav-pills mb-3" id="predection-list-menu" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Quiz</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-blogs-tab" data-toggle="pill" href="#pills-blogs" role="tab" aria-controls="pills-blogs" aria-selected="false">Blogs</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
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
                                
                                echo '<center><button id="sidequiz" class="btn btn-danger mt-2 mb-5" data-offset=' . sidebar_card_limit() . '>Load more</button></center>';
                            }*/

                            if (!empty($sidebar_quiz)) {
                                foreach ($sidebar_quiz as $key => $value) {
                            ?>

                                    <a href="<?= base_url('quiz/instruction/' . base64_encode($value['quiz_id']) . '?topic_id=' . base64_encode($value['topic_id'])) ?>" class="card prediction-card text-decoration-none mb-5">
                                        <!-- <div class="banner-img" style="background-image:url(<?= $value['image'] ?>)" title="<?= empty(@$value['name']) ? 'sidebar_quiz' : @$value['name']; ?>"></div> -->
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
                        <div class="tab-pane fade" id="pills-blogs" role="tabpanel" aria-labelledby="pills-blogs-tab">
                            <?php
                            if (!empty($sidebar_blogs)) {
                                foreach ($sidebar_blogs as $key => $value) {
                            ?>

                                    <!-- <a href="<?= base_url('blog/' . $value['id'].'/'.trim(preg_replace('/[^a-zA-Z0-9]+/', '-', $value['title']),'-').'/') ?>" class="card prediction-card text-decoration-none"> -->
                                    <a href="<?= base_url('blog/detail/' . $value['id']) ?>" class="card prediction-card text-decoration-none">
                                        <!-- <div class="banner-img" style="background-image:url(<?= $value['image'] ?>)" title="<?= empty(@$value['title']) ? 'sidebar_quiz' : @$value['title']; ?>"></div> -->
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
        $('#sidequiz').click(function() {
            var main_offset = parseInt('<?= sidebar_card_limit() ?>');
            var offset = $(this).data('offset');
            $(this).data('offset', offset + main_offset)
            $.ajax({
                url: "<?= base_url('Sidebar/load_quiz'); ?>",
                type: "POST",
                dataType: 'JSON',
                data: {
                    offset: offset,
                    topics: topic_id
                },
                success: function(data) {
                    if (data.length == 0 || data.length < main_offset) {
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
        $.each(data, function(key, value) {
            div += '<a href="' + base_url + 'quiz/instruction/' + btoa(value.quiz_id) + '?topic_id=' + btoa(value.topic_id) + '" class="card prediction-card text-decoration-none mb-5">';
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

        $.ajaxSetup({
            beforeSend: function() {
                $("#cat_game_load_id.cat_game_load").show();
            },
            complete: function() {
                $("#cat_game_load_id.cat_game_load").hide();
            }
        });
        $('.cat_game_load').click(function() {
            var offset = parseInt($(this).attr('data-offset'));
            $(this).attr('data-offset', (offset + main_offset));
            var category = $(this).attr('data-category');
            $.ajax({
                url: "<?= base_url('games/get_cat_games'); ?>",
                type: "POST",
                dataType: 'JSON',
                data: {
                    offset: offset,
                    category: category
                },
                success: function(data) {
                    if (data.length == 0) {
                        $('.cat_game_load').hide();
                    } else {
                        if (data.length < main_offset) {
                            $('.cat_game_load').hide();
                        }
                        //                        hide_loadmore_btn(cat_game_count, 'cat_game_load', data.length);
                        add_topic('category-predection', data);
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

        function add_topic(selector, data) {
            var div = "";
            $.each(data, function(key, value) {
                div += '<div class="col-md-6">';
                div += '<a href=' + base_url + 'Predictions/prediction_game/' + value.id + ' class="card prediction-card text-decoration-none no-hover ">';
               div += '<div class="banner-img" style="background-image:url(' + value.image + ')" title="' + value.title + '"></div>';
                div += '<div class="card-body">';
                div += '<button class="btn play-btn">';
                div += 'Play Now';
                div += '</button>';
                div += '<h6 class="title text-dark">';
                div += value.title;
                div += '</h6>';
                div += '<div class="d-flex justify-content-between">';
                div += '<div>';
                div += '<img src="' + base_url + 'assets/img/clock.svg">';
                div += '<span class="font-weight-light ml-1"><span class="font-weight-normal">';
                div += value.end_date + "</span></span>";
                div += '</div>';

                div += '<div>';
                div += '<img src="' + base_url + 'assets/img/coin.png" class="img-fluid" style="width:14px">';
                div += '<span class="font-weight-light ml-1">' + value.req_game_points + '</span>';
                div += '<br>';
                div += '<small>*Required</small>';
                div += '</div>';

                div += '<img src="' + base_url + 'assets/img/share.svg" class="d-none">';
                div += '</div>';
                div += '</div>';
                div += '</a>';
                div += '</div>';
            });
            $('#' + selector).append(div);
        }

    });

    $('#sideblog').click(function() {
        var topic_id = '';
        var main_offset = parseInt('<?= sidebar_card_limit() ?>');
        var offset = $(this).data('offset');
        // console.log("hi");
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

    function add_blog(selector, data) {
        var div = '';
        $.each(data, function(key, value) {
            /* var str=value.title;
            var string = str.replace(/[^A-Z0-9]+/ig, "-");
            var newString = string.replace(/-+$/,'/');
            div += '<a href="' + base_url + 'blog/' + value.id +'/'+newString+'" class="card prediction-card text-decoration-none">'; */
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
