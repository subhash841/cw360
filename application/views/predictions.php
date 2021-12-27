<div class="container-fluid">
<div class="row ">
<div class="col-md-8 theme-padding main-height">
<!--            <div class="bredcum-holder">
<a href="#">Home /</a>
<a href="#">Article 370 /</a>
<a href="#" class="active">Game /</a>
</div>-->
<div id="predection-container">
<h5 class="title mt-4"><?= $game_details['title'] ?></h5>
<div class="profile-info ml-3 ml-md-0">
<!--  <div class="holder">
<h6 class="title">Rank</h6>
<h6 class="mb-0"><img src="<?= base_url(); ?>assets/img/trophy.svg" class="img-fluid"><b>141</b></h6>
</div>
<div class="holder">
<h6 class="title">Portfolio</h6>
<h6 class="mb-0"><b>339</b><span>Points</span></h6>
</div> -->
<div class="holder border-0">
<h6 class="title">Available</h6>
<h6 class="mb-0"><b id="availablePoints"><?= empty($available_points['points']) ? '0' : $available_points['points'] ?></b><span>Coins</span></h6>
</div>
</div>
<div class="d-md-flex predection-data-container">
<div>
<div class="predection-topics w-100 mb-2">
<div class="nav flex-md-column flex-row justify-content-evenly nav-pills w-100" id="v-pills-tab" role="tablist" aria-orientation="vertical">
<a class="nav-link active" id="v-pills-game-tab" data-toggle="pill" href="#game-tab" role="tab" aria-selected="true">
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
<a class="nav-link" id="v-pills-leaderboard" data-toggle="pill" href="#leaderboard" role="tab" aria-selected="false">
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

<span>Leaderboard</span>
</a>
<a class="nav-link d-none" id="v-pills-basket" data-toggle="pill" href="#basket" role="tab" aria-selected="false">
<svg xmlns="http://www.w3.org/2000/svg" width="20.126" height="20.132" viewBox="0 0 20.126 20.132">
<g id="Group_2823" data-name="Group 2823" transform="translate(-115.564 -395.558)">
<g id="noun_Gift_1212145" transform="translate(107.664 385.664)">
<g id="Group_2808" data-name="Group 2808" transform="translate(8 10)">
<g id="Group_2807" data-name="Group 2807" transform="translate(0)">
<path id="Path_9907" data-name="Path 9907" d="M10.076,29.1H25.851V18.3H10.076ZM26.681,18.3V29.1a.83.83,0,0,1-.83.83H10.076a.83.83,0,0,1-.83-.83V18.3h-.83A.415.415,0,0,1,8,17.887V14.566a.415.415,0,0,1,.415-.415h4.706a2.283,2.283,0,0,1,2.455-3.845,8.223,8.223,0,0,1,2.248,3.014,8.223,8.223,0,0,1,2.248-3.014,2.283,2.283,0,0,1,2.455,3.845h4.984a.415.415,0,0,1,.415.415v3.321a.415.415,0,0,1-.415.415ZM15.161,11.025a1.453,1.453,0,0,0-1.453,2.517,8.474,8.474,0,0,0,3.467.324A8.475,8.475,0,0,0,15.161,11.025Zm6.779,2.517a1.453,1.453,0,0,0-1.453-2.517,8.475,8.475,0,0,0-2.014,2.841A8.474,8.474,0,0,0,21.941,13.542ZM8.83,14.982v2.491H27.1V14.982Z" transform="translate(-8 -10)" fill="#a1a6ae" stroke="#a1a6ae" stroke-width="0.2" fill-rule="evenodd"/>
</g>
</g>
</g>
<path id="Path_9914" data-name="Path 9914" d="M-1857.491,399.622v15.736" transform="translate(1983)" fill="none" stroke="#a1a6ae" stroke-width="1"/>
</g>
</svg>
<span><span>Basket</span>
</a>
<a class="nav-link " id="v-pills-rewards" data-toggle="pill" href="#rewards" role="tab" aria-selected="false">
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
<!--                                 <a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false">
        <svg xmlns="http://www.w3.org/2000/svg" width="22.274" height="20.536" viewBox="0 0 22.274 20.536">
        <g id="Group_2067" data-name="Group 2067" transform="translate(-292.5 -123.5)">
        <g id="Group_2066" data-name="Group 2066" transform="translate(293 124)">
        <g id="Group_2064" data-name="Group 2064" transform="translate(10.422 3.064)">
        <line id="Line_2" data-name="Line 2" x2="3.176" y2="3.176" stroke="#a1a6ae" stroke-linecap="round" stroke-miterlimit="10" stroke-width="1"/>
        <line id="Line_3" data-name="Line 3" y1="3.045" x2="3.045" transform="translate(0.121 0.131)" stroke="#a1a6ae" stroke-linecap="round" stroke-miterlimit="10" stroke-width="1"/>
        </g>
        <path id="Path_8117" data-name="Path 8117" d="M7.152,7.011a.948.948,0,0,1,.931,1.032V20a1.85,1.85,0,0,0,1.85,1.85H23.9" transform="translate(-4.717 -5.712)" fill="none" stroke="#a1a6ae" stroke-linecap="round" stroke-miterlimit="10" stroke-width="1"/>
        <g id="Group_2065" data-name="Group 2065" transform="translate(3.366 0)">
        <path id="Path_8118" data-name="Path 8118" d="M22.937,16a4.625,4.625,0,1,1-9.25,0H9.668v8.905H26.835a.74.74,0,0,0,.74-.74V16.74a.74.74,0,0,0-.74-.74Z" transform="translate(-9.668 -11.375)" fill="none" stroke="#a1a6ae" stroke-miterlimit="10" stroke-width="1"/>
        <path id="Path_8119" data-name="Path 8119" d="M29.782,8.125h0a4.625,4.625,0,0,0-9.25,0h0" transform="translate(-16.512 -3.5)" fill="none" stroke="#a1a6ae" stroke-miterlimit="10" stroke-width="1"/>
        </g>
        <circle id="Ellipse_148" data-name="Ellipse 148" cx="1.218" cy="1.218" r="1.218" transform="translate(0 0.082)" fill="none" stroke="#a1a6ae" stroke-miterlimit="10" stroke-width="1"/>
        <circle id="Ellipse_149" data-name="Ellipse 149" cx="1.592" cy="1.592" r="1.592" transform="translate(5.74 16.277)" fill="none" stroke="#a1a6ae" stroke-miterlimit="10" stroke-width="1"/>
        <circle id="Ellipse_150" data-name="Ellipse 150" cx="1.592" cy="1.592" r="1.592" transform="translate(14.477 16.353)" fill="none" stroke="#a1a6ae" stroke-miterlimit="10" stroke-width="1"/>
        </g>
        </g>
        </svg>
        <span>Market</span></a> -->
