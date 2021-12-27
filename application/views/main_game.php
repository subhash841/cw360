<div class="container-fluid">
    <div class="row">

        <div class="col-md-8 theme-padding main-height  <?= (@$user_summary_joureny == true )? 'min-h-720' : '' ?> <?= (@$user_leaderboard_joureny == true)? 'sm-hide-scroll' : '' ?>"
        <?= (@$user_leaderboard_joureny == true )? "style='overflow: visible;'" : "style=overflow-x: hidden;'" ?> >
            <div id="predection-container">
                <h5 class="title mt-4"><?= $game_details['title'] ?></h5>
                <div class="profile-info position-relative ml-md-0 row bg-darkblue ">
                     <div class="holder col-3">
                         <h6 class="title">Rank</h6>
                         <h6 class="mb-0"><img src="<?= base_url(); ?>assets/img/trophy.svg" class="img-fluid"><b id="user_rank"><?=$portfolio_data['user_rank']?></b></h6>
                     </div>
                     <div class="holder col">
                         <h6 class="title">Portfolio</h6>
                         <h6 class="mb-0"><b id="portfolioPoints"><?=round($portfolio_data['user_points'])?></b><span>Coins</span></h6>
                     </div>
                    <div class="holder col border-0">
                        <h6 class="title">Available</h6>
                        <h6 class="mb-0"><b id="availablePoints"><?= empty($available_points['points']) ? '0' : round($available_points['points']) ?></b><span>Coins</span></h6>
                    </div>
                    <?php if (!empty($this->user_id)):?>
                    <div class="position-absolute cursor-pointer" style="top: 0;right: 0" id="portfolio_refresh" data-toggle="tooltip" title="Refresh">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 491.236 491.236" style="enable-background:new 0 0 491.236 491.236;" xml:space="preserve" width="20px" height="20px" fill="grey" class="refreshtoporders">
                            <g><g>
                                    <path d="M55.89,262.818c-3-26-0.5-51.1,6.3-74.3c22.6-77.1,93.5-133.8,177.6-134.8v-50.4c0-2.8,3.5-4.3,5.8-2.6l103.7,76.2    c1.7,1.3,1.7,3.9,0,5.1l-103.6,76.2c-2.4,1.7-5.8,0.2-5.8-2.6v-50.3c-55.3,0.9-102.5,35-122.8,83.2c-7.7,18.2-11.6,38.3-10.5,59.4    c1.5,29,12.4,55.7,29.6,77.3c9.2,11.5,7,28.3-4.9,37c-11.3,8.3-27.1,6-35.8-5C74.19,330.618,59.99,298.218,55.89,262.818z     M355.29,166.018c17.3,21.5,28.2,48.3,29.6,77.3c1.1,21.2-2.9,41.3-10.5,59.4c-20.3,48.2-67.5,82.4-122.8,83.2v-50.3    c0-2.8-3.5-4.3-5.8-2.6l-103.7,76.2c-1.7,1.3-1.7,3.9,0,5.1l103.6,76.2c2.4,1.7,5.8,0.2,5.8-2.6v-50.4    c84.1-0.9,155.1-57.6,177.6-134.8c6.8-23.2,9.2-48.3,6.3-74.3c-4-35.4-18.2-67.8-39.5-94.4c-8.8-11-24.5-13.3-35.8-5    C348.29,137.718,346.09,154.518,355.29,166.018z"></path>
                                </g>
                            </g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g>
                        </svg>
                    </div>
                    <?php endif; ?>
                </div>
                <?php
                // echo $game_details['end_date'];
                //echo date('Y-m-d H:i:s');
                 // if((time()-(60*60*24)) < strtotime($game_details['end_date'])){echo "if";}else{echo "else";}
                    if (!empty($this->user_id) && $game_id > 268 && !empty($available_points) && (date('Y-m-d H:i:s') < $game_details['end_date'])):?>
                    <div class="d-inline-flex coins-conversion-details-holder">
                        <button id='coins-conversion-details' class="btn point-btn text-white">Add Coins</button>
                    </div>
                <?php endif; ?>

                <div class="d-md-flex predection-data-container">
                    <!--left menu start-->
                    <div>
                        <div class="predection-topics w-100 mb-2">
                            <?php
                            $viewname = strtolower($this->uri->segment(2));
                            ?>
                            <div class="nav flex-md-column flex-row justify-content-evenly nav-pills w-100" id="v-pills-tab" >
                                <a class="nav-link <?= @$viewname == 'prediction_game' ? 'active' : '' ?>" id="v-pills-game-tab"href="<?= base_url('Predictions/prediction_game/' . $game_id) ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="23.071" height="20.727" viewBox="0 0 23.071 20.727">
                                        <g id="Group_934" data-name="Group 934" transform="translate(-28.191 -760.245)">
                                            <g id="Rectangle_1415" data-name="Rectangle 1415" transform="translate(39.861 761.245) rotate(20)" fill="#fff" stroke="#a1a6ae" stroke-width="1">
                                                <rect width="12.133" height="16.577" rx="2" stroke="none"/>
                                                <rect x="0.5" y="0.5" width="11.133" height="15.577" rx="1.5" fill="none"/>
                                            </g>
                                            <g id="Rectangle_583" data-name="Rectangle 583" transform="translate(33.66 761.82)" fill="#fff" stroke="#a1a6ae" stroke-width="1">
                                                <rect width="12.133" height="16.577" rx="2" stroke="none"/>
                                                <rect x="0.5" y="0.5" width="11.133" height="15.577" rx="1.5" fill="none"/>
                                            </g>
                                            <g id="Rectangle_1414" data-name="Rectangle 1414" transform="translate(28.191 764.395) rotate(-20)" fill="#fff" stroke="#a1a6ae" stroke-width="1">
                                                <rect width="12.133" height="16.577" rx="2" stroke="none"/>
                                                <rect x="0.5" y="0.5" width="11.133" height="15.577" rx="1.5" fill="none"/>
                                            </g>
                                        </g>
                                    </svg>
                                    <span>Game</span></a>
                                    
                                <a class="nav-link <?= (@$user_leaderboard_joureny == true)? 'position-relative bg-white zindex-20' : '' ?> <?= @$viewname == 'leaderboard' ? 'active' : '' ?>" id="v-pills-leaderboard" 
                                    href="<?= (@$user_leaderboard_joureny == true )? 'javascript:void(0)': base_url('Predictions/leaderboard/' . $game_id) ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22.796" height="20.59" viewBox="0 0 22.796 20.59" fill="red">
                                        <g id="Group_15" data-name="Group 15" transform="translate(-173.681 -763.5)" opacity="0.4">
                                            <g id="Group_13" data-name="Group 13" transform="translate(174.181 764)">
                                                <path id="Path_13" data-name="Path 13" d="M36.2,16.842H49.552a.632.632,0,0,1,.632.632v5.572a7.306,7.306,0,0,1-7.305,7.305h0a7.306,7.306,0,0,1-7.305-7.305V17.474A.632.632,0,0,1,36.2,16.842Z" transform="translate(-31.987 -16.842)" fill="none" stroke="#162237" stroke-miterlimit="10" stroke-width="1"/>
                                                <path id="Rectangle_5" data-name="Rectangle 5" d="M2.71,0h4.7a2.71,2.71,0,0,1,2.71,2.71v0A1.008,1.008,0,0,1,9.108,3.718h-8.1A1.008,1.008,0,0,1,0,2.71v0A2.71,2.71,0,0,1,2.71,0Z" transform="translate(5.833 15.872)" fill="none" stroke="#162237" stroke-miterlimit="10" stroke-width="1"/>
                                                <line id="Line_1" data-name="Line 1" y2="2.363" transform="translate(10.891 13.509)" fill="none" stroke="#162237" stroke-miterlimit="10" stroke-width="1"/>
                                                <path id="Rectangle_6" data-name="Rectangle 6" d="M0,0H2.967A.632.632,0,0,1,3.6.632v.5A3.6,3.6,0,0,1,0,4.725H0a0,0,0,0,1,0,0V0A0,0,0,0,1,0,0Z" transform="translate(18.198 1.795)" fill="none" stroke="#162237" stroke-miterlimit="10" stroke-width="1"/>
                                                <path id="Rectangle_7" data-name="Rectangle 7" d="M0,0H0A3.6,3.6,0,0,1,3.6,3.6v.5a.632.632,0,0,1-.632.632H0a0,0,0,0,1,0,0V0A0,0,0,0,1,0,0Z" transform="translate(3.598 6.52) rotate(180)" fill="none" stroke="#162237" stroke-miterlimit="10" stroke-width="1"/>
                                                <path id="Path_14" data-name="Path 14" d="M66.822,42.045a5.084,5.084,0,0,1-3.162,2.581" transform="translate(-51.204 -34.086)" fill="none" stroke="#162237" stroke-miterlimit="10" stroke-width="1"/>
                                            </g>
                                        </g>
                                    </svg>
                                 
                                 <?php if(@$user_leaderboard_joureny){ ?>
                                    
                                    <img src="<?= base_url()?>assets/img/top.png" class="top-img">
                                    <div class="position-absolute" id="info">
                                        <h6 style="font-size:0.8rem;text-transform: none;" class="font-weight-light">
                                        Press <span style="color: #91AEFF;font-weight: 700;" class="head font-weight-bold">Leaderboard</span>  to see your position amongst other players and your total coins.
                                        </h6>
                                    </div>

                                    <div class="position-absolute" id="images">
                                        <img alt="image will be here" class="img-fluid" src="<?= base_url()?>assets/img/1.png">
                                        <img alt="image will be here" class="img-fluid" src="<?= base_url()?>assets/img/2.png">
                                    </div>

                                    <?php } ?>


                                    <span>Leaderboard</span>
                                </a>
                                <a class="nav-link  <?= (@$user_summary_joureny == true )? 'position-relative bg-white zindex-20' : '' ?> <?= @$viewname == 'summary' ? 'active' : '' ?>" id="v-pills-basket" 
                                href="<?= (@$user_summary_joureny == true )? 'javascript:void(0)': base_url('Predictions/summary/' . $game_id); ?> ">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="19" viewBox="0 0 18 19">
                                      <g id="Group_3129" data-name="Group 3129" transform="translate(-116.5 -409.5)">
                                        <rect id="Rectangle_2410" data-name="Rectangle 2410" width="10" height="4" rx="1" transform="translate(124 410)" fill="none" stroke="#a1a6ae" stroke-width="1"/>
                                        <rect id="Rectangle_2411" data-name="Rectangle 2411" width="10" height="4" rx="1" transform="translate(124 417)" fill="none" stroke="#a1a6ae" stroke-width="1"/>
                                        <rect id="Rectangle_2412" data-name="Rectangle 2412" width="10" height="4" rx="1" transform="translate(124 424)" fill="none" stroke="#a1a6ae" stroke-width="1"/>
                                        <rect id="Rectangle_2413" data-name="Rectangle 2413" width="4" height="4" rx="1" transform="translate(117 410)" fill="none" stroke="#a1a6ae" stroke-width="1"/>
                                        <rect id="Rectangle_2414" data-name="Rectangle 2414" width="4" height="4" rx="1" transform="translate(117 417)" fill="none" stroke="#a1a6ae" stroke-width="1"/>
                                        <rect id="Rectangle_2415" data-name="Rectangle 2415" width="4" height="4" rx="1" transform="translate(117 424)" fill="none" stroke="#a1a6ae" stroke-width="1"/>
                                      </g>
                                    </svg> 
                                    <span>Summary</span>

                                    <?php if(@$user_summary_joureny){ ?>
                                    
                                    <!-- desktop summary journey start -->
                                    <img src="<?= base_url()?>assets/img/top.png" class="position-absolute top-img d-none d-lg-block d-xl-block d-md-block ">
                                    <div class="position-absolute d-none d-lg-block d-xl-block d-md-block " id="summary">
                                        <h6 style="font-size:0.8rem;line-height: 19px;text-transform: none;">
                                                <span class="head font-weight-bold" style="color: #91AEFF;font-weight: 700;">Game Summary</span>
                                                <br>Appears after all the predictions are swiped. This screen shows played, skipped and completed predictions. You can also see the profit or loss gained in each prediction. Predictions will be completed as soon as the end date timer is over.
                                        </h6>
                                        <br>
                                        <!-- <h6>
                                                You can change your view of the prediction by clicking on to the <b> change to no button</b>
                                        </h6> -->
                                        <h6 style="font-size:0.8rem;line-height: 19px;text-transform: none;">
                                        You can change your view of the prediction by clicking on to the 
                                            <br>
                                            <span class="min-head text-white" style="font-weight: 500; font-size:14px">CHANGE TO NO</span> button
                                        </h6>
                                        <img src="<?= base_url()?>assets/img/no.png" class="img-fluid mb-4">
                                        <h6 style="font-size:0.8rem;line-height: 19px;text-transform: none;">
                                        You can change your view of the prediction by clicking on to the 
                                            <span  class="min-head text-white" style="font-weight: 500; font-size:14px">CHANGE TO YES </span>button
                                        </h6>
                                        <img src="<?= base_url()?>assets/img/yes.png" class="img-fluid mb-4">
                                        <h6 style="font-size:0.8rem;line-height: 19px;text-transform: none;">
                                        Completed predictions will appear with  
                                            <span class="min-head text-white" style="font-weight: 500; font-size:14px">COMPLETED</span>  tag. 
                                        </h6>
                                        <img src="<?= base_url()?>assets/img/comp.png" class="img-fluid mb-4">
                                    </div>

                                    <div class="position-absolute summary_journey d-none d-lg-block d-xl-block d-md-block " id="image-holder">
                                        <img alt="image will be here" src="<?= base_url()?>assets/img/m1.png" class="img-fluid mb-2">
                                        <img alt="image will be here" src="<?= base_url()?>assets/img/m2.png" class="img-fluid mb-2">
                                        <img alt="image will be here" src="<?= base_url()?>assets/img/m3.png" class="img-fluid mb-2">
                                    </div>
                                    <!-- desktop summary journey end -->

                                    <!-- mobile summary start -->
                                    <img src="<?= base_url()?>assets/img/summary_top.png" class="position-absolute  d-sm-block d-md-none" style="top:48px;">
                                    <div class="responsive-summary position-absolute mt-5  d-sm-block d-md-none">
                                        <div id="carouselExampleSlidesOnly" class="carousel slide" data-touch="false" data-ride="false">
                                            <div class="carousel-inner">
                                                <div class="carousel-item active ">
                                                    <h6 style="text-transform:none;">
                                                    <span class="head font-weight-bold" style="color: #91AEFF;font-weight: 700;">Game Summary </span>
                                                    <br>Appears after all the predictions are swiped.<br> This screen shows played, skipped and completed predictions. You can also see the profit or loss gained in each prediction. Predictions will be completed as soon as the end date timer is over.
                                                    <br>
                                                    <br>You can change your view of the prediction by clicking on to the <b class="h6">CHANGE TO NO</b> button
                                                    </h6>
                                                    <img src="<?= base_url()?>assets/img/no.png" class="img-fluid mb-4">
                                                    <img alt="image will be here" src="<?= base_url()?>assets/img/mo-no.png" class="img-fluid mb-2">
                                                </div>
                                                <div class="carousel-item second">
                                                    <h6 style="text-transform:none;">
                                                    You can change your view of the prediction by clicking on to the <b class="h6">CHANGE TO YES</b> button
                                                    </h6>
                                                    <img src="<?= base_url()?>assets/img/yes.png" class="img-fluid mb-4">
                                                    <img alt="image will be here" src="<?= base_url()?>assets/img/mo-yes.png" class="img-fluid mb-2">
                                                </div>
                                                <div class="carousel-item last">
                                                    <h6 style="text-transform:none;">Completed predictions will appear with <b class="h6">COMPLETED </b>tag.</h6>
                                                    <img src="<?= base_url()?>assets/img/comp.png" class="img-fluid mb-4">
                                                    <img alt="image will be here" src="<?= base_url()?>assets/img/mo-comp.png" class="img-fluid mb-2">
                                                </div>
                                            </div>
                                        </div>
                                        <script>
                                        $('.next-slide').click(function(){
                                            var second = $('.carousel-item.second').hasClass('active');
                                            var last = $('.carousel-item.last').hasClass('active');
                                            if(second){
                                                $('.mob-right-arrow').attr('src',base_url+'assets/img/close.png')
                                            }
                                            if(last){
                                                location.reload();
                                                return;
                                            }
                                            $('#carouselExampleSlidesOnly').carousel('next');
                                        });
                                        $(function(){
                                            var width = window.innerWidth;
                                            if(width > 768){
                                                $('.mob-right-arrow').attr({'src':base_url+'assets/img/close.png','onclick':'location.reload()'});
                                                // alert()
                                            }
                                        })
                                        </script>
                                    </div>
                                    <!-- mobile summary end -->

                                    <?php } ?>


                                </a>
                                <a class="nav-link <?= @$viewname == 'rules_rewards' ? 'active' : '' ?>" id="v-pills-rewards"   href="<?= base_url('Predictions/rules_rewards/' . $game_id) ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="19.257" height="20.59" viewBox="0 0 19.257 20.59">
                                        <g id="Group_2874" data-name="Group 2874" transform="translate(-49.253 -30.417)">
                                            <path id="Path_10050" data-name="Path 10050" d="M63.847,129.744H51.11a1.357,1.357,0,0,1-1.357-1.357v-1.029a1.015,1.015,0,0,1,1.015-1.015H61.56a1.015,1.015,0,0,1,1.015,1.015v1.029a1.357,1.357,0,0,0,1.357,1.357h0a1.357,1.357,0,0,0,1.357-1.357V113.944a1.015,1.015,0,0,0-1.015-1.015H53.435a1.015,1.015,0,0,0-1.015,1.015v12.388" transform="translate(0 -79.237)" fill="none" stroke="#a1a6ae" stroke-linecap="round" stroke-miterlimit="10" stroke-width="1"/>
                                            <path id="Path_10051" data-name="Path 10051" d="M217.548,47.841h1.706a1.015,1.015,0,0,0,1.015-1.015V31.932a1.015,1.015,0,0,0-1.015-1.015H208.36a1.015,1.015,0,0,0-1.015,1.015v1.762" transform="translate(-152.259 0)" fill="none" stroke="#a1a6ae" stroke-linecap="round" stroke-miterlimit="10" stroke-width="1"/>
                                            <path id="Path_10054" data-name="Path 10054" d="M1,0H5.3" transform="translate(56.378 37.417)" fill="none" stroke="#a1a6ae" stroke-linecap="round" stroke-width="1"/>
                                            <path id="Path_10053" data-name="Path 10053" d="M7,0H1" transform="translate(54.686 40.471)" fill="none" stroke="#a1a6ae" stroke-linecap="round" stroke-width="1"/>
                                            <path id="Path_10052" data-name="Path 10052" d="M7,0H1" transform="translate(54.686 43.524)" fill="none" stroke="#a1a6ae" stroke-linecap="round" stroke-width="1"/>
                                        </g>
                                    </svg>
                                    <span>Rules & Rewards</span>
                                </a>

                            </div>
                        </div>
                    </div>
                    <!--left menu end-->

                    <!--game div start-->

                    <div class="w-100">
                        <?php $this->load->view($view_name); ?>
                    </div>
                    <!--game div end-->

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
                                 /*if (!empty($sidebar_games)) {
                                     foreach ($sidebar_games as $key => $value) {
                                         ?>

                                    <a href="<?= base_url('Predictions/prediction_game/' . $value['id']) ?>" class="card prediction-card text-decoration-none">
                                        <div class="banner-img" style="background-image:url(<?= $value['image'] ?>)"></div>
                                        <div class="card-body">
                                            <button class="btn play-btn">
                                                Play Now
                                            </button>
                                            <h6 class="title">
                                                <?= $value['title'] ?>
                                            </h6>
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <img src="<?= base_url(); ?>assets/img/clock.svg">
                                                        <span class="font-weight-light ml-1">Game Ends In : <span
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
                            if (!empty($sidebar_games) && count($sidebar_games) > 3) {
                                
                                echo '<center><button id="sidegames" class="btn btn-danger mt-2 mb-5" data-offset=' . get_right_side_game_limit() . '>Load more</button></center>';
                            }*/
                                
                            if (!empty($sidebar_quiz)) {
                                     foreach ($sidebar_quiz as $key => $value) {
                                         ?>

                                    <a href="<?= base_url('quiz/instruction/' .base64_encode($value['quiz_id']).'?topic_id='.base64_encode($value['topic_id'])) ?>" class="card prediction-card text-decoration-none mb-5">
                                        <!-- <div class="banner-img" style="background-image:url(<?= $value['image'] ?>)"></div> -->
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

                                <!--     <a href="<?= base_url('blog/' . $value['id'].'/'.rtrim(preg_replace('/[^a-zA-Z0-9]+/', '-', $value['title']),'-').'/') ?>" class="card prediction-card text-decoration-none"> -->
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
    
<?php
    $this->load->view('popup/coins_conversion');  //Coins conversion popup  
?>
<!--sidebar game load-->
<script>
    $(function () {
        var topic_id = '<?= $game_details['topic_id']; ?>';
        var game_id = '<?= $game_id ?>';
        $('#sidegames').click(function () {
            var main_offset = parseInt('<?= get_right_side_game_limit() ?>');
            var offset = $(this).data('offset');
            $(this).data('offset', offset + main_offset)
            $.ajax({
                url: "<?= base_url('Predictions/all_games'); ?>",
                type: "POST",
                dataType: 'JSON',
                data: {game_id: game_id, offset: offset, topicid: topic_id},
                success: function (data) {
                    console.log(data.length);
                    if (data.length == 0 || data.length < main_offset ) {
                        $('#sidegames').hide();
                    } else {
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
          //  div += '<div class="banner-img" style="background-image:url(' + value.image + ')"></div>';
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
    $('#portfolio_refresh').click(function(){
        var game_id = '<?= $game_id ?>';
        $.ajax({
            url: base_url + 'Games/refresh_portfolio',
            type: "POST",
            dataType: 'JSON',
            data: {game_id: game_id},
            success: function (res) {
                if (res.message =='redirect_to_home') {
                    window.location.href = base_url + 'Home';
                }else if(res.status =='success'){
                    var portfolioPoints = res.user_portfolio_points=='' ? '0' : res.user_portfolio_points;
                    var availablePoints = res.user_available_points=='' ? '0' : res.user_available_points; 
                    $('#user_rank').html(res.user_rank);
                    $('#portfolioPoints').html(Math.round(portfolioPoints));
                    $('#availablePoints').html(availablePoints);
                }else{
                    return false;
                }
            }
        });
    });

    $(function () {
        var topic_id = '<?= $game_details['topic_id']; ?>';       
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
          //  div += '<div class="banner-img" style="background-image:url(' + value.image + ')"></div>';
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
        var topic_id = '<?= $game_details['topic_id']; ?>';
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
       /*      var str=value.title;
            var string = str.replace(/[^A-Z0-9]+/ig, "-");
            var newString = string.replace(/-+$/,'/');
            div += '<a href="'+base_url+'blog/'+value.id+'/'+newString+'" class="card prediction-card text-decoration-none">'; */
            div += '<a href="' + base_url + 'blog/detail/' + value.id+'" class="card prediction-card text-decoration-none">';
//   div += '<div class="banner-img" style="background-image:url(' + value.image + ')"></div>';
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
            //div += '"+value.end_date+" < /span></span >';
            div += '</div>';
            // div += '<img src="' + base_url + 'assets/img/share.svg" >';
            div += '</div>';
            div += '</div>';
            div += '</a>';
        });
        $('#' + selector).before(div);
    }
    
    $(document).on('click', '#coins-conversion-details', function () {
        var game_id = '<?= $game_id ?>';
        var user_id = '<?= $this->user_id ?>';
        $.ajax({
            url: base_url + 'Games/coins_coversion_details',
            data: {game_id:game_id, user_id:user_id},
            type: 'POST',
            dataType: 'JSON',
            success: function (res, textStatus, jqXHR) {
                var max_points=parseFloat(res.point_value_per_coin)*parseInt(res.coin_transfer_limit);
                $('#coins_to_convert').val('');
                $('#points_to_get').html('');
                $('#max_points').html(Math.round(max_points));
                $('#coin_transfer_limit').html(res.coin_transfer_limit);
                $('#convert_coins_to_points').modal('show');
            },
            error: function (jqXHR, textStatus, errorThrown) { }
        })
    })
</script>
