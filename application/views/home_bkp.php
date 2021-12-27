<div id="topic-holder" class="container-fluid px-0 d-flex">
    <div class="container pt-md-5 pt-4 webkit-box">
        <div class="row no-gutters">

            <div class="col">
                <div class="d-flex justify-content-between">
                    <h4 class="title text-white mb-4">
                        Hot Topics
                    </h4>
                </div>

                <?php //print_r($topic_data);?>
                <div class="topic-holder d-flex justify-content-between">

                    <div class="topic-container col px-md-0">
                        <?php if (@$topic_data[0]) { ?>
                            <a href="<?= base_url() ?>games/<?= @$topic_data[0]['id'] ?>" class="topic d-block no-hover">
                                <img src="<?= @$topic_data[0]['image'] ?>">  
                                <h6><?= @$topic_data[0]['topic'] ?></h6>
                            </a>
                        <?php } ?>
                        <?php if (@$topic_data[4]) { ?>
                            <a href="<?= base_url() ?>games/<?= @$topic_data[4]['id'] ?>" class="topic d-block no-hover">
                                <img src="<?= @$topic_data[4]['image'] ?>">
                                <h6><?= @$topic_data[4]['topic'] ?></h6>
                            </a>
                        <?php } ?>

                    </div>

                    <div class="topic-container col px-md-0">

                        <?php if (@$topic_data[1]) { ?>
                            <a href="<?= base_url() ?>games/<?= @$topic_data[1]['id'] ?>" class="topic d-block no-hover">
                                <img src="<?= @$topic_data[1]['image'] ?>">
                                <h6><?= @$topic_data[1]['topic'] ?></h6>
                            </a>
                        <?php } ?>
                        <?php if (@$topic_data[5]) { ?>
                            <a href="<?= base_url() ?>games/<?= @$topic_data[5]['id'] ?>" class="topic d-block no-hover">
                                <img src="<?= @$topic_data[5]['image'] ?>">
                                <h6><?= @$topic_data[5]['topic'] ?></h6>
                            </a>
                        <?php } ?>


                    </div>

                    <div class="topic-container col px-md-0">
                        <?php if (@$topic_data[2]) { ?>
                            <a href="<?= base_url() ?>games/<?= @$topic_data[2]['id'] ?>" class="topic d-block no-hover">
                                <img src="<?= @$topic_data[2]['image'] ?>">
                                <h6><?= @$topic_data[2]['topic'] ?></h6>
                            </a>
                        <?php } ?>
                        <?php if (@$topic_data[6]) { ?>
                            <a href="<?= base_url() ?>games/<?= @$topic_data[6]['id'] ?>" class="topic d-block no-hover">
                                <img src="<?= @$topic_data[6]['image'] ?>">
                                <h6><?= @$topic_data[6]['topic'] ?></h6>
                            </a>
                        <?php } ?>
                    </div>

                    <div class="topic-container col px-md-0">
                        <?php if (@$topic_data[3]) { ?>
                            <a href="<?= base_url() ?>games/<?= @$topic_data[3]['id'] ?>" class="topic d-block no-hover">
                                <img src="<?= @$topic_data[3]['image'] ?>">
                                <h6><?= @$topic_data[3]['topic'] ?></h6>
                            </a>
                        <?php } ?>

                        <?php if (@$topic_data[7]) { ?>
                            <a href="<?= base_url() ?>games/<?= @$topic_data[7]['id'] ?>" class="topic d-block no-hover">
                                <img src="<?= @$topic_data[7]['image'] ?>">
                                <h6><?= @$topic_data[7]['topic'] ?></h6>
                            </a>
                        <?php } ?>
                        <?php
                        if (count(@$topic_data) > 8) {
                            ?>
                            <a href="<?= base_url() ?>topic" class="text-white ml-2 text-decoration-none">View all ></a>
                            <?php
                        }
                        ?>

                    </div>

                </div>
                <div class="d-block d-md-none text-center">

                    <?php
                    if (count(@$topic_data) >= 4) {
                        ?>
                        <a href="<?= base_url() ?>topic" class="text-white ml-2 text-decoration-none no-hover">
                            <h6 class="font-weight-normal"><span class="mr-2">View More Topics</span> &gt;</h6>
                        </a>
                        <?php
                    }
                    ?>

                </div>
            </div>
            <div class="col mt-5 ml-md-5 pl-md-5 flex-column justify-content-between d-none d-md-flex">
                <h1 class="text-white ml-md-5 home-predect-title mb-2">Learn,  <br>Predict  and <br>Get Rewarded</h1>
                <div>
                    <!--<img src="<?= base_url(); ?>assets/img/homebanner_man.png" class="img-fluid ">-->
                    <img src="<?= base_url(); ?>assets/img/swiping_cards.gif" class="img-fluid ">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container py-5 my-md-5" id="predection-game-container">
    <div class="row justify-content-center">
        <div class="col-md-6 text-md-center">
            <h4 class="p-title">Prediction Games</h4>
            <!--<p class="p-desc d-none d-md-block">Play Prediction Games, Rule the Leaderboard, Challenge other Players, Collect Points and Win Exciting Rewards. Start Playing Now!</p>-->
        </div>
    </div> 
    <div class="row mt-md-4" id="predection-row">
        <?php
        // echo "<pre>";
        // print_r($prediction_games_list);
        foreach ($prediction_games_list as $key => $value) {
            if ($key <= 3) {
                ?>
                <div class="col-md-3">
                    <a href="<?php echo base_url() ?>Predictions/prediction_game/<?= $value['id'] ?>" class="no-hover text-decoration-none">
                        <div class="card prediction-card">
                            <div class="banner-img " style="background-image: url(<?= @$value['image'] ?>);"></div>
                            <div class="card-body">
                                <button class="btn play-btn">
                                    PLAY NOW
                                </button>
                                <h6 class="title text-dark">
                                    <?= @$value['title'] ?>
                                </h6>
                                <div class="d-flex justify-content-between">
                                    <div class=""> 
                                        <img src="<?php echo base_url() ?>/assets/img/clock.svg">
                                        <span class="font-weight-light ml-1"><?= @$value['game_end_date'] ?></span>
                                    </div>
                                    <div>
                                        <img src="<?php echo base_url() ?>/assets/img/coins.png" class="img-fluid float-left mr-1" style="width:14px; margin-top:5px;">
                                        <span class="font-weight-light ml-1"><?= @$value['req_game_points'] ?></span>
                                        <br>
                                        <small>*required</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <?php
            }
        }
        ?>
        <!--  <div class="col-md-3">
             <div class="card prediction-card">
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
                             <img src="<?php echo base_url() ?>/assets/img/clock.svg">
                             <span class="font-weight-light ml-1">2 Days left</span>
                         </div>
 
                     </div>
                 </div>
             </div>
         </div>
         <div class="col-md-3">
             <div class="card prediction-card">
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
                             <img src="<?php echo base_url() ?>/assets/img/clock.svg">
                             <span class="font-weight-light ml-1">2 Days left</span>
                         </div>
 
                     </div>
                 </div>
             </div>
         </div>
         <div class="col-md-3">
             <div class="card prediction-card">
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
                             <img src="<?php echo base_url() ?>/assets/img/clock.svg">
                             <span class="font-weight-light ml-1">2 Days left</span>
                         </div>
 
                     </div>
                 </div>
             </div>
         </div> -->
    </div>
    <?php
    if (@$prediction_games_list[4]) {
        echo '<a class="d-block text-center text-red no-hover mt-4" href="' . base_url('games') . '">View All <span>&nbsp;&nbsp;></span></a>';
    }
    ?>