</div>
</div>
</div>

<div class="tab-content w-100" id="v-pills-tabContent">
<!-- game tab start -->
<div class="tab-pane fade show active " id="game-tab" role="tabpanel">
<div class="predection-carousel ml-md-5 w-100 pb-4">
<?php if (!empty($prediction_details)): ?>
<div id="main-card-holder" class="container-fluid">
<div class="card-animation-holder" data-gameId="<?= $game_id ?>" id="data-id-pred" data-offset-pred="3">
<?php foreach ($prediction_details as $key => $prediction_data): ?>
<?php $visible_class = get_visible_class($key) ?>
<div class="card-holder  <?= $visible_class ?>">
<h6 class="pred-title"><?= $prediction_data['title'] ?></h6>
<div class="d-none pred-id"><?= base64_encode($prediction_data['id']); ?></div>
<div class="predection-price-container">
<h6 class="cur-val">Current Value</h6>
<div class="cur-price d-flex justify-content-center align-items-center">
    <!-- <span><img src="<?= base_url(); ?>assets/img/card-coin.png"
               class="img-fluid float-left"></span> -->
    <h5 class="mb-0 price"><?= $key == 0 ? round($prediction_data['current_price']) : '' ?></h5>&nbsp;&nbsp;
    <h6>Coins</h6>
</div>
</div>
<?php
if ($prediction_data['agreed'] > 0 || $prediction_data['disagreed'] > 0):
    $possibility = get_possibility_percentage($prediction_data);
    ?>
    <div class="possibilityText <?= $possibility['fontClass'] ?>"><?= $possibility['textPossibility'] ?></div>
<?php endif ?>

