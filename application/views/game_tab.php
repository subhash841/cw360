<div class="predection-carousel ml-md-5 w-100 pb-4">
    <?php if (!empty($prediction_details) && !empty($game_details['is_published']) && $game_details['end_date']>=(date('Y-m-d H:i:s'))): ?>
        <div id="main-card-holder" class="container-fluid position-relative">
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
            <div class="status-holder ">
                <span id="yes"><span class="fa fa-check d-block">YES</span></span>
                <span id="no"><span class="fa fa-remove d-block">SKIP/NO</span></span>
            </div>
            <!-- <div class="predection-button mx-auto mt-2 predectionButtons <?= !empty($this->user_id) ? 'd-none' : '' ?>"> -->
            <div class="predection-button mx-auto mt-2 predectionButtons <?= @$user_game_joureny== true ? 'position-relative ' : '' ?> ">

                <?php
                    if(@$user_game_joureny) { ?>

                <div class="c1">
                    <h6>Press <span class="h5 d-inline-block red font-weight-bold">SKIP/NO</span> to reject a prediction</h6>
                </div>
                <div class="c2">
                    <h6>Press <span class="h5 d-inline-block green font-weight-bold">YES</span> if you agree</h6>
                </div>

                <div class="c3 w-100">
                    <h6 style="font-size:0.8rem;" class="font-weight-light">If Predicted <span class="h5" style="color: #91AEFF;font-weight: 700;"> YES and Correct</span> = 25 bonus coins</h6>
                    <h6 style="font-size:0.8rem;" class="font-weight-light">If Predicted <span class="h5" style="color: #91AEFF;font-weight: 700;"> YES and Incorrect</span> Prediction value = 0</h6>
                </div>
                
                <img src="<?= base_url()?>assets/img/right_arrow.png" alt="arrow" class="right-arrow img-fluid" >
                <img src="<?= base_url()?>assets/img/left_arrow.png" alt="arrow" class="left-arrow img-fluid">

                    <?php }
                ?>


                <button class="btn btn-no">
                    <img src="<?= base_url(); ?>assets/img/no-btn.svg" class="img-fluid">
                    SKIP / NO
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
            <div class="predectionButtons <?= @$user_game_joureny== true ? 'position-relative padding-111' : '' ?>">
                <button class="btn btn-share" data-toggle="modal" data-target="#shareModal">
                    <img src="<?= base_url(); ?>assets/img/share-btn.svg" class="img-fluid">
                    SHARE
                </button>
                <?php
                    if(@$user_game_joureny) { ?>
                            <img src="<?= base_url()?>assets/img/share_arrow.png" class="img-fluid c4">
                            <div class="c4 w-100 positon-absolute">
                                <h6 style="font-size:0.8rem;" class="font-weight-light">Press <span class="h5" style="color: #91AEFF;font-weight: 700;">SHARE</span> to share a prediction </h6>
                            </div>
                    <?php } ?>

            </div> 
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
<?php
    $this->load->view('popup/rules_rewards');
    $this->load->view('popup/max_players_limit');
?>
<?php if (!empty($this->user_id)): ?>
    <div class="modal fade" id="reqGamePoints" tabindex="-1" role="dialog" aria-labelledby="challengeModalCenterTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 410px;">
            <div class="modal-content modal-blue-bg border-radius-10 border-0 popup-bg">
                <div class="px-4 py-5 text-center text-white">
                    <p class="font-weight-light sub-text-color my-4" id="reqGamePointsText">Entry Fee: <?= $game_details['req_game_points'] ?> Coins. Do you want to continue?</p>
                    <a href="javascript:window.location.reload();"><button class="btn button-plan-bg border-radius-12 text-white mt-2 px-4" id="">No</button></a>
                    <button class="btn button-plan-bg border-radius-12 text-white mt-2 px-4" id="deductCoins">Yes</button>
                </div>
            </div>
        </div>
    </div>
<?php endif ?>
<script>
    first_prediction_fpt_date = "<?= !empty($prediction_details) ? $prediction_details[0]['fpt_end_datetime'] : '' ?>";
    if (first_prediction_fpt_date!='') {
        // first_prediction_fpt = "<?= !empty($prediction_details) ? $prediction_details[0]['fpt_end_datetime'] : '' ?>";
        // first_prediction_fpt = moment(first_prediction_fpt_date).format('MM/DD/YYYY HH:mm:ss');
        countDownDate = moment(first_prediction_fpt_date).format('x');
    }else{
        // first_prediction_fpt = '';
        countDownDate = '';
    }
    // countDownDate = new Date(first_prediction_fpt).getTime();

    prediction_end_date = "<?= !empty($prediction_details) ? date('d M, Y', strtotime($prediction_details[0]['end_date'])) : '' ?>";
    gamePoints = '';
    req_game_points = "<?= $game_details['req_game_points'] ?>";
</script>
<script>
    $(function () {
        $('html, body').animate({
            scrollTop: $(".predection-data-container").offset().top - 10
        }, 800);
    })
    user_id = '<?=$this->user_id;?>';
    showRewardsPopup = '';
    play_game_cookie = '<?= $play_game_cookie ?>';
</script>
