<!-- footer start -->
<div class="container-fluid">
    <div class="row text-white border-top theme-padding" id="footer">

        <!--            <div class="col-md-5 py-4">
                        <img src="<?= base_url(); ?>assets/img/header-logo.png">
                        <p>           
                            CrowdWisdom is an innovative question based crowdsourcing platform. The Platform is designed
                            to<br>
                            make decisions in your life easier by accessing the best experts in India and around the world
                        </p>
                        <h4 class="contact-title">Contact Us</h4>
                        <a href="mailto: support@crowdwisdom.co.in">support@crowdwisdom.co.in</a>
                        <br>
                         <a href="tel: 9930 008 402">9930 008 402</a> 
                    </div>-->
        <div class="col-12 mt-4 mb-2 ">

            <!--<h5 class="font-weight-500">Company</h5>-->

            <ul class="list-unstyled d-flex justify-content-center flex-wrap">
                <li class="">
                    <a href="<?php echo base_url() ?>contactus" class="a-nohoverstyle nostyle px-2 footer-font border-right">Contact Us</a></li>
                <li class="">
                    <a href="<?php echo base_url() ?>disclaimer" class="a-nohoverstyle nostyle px-2 footer-font border-right">Disclaimer</a>
                </li>
                <li class="">
                    <a href="<?php echo base_url() ?>intellectualproperty" class="a-nohoverstyle nostyle px-2 footer-font border-right">Intellectual Property</a>
                </li>
                <li class="">
                    <a href="<?php echo base_url() ?>terms" class="a-nohoverstyle nostyle px-2 footer-font border-right">Terms and Conditions</a>
                </li>
                <li class="">
                    <a href="<?php echo base_url() ?>refund" class="a-nohoverstyle nostyle px-2 footer-font border-right">Refund and Cancellation Policy</a>
                </li>
                <li class="">
                    <a href="<?php echo base_url() ?>privacypolicy" class="a-nohoverstyle nostyle px-2 footer-font border-right">Privacy Policy</a>
                </li>
                <li class="">
                    <a href="<?php echo base_url() ?>processflowproserv" class="a-nohoverstyle nostyle px-2 footer-font">How to Purchase Coins</a></li>
            </ul>

        </div>
        <!--         <div class="col-md-6 my-2 mt-4 mb-2">
                    <h5 class="font-weight-500">Products</h5>
                    <ul class="list-unstyled">
                        <li class="">
                            <a href="<?php echo base_url() ?>processflowproserv" class="a-nohoverstyle nostyle pr-1 footer-font">Process flow to purchase the product & service</a></li>
                    </ul>
                </div> -->

        <!-- <div class="col-md-4 py-4">
            <h4 class="contact-title">Contact Us</h4>
            <a href="mailto: support@crowdwisdom.co.in">support@crowdwisdom.co.in</a>
            <br>
            <a href="tel: 9930 008 402">9930 008 402</a>
        </div> -->
        <div class="col-12 border-top">
            <p class="copright my-3 text-center">
                Copyright &copy; <?= date('Y') ?> CrowdWisdom All Rights Reserved
            </p>
        </div>
    </div>
</div>
</div>
</div>