<div class="predection-time  mt-4">
<div class="d-flex justify-content-center">
    <img src="<?= base_url(); ?>assets/img/reddot.svg">
    <p class="mb-0 time-title"></p>
</div>
    <span class="time"></span>
</div>
        </div>
    <?php endforeach; ?>
    </div>
    <div class="status-holder">
        <span id="yes"><i class="fa fa-check"></i></span>
        <span id="no"><i class="fa fa-remove"></i></span>
    </div>
    <div class="predection-button mx-auto mt-2 predectionButtons <?= !empty($this->user_id) ? 'd-none' : '' ?>">
        <button class="btn btn-no">
            <img src="<?= base_url(); ?>assets/img/no-btn.svg" class="img-fluid">
                NO
        </button>

        <button class="btn btn-yes">
            <img src="<?= base_url(); ?>assets/img/yes-btn.svg" class="img-fluid">
                YES
        </button>
        <?php
        if (count($prediction_details) == 3) {
            $data_offset = encodeString('3');
        } else {
            $data_offset = '';
        }
        ?>
        <span data-offset="<?= $data_offset ?>" class="d-none" id="limitOffset"></span>
    </div>
    <!-- <div class="predectionButtons">
        <button class="btn btn-share">
            <img src="<?= base_url(); ?>assets/img/share-btn.svg" class="img-fluid">
                SHARE
        </button>
    </div> -->
    </div>
<?php else: ?>
    <!--empty infographics strat end-->
    <div class="no-games text-center mb-5 pt-3">
        <h5 class="font-weight-bold cw-text-color-gray">
            No Predictions Available
        </h5>
        <img class="img-fluid my-5" src="<?= base_url(); ?>assets/img/empty_predictions.svg">
            <a href="<?= base_url()?>games">
                <h6 class="font-weight-bold try-games-text">
                    Try out other Games
                </h6>
            </a>
    </div>
    <!--empty infographics end-->
<?php endif; ?>
</div>
</div>
<!--summay screen start-->
<div id="predection-list-main-container" class="px-5 d-none">
    <div class="predection-list-container">
        <h5 class="font-weight-bold">Predictions</h5>
        <div class="predection-list" data-gameid="1" id="data-gameId">
            <div class="predection pre-5 row bg-blue">
                <div class="main-title col-md-4 col-md-12 mb-3">test prediction </div>
                <div class="c-price col border-right">
                    <span class="title">Current Price</span>
                    <b>9.00</b><span> Coins</span>
                </div>
                <div class="c-profit col border-right">
                    <span class="title">Current Profit</span>
                    <b class="">0</b><span class=""> Coins</span>
                </div>
                <div class="p-skipped col">
                    <span class="title">Prediction Skipped</span>
                </div>
                <div class="status col">
                    <button onclick="openpopup('Are You Sure You Want To Change The Prediction To Yes ?', '5', '1', 'Yes', '2019-10-09 12:01:31')" ;="">Change to YES</button>

                </div>
            </div>   
            <div class="predection pre-3 row ">
                <div class="main-title col-md-4 col-md-12 mb-3">BSP will win Between 80 and 120 seats</div>
                <div class="c-price col">
                    <span class="title">Current Price</span>
                    <b>15.00</b><span> Coins</span>
                </div>
                <div class="c-profit col">
                    <span class="title">Current Profit</span>
                    <b class="">0</b><span class=""> Coins</span>
                </div>
                <div class="p-price col">
                    <span class="title">Purchased Price</span>
                    <b>15.00</b><span> Coins</span>
                </div>
                <div class="status col">
                    <button onclick="openpopup('Are You Sure You Want To Change The Prediction To Skip ?', '3', '1', 'No', '2019-10-07 23:05:04')" ;="">Change to Skip</button>

                </div>
            </div>  
            <div class="predection pre-2 row bg-blue">
                <div class="main-title col-md-4 col-md-12 mb-3">Congress will win between 240 and 260 seats</div>
                <div class="c-price col">
                    <span class="title">Current Price</span>
                    <b>10.00</b><span> Coins</span>
                </div>
                <div class="c-profit col">
                    <span class="title">Current Profit</span>
                    <b class="">0</b><span class=""> Coins</span>
                </div>
                <div class="p-skipped col">
                    <span class="title">Prediction Skipped</span>
                </div>
                <div class="status col">
                    <button onclick="openpopup('Are You Sure You Want To Change The Prediction To Yes ?', '2', '1', 'Yes', '2019-10-07 22:35:20')" ;="">Change to YES</button>

                </div>
            </div>  
            <div class="predection pre-1 row ">
                <div class="main-title col-md-4 col-md-12 mb-3">BJP will win between 240 and 260 seats</div>
                <div class="c-price col">
                    <span class="title">Current Price</span>
                    <b>100.00</b><span> Coins</span>
                </div>
                <div class="c-profit col">
                    <span class="title">Current Profit</span>
                    <b class="">0</b><span class=""> Coins</span>
                </div>
                <div class="p-price col">
                    <span class="title">Purchased Price</span>
                    <b>100.00</b><span> Coins</span>
                </div>
                <div class="status col">
                    <button onclick="openpopup('Are You Sure You Want To Change The Prediction To Skip ?', '1', '1', 'No', '2019-10-07 22:35:16')" ;="">Change to Skip</button>

                </div>
            </div>  
        </div>
    </div>