</div>
<?php //print_r($quiz_data);   ?>
<!-- play quiz start -->
<div id="play-quiz" class="pt-md-5 d-none d-md-block">
    <div class="container pt-5">
        <div class="row">
            <div class="col-md-4 d-flex flex-column justify-content-between">
                <div>
                    <h2 class="font-weight-bold">Play Quiz &amp; <br>Get Rewarded</h2>
                    <p class="text-gray desc d-none d-md-block">Try Out Your Knowledge in Quiz Games and Win Coins to Achieve Exciting Rewards. Start Playing Now!</p>
                </div>
                <div>
                    <img src="<?= base_url(); ?>assets/img/Quiz.gif" class="img-fluid">
                </div>
            </div>
            <div class="col-md-7 offset-md-1" id="quiz-card-container">
                <div class="row">
                <?php if(!empty($quiz_data)){ ?>
                    <div class="col-md-4">
                        <?php if (!empty(@$quiz_data[0]['name'])) { ?>
                            <a href="<?= base_url() ?>quiz/instruction/<?= base64_encode(@$quiz_data[0]['quiz_id']) ?>?topic_id=<?= base64_encode(@$quiz_data[0]['topic_id']) ?>" class="d-block no-hover">
                                <div class="card prediction-card">
                                    <div class="banner-img " style="background-image: url(<?= @$quiz_data[0]['image'] ?>);"></div>
                                    <div class="card-body">
                                        <button class="btn play-btn">
                                            Play Now
                                        </button>
                                        <h6 class="title">
                                            <?= @$quiz_data[0]['name'] ?>
                                        </h6>

                                    </div>
                                </div>
                            </a>
                        <?php } ?>
                        <?php if (!empty(@$quiz_data[3]['name'])) { ?>
                            <a href="<?= base_url() ?>quiz/instruction/<?= base64_encode(@$quiz_data[3]['quiz_id']) ?>?topic_id=<?= base64_encode(@$quiz_data[3]['topic_id']) ?>" class="d-block no-hover">
                                <div class="card prediction-card">
                                    <div class="banner-img" style="background-image: url(<?= @$quiz_data[3]['image'] ?>);"></div>
                                    <div class="card-body">
                                        <button class="btn play-btn">
                                            Play Now
                                        </button>
                                        <h6 class="title">
                                            <?= @$quiz_data[3]['name'] ?>
                                        </h6>

                                    </div>
                                </div>
                            </a>
                        <?php } ?>
                    </div>
                    <div class="col-md-4 pb-5">
                        <?php if (!empty(@$quiz_data[1]['name'])) { ?>  
                            <a href="<?= base_url() ?>quiz/instruction/<?= base64_encode(@$quiz_data[1]['quiz_id']) ?>?topic_id=<?= base64_encode(@$quiz_data[1]['topic_id']) ?>" class="d-block no-hover">  
                                <div class="card prediction-card">
                                    <div class="banner-img " style="background-image: url(<?= @$quiz_data[1]['image'] ?>);"></div>
                                    <div class="card-body">
                                        <button class="btn play-btn">
                                            Play Now
                                        </button>
                                        <h6 class="title">
                                            <?= @$quiz_data[1]['name'] ?>
                                        </h6>

                                    </div>
                                </div> 
                            </a>                   
                        <?php } if (!empty(@$quiz_data[4]['name'])) { ?> 
                            <a href="<?= base_url() ?>quiz/instruction/<?= base64_encode(@$quiz_data[4]['quiz_id']) ?>?topic_id=<?= base64_encode(@$quiz_data[4]['topic_id']) ?>" class="d-block no-hover">
                                <div class="card prediction-card">
                                    <div class="banner-img " style="background-image: url(<?= @$quiz_data[4]['image'] ?>);"></div>
                                    <div class="card-body">
                                        <button class="btn play-btn">
                                            Play Now
                                        </button>
                                        <h6 class="title">
                                            <?= @$quiz_data[4]['name'] ?>
                                        </h6>

                                    </div>
                                </div>
                            </a>
                            <?php
                        }
                        if (count(@$quiz_data) > 6) {
                            ?> 
                            <a class="d-block text-center text-red " href="<?= base_url()?>quiz/all_quiz_list">View all <span>&nbsp;></span></a>
                        <?php } ?>
                    </div>
                    <div class="col-md-4">
                        <?php if (!empty(@$quiz_data[2]['name'])) { ?>
                            <a href="<?= base_url() ?>quiz/instruction/<?= base64_encode(@$quiz_data[2]['quiz_id']) ?>?topic_id=<?= base64_encode(@$quiz_data[2]['topic_id']) ?>" class="d-block no-hover">
                                <div class="card prediction-card">
                                    <div class="banner-img " style="background-image: url(<?= @$quiz_data[2]['image'] ?>);"></div>
                                    <div class="card-body">
                                        <button class="btn play-btn">
                                            Play Now
                                        </button>
                                        <h6 class="title">
                                            <?= @$quiz_data[2]['name'] ?>
                                        </h6>

                                    </div>
                                </div>
                            </a>
                        <?php } if (!empty(@$quiz_data[5]['name'])) { ?>
                            <a href="<?= base_url() ?>quiz/instruction/<?= base64_encode(@$quiz_data[5]['quiz_id']) ?>?topic_id=<?= base64_encode(@$quiz_data[5]['topic_id']) ?>" class="d-block no-hover">
                                <div class="card prediction-card">
                                    <div class="banner-img " style="background-image: url(<?= @$quiz_data[5]['image'] ?>);"></div>
                                    <div class="card-body">
                                        <button class="btn play-btn">
                                            Play Now
                                        </button>
                                        <h6 class="title">
                                            <?= @$quiz_data[5]['name'] ?>
                                        </h6>

                                    </div>
                                </div>
                            </a>
                        <?php } ?> 
                    </div>
                    <?php }else{ echo "<b>No Quiz Available ! </b>";}?>
                </div>


            </div>
        </div>
    </div>
