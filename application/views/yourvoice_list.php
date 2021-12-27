<div class="container-fluid">
    <div class="row">

        <!-- main voice start -->
        <div class="col-md-8 theme-padding main-height">
           
            <div class="row mt-4">
                <div class="col-6">
                    <h1 class="title mb-5" style="font-size:1.5rem;">Blogs</h1>
                </div>
            </div>

            <!--<div id="blog-list">
                <ul class="nav nav-pills mb-3 theme-nav theme-gray-nav" id="pills-tab" role="tablist">

                    <li class="nav-item">
                        <a class="nav-link active" id="pills-all-tab" data-toggle="pill" href="#pills-all" role="tab" aria-selected="false">all</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " id="pills-Politics-tab" data-toggle="pill" href="#pills-Politics" role="tab" aria-selected="true">Politics</a>
                    </li>                
                </ul>
                <div class="tab-content" id="pills-tabContent"> 

                    <div class="tab-pane fade active show" id="pills-all" role="tabpanel" aria-labelledby="pills-all-tab">
                        <div class="row">
                           
                              <div class="col-md-6 blog-list">
                                    <div class="data-container">
                                        <div class="blog-banner shadow" style="background-image:url('http://localhost/crowdwisdom/assets/img/banner.png')"></div>
                                        <div class="d-flex flex-column">
                                            <h6 class="blog-title">Population Control Bill: Modi Government’s Next Mission for New India?</h6>
                                            <div class="mt-auto mb-1">
                                                <img src="<?= base_url() ?>assets/img/calendar.svg" class="img-fluid mr-2"><span>19 Aug 2019</span>
                                            </div>
                                        </div>    
                                    </div>
                                </div> 
                              

                        </div>
                    </div>
 
                    <div class="tab-pane fade " id="pills-Politics" role="tabpanel" aria-labelledby="pills-Politics-tab">
                        22
                    </div>
                </div>
            </div>-->

            <div id="blog-list">
                <div class="row">
                
            <?php
                if(empty($all_blogs)){
                    echo 'No blogs found';
                }else{
                foreach($all_blogs as $key => $value) {
                                ?>
                               <!--  <a href="<?= base_url('blog/'.$value['id'].'/'.rtrim(preg_replace('/[^a-zA-Z0-9]+/', '-', $value['title']),"- ")).'/'?>" class="col-md-6 blog-list text-decoration-none"> -->
                                <a href="<?= base_url('blog/detail/'.$value['id'])?>" class="col-md-6 blog-list text-decoration-none">
                                    <div class="data-container">
                                        <div class="blog-banner shadow" style="background-image:url('<?= $value['image']?>')" title="<?= empty ( @$value['title'] ) ? 'blog_img' : @$value['title']; ?>"></div>
                                        <div class="d-flex flex-column">
                                            <h6 class="blog-title"><?= $value['title']?></h6>
                                            <div class="mt-auto mb-1">
                                                <img src="<?= base_url() ?>assets/img/calendar.svg" class="img-fluid mr-2" alt="calendar"><span><?= $value['created_date']?></span>
                                            </div>
                                        </div>    
                                    </div>
                                </a>
                                <?php
                            }
                        }
                        ?>
                </div>
            </div>

        </div>
        <!-- main voice end -->
 

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
                        <li class="nav-item">
                            <a class="nav-link" id="pills-quiz-tab" data-toggle="pill" href="#pills-quiz"
                               role="tab" aria-controls="pills-quiz" aria-selected="true">Quiz</a>
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
                                        <!-- <div class="banner-img" style="background-image:url(<?= $value['image'] ?>)" title="<?= empty ( @$value['title'] ) ? 'sidebar_games_img' : @$value['title']; ?>"></div> -->
                                        <div class="card-body">
                                            <button class="btn play-btn" style="bottom:-17px;top:unset;right:18px;">
                                                Play Now
                                            </button>
                                            <h6 class="title">
                                                <?= $value['title'] ?>
                                            </h6>
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <img src="<?= base_url(); ?>assets/img/clock.svg" alt="clock">
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
                        <div class="tab-pane fade" id="pills-quiz" role="tabpanel"
                             aria-labelledby="pills-quiz-tab">
                             <?php
                                 if (!empty($sidebar_quiz)) {
                                     foreach ($sidebar_quiz as $key => $value) {
                                         ?>

                                    <a href="<?= base_url('quiz/instruction/' .base64_encode($value['quiz_id']).'?topic_id='.base64_encode($value['topic_id'])) ?>" class="card prediction-card text-decoration-none mb-5">
                                        <!-- <div class="banner-img" style="background-image:url(<?= $value['image'] ?>)" title="<?= empty ( @$value['name'] ) ? 'quiz_img' : @$value['name']; ?>"></div> -->
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
                    </div>
                </div>
            </div>
        </div>
        <!--right side game end-->
    </div>
</div>
<!-- <script data-ad-client="ca-pub-4527310681159742" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script> -->
<!-- <script type="text/javascript">
var infolinks_pid = 3298607;
var infolinks_wsid = 0;
</script>
<script type="text/javascript" src="//resources.infolinks.com/js/infolinks_main.js"></script>-->
<script>

    $(function () {
        var topic_id = '';
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
            div += '<div class="card-body" >';
            div += '<button class="btn play-btn" style="bottom:-17px;top:unset;right:18px;">';
            div += 'Play Now';
            div += '</button>';
            div += '<h6 class="title text-left" >';
            div += value.title;
            div += '</h6>';
            div += '<div class="d-flex justify-content-between" >';
            div += '<div >';
            div += '<img src="' + base_url + 'assets/img/clock.svg" alt="clock">';
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

    $(function () {
        var topic_id = ''; <?php //$category_id; ?>
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
                    console.log(data);
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
            console.log(value);
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
</script>