</div>
<!--suummay screen end-->
<!-- game tab end -->

<!-- rank tab start -->
<div class="tab-pane fade" id="leaderboard" role="tabpanel" >
    <?php $this->load->view('rank_tab') ?>
</div>
<!-- rank tab end -->

<!-- basket tab start -->
<div class="tab-pane fade" id="basket" role="tabpanel">
    <?php $this->load->view('basket_tab') ?>
</div>
<div class="tab-pane fade" id="rewards" role="tabpanel">
    <?php $this->load->view('reward_tab', $game_details) ?>
</div>
<!-- basket tab end -->
<!-- <div class="tab-pane fade" id="v-pills-settings" role="tabpanel">4</div> -->
</div>
</div>
</div>
</div>






<div class="col-md-4 theme-bg theme-padding main-height">
    <div class="predection-list">
        <h3 class="title">Explore More of world cup</h3>

        <div class="data-container">
            <ul class="nav nav-pills mb-3" id="predection-list-menu" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home"
                       role="tab" aria-controls="pills-home" aria-selected="true">Game</a>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                     aria-labelledby="pills-home-tab">
                         <?php foreach ($sidebar_games as $key => $value) { ?>

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
                                            <span class="font-weight-light ml-1"><span
                                                    class="font-weight-normal">
                                                    <?= $value['end_date'] ?></span></span>
                                    </div>
                                    <img src="<?= base_url(); ?>assets/img/share.svg">
                                </div>
                            </div>
                        </a>
                    <?php } ?>

                </div>


            </div>
        </div>
    </div>
</div>
</div>
</div>

<!--  <div class="col-md-4 theme-bg theme-padding main-height">
     <div class="predection-list">
         <h3 class="title">Explore More of world cup</h3>

         <div class="data-container">
             <ul class="nav nav-pills mb-3" id="predection-list-menu" role="tablist">
                 <li class="nav-item">
                     <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home"
                        role="tab" aria-controls="pills-home" aria-selected="true">Home</a>
                 </li>
                 <li class="nav-item">
                     <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile"
                        role="tab" aria-controls="pills-profile" aria-selected="false">Profile</a>
                 </li>
                 <li class="nav-item">
                     <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact"
                        role="tab" aria-controls="pills-contact" aria-selected="false">Contact</a>
                 </li>
             </ul>
             <div class="tab-content" id="pills-tabContent">
                 <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                      aria-labelledby="pills-home-tab">
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
                                     <img src="<?= base_url(); ?>assets/img/clock.svg">
                                         <span class="font-weight-light ml-1">Game Ends In : <span
                                                 class="font-weight-normal">
                                                 1 Week</span></span>
                                 </div>
                                 <img src="<?= base_url(); ?>assets/img/share.svg">
                             </div>
                         </div>
                     </div>
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
                                     <img src="<?= base_url(); ?>assets/img/clock.svg">
                                         <span class="font-weight-light ml-1">Game Ends In : <span
                                                 class="font-weight-normal">
                                                 1 Week</span></span>
                                 </div>
                                 <img src="<?= base_url(); ?>assets/img/share.svg">
                             </div>
                         </div>
                     </div>
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
                                     <img src="<?= base_url(); ?>assets/img/clock.svg">
                                         <span class="font-weight-light ml-1">Game Ends In : <span
                                                 class="font-weight-normal">
                                                 1 Week</span></span>
                                 </div>
                                 <img src="<?= base_url(); ?>assets/img/share.svg">
                             </div>
                         </div>
                     </div>
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
                                     <img src="<?= base_url(); ?>assets/img/clock.svg">
                                         <span class="font-weight-light ml-1">Game Ends In : <span
                                                 class="font-weight-normal">
                                                 1 Week</span></span>
                                 </div>
                                 <img src="<?= base_url(); ?>assets/img/share.svg">
                             </div>
                         </div>
                     </div>
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
                                     <img src="<?= base_url(); ?>assets/img/clock.svg">
                                         <span class="font-weight-light ml-1">Game Ends In : <span
                                                 class="font-weight-normal">
                                                 1 Week</span></span>
                                 </div>
                                 <img src="<?= base_url(); ?>assets/img/share.svg">
                             </div>
                         </div>
                     </div>
                     <div>
                         <div class="tab-pane fade" id="pills-profile" role="tabpanel"
                              aria-labelledby="pills-profile-tab">...</div>
                         <div class="tab-pane fade" id="pills-contact" role="tabpanel"
                              aria-labelledby="pills-contact-tab">...</div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div> -->