</div>
<!-- play quiz end -->

<!-- play quiz mobile start -->
<div id="mobile_quiz" class="container d-block d-sm-none">
    <h3>PLAY QUIZ</h3>
    <div id="mobile-play" class="row">
        <?php
        if(!empty($quiz_data)){
        foreach ($quiz_data as $key => $value) {
            ?>   

            <a href="<?= base_url() ?>quiz/instruction/<?= base64_encode(@$value['quiz_id']) ?>?topic_id=<?= base64_encode(@$value['topic_id']) ?>" class="d-block no-hover">
                <div class="col-md-3">
                    <div class="card prediction-card">
                        <div class="banner-img" style="background-image: url(<?= @$value['image'] ?>);"></div>
                        <div class="card-body">
                            <button class="btn play-btn">
                                Play Now
                            </button>
                            <h6 class="title">
                                <?= @$value['name'] ?>
                            </h6>             

                        </div>
                    </div>
                </div>
            </a>
        <?php } }else{ echo "<b>No Quiz Available ! </b>"; }?>    

        <!-- <div class="col-md-3">
            <div class="card prediction-card">
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
                            <img src="<?php echo base_url() ?>/assets/img/clock.svg">
                            <span class="font-weight-light ml-1">2 Days left</span>
                        </div>
        
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card prediction-card">
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
                            <img src="<?php echo base_url() ?>/assets/img/clock.svg">
                            <span class="font-weight-light ml-1">2 Days left</span>
                        </div>
        
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card prediction-card">
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
                            <img src="<?php echo base_url() ?>/assets/img/clock.svg">
                            <span class="font-weight-light ml-1">2 Days left</span>
                        </div>
        
                    </div>
                </div>
            </div>
        </div>-->

    </div>