<!-- Profile Slide Screen -->
<div class="main-height user-profile-info user-side-panel position-fixed">
    <div>
        <div>
            <div class="px-4 py-3 pb-4 profile-slide-bg">
                <div class="text-right">
                    <img class="img-fluid profile-close-btn" src="<?= base_url(); ?>assets/img/close-btn-white.svg">
                    <div class="row mt-3">
                        <?php
                        @$user_details = user_details($this->user_id);
                        if (!empty($user_details)) {
                        ?>
                            <div class="col-4 pr-0 text-center">
                                <div class="position-relative">
                                    <?php if (@$user_details['image'] == "") { ?>

                                        <a href="javascript:void(0)" class="d-inline-block default_profile cursor-pointer average_portfolio" style="height:80px;width:80px; background:url('https://www.abc.net.au/news/image/8314104-1x1-940x940.jpg') center center no-repeat;background-size:cover;margin: 0 auto;border-radius: 50%;" data-img="https://www.abc.net.au/news/image/8314104-1x1-940x940.jpg" data-name="<?= $user_details['name'] ?>" data-email="<?= $user_details['email'] ?>" data-userid="<?= $user_details['id'] ?>"></a>
                                    <?php } else { ?>
                                        <a href='javascript:void(0)' class="d-inline-block default_profile cursor-pointer average_portfolio" style="height:80px;width:80px; background:url(<?= @$user_details['image']; ?>) center center no-repeat;background-size:cover;margin: 0 auto;border-radius: 50%;" data-img="<?= $user_details['image'] ?>" data-name="<?= $user_details['name'] ?>" data-email="<?= $user_details['email'] ?>" data-userid="<?= $user_details['id'] ?>"></a>
                                    <?php } ?>
                                    <!--   <img class="img-fluid"  src="<?= base_url(); ?>assets/img/Janet-Cole-lg.png"> -->
                                    <img class="img-fluid position-absolute profile-edit-icon" id="profile_edit" src="<?= base_url(); ?>assets/img/edit-profile-icon.svg">
                                </div>
                            </div>
                            <div class="col-7 pl-0  text-left">
                                <h5 class="font-weight-normal mt-2 pt-1 text-white" style="word-break: break-all;"><?= @$user_details['name']; ?></h5>
                                <h6 class="font-weight-light text-white fs08">Profile ID: CW #<span id='userId'><?= $this->user_id ?></span></h6>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="px-4 py-3">
                <div class="my-0 px-2 py-3">
                    <div class="profile-links">
                        <!-- <a class="text-decoration-none d-block mb-4" href="#!" id="user-wallet-history">
                            <img class="img-fluid" src="<?= base_url(); ?>assets/img/wallet-icon.svg">
                            <h6 class="d-inline ml-3 font-weight-normal">Wallet History</h6>
                        </a> -->
                        <a class="text-decoration-none d-block mb-4" href="<?= base_url() ?>wallet_history">
                            <img class="img-fluid w25" src="<?= base_url(); ?>assets/img/wallet-icon.svg">
                            <h6 class="d-inline ml-3 font-weight-normal">Wallet History</h6>
                        </a>
                        <a class="text-decoration-none d-block mb-4" href="<?= base_url() ?>games_dashboard">
                            <img class="img-fluid w25" src="<?= base_url(); ?>assets/img/games_dashboard.svg">
                            <h6 class="d-inline ml-3 font-weight-normal">Games Dashboard</h6>
                        </a>
                        <a class="text-decoration-none d-block mb-4" href="<?= base_url() . 'subscriptions'; ?>">
                            <img class="img-fluid w25" src="<?= base_url(); ?>assets/img/subscription-icon.svg">
                            <h6 class="d-inline ml-3 font-weight-normal">Purchase</h6>
                        </a>
                        <a class="text-decoration-none d-block mb-4" href="#!" id="user-sub-history">
                            <img class="img-fluid w25" src="<?= base_url(); ?>assets/img/subscription-history-icon.svg">
                            <h6 class="d-inline ml-3 font-weight-normal">Purchase History</h6>
                        </a>
                        <a class="text-decoration-none d-block mb-4" href="#!" id="user-rewards">
                            <img class="img-fluid w25" src="<?= base_url(); ?>assets/img/medal.png">
                            <h6 class="d-inline ml-3 font-weight-normal">Rewards</h6>
                        </a>
                        <a class="text-decoration-none d-block mb-4" href="<?= base_url(); ?>login/logout">
                            <img class="img-fluid w25" src="<?= base_url(); ?>assets/img/logout-icon.svg">
                            <h6 class="d-inline ml-3 font-weight-normal">Logout</h6>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--profile slide end-->

<!--rewards screen end-->
<div class="main-height user-rewards user-side-panel position-fixed">
    <div>
        <div class="row no-gutters">
            <div class="px-4 py-3">
                <div class="text-left">
                    <img class="img-fluid rewards-close-btn" src="<?= base_url(); ?>assets/img/back-arrow-slide.svg">
                    <h6 class="d-inline ml-3">Rewards</h6>
                </div>
            </div>

            <?php if (@$this->user_id != 0) { ?>
                <h6 class="mr-3 ml-auto d-flex align-items-center">
                    <img src="<?= base_url(); ?>assets/img/wallet.png" class="img-fluid mr-2 "><?= get_User_Coins(); ?>
                </h6>
            <?php } ?>
            <div class="w-100 position-relative">
                <img src="<?= base_url(); ?>assets/img/rewards-top.svg" class="img-fluid w-100">
                <div class="position-absolute w-100 h-100" style="top: 0;">
                    <div class="row mx-2 h-100">
                        <div class="col-7 offset-5">
                            <div class="text-center text-white mt-3 mt-md-3 pt-3">
                                <img src="<?= base_url(); ?>assets/img/trophy-rewards.svg" class="img-fluid mt-3">
                                <div class="mt-3">
                                    <span style="font-size:0.7rem;">Redeemable coins</span>
                                    <h5><img class="d-inline mr-1" style="width: 21px;" src="<?= base_url(); ?>assets/img/coins.png">
                                        <?php
                                        if (@$this->user_id != 0) {
                                            echo get_Redeem_User_Coins();
                                        } else {
                                            echo "0";
                                        }
                                        ?>
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--            <div class="w-100 px-5">
                            <div class="mx-0 my-2 p-2 border-radius-15 text-white text-center" style="background-color: #3f67db;">
                                <p class="my-2">You are <img class="d-inline mr-1" style="width: 13px;" src="<?= base_url(); ?>assets/img/coins.png">7,000 away from<br>Pro Predictor Lv.1</p>
                            </div>
                        </div>-->
            <div class="w-100 my-3">
                <!--<h6 class="font-weight-bold ml-4 ">PREDICTOR LEVELS</h6>-->
                <div class="predictor-box mt-4 text-white">
                    <div class="position-relative py-1">
                        <hr class="predictor-hr">
                        <div class="position-absolute py-2 pl-5 pr-5 bg-blue top-0 border-right-15">
                            <span class="font-weight-light">Redeem Coins</span>
                        </div>
                    </div>
                    <div class="prizes-box my-3 py-2 px-2">
                        <?php
                        $reward = getall_rewards();
                        if (!empty($reward)) {
                            foreach ($reward as $key => $value) {
                        ?>
                                <div class="row mx-0 my-3">
                                    <div class="col">
                                        <div class="p-1 border-radius-15 reward-card-bg">
                                            <div class="row">
                                                <div class="col-8">
                                                    <div class="w-100 h-100 pl-3 py-2 d-flex flex-column justify-content-between">
                                                        <h6><?= $reward[$key]['title']; ?></h6>
                                                        <div class="mb-0">
                                                            <img class="d-inline" style="width: 14px;" src="<?= base_url(); ?>assets/img/coins.png">
                                                            <small><?= $reward[$key]['req_coins']; ?> coins</small>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="col-4 text-right">
                                                    <img class="img-fluid" src="<?= $reward[$key]['image']; ?>" style="width:94px;height: 94px;border-radius: 11px;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        <?php
                            }
                        }
                        ?>

                    </div>
                </div>
                <?php if ($this->user_id != '0') { ?>
                    <div class="text-center pb-4">
                        <button class="d-block btn btn-danger mx-auto mb-5" id="redeem-btn">Redeem</button>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<!--rewards screen end-->


<!-- Profile Edit Slide Screen -->
<div class="main-height user-profile-edit user-side-panel position-fixed">
    <div>
        <div>
            <div class="px-4 py-3">
                <div class="text-left">
                    <img class="img-fluid proedit-hist-close-btn" src="<?= base_url(); ?>assets/img/back-arrow-slide.svg">
                    <h6 class="d-inline ml-3">My Profile</h6>
                </div>
            </div>
            <?php //@$user_details = user_details($this->user_id);     
            ?>
            <div class="px-4 py-3 pb-4">
                <div class="text-right">
                    <img class="img-fluid profile-close-btn" src="<?= base_url(); ?>assets/img/close-btn-white.svg">
                    <div class="row mt-3 text-center">
                        <div class="col text-center">
                            <div class="position-relative">

                                <?php if (@$user_details['image'] == "") { ?>

                                    <div class="default_profile" style="height:130px;width:130px; background:url('https://www.abc.net.au/news/image/8314104-1x1-940x940.jpg') center center no-repeat;background-size:cover;margin: 0 auto;border-radius: 50%;"></div>
                                <?php } else { ?>
                                    <div class="default_profile" style="height:130px;width:130px; background:url(<?= @$user_details['image']; ?>) center center no-repeat;background-size:cover;margin: 0 auto;border-radius: 50%;"></div>
                                <?php } ?>


                                <img class="img-fluid uploaded-img-preview">
                                <!-- <img class="img-fluid position-absolute profile-edit-icon" src="<?= base_url(); ?>assets/img/edit-profile-icon.svg"> -->
                                <input type="image" style="bottom: 21px;padding-left: 20px;width: 51px;right: unset;" class="img-fluid position-absolute profile-edit-icon" src="<?= base_url(); ?>assets/img/edit-profile-icon.svg" />
                                <!-- <input type="file" id="my_file" style="display: none;" /> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- <div class="px-4 py-3">
                <div class="my-0 px-2 py-3">
                    <div class="profile-form">
                        <form id="persondetailform" name="persondetail" method="post" enctype="multipart/form-data" autocomplete="off">
                            <input type="file" id="uploadBtn" name="poll_img" class="upload d-none">
                            <input type="text" id="main_image" name="main_image" class="d-none" value="<?= $user_details['image']; ?>">

                            <div class="mt-1">
                                <label for="name">Full Name</label>

                                <input class="w-100 border p-2 border-radius-12" type="text" name="name" value="<?= @$user_details['name']; ?>" id="name" maxlength="15">
                                <div class="text-danger" id="name_error"></div>
                            </div>
                            <div class="mt-1">
                                <label for="dob">Date Of Birth</label>
                                <input class="w-100 border p-2 border-radius-12 datepicker" type="text" name="dob" value="<?= @$user_details['dob']; ?>" id="dob">
                                <div class="text-danger" id="dob_error"></div>
                            </div>
                            <div class="mt-1">
                                <label for="gender">Gender </label>
                                <select class="w-100 border p-2 border-radius-12" name="gender" id="gender">
                                    <option value="">Select Gender</option>
                                    <?php
                                    $gender = array(array('alias' => 'm', 'name' => 'Male'), array('alias' => 'f', 'name' => 'Female'));
                                    foreach ($gender as $key => $value) :
                                    ?>
                                        <option value="<?= $value['alias'] ?>" <?= ($value['alias'] == @$user_details['gender']) ? 'selected' : '' ?>>
                                            <?= $value['name'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="text-danger" id="gender_error"></div>
                            </div>
                            <div class="mt-1">
                                <label for="phone">Mobile Number</label>
                                <input class="w-100 border p-2 border-radius-12" type="text" value="<?= @$user_details['phone']; ?>" name="phone" id="phone" maxlength="10">
                                <div class="text-danger" id="phone_error"></div>
                            </div>
                            <div class="mt-1">
                                <label for="email">Email ID</label>
                                <input class="w-100 border p-2 border-radius-12" type="email" value="<?= @$user_details['email']; ?>" name="email" id="email">
                                <div class="text-danger" id="email_error"></div>
                            </div>
                            <center>
                                <button type="button" class="btn button-plan-bg border-radius-12 mt-3 mb-5 text-white px-3" onclick="update_profile();">SAVE CHANGES</button>
                            </center>
                        </form>
                    </div>
                </div>
            </div> --> 
        </div>
    </div>
</div>

<!-- Subcription History Slide Screen -->
<div class="main-height user-sub-history user-side-panel position-fixed">
    <div class="sidepanel-content">
        <div class="px-4 py-3">
            <div class="text-left">
                <img class="img-fluid sub-hist-close-btn" src="<?= base_url(); ?>assets/img/back-arrow-slide.svg">
                <h6 class="d-inline ml-3">Purchase History</h6>

            </div>
            <div class="my-4 px-2 py-3">
                <!--empty infographics strat-->
                <div class="px-3 px-md-4 py-5 text-center d-none" id="emptyinfoforsubscription">
                    <img src="<?= base_url(); ?>assets/img/insufficientPoints.svg" class="img-fluid">
                    <h5 class="my-4 pt-2">No purchase history available</h5>
                    <a href="<?= base_url() ?>subscriptions" class="btn button-plan-bg border-radius-12 text-white mt-4 px-5">OK</a>
                </div>
                <!--empty infographics end-->
                <div class="sub-history-list">
                    <!-- <div class="row sub-history-list-data" >
                        <div class="col-8">
                            <h6 class="font-weight-normal">Gold</h6>
                            <h6 class="fs08 cw-text-color-gray">26 Jan 2019, 05:00 PM</h6>
                            <h6 class="font-weight-normal"><img src="<?= base_url(); ?>assets/img/coin.png" width="17px" class="img-fluid"> 5000 Coins</h6>
                        </div>
                        <div class="col-4">
                            <h6 class="text-right"><span style="font-family: none;"> ₹</span>899</h6>
                        </div>
                        <div class="col-12"><hr class="mt-1"></div>
                    </div> -->

                    <!-- <div class="row">
                        <div class="col-8">
                            <h6 class="font-weight-normal">Gold</h6>
                            <h6 class="fs08 cw-text-color-gray">26 Jan 2019, 05:00 PM</h6>
                            <h6 class="font-weight-normal"><img src="<?= base_url(); ?>assets/img/coin.png" width="17px" class="img-fluid"> 5000 Coins</h6>
                        </div>
                        <div class="col-4">
                            <h6 class="text-right"><span style="font-family: none;"> ₹</span>899</h6>
                        </div>
                        <div class="col-12"><hr class="mt-1"></div>
                    </div>

                    <div class="row">
                        <div class="col-8">
                            <h6 class="font-weight-normal">Gold</h6>
                            <h6 class="fs08 cw-text-color-gray">26 Jan 2019, 05:00 PM</h6>
                            <h6 class="font-weight-normal"><img src="<?= base_url(); ?>assets/img/coin.png" width="17px" class="img-fluid"> 5000 Coins</h6>
                        </div>
                        <div class="col-4">
                            <h6 class="text-right"><span style="font-family: none;"> ₹</span>899</h6>
                        </div>
                        <div class="col-12"><hr class="mt-1"></div>
                    </div>

                    <div class="row">
                        <div class="col-8">
                            <h6 class="font-weight-normal">Gold</h6>
                            <h6 class="fs08 cw-text-color-gray">26 Jan 2019, 05:00 PM</h6>
                            <h6 class="font-weight-normal"><img src="<?= base_url(); ?>assets/img/coin.png" width="17px" class="img-fluid"> 5000 Coins</h6>
                        </div>
                        <div class="col-4">
                            <h6 class="text-right"><span style="font-family: none;"> ₹</span>899</h6>
                        </div>
                        <div class="col-12"><hr class="mt-1"></div>
                    </div>

                    <div class="row">
                        <div class="col-8">
                            <h6 class="font-weight-normal">Gold</h6>
                            <h6 class="fs08 cw-text-color-gray">26 Jan 2019, 05:00 PM</h6>
                            <h6 class="font-weight-normal"><img src="<?= base_url(); ?>assets/img/coin.png" width="17px" class="img-fluid"> 5000 Coins</h6>
                        </div>
                        <div class="col-4">
                            <h6 class="text-right"><span style="font-family: none;"> ₹</span>899</h6>
                        </div>
                        <div class="col-12"><hr class="mt-1"></div>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Wallet History Slide Screen -->
<div class="main-height user-wallet-history user-side-panel position-fixed">
    <div>
        <div class="px-4 py-3">
            <div class="text-left">
                <img class="img-fluid wallet-hist-close-btn" src="<?= base_url(); ?>assets/img/back-arrow-slide.svg">
                <h6 class="d-inline ml-3">Wallet History</h6>
            </div>
        </div>

        <div class="px-4 py-3">
            <div class="wallet-point-bg border-radius-15 text-center text-white py-4">
                <h6>Available Coins</h6>
                <h3 class="mb-0"><img src="<?= base_url(); ?>assets/img/coin.png" width="21px" class="img-fluid"> <?= get_User_Coins(); ?></h3>
            </div>
        </div>
        <!-- wallet list start here  -->
        <div>
            <div class="mt-2 mb-3 px-0 py-2">
                <div class="sub-history-list">
                    <div class="row mx-0 mb-2 py-3 px-2 wallet-history-row-bg">
                        <div class="col-8">
                            <h6 class="fs09">You won the World Cup prediction game.</h6>
                            <h6 class="fs08 cw-text-color-gray mb-0">Game . 16 July 2019</h6>
                        </div>
                        <div class="col-4">
                            <h6 class="text-right text-greencolor font-weight-normal">+ 20000</h6>
                        </div>
                    </div>

                    <div class="row mx-0 mb-2 py-3 px-2 wallet-history-row-bg">
                        <div class="col-8">
                            <h6 class="fs09">You won the World Cup prediction game.</h6>
                            <h6 class="fs08 cw-text-color-gray mb-0">Game . 16 July 2019</h6>
                        </div>
                        <div class="col-4">
                            <h6 class="text-right text-red font-weight-normal">- 20000</h6>
                        </div>
                    </div>

                    <div class="row mx-0 mb-2 py-3 px-2 wallet-history-row-bg">
                        <div class="col-8">
                            <h6 class="fs09">You won the World Cup prediction game.</h6>
                            <h6 class="fs08 cw-text-color-gray mb-0">Game . 16 July 2019</h6>
                        </div>
                        <div class="col-4">
                            <h6 class="text-right text-greencolor font-weight-normal">+ 20000</h6>
                        </div>
                    </div>

                    <div class="row mx-0 mb-2 py-3 px-2 wallet-history-row-bg">
                        <div class="col-8">
                            <h6 class="fs09">You won the World Cup prediction game.</h6>
                            <h6 class="fs08 cw-text-color-gray mb-0">Game . 16 July 2019</h6>
                        </div>
                        <div class="col-4">
                            <h6 class="text-right text-greencolor font-weight-normal">+ 20000</h6>
                        </div>
                    </div>

                    <div class="row mx-0 mb-2 py-3 px-2 wallet-history-row-bg">
                        <div class="col-8">
                            <h6 class="fs09">You won the World Cup prediction game.</h6>
                            <h6 class="fs08 cw-text-color-gray mb-0">Game . 16 July 2019</h6>
                        </div>
                        <div class="col-4">
                            <h6 class="text-right text-greencolor font-weight-normal">+ 20000</h6>
                        </div>
                    </div>

                </div>
            </div>
            <!-- wallet list end here  -->
        </div>
    </div>
</div>

<!-- Notification Slide Screen -->
<div class="w-100 blurdiv"></div>
<div class="main-height user-notifications user-side-panel position-fixed ">
    <div>
        <div class="px-4 py-3">
            <div class="d-flex justify-content-between align-items-center mt-2 mb-4">
                <h6 class="d-inline mb-0">Notifications</h6>
                <img class="img-fluid noti-close-btn" src="<?= base_url(); ?>assets/img/close-btn.svg">
            </div>
            <!-- <h6 class="font-weight-600 my-3">Today</h6> -->
            <div class="mb-4 px-2 pb-3">
                <div class="notifications-list row" id="notification_list">

                </div>
            </div>
        </div>
    </div>
</div>
<!-- Notification Slide Screen -->


<!-- Redeem Slide Screen -->
<div class="main-height user-redeem user-side-panel position-fixed">
    <div>
        <div class="px-4 py-3">
            <div class="text-left">
                <img class="img-fluid redeem-close-btn" src="<?= base_url() ?>assets/img/back-arrow-slide.svg">
                <h6 class="d-inline ml-3">Redeem Coins</h6>
            </div>
        </div>

        <div class="px-4 py-3 text-center">
            <b>Redeemable Coins Available</b>
            <div class="d-flex align-items-center justify-content-center mt-2">
                <img src="<?= base_url() ?>assets/img/coin.png" class="img-fluid mr-2">
                <h6 class="coins"><?=
                                        $get_Redeem_User_Coins = get_Redeem_User_Coins();
                                    $get_Redeem_User_Coins;
                                    ?></h6>
            </div>
            <div class="redeem-point-bg border-radius-15 text-center text-white py-4 d-flex flex-column justify-content-end mt-4 mb-3">
                <form id="redeem_request_form" method="post">
                    <div>
                        <input type="text" class="point_redeem text-center text-white" placeholder="Enter No. of Coins" id="point_redeem" maxlength="10" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                    </div>
                    <div class="text-white" id="point_redeem_error"></div>
                </form>
                <div>
                    <button type="button" class="fs08 btn button-plan-bg border-radius-12 mt-4 text-white px-3" id="submit_request_reddem">REQUEST REDEMPTION</button>
                </div>
            </div>
            <div>
                <b>Note : </b>
                <i>Only Coins which you earn <br> can be redeemed. Purchased or <br>Bonus Coins cannot be <br>redeemed.</i>
                <br>
                <i class="mt-3 d-inline-block">Coins will be redeemed in 2 <br>working days</i>
            </div>

        </div>
        <!--  <div class="border-top text-center">
             <a href="#" class="text-red pt-3 d-block redeem-view">View Redeem History</a>
         </div> -->


    </div>
</div>
<!-- Redeem Slide Screen -->

<!-- Redeem History Slide Screen -->
<div class="main-height user-redeem-histroy user-side-panel position-fixed">
    <div>
        <div class="px-4 py-3">
            <div class="text-left">
                <img class="img-fluid redeem-history-close-btn" src="<?= base_url() ?>assets/img/back-arrow-slide.svg">
                <h6 class="d-inline ml-3">Redeem History</h6>
            </div>
        </div>
        <div class="px-4 py-3 text-center">
            <b>Redeemable Coins Available</b>
            <div class="d-flex align-items-center justify-content-center mt-2">
                <img src="<?= base_url() ?>assets/img/coin.png" class="img-fluid mr-2">
                <h4 class="coins mb-0"><?=
                                            $get_Redeem_User_Coins = get_Redeem_User_Coins();
                                        $get_Redeem_User_Coins;
                                        ?>500</h4>
            </div>

            <div class="mt-4" id="redeeem-histroy">
                <div class="d-flex justify-content-between border-bottom pb-2 mb-4">
                    <div class="text-left">
                        <h6 class="redeem-title">Redeemed Points</h6>
                        <h6 class="points">600</h6>
                    </div>
                    <div class="text-right">
                        <h6 class="date">01 August</h6>
                        <h6 class="time">05:00 PM</h6>
                    </div>
                </div>
                <div class="d-flex justify-content-between border-bottom pb-2 mb-4">
                    <div class="text-left">
                        <h6 class="redeem-title">Redeemed Points</h6>
                        <h6 class="points">600</h6>
                    </div>
                    <div class="text-right">
                        <h6 class="date">01 August</h6>
                        <h6 class="time">05:00 PM</h6>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- Redeem History Slide Screen -->




<!-- all modals start-->
<div class="modal fade" id="commonModal" tabindex="-1" role="dialog" aria-labelledby="commonModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered " role="document">
        <div class="modal-content bg-blue theme-sm-modal ">
            <!-- <div class="modal-header">
              <h5 class="modal-title" id="commonModalLabel">Modal title</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div> -->
            <input type="hidden" name="contentpre_id" id="contentpre_id">
            <input type="hidden" name="contentGameId" id="contentGameId">
            <input type="hidden" name="contentcondition" id="contentcondition">
            <input type="hidden" name="contentdateTime" id="contentdateTime">
            <input type="hidden" name="change_prediction_time" id="change_prediction_time">
            <div class="modal-body p-0">
                <h3 class="p-title">Do you want to login to continue playing the game?</h3>
            </div>
            <div class="p-0 d-flex justify-content-center mt-3">
                <button type="button" class="btn bg-green text-white mr-3 " id="btn_yes"><span><img class="img-fluid mr-2" src="<?= base_url() ?>assets/img/yes.svg"></span>YES</button>
                <button type="button" class="btn bg-red text-white" data-dismiss="modal"><img class="img-fluid mr-2" src="<?= base_url() ?>assets/img/no.svg">NO</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="summaryModal" tabindex="-1" role="dialog" aria-labelledby="summaryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered " role="document">
        <div class="modal-content bg-blue theme-sm-modal ">
            <!-- <div class="modal-header">
              <h5 class="modal-title" id="commonModalLabel">Modal title</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div> -->
            <input type="hidden" name="contentpre_id" id="contentpre_id">
            <input type="hidden" name="contentGameId" id="contentGameId">
            <input type="hidden" name="contentcondition" id="contentcondition">
            <input type="hidden" name="contentdateTime" id="contentdateTime">
            <input type="hidden" name="change_prediction_time" id="change_prediction_time">
            <div class="modal-body p-0">
                <h3 class="p-title">Do you want to login to continue playing the game?</h3>
            </div>
            <div class="p-0 d-flex justify-content-center mt-3">
                <button type="button" class="btn bg-green text-white mr-3 btn-yes" id="btn_yes"><span><img class="img-fluid mr-2" src="<?= base_url() ?>assets/img/yes.svg"></span>Agree</button>
                <button type="button" class="btn bg-red text-white" data-dismiss="modal"><img class="img-fluid mr-2" src="<?= base_url() ?>assets/img/no.svg">Disagree</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="challengeModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 410px;">
        <div class="modal-content modal-blue-bg border-radius-10 border-0 popup-bg">
            <div class="px-4 py-5 text-center text-white">
                <p class="font-weight-light sub-text-color my-4" id="modalText"></p>
                <button class="btn button-plan-bg border-radius-12 text-white mt-2 px-4" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="popup_macModal" tabindex="-1" role="dialog" aria-labelledby="challengeModalCenterTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 410px;">
        <div class="modal-content modal-blue-bg border-radius-10 border-0 popup-bg">
            <div class="px-4 py-5 text-center text-white">
                <p class="font-weight-light sub-text-color my-4" id="modalTextPopup">

                </p>
                <button class="btn button-plan-bg border-radius-12 text-white mt-2 px-4" id="btn_ok_mac">OK</button>
            </div>
        </div>
    </div>
</div>
<!-- all modals end -->

<!-- Insufficient coins Modal in quiz -->
<div class="modal fade" id="insufficientCoinsQuiz" tabindex="-1" role="dialog" aria-labelledby="insufficientPointsModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 410px;">
        <div class="modal-content modal-blue-bg border-radius-10 border-0">
            <div class="px-3 px-md-4 py-5 text-center text-white">
                <img src="<?= base_url(); ?>assets/img/insufficientPoints.svg" class="img-fluid">
                <h5 class="my-4 pt-2">Insufficient Coins</h5>
                <p class="mb-0 font-weight-light sub-text-color">You have insufficient coins to play the quiz.</p>
                <a href="<?= base_url(); ?>subscriptions">
                    <button class="btn button-plan-bg border-radius-12 text-white mt-2 px-5">OK</button>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Insufficient Points Modal in Predictions Game -->
<div class="modal fade" id="insufficientPoints" tabindex="-1" role="dialog" aria-labelledby="insufficientPointsModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 410px;">
        <div class="modal-content modal-blue-bg border-radius-10 border-0">
            <div class="px-3 px-md-4 py-5 text-center text-white">
                <img src="<?= base_url(); ?>assets/img/insufficientPoints.svg" class="img-fluid">
                <h5 class="my-4 pt-2">Insufficient Coins</h5>
                <p class="mb-0 font-weight-light sub-text-color">You have insufficient coins to play the game.</p>
                <p class="font-weight-light sub-text-color">You can skip to see remaining predictions and prediction summary.</p>
                <button class="btn button-plan-bg border-radius-12 text-white mt-2 px-5" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>
<!-- Rules and rewards popup start -->
<div class="modal fade" id="rulesrewards" tabindex="-1" role="dialog" aria-labelledby="rulesrewardsPointsModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg  modal-dialog-centered" role="document">
        <div class="modal-content border-radius-10 border-0">
            <div class="row mx-md-5" id="instruction">
                <div class="col mt-3">
                    <h5 class="heading">
                        This game is about predicting<b> Cricket</b> accurately
                    </h5>
                    <h5 class="mb-4"><b class="font-weight-600">REWARDS</b></h5>
                    <div class="bg-blue px-5 py-3 border-15 mt-3 mb-5">
                        <table class="table text-white table-borderless ">
                            <tbody id="reward_table"></tbody>
                        </table>
                    </div>
                    <h5 class="mb-4"><b class="font-weight-600">How to play?</b></h5>

                    <!-- <iframe class="border-15" width="100%" height="280" src="https://www.youtube.com/embed/zTkY13IY5g8" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen="">
        </iframe> -->

                    <div class="mt-3 mb-5">
                        <p>Rules &amp; Updates</p>
                        <ol>
                            <li>Each prediction is similar to a company in the stock market </li>
                            <li>Instead of real money, you trade with 10000 points that you can buy at the beginning of the game </li>
                            <li>You can purchase a prediction by buying units of that prediction sold in our market. </li>
                            <li>One unit is like one share. You can also sell a prediction if you are convinced it will not come true or you find a better alternative. </li>
                            <li>Should a prediction come true, you get 100 bonus points for each unit/share owned For every wrong prediction, </li>
                            <li>the number of units/shares become zero Price of a prediction will go up if there is demand and more people believe that the prediction will come true</li>
                        </ol>
                        <div class="bg-light-blue px-4 py-3 rounded-pill text-gray ml-4 d-inline-block"> This game ends on December 31st, 2019</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Rules and rewards popup end-->
<!-- Initial Coins Modal -->
<div class="modal fade" id="initialCoinsModalCenter" tabindex="-1" role="dialog" aria-labelledby="initialCoinsModalCenterTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered mx-auto" role="document" style="max-width: 360px;">
        <div class="modal-content modal-blue-bg border-radius-10 border-0 popup-bg">
            <div class="px-4 px-md-5 py-5 text-center text-white">
                <div class="position-relative">
                    <img src="<?= base_url(); ?>assets/img/initial-coins-bg.svg" class="img-fluid">
                    <div class="position-absolute w-100" style="bottom: 0;">
                        <img class="img-fluid" src="<?= base_url(); ?>assets/img/coin.png">
                        <h4 class="mt-3 mb-0"><?= @$_SESSION['data']['get_initial_coins'] ?></h4>
                    </div>
                </div>
                <h5 class="mt-5 mb-4 pt-2">Congratulations !!!</h5>
                <p class="mb-0 font-weight-light sub-text-color"><?= @$_SESSION['data']['get_initial_coins'] ?> Coins Have Been Added To Your Wallet. Select Topic To Start Playing Your Favourite Prediction Game.</p>
                <button class="btn button-plan-bg border-radius-12 text-white mt-4 px-5" id="popupintilcoin">OK</button>
            </div>
        </div>
    </div>
</div>

<!--share popup start-->
<div class="modal fade" id="shareModal" tabindex="-1" role="dialog" aria-labelledby="shareTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mx-auto" role="document" style="max-width: 240px;">
        <div class="modal-content modal-blue-bg border-radius-10 border-0 popup-bg">
            <div class="px-4 py-5 text-center text-white">

                <a id="facebookshare" target="_blank" class="d-flex mb-3 text-white text-decoration-none">
                    <div><img src="<?= base_url() ?>assets/img/fb.png" class="img-fluid mr-3" style="width:30px"></div>
                    <h6 class="mb-0">Facebook</h6>
                </a>
                <a id="twittershare" target="_blank" class="d-flex mb-3 text-white text-decoration-none">
                    <div><img src="<?= base_url() ?>assets/img/twitter.png" class="img-fluid mr-3" style="width:30px"></div>
                    <h6 class="mb-0">Twitter</h6>
                </a>
                <a id="linkedinshare" target="_blank" class="d-flex mb-3 text-white text-decoration-none">
                    <div><img src="<?= base_url() ?>assets/img/linkdein.jpg" class="img-fluid mr-3" style="width:30px"></div>
                    <h6 class="mb-0">Linkedin</h6>
                </a>
                <a id="whatsappshare" target="_blank" class="d-flex mb-3 text-white text-decoration-none">
                    <div><img src="<?= base_url() ?>assets/img/whatsapp.jpg" class="img-fluid mr-3" style="width:30px"></div>
                    <h6 class="mb-0">Whatsapp</h6>
                </a>
                <div class="copy-link">
                    <p class="text-left mb-1 font-weight-light copy-title">Click to copy link</p>
                    <input type="text" placeholder="Sharable link" class="input-group" value="">
                </div>
            </div>
        </div>
    </div>
</div>
<!--share popup end-->

<!--average portfolio popup starts-->
<?php $this->load->view('popup/average_portfolio'); ?>
<!--average portfolio popup ends-->

<!-- all modals end-->


<!-- toast div start -->
<div id="alert_placeholder" class="fixed-top my-3 " style="right:21px;z-index: 1051;top:80px"></div>
<!-- toast div end -->

<!--mobile width floating btn start-->
<?php
$className = strtolower($this->router->fetch_class());
$method = $this->router->fetch_method();
if ($className == 'home' || $method == 'rules_rewards') {
?>
    <div class="d-flex fixed-bottom bg-transparent w-100 foating-menu d-block d-sm-none">
        <?php if ($className == 'home') { ?>
            <a href="javascript:void(0)" id="gameDashboard" class="btn col gamedashboard bg-white">Game Dashboard</a>
            <a href="javascript:void(0)" class="btn col redeem bg-white">Redeem</a>
        <?php } ?>
        <?php if ($className != 'home') { ?>
            <a href="javascript:void(0)" class="btn col bg-white redeem border border-red">Redeem</a>
        <?php } ?>
        <?php
        if ($className == 'predictions' || $className == 'games') {
            echo '<a href="' . base_url('subscriptions') . '" class="btn col purchase text-white">Purchase</a>';
        }
        ?>

    </div>
<?php } ?>



<!-- footer end -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript">
    $('.subs-slide').slick({
        dots: false,
        infinite: false,
        speed: 300,
        slidesToShow: 2,
        centerPadding: '60px',
        variableWidth: true,
        responsive: [{
                breakpoint: 1024,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
                    dots: false
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    dots: true,
                    arrows: false
                }
            }
        ]
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {

        var user_profile = false;
        var user_edit_profile = false;
        var user_notifications = false;
        var user_sub_history = false;
        var user_wallet_history = false;
        var user_rewards = false;
        var user_redeem = false;
        var user_redeem_history = false;

        $('.btn-share').on('click', function() {
            var card = getVisibleCArd();
            let number = atob(card.find('.pred-id').html());
            $('.copy-link p').html('Click to copy link');
            $('.copy-link input').attr('value', location.href + '/' + number);
            $('#facebookshare').attr('href', encodeURI('https://www.facebook.com/sharer/sharer.php?u=' + location.href + '/' + number));
            $('#twittershare').attr('href', encodeURI('https://twitter.com/intent/tweet?url=' + location.href + '/' + number + '&hashtags=Crowdwisdom'));
            $('#linkedinshare').attr('href', encodeURI('https://www.linkedin.com/shareArticle?mini=true&url=' + location.href + '/' + number));
            $('#whatsappshare').attr('href', encodeURI('https://wa.me/?text=' + location.href + '/' + number));
        });

        $('.btn-blog-share, .normal_btn-quiz-share').on('click', function() {
            $('.copy-link p').html('Click to copy link');
            $('.copy-link input').attr('value', location.href);
            $('#facebookshare').attr('href', encodeURI('https://www.facebook.com/sharer/sharer.php?u=' + location.href));
            $('#twittershare').attr('href', encodeURI('https://twitter.com/intent/tweet?url=' + location.href + '/' + '&hashtags=Crowdwisdom'));
            $('#linkedinshare').attr('href', encodeURI('https://www.linkedin.com/shareArticle?mini=true&url=' + location.href));
            $('#whatsappshare').attr('href', encodeURI('https://wa.me/?text=' + location.href));
        });

        $('.btn-quiz-share').on('click', function() {
            var url = base_url + 'quiz/quiz_preview/' + quiz_id + '/' + topicId + '/' + userId;
            $('.copy-link p').html('Click to copy link');
            $('.copy-link input').attr('value', url);
            $('#facebookshare').attr('href', encodeURI('https://www.facebook.com/sharer/sharer.php?u=' +
                url));
            $('#twittershare').attr('href', encodeURI('https://twitter.com/intent/tweet?url=' + url + '/' + '&hashtags=Crowdwisdom'));
            $('#linkedinshare').attr('href', encodeURI('https://www.linkedin.com/shareArticle?mini=true&url=' + url));
            $('#whatsappshare').attr('href', encodeURI('https://wa.me/?text=' + url));
        });

        $('.copy-link p, .copy-link input').click(function(e) {
            $('.copy-link input').select();
            if (document.execCommand("copy")) {
                $('.copy-link p').html('Link copied');
            }
        });

        $('.datepicker').datepicker({

            format: "dd/mm/yyyy",
            endDate: '-1d',
            autoclose: true
        });

        //initialCoinsModalCenter function start

        var popup_show = "<?= @$_SESSION['data']['game_point_pop']; ?>";
        if (popup_show == '1') {
            $("#initialCoinsModalCenter").modal("show");
        }

        var popup_macId = "<?= @$_SESSION['login_data']['popup']; ?>";
        //alert(popup_macId);
        if (popup_macId == '1') {
            $("#modalTextPopup").html("<?= @$_SESSION['login_data']['msg'] ?>");
            $('#popup_macModal').modal('show');
        }


        $('#popupintilcoin').click(function() {
            //alert('popupintilcoin');
            $.ajax({
                url: base_url + "login/update_game_point_pop",
                type: "POST",
                dataType: "json",
                data: '',
                success: function(data, textStatus, jqXHR) {
                    // console.log(data)
                    if (data == "pass") {
                        $("#initialCoinsModalCenter").modal("hide");
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {

                }
            });
        });


        $('#user-profile-info').click(function() {
            if (user_notifications) {
                close_drawer('user-notifications');
                user_notifications = false
            }
            if (user_sub_history) {
                close_drawer('user-sub-history');
                user_sub_history = false;
            }
            if (user_wallet_history) {
                close_drawer('user-wallet-history');
                user_wallet_history = false;
            }

            if (user_rewards) {
                close_drawer('user-rewards');
                user_rewards = false;
            }
            if (user_edit_profile) {
                close_drawer('user-profile-edit');
                user_edit_profile = false;
            }

            if (user_redeem) {
                close_drawer('user-redeem');
                user_redeem = false;
            }

            if (user_profile == false) {
                open_drawer('user-profile-info');
                user_profile = true;
            } else {
                close_drawer('user-profile-info');
                user_profile = false;
            }

        });



        /*User Edit Profile*/
        $('#profile_edit').click(function () {
            // if (user_edit_profile == false) {
            //     $('.user-profile-edit').css('display', 'block').animate({'marginRight': '0'}, 500, 'linear');
            //     user_edit_profile = true;
            // } else {
            //     // close_drawer('user-wallet-history');
            //     $('.user-profile-edit').css('display', 'block').animate({'marginRight': '-375'}, 500, 'linear', function () {
            //         $('.user-profile-edit').css('display', 'none')
            //     });
            //     user_edit_profile = false;
            // }
        window.location.href = "<?php echo base_url('My_profile/edit_profile_page');?>";    
        });

        $('.profile-close-btn').click(function() {
            close_drawer('user-profile-info');
            user_profile = false;
        });


        /*User Subscription History*/
        $('#user-sub-history').click(function() {
            if (user_sub_history == false) {
                $('.user-sub-history').css('display', 'block').animate({
                    'marginRight': '0'
                }, 500, 'linear');
                user_sub_history = true;
                html = "";
                $.ajax({
                    url: base_url + "home/sub_history",
                    type: "POST",
                    dataType: "json",
                    data: '',
                    success: function(data, textStatus, jqXHR) {
                        if (data.subscription_history_data.length == 0) {
                            $('#emptyinfoforsubscription').removeClass('d-none');
                        } else {
                            var html = "";
                            $.each(data.subscription_history_data, function(key, val) {
                                html += '<div class="row">';
                                html += '<div class="col-8">';
                                html += '<h6 class="font-weight-normal">' + val.package_name + '</h6>';
                                html += '<h6 class="fs08 cw-text-color-gray">' + moment(val.transaction_date).format('DD MMM YYYY, h:mm A') + '</h6>';
                                html += '<h6 class="font-weight-normal"><img src="<?= base_url(); ?>assets/img/coin.png" width="17px" class="img-fluid"> ' + val.coins + ' Coins</h6>';
                                html += ' </div>';
                                html += '<div class="col-4">';
                                html += '<h6 class="text-right"><span style="font-family: none;"> ₹</span>' + val.transaction_amount + '</h6>';
                                html += '</div>';
                                html += '<div class="col-12"><hr class="mt-1"></div>';
                                html += '</div>';

                            });
                            $(".sub-history-list").html(html)
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {}
                });
            } else {
                $('.user-sub-history').css('display', 'block').animate({
                    'marginRight': '-375'
                }, 500, 'linear', function() {
                    $('.user-sub-history').css('display', 'none')
                });
                //                close_drawer('user-sub-history');
                user_sub_history = false;
            }
        });

        $('.sub-hist-close-btn').click(function() {
            $('.user-sub-history').css('display', 'block').animate({
                'marginRight': '-375'
            }, 500, 'linear', function() {
                $('.user-sub-history').css('display', 'none')
            });
            user_sub_history = false;
        });



        $('.proedit-hist-close-btn').click(function() {
            $('.user-profile-edit').css('display', 'block').animate({
                'marginRight': '-375'
            }, 500, 'linear', function() {
                $('.user-profile-edit').css('display', 'none')
            });
            user_edit_profile = false;
        });




        /*User Wallet History*/
        $('#user-wallet-history').click(function() {
            if (user_wallet_history == false) {
                $('.user-wallet-history').css('display', 'block').animate({
                    'marginRight': '0'
                }, 500, 'linear');
                user_wallet_history = true;
            } else {
                //                close_drawer('user-wallet-history');
                $('.user-wallet-history').css('display', 'block').animate({
                    'marginRight': '-375'
                }, 500, 'linear', function() {
                    $('.user-wallet-history').css('display', 'none')
                });
                user_wallet_history = false;
            }
        });


        $('.wallet-hist-close-btn').click(function() {
            if (user_wallet_history == false) {
                $('.user-wallet-history').css('display', 'block').animate({
                    'marginRight': '0'
                }, 500, 'linear');
                user_wallet_history = true;
            } else {
                //                close_drawer('user-wallet-history');
                $('.user-wallet-history').css('display', 'block').animate({
                    'marginRight': '-375'
                }, 500, 'linear', function() {
                    $('.user-wallet-history').css('display', 'none')
                });
                user_wallet_history = false;
            }
        });



        /*User rewards start*/
        $('#user-rewards').click(function() {
            if (user_rewards == false) {
                open_drawer('user-rewards');
                //                $('.user-rewards').css('display', 'block').animate({'marginRight': '0'}, 500, 'linear');
                user_rewards = true;
            } else {
                close_drawer('user-rewards');
                //                $('.user-rewards').css('display', 'block').animate({'marginRight': '-375'}, 500, 'linear', function () {
                //                    $('.user-rewards').css('display', 'none')
                //                });
                user_rewards = false;
            }
        });


        $('.rewards-close-btn').click(function() {
            if (user_rewards == false) {
                open_drawer('user-rewards');
                //                $('.user-rewards').css('display', 'block').animate({'marginRight': '0'}, 500, 'linear');
                user_rewards = true;
            } else {
                close_drawer('user-rewards');
                //                $('.user-rewards').css('display', 'block').animate({'marginRight': '-375'}, 500, 'linear', function () {
                //                    $('.user-rewards').css('display', 'none')
                //                });
                user_rewards = false;
            }
        });
        /*User rewards end*/

        /*User redeem histroy start*/
        $('.redeem-view').click(function() {
            if (user_redeem_history == false) {
                open_drawer('user-redeem-histroy');
                //                $('.user-redeem-histroy').css('display', 'block').animate({'marginRight': '0'}, 500, 'linear');
                user_rewards = true;
            } else {
                $('.user-redeem-histroy').css('display', 'block').animate({
                    'marginRight': '-375'
                }, 500, 'linear', function() {
                    $('.user-redeem-histroy').css('display', 'none')
                });
                user_redeem_history = false;
            }
        });


        $('.redeem-history-close-btn').click(function() {
            if (user_redeem_history == false) {
                open_drawer('user-redeem-histroy');
                //                $('.user-redeem-histroy').css('display', 'block').animate({'marginRight': '0'}, 500, 'linear');
                user_redeem_history = true;
            } else {
                $('.user-redeem-histroy').css('display', 'block').animate({
                    'marginRight': '-375'
                }, 500, 'linear', function() {
                    $('.user-redeem-histroy').css('display', 'none')
                });
                user_redeem_history = false;
            }
        });
        /*User redeem histroy end*/

        /*User Notifications*/

        function get_notifications() {
            $.ajax({
                url: base_url + "Home/get_notifications",
                type: "POST",
                dataType: "json",
                success: function(res, textStatus, jqXHR) {
                    notification = "";
                    if (res.notifications != '') {
                        $.each(res.notifications, function(key, value) {
                            notification += "<div class='col-12 bg-white p-3 mb-3'>";
                            notification += "<div class='not-header'>";
                            if (is_blank(value.game_title) != 0 && (value.prediction_status != 'right' || value.prediction_status != 'wrong')) {
                                notification += "<h6 class='mb-0 not-title font-weight-600'>New Game Available! Play now to win.</h6>";
                            } else if (is_blank(value.prediction_title) != 0) {
                                if (value.prediction_status == 'right' || value.prediction_status == 'wrong') {
                                    notification += "<h6 class='mb-0 not-title font-weight-600'>Congrats!! Your prediction is right.</h6>";
                                } else {
                                    notification += "<h6 class='mb-0 not-title font-weight-600'>New Prediction Available! Play now to win.</h6>";
                                }
                            } else if (is_blank(value.coins) != 0 && is_blank(value.add_deduct) == 0) {
                                notification += "<h6 class='mb-0 not-title font-weight-600'>" + Math.round(value.coins) + " coins have been added to your wallet.</h6>";
                            } else if (is_blank(value.coins) != 0 && (is_blank(value.add_deduct) == '1' || is_blank(value.add_deduct) == '2')) {
                                if (value.add_deduct == '1') {
                                    notification_msg = Math.round(value.coins) + " coins have been added to your wallet by Crowdwisdom.";
                                } else if (value.add_deduct == '2') {
                                    notification_msg = Math.round(value.coins) + " coins have been deducted from your wallet by Crowdwisdom.";
                                }
                                notification += "<h6 class='mb-0 not-title font-weight-600'>" + notification_msg + "</h6>";
                            }
                            notification += "<small class='text-gray'>" + moment(value.created_date).format('DD MMM, h:mm A') + "</small>";
                            notification += "</div>";
                            if (is_blank(value.game_title) != 0 && is_blank(value.prediction_title) == 0) {
                                notification += "<a href='" + base_url + "Predictions/prediction_game/" + value.game_id + "'><p class='not-desc'>" + value.game_title + "</p>";
                                notification += "<img src='" + value.game_image + "' class='img-fluid w-100'></a>";
                            }
                            if (is_blank(value.prediction_id) != 0 && is_blank(value.prediction_title) != 0 && (value.prediction_status != 'right' || value.prediction_status != 'wrong')) {
                                notification += "<a href='" + base_url + "Predictions/prediction_game/" + value.game_id + "/" + value.prediction_id + "'><p class='not-desc'>" + value.prediction_title + "</p>";
                                notification += "<img src='" + value.prediction_image + "' class='img-fluid w-100'></a>";
                            }
                            if (is_blank(value.prediction_title) != 0 && (value.prediction_status == 'right' || value.prediction_status == 'wrong')) {
                                notification += "<p class='not-desc'><b>Prediction: </b>" + value.prediction_title + "</p>";
                                notification += "<p class='not-desc'><b>Game: </b>" + value.game_title + "</p>";
                                notification += "<img src='" + base_url + "assets/img/you_won.png' class='img-fluid w-100'></a>";
                            }
                            notification += "</div>";
                        });
                    } else {
                        notification = "<p id='empty_notification'>No notifications available.</p>";
                    }
                    $('.notify-count').remove(); //to remove notification count
                    $('#notification_list').html(notification);
                },
            });
        }

        function add_new_notifications(res) {
            new_notification_obj = Object.assign({}, res.new_notifications);
            notification_obj_count = Object.keys(new_notification_obj).length;
            if (notification_obj_count > 0) {
                new_notification = "";
                $.each(new_notification_obj, function(key, value) {
                    new_notification += "<div class='col-12 bg-white p-3 mb-3'>";
                    new_notification += "<div class='not-header'>";
                    // new_notification += "<img src='"+base_url+"assets/img/circularnotification.svg' class='im-fluid float-left mr-3'>";
                    if (is_blank(value.game_title) != 0 && (value.prediction_status != 'right' || value.prediction_status == 'wrong')) {
                        new_notification += "<h6 class='mb-0 not-title font-weight-600'>New Game Available! Play now to win.</h6>";
                    } else if (is_blank(value.prediction_title) != 0) {
                        if (value.prediction_status == 'right' || value.prediction_status == 'wrong') {
                            new_notification += "<h6 class='mb-0 not-title font-weight-600'>Congrats!! Your prediction is right.</h6>";
                        } else {
                            new_notification += "<h6 class='mb-0 not-title font-weight-600'>New Prediction Available! Play now to win.</h6>";
                        }
                    } else if (is_blank(value.coins) != 0 && is_blank(value.add_deduct) == 0) {
                        new_notification += "<h6 class='mb-0 not-title font-weight-600'>" + Math.round(value.coins) + " coins have been added to your wallet.</h6>";
                    } else if (is_blank(value.coins) != 0 && (is_blank(value.add_deduct) == '1' || is_blank(value.add_deduct) == '2')) {
                        if (value.add_deduct == '1') {
                            notification_msg = Math.round(value.coins) + " coins have been added to your wallet by Crowdwisdom.";
                        } else if (value.add_deduct == '2') {
                            notification_msg = Math.round(value.coins) + " coins have been deducted from your wallet by Crowdwisdom.";
                        }
                        new_notification += "<h6 class='mb-0 not-title font-weight-600'>" + notification_msg + "</h6>";
                    }
                    new_notification += "<small class='text-gray'>" + moment(value.created_date).format('DD MMM, h:mm A') + "</small>";
                    new_notification += "</div>";

                    if (is_blank(value.game_title) != 0 && is_blank(value.prediction_title) == 0) {
                        new_notification += "<a href='" + base_url + "Predictions/prediction_game/" + value.game_id + "' class='title-text'><p class='not-desc title-text'>" + value.game_title + "</p>";
                        new_notification += "<img src='" + value.game_image + "' class='img-fluid w-100'></a>";
                    }
                    if (is_blank(value.prediction_id) != 0 && is_blank(value.prediction_title) != 0 && (value.prediction_status != 'right' || value.prediction_status != 'wrong')) {
                        new_notification += "<a href='" + base_url + "Predictions/prediction_game/" + value.game_id + "/" + value.prediction_id + "'><p class='not-desc title-text' class='title-text'>" + value.prediction_title + "</p>";
                        new_notification += "<img src='" + value.prediction_image + "' class='img-fluid w-100'></a>";
                    }
                    if (is_blank(value.prediction_title) != 0 && (value.prediction_status == 'right' || value.prediction_status == 'wrong')) {
                        new_notification += "<p class='not-desc'><b>Prediction: </b>" + value.prediction_title + "</p>";
                        new_notification += "<p class='not-desc'><b>Game: </b>" + value.game_title + "</p>";
                        new_notification += "<img src='" + base_url + "assets/img/you_won.png' class='img-fluid w-100'></a>";
                    }
                    new_notification += "</div>";
                });
                $('#empty_notification').remove();
                $('#notification_list').prepend(new_notification);
            }
        }

        /*function is_blank(value) {
            alert(456);
            if (value == '') {
                value = 0;
            } else if (typeof value === 'undefined') {
                value = 0;
            } else if (value == null) {
                value = 0;
            } else {
                value = value;
            }
            return value;
        }*/

        $('#user_notifications').click(function() {

            if (user_profile) {
                close_drawer('user-profile-info');
                user_profile = false
            }
            if (user_sub_history) {
                close_drawer('user-sub-history');
                user_sub_history = false;
            }
            if (user_wallet_history) {
                close_drawer('user-wallet-history');
                user_wallet_history = false;
            }

            if (user_rewards) {
                close_drawer('user-rewards');
                user_rewards = false;
            }

            if (user_redeem) {
                close_drawer('user-redeem');
                user_redeem = false;
            }

            if (user_edit_profile) {
                close_drawer('user-profile-edit');
                user_edit_profile = false;
            }

            if (user_notifications == false) {
                open_drawer('user-notifications');
                user_notifications = true;
                get_notifications();
            } else {
                close_drawer('user-notifications');
                $('.notify-count').remove(); //to remove notification count
                user_notifications = false;
            }


        });


        $('.noti-close-btn').click(function() {
            if (user_notifications == false) {
                open_drawer('user-notifications');
                user_notifications = true;
                get_notifications();
            } else {
                close_drawer('user-notifications');
                $('.notify-count').remove(); //to remove notification count
                user_notifications = false;
            }
        });

        //        user notification end

        //        Redeem start
        $('#redeem-btn').click(function() {
            if (user_redeem == false) {
                $('.user-redeem').css('display', 'block').animate({
                    'marginRight': '0'
                }, 500, 'linear');
                user_redeem = true;
            } else {
                $('.user-redeem').css('display', 'block').animate({
                    'marginRight': '-375'
                }, 500, 'linear', function() {
                    $('.user-redeem').css('display', 'none')
                });
                user_redeem = false;
            }
        });

        $('.redeem-close-btn').click(function() {
            $("#point_redeem").val('');
            $('#point_redeem_error').html();
            if (user_redeem == false) {
                $('.user_redeem').css('display', 'block').animate({
                    'marginRight': '0'
                }, 500, 'linear');
                user_redeem = true;
            } else {
                $('.user-redeem').css('display', 'block').animate({
                    'marginRight': '-375'
                }, 500, 'linear', function() {
                    $('.user-redeem').css('display', 'none')
                });
                user_redeem = false;
            }
        });

        $('.redeem').click(function() {
            //$('#user-rewards').trigger('click');

            if (user_notifications) {
                close_drawer('user-notifications');
                user_notifications = false
            }
            if (user_sub_history) {
                close_drawer('user-sub-history');
                user_sub_history = false;
            }
            if (user_wallet_history) {
                close_drawer('user-wallet-history');
                user_wallet_history = false;
            }

            if (user_profile) {
                close_drawer('user-profile-info');
                user_profile = false;
            }

            if (user_edit_profile) {
                close_drawer('user-profile-edit');
                user_edit_profile = false;
            }

            if (user_rewards == false) {
                open_drawer('user-rewards');
                user_rewards = true;
            } else {
                close_drawer('user-rewards');
                user_rewards = false;
                if (user_redeem) {
                    close_drawer('user-redeem');
                    user_redeem = false;
                }
            }
            /*if (user_redeem) {
                close_drawer('user_redeem');
                user_redeem = false;
            }*/
        })
        //        Redeem end

        $("input[type='image']").click(function() {
            $("input[id='uploadBtn']").click();
        });


        $("#uploadBtn").on("change", function() {
            var file = $(this)[0].files[0];
            var imageData = new FormData();
            imageData.append('file', file);
            ajax_call_multipart("https://imgupload.crowdwisdom.co.in", "POST", imageData, function(result) {
                $("#main_image").val(result);
                $(".default_profile").css('background-image', 'url(' + result + ')');

            });
        });


        function ajax_call_multipart(url, method, param, cb) {
            $.ajax({
                url: url,
                method: method,
                data: param,
                cache: false,
                contentType: false,
                processData: false
            }).done(function(result) {
                cb(result);
            });
        }

        function get_notification_count() {
            $.ajax({
                url: base_url + 'home/get_notification_count',
                type: 'POST',
                data: {
                    user_notifications: user_notifications
                },
                dataType: 'JSON',
                success: function(data, textStatus, jqXHR) {
                    if (is_blank(data.notification_details.notificationCount) != 0 && is_blank(data.notification_details.lastNotificationId) != 0) {
                        if (user_notifications == false) {
                            var notification = '<span class="notify-count position-absolute d-flex align-items-center justify-content-center" id="notificationCount">' + data.notification_details.notificationCount + '</span>';
                            $('#notificationCount').remove();
                            $('#user_notifications').after(notification);
                        }
                    }
                    if (user_notifications == true) {
                        add_new_notifications(data); //append new notifications if notification drawer is open 
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {}
            });
        }

        function get_user_coins() {
            $.ajax({
                url: base_url + 'home/get_user_coins',
                type: 'POST',
                dataType: 'JSON',
                success: function(data, textStatus, jqXHR) {
                    if (is_blank(data.user_coins.coins) != 0) {
                        $('#user_coins').html(data.user_coins.coins);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {}
            });
        }

        user_id = "<?php echo $this->user_id; ?>";
        if (is_blank(user_id) != 0) {
            setInterval(get_notification_count, 7000);
        }
        if (is_blank(user_id) != 0) {
            setInterval(get_user_coins, 5000);
        }
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        // Setting Input Field To Disabled IF email Response from social Login.
        var email = "<?= @$user_details['email']; ?>";
        if (email) {
            document.getElementById("email").readOnly = true;
        }
    });

    function update_profile() {
        redirect = '<?php echo $this->uri->segment(1); ?>';
        var url = base_url + "my_profile/update_profile";
        var formdata = $('#persondetailform').serializeArray();
        formdata.push({
            redirect: redirect
        });
        var name = $("#name").val();
        var gender = $("#gender").val();
        var dob = $("#dob").val();
        var phone = $("#phone").val();
        var email = $("#email").val();
        var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
        //alert(name.length);
        if (name == '' && gender == '' && dob == '' && phone == '' && email == '') {

            $('#name_error').html('The name field is required');
            $('#gender_error').html('Please select gender');
            $('#dob_error').html('Please select Date of Birth');
            $('#phone_error').html('The mobile no. field is required.');
            $('#email_error').html('The email field is required.');

            $('#persondetailform input').focus(function(e) {
                $(this).next('.text-danger').hide();
            });

            $('#persondetailform select').focus(function(e) {
                $(this).next('.text-danger').hide();
            });
            return false;
        } else if (name == '') {
            $('#name_error').html('The name field is required');
            return false;
        } else if (name == '') {
            $('#name_error').html('The name field is required');
            return false;
        } else if (gender == '') {
            $('#gender_error').html('Please select gender');
            return false;
        } else if (dob == '') {
            $('#dob_error').html('Please select Date of Birth');
            return false;
        } else if (phone == '') {
            $('#phone_error').html('The mobile no. field is required.');
            return false;
        } else if (email == '') {
            $('#email_error').html('The email field is required.');
            return false;
        } else if (email != '' && reg.test(email) == false) {
            $('#email_error').html('Invalid Email.');
            return false;
        } else {

            $.ajax({
                url: url,
                dataType: 'JSON',
                data: formdata,
                type: 'post',
                success: function(data, textStatus, jqXHR) {
                    if (data.status == 'failure') {

                        if (data.error != "") {
                            $.each(data.error, function(index, value) {

                                if (index == 'name') {
                                    $('#name_error').text(data.error.name).css("color", "#f44336");
                                } else if (index == 'phone') {
                                    $('#phone_error').text(data.error.phone).css("color", "#f44336");
                                }
                            });

                        }


                    } else {
                        $('#modalText').html('Profile updated successfully');
                        $('#basicModal').modal('show');
                        setInterval(function() {
                            location.reload();
                        }, 2000);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {}
            });
        }
    }


    function showmessage(message, alerttype) {
        $('#alert_placeholder').fadeIn('fast');
        $('#alert_placeholder').html("<div class ='float-right col-md-3 alert alert-" + alerttype + "' >" + message + "<button type='button' class='close' data-dismiss='alert' aria-label='close'><span aria-hidden='true'>&times</span></button></div> ");
        setTimeout(function() {
            $('#alert_placeholder').fadeOut('fast');
        }, 3000);
    }
</script>

<script>
    // $(window).scroll(function (e) {
    //     st = $(this).scrollTop();
    //     if (st > 100) {
    //         $('.navbar-holder').addClass('fixed-top bg-white').removeClass('blue-nav');
    //     } else {
    //         $('.navbar-holder').removeClass('fixed-top bg-white').addClass('blue-nav');
    //     }
    // });
    function open_drawer(selector) {
        $('.blurdiv').show();
        $('body').css({
            'height': '100vh',
            'width': '100%',
            'overflow': 'hidden'
        });
        $("." + selector).css('display', 'block').animate({
            'marginRight': '0'
        }, 500, 'linear');
    }

    function close_drawer(selector) {
        $('.blurdiv').hide();
        $('body').css({
            'height': 'unset',
            'width': 'unset',
            'overflow': 'unset'
        });
        $('.' + selector).css('display', 'block').animate({
            'marginRight': '-375'
        }, 500, 'linear', function() {
            $('.' + selector).css('display', 'none');
        });
    }

    function openpopup(title, pre_id, game_id, condition, dateTime, change_prediction_time) {
        $('.p-title').html(title);
        $("#contentpre_id").val(pre_id);
        $("#contentGameId").val(game_id);
        $("#contentcondition").val(condition);
        $("#contentdateTime").val(dateTime);
        $("#change_prediction_time").val(change_prediction_time);
        $('#summaryModal').modal('show');
    }

    function active_second() {
        var no_of_tab = ($('#pills-tab .nav-item').length);
        if (no_of_tab == 2) {
            var second_tab_id = $('#pills-tab .nav-item:nth-child(2) .nav-link').attr('id');
            $('#' + second_tab_id).tab('show');
            // console.log(second_tab_id);

        }
    }

    $(document).on('click', '#submit_request_reddem', function() {
        $('#submit_request_reddem').attr('disabled', true);
        var point_redeem = $("#point_redeem").val();
        var user_id = "<?php echo $this->user_id; ?>";
        var email = "<?php echo @$_SESSION['data']['email']; ?>";
        var coins = "<?php echo $get_Redeem_User_Coins; ?>";
        //alert(email);
        // alert(coins);
        var numbers = /^[0-9]+$/;
        if (point_redeem == '') {
            $('#point_redeem_error').html('The Coins field is required.');
            $('#submit_request_reddem').removeAttr('disabled');
            return false;
        } else if (!point_redeem.match(numbers)) {
            $('#point_redeem_error').html('Coins cannot be Decimal.');
            $('#submit_request_reddem').removeAttr('disabled');
            return false;
        } else if (parseInt(point_redeem) == 0) {
            $('#point_redeem_error').html('Not Enough Coins.');
            $('#submit_request_reddem').removeAttr('disabled');
            return false;
        } else if (parseInt(point_redeem) > parseInt(coins)) {
            $('#point_redeem_error').html('Not Enough Coins.');
            $('#submit_request_reddem').removeAttr('disabled');
            return false;
        } else {
            $.ajax({
                url: base_url + "redeem/point_redeem",
                type: "POST",
                dataType: "json",
                data: {
                    point_redeem: point_redeem,
                    user_id: user_id,
                    email: email,
                },
                success: function(data, textStatus, jqXHR) {
                    // console.log(data);
                    $("#point_redeem").val('');
                    $('#modalText').html('Redemption request has been sent.' + point_redeem + ' deduction.');
                    $('#basicModal').modal('show');
                    setInterval(function() {
                        $('#submit_request_reddem').removeAttr('disabled');
                        location.reload();
                    }, 2000);

                },
            });
        }
    });


    $(document).on('click', '#btn_ok_mac', function() {
        // alert()
        $.ajax({
            url: base_url + "home/destroy_session",
            type: "POST",
            dataType: "json",
            data: {
                popup_macId_chk: "<?= @$_SESSION['login_data']['popup']; ?>"
            },
            success: function(data, textStatus, jqXHR) {
                // console.log(data);     
                window.location.href = base_url + "home";
            },
        });
    });

    dash_userloged_in = "<?= @$_SESSION['login_data']['uid']; ?>";
    $('#gameDashboard').on('click', function(e) {
        if (dash_userloged_in != "") {
            window.location.href = base_url + "games_dashboard";
        } else {
            window.location.href = base_url + "login?section=games_dashboard";
        }
    });
</script>

<!-- Optional JavaScript -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="https://hammerjs.github.io/dist/hammer.js"></script>

<script src="<?= base_url(); ?>assets/js/common.js?v0.5.1"></script>
<?php if (loadFile($this->uri->segment(1), $this->uri->segment(2)) == 'leaderboard') : ?>
    <script src="<?= base_url(); ?>assets/js/games.js?v0.5.1"></script>
<?php endif; ?>
<?php if (loadFile($this->uri->segment(1), $this->uri->segment(2)) == 'prediction_game') : ?>
    <script src="<?= base_url(); ?>assets/js/predictions.js?v0.5.1"></script>
<?php endif; ?>
<?php if (loadFile($this->uri->segment(1), $this->uri->segment(2)) == 'summary') : ?>
    <script src="<?= base_url(); ?>assets/js/summary.js?v0.5.1"></script>
<?php endif; ?>
</body>

</html>