</div>
</div>
<!-- Rules and rewards popup start -->
<?php
    if (check_cookie($rewards_sess_cookie,$this->user_id)==true) {
        $show_rewards = true;    
        $this->load->view('popup/rules_rewards');
    }else{
        $show_rewards = false;
    }
?>
<!-- Rules and rewards popup end-->

<?php if (!empty($this->user_id)): ?>
<div class="modal fade" id="reqGamePoints" tabindex="-1" role="dialog" aria-labelledby="challengeModalCenterTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 410px;">
        <div class="modal-content modal-blue-bg border-radius-10 border-0 popup-bg">
            <div class="px-4 py-5 text-center text-white">
                <p class="font-weight-light sub-text-color my-4" id="reqGamePointsText">Entry Fees <?= $game_details['req_game_points'] ?>. Do you want to continue?</p>
                <a href="<?= base_url() ?>home"><button class="btn button-plan-bg border-radius-12 text-white mt-2 px-4" id="">No</button></a>
                <button class="btn button-plan-bg border-radius-12 text-white mt-2 px-4" id="deductCoins">Yes</button>
            </div>
        </div>
    </div>
</div>
<?php endif ?>
<script>
    first_prediction_fpt = "<?= !empty($prediction_details) ? $prediction_details[0]['fpt_end_datetime'] : '' ?>";
    countDownDate = new Date(first_prediction_fpt).getTime();
    prediction_end_date = "<?= !empty($prediction_details) ? date('d M, Y', strtotime($prediction_details[0]['end_date'])) : '' ?>";
    gamePoints = '';
    show_rewards = '<?=$show_rewards;?>';
    req_game_points = "<?= $game_details['req_game_points'] ?>";
</script>
<script>
    $(function () {
        var game_id = '<?= $game_id ?>';
        $('#sidegames').click(function () {
            var main_offset = parseInt('<?= $this->config->item('all_predection_game_limit'); ?>');
            var offset = $(this).data('offset');
            $(this).data('offset', offset + main_offset)
            $.ajax({
                url: "<?= base_url('Predictions/all_games'); ?>",
                type: "POST",
                dataType: 'JSON',
                data: {game_id: game_id, offset: offset},
                success: function (data) {
                    if (data.length == 0) {
                        $('#sidegames').hide();
                    } else {
                        console.log(data);
                        add_game('sidegames', data);
                    }
                }
            });
        });
    });
    function add_game(selector, data) {
        var div = '';
        $.each(data, function (key, value) {
            div += '<div class="card prediction-card">';
            div += '<div class="banner-img" style="background-image:url(' + value.image + ')"></div>';
            div += '<div class="card-body" >';
            div += '<button class="btn play-btn">';
            div += 'Play Now';
            div += '</button>';
            div += '<h6 class="title" >';
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
            div += '<img src="' + base_url + 'assets/img/share.svg" >';
            div += '</div>';
            div += '</div>';
            div += '</div>';
        });
        $('#' + selector).before(div);
    }
</script>