</div>
<!-- play quiz mobile end -->



<!-- <div class="container py-5" id="home-blogs">
    <div class="row justify-content-center">
        <div class="col-md-6 text-md-center">
            <h4 class="p-title">Blogs</h4>
            <p class="p-desc  d-none d-md-block">Post a Blog to Share Your Views Over a Topic. Read the Blogs to Know the View of Crowd and Upgrade Your Knowledge </p>
        </div>
    </div>
    <div class="row mt-md-5 mt-3 justify-content-center">
        <div class="col-md-8">
            <div class="row">
<?php
// echo"<pre>";
// print_r($blogs_data);
foreach ($blogs_data as $key => $value) {
    ?>
                                                                    <div class="col-md-6 blog-list">
                                                                        <div class="blog-banner" style="background-image:url('<?= base_url() ?>images/blogs/<?= @$value['image'] ?>')";></div>
                                                                        <div>
                                                                            <h6 class="blog-title"><?= $value['title'] ?></h6>
                                                                            <span>Politics</span>&nbsp;<span>.</span>&nbsp;<span><?= $value['blog_date'] ?></span>
                                                                        </div>
                                                                    </div>
<?php } ?>    
<!--<div class="col-md-6 blog-list">
    <div class="blog-banner" style="background-image:url('<?= base_url() ?>assets/img/blog.png')";></div>
    <div>
        <h6 class="blog-title">Population Control Bill: Modi Government’s Next Mission for New India?</h6>
        <span>Politics</span>&nbsp;<span>.</span>&nbsp;<span>19 Aug 2019</span>
    </div>
</div>
<div class="col-md-6 blog-list">
    <div class="blog-banner" style="background-image:url('<?= base_url() ?>assets/img/blog.png')";></div>
    <div>
        <h6 class="blog-title">Population Control Bill: Modi Government’s Next Mission for New India?</h6>
        <span>Politics</span>&nbsp;<span>.</span>&nbsp;<span>19 Aug 2019</span>
    </div>
</div>
<div class="col-md-6 blog-list">
    <div class="blog-banner" style="background-image:url('<?= base_url() ?>assets/img/blog.png')";></div>
    <div>
        <h6 class="blog-title">Population Control Bill: Modi Government’s Next Mission for New India?</h6>
        <span>Politics</span>&nbsp;<span>.</span>&nbsp;<span>19 Aug 2019</span>
    </div>
</div>
<div class="col-md-6 blog-list">
    <div class="blog-banner" style="background-image:url('<?= base_url() ?>assets/img/blog.png')";></div>
    <div>
        <h6 class="blog-title">Population Control Bill: Modi Government’s Next Mission for New India?</h6>
        <span>Politics</span>&nbsp;<span>.</span>&nbsp;<span>19 Aug 2019</span>
    </div>
</div>
<div class="col-md-6 blog-list">
    <div class="blog-banner" style="background-image:url('<?= base_url() ?>assets/img/blog.png')";></div>
<div>
<h6 class="blog-title">Population Control Bill: Modi Government’s Next Mission for New India?</h6>
<span>Politics</span>&nbsp;<span>.</span>&nbsp;<span>19 Aug 2019</span>
</div>
</div>
</div>

</div>
<a class="d-block text-center text-red " href="#">view all <span>&nbsp;></span></a>

</div>-->

<script>
    $(function () {
        $('#predection-row').slick({
            mobileFirst: true,
            infinite: false,
            slidesToShow: 1.2,
            variableWidth: false,
            arrows: false,
            responsive: [
                {
                    breakpoint: 2000,
                    settings: "unslick"
                },
                {
                    breakpoint: 1600,
                    settings: "unslick"
                },
                {
                    breakpoint: 1024,
                    settings: "unslick"
                },
                {
                    breakpoint: 600,
                    settings: "unslick"
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        });
        $('#mobile-play').slick({
            mobileFirst: true,
            infinite: false,
            slidesToShow: 1.2,
            variableWidth: false,
            arrows: false,
            responsive: [
                {
                    breakpoint: 2000,
                    settings: "unslick"
                },
                {
                    breakpoint: 1600,
                    settings: "unslick"
                },
                {
                    breakpoint: 1024,
                    settings: "unslick"
                },
                {
                    breakpoint: 600,
                    settings: "unslick"
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        });
    })
</script>
