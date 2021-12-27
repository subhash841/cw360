        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-111765819-4"></script>
        <script src="<?php echo base_url(); ?>js/leaderboard.js"></script>
        <script>
         window.dataLayer = window.dataLayer || [];
         function gtag(){dataLayer.push(arguments);}
         gtag('js', new Date());

         gtag('config', 'UA-111765819-4');
        </script>
        <!-- Global site tag (gtag.js) - Google Analytics -->
<div class="modal fade" id="rulesrewards" tabindex="-1" role="dialog" aria-labelledby="rulesrewardsPointsModalCenterTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg  modal-dialog-centered" role="document" >
        <div class="modal-content border-radius-10 border-0 px-3 px-md-0">
            <div class="row m-md-3" id="instruction">
           
           
        <?php if (empty($this->user_id)): ?>
            <div class="col-12 mt-3 text-center">
                <div class="mx-auto mb-4" style="width: 249px;">
                <div class="mt-4">
                            <span class="bg-white font-weight-bold h5 px-3">Login with</span>
                        </div>
                    <div class="position-relative border mt-4 py-1" style="border-radius: 30px;width: 249px;height: 115px;">
                    <div class="row no-gutters" style="margin: 20px 0;">
                            <div class="col-12 border-right">
                                    <a href="<?= base_url()?>Login/googlelogin?section=predictions&gid=<?=$game_id?>&rlsnrwds=no" class="no-link">
                                     <img src="<?= base_url( 'assets/img/goolelogin.svg' ); ?>" class="img-fluid" />
                                    </a>
                            </div>
                            <!-- <div class="col-6 ">
                                    <a href="#" id="facebook" class="no-link">
                                    <img src="<?= base_url( 'assets/img/login-facebook.svg' ); ?>" class="img-fluid" />
                                    </a>
                            </div> -->
                        </div>
                    </div>
                    <div class="my-4">
                        <a class="d-block no-link text-decoration-none login-link" href="<?= base_url()?>privacypolicy">PRIVACY POLICY</a>
                        
                        <a class="d-block mt-2 no-link text-decoration-none login-link" href="<?= base_url()?>About_us">ABOUT US</a>
                    </div>
                </div>
            </div>
            <?php endif?>
                <div class="col mt-3">
                     <div class="rules p-4 border-15 position-relative">
            <!-- <b>This game is about predicting<b class="text-red"> <?= $game_details['title'] ?></b> accurately</b> -->
            <b>Game Rules</b>
            <div class="mt-3">
                <?= $game_details['description'] ?>
            </div>
            <div class="d-flex bg-blue text-white py-3 px-4 border-15 align-items-center justify-content-between position-absolute">
                <h6 class="mb-0">Entry Fees (coins)</h6>
                <div class="d-flex align-items-center"><img src="<?= base_url() ?>assets/img/coin.png" class="img-fluid mr-2"><h5 class="font-weight-500 d-inline-block mb-0"><?= $game_details['req_game_points'] ?></h5></div>
            </div>
        </div>
                       <h4 class="mt-5 pt-3">Rewards</h4>

        <table class="table text-white table-borderless ">
            <tbody id="reward_table">
          <!--       <tr>
                    <td>Top Position</td>
                    <td>3000</td>
                </tr>
                <tr>
                    <td>asdsd</td>
                    <td>3000</td>
                </tr>
                <tr>
                    <td>asdsd</td>
                    <td>3000</td>
                </tr>
                <tr>
                    <td>asdsd</td>
                    <td>3000</td>
                </tr> -->

            </tbody>
        </table>
               <!--      <h5 class="mb-4"><b class="font-weight-600">REWARDS</b></h5>
                    <div class="bg-blue px-5 py-3 border-15 mt-3 mb-5">
                        <table class="table text-white table-borderless ">
                            <tbody id="reward_table"></tbody>
                        </table>
                    </div> -->
                    <!-- <h5 class="mb-4"><b class="font-weight-600">How to play?</b></h5> -->

                    <!-- <iframe class="border-15" width="100%" height="280" src="https://www.youtube.com/embed/zTkY13IY5g8" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen="">
                    </iframe> -->

                    <div class="mt-3 mb-3">
                        <!-- <p>Rules &amp; Updates</p>
                         <?= $game_details['description'] ?> -->
                           <!--  <ol>
                                <li>Each prediction is similar to a company in the stock market </li>
                                <li>Instead of real money, you trade with 10000 points that you can buy at the beginning of the game </li>
                                <li>You can purchase a prediction by buying units of that prediction sold in our market. </li>
                                <li>One unit is like one share. You can also sell a prediction if you are convinced it will not come true or you find a better alternative. </li>
                                <li>Should a prediction come true, you get 100 bonus points for each unit/share owned For every wrong prediction, </li>
                                <li>the number of units/shares become zero Price of a prediction will go up if there is demand and more people believe that the prediction will come true</li>
                            </ol> -->
                            
                    </div>
                </div>
                <div class="col-12 text-center">
                    <?php if (!empty($this->user_id)): ?>
                        <button class="btn bg-red text-white border-15 px-5 mx-auto mb-3 mt-3 play_or_view_game" data-action-type="play_game"><small class="font-weight-500">PLAY THE GAME</small></button>
                        <br>
                        <button class="btn text-red mb-5 mx-auto d-inline-block play_or_view_game" data-action-type="view_the_game"><small>VIEW THE GAME</small></button>
                    <?php //else: ?>
                        <!-- <a href="<?=base_url()?>Login?section=predictions&gid=<?=$game_id?>&rlsnrwds=no" class="btn bg-red text-white mt-3 border-15 px-5 mx-auto d-inline-block"><small>LOGIN/ONE CLICK REGISTER</small></a>
                        <br>
                        <a href="javascript:void(0)" class="btn text-red mx-auto mb-3 mt-3 play_or_view_game" data-action-type="proceed_without_login"><small class="font-weight-500">PROCEED WITHOUT LOGIN</small></a> -->
                    <?php endif?> 
                </div>
                <div class="col-12 text-center mb-4 mobilegameend">
                    <div class="bg-light-blue px-4 py-3 rounded-pill text-gray mx-auto d-inline-block"> <span>This game ends on   <?= date("F dS, Y", strtotime($game_details['end_date'])) ?></span>
                    </div>
                </div>
                <!-- <div class="d-flex justify-content-between col-12 mb-5">
                    <?php if (!empty($this->user_id)): ?>
                        <button class="btn btn-primary w-100 mr-3 play_or_view_game" data-action-type="view_the_game">View the Game</button>
                        <button class="btn btn-primary w-100 ml-3 play_or_view_game" data-action-type="play_game">Play the Game</button>
                    <?php else: ?>
                        <button class="btn btn-primary w-100 mr-3 play_or_view_game" data-action-type="proceed_without_login">Proceed without Login</button>
                        <a href='<?=base_url()?>Login?section=predictions&gid=<?=$game_id?>' class="w-100 ml-3"><button class="btn btn-primary w-100">Login/Register</button></a>
                        
                    <?php endif?>        
                </div> -->
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {
        var redirect_to = "<?= $_SERVER['REQUEST_URI'] ?>";
        window.fbAsyncInit = function () {
            FB.init({
                appId: '1140238086152057', //my app
                cookie: true,
                xfbml: true,
                version: 'v3.2'
            });
        };
        (function (d, debug) {
            var js, id = 'facebook-jssdk',
                    ref = d.getElementsByTagName('script')[0];
            if (d.getElementById(id)) {
                return;
            }
            js = d.createElement('script');
            js.id = id;
            js.async = true;
            js.src = "//connect.facebook.net/en_US/all" + (debug ? "/debug" : "") + ".js";
            ref.parentNode.insertBefore(js, ref);
        }(document, /*debug*/ false));

        //Onclick for fb login
        $("#facebook").on("click", function (e) {
            e.preventDefault();
            FB.login(function (response) {
                if (response.authResponse) {
                    access_token = response.authResponse.accessToken;
                    FB.api('/me?fields=id,name,email,gender,permissions', function (response) {
                        // alert(response.permissions);
                        name = response.name;
                        user_id = response.id;
                        user_email = response.email;
                        gender = response.gender;
                        // alert("name="+name+" user_id="+user_id+" gender"+gender+" email="+user_email);
                        FB.api('/me/picture?type=normal', function (response) {
                            //profile_image = response.data.url;
                            profile_image = "";
                            //var data = "access_token="+access_token+"&name="+name+"&user_id="+user_id+"&user_email="+user_email+"&gender="+gender+"&profile_image="+profile_image;
                            var data = {
                                access_token: access_token,
                                name: name,
                                user_id: user_id,
                                user_email: user_email,
                                gender: gender,
                                profile_image: profile_image,
                                // section: 'predictions',
                                gid: "<?=$game_id?>",
                                rlsnrwds: 'no'
                            }
                            $.ajax({
                                url: base_url+"Login/fblogin",
                                type: 'POST',
                                data: data,
                                success: function (obj) {
                                    console.log(obj+'obj'); return;
                                    //        if (obj == "200")
                                    //            {
                                    //            window.location.reload();
                                    //            }
                                },
                                error: function (XMLHttpRequest, textStatus, errorThrown) {
                                      console.log(errorThrown+'error'); return;
                                    //alert(textStatus);
                                    // $('#confirm_msg').html('An error occured! please try after sometime. Status:'+textStatus+"Error: " + errorThrown).show();
                                    // window.location.reload();
                                }
                            }).done(function (response) {
                                //console.log(response+'done'); return;
                                response = JSON.parse(response);
                                if (response.status) {
                                    //console.log(base_url+" - "+redirect_to);
                                    window.location.assign(redirect_to);
                                } else {
                                    window.location.assign(redirect_to);
                                }
                            });
                        });
                    });
                } else {
                    alert("Login attempt failed!");
                }
            }, {
                scope: 'email,public_profile'
            });
        });
    });
</script>
<script>
    var gameid = '<?= @$game_details['id'] ?>';
    $(function () {
        var tr = '';
        $.ajax({
            url: base_url + 'Predictions/game_reward',
            data: {'game_id': gameid},
            dataType: 'JSON',
            type: 'POST',
            success: function (res) {
                var tr = '';
                if (!res.length == 0) {
                    $.each(res, function (key, value) {
                        tr += '<tr><td>' + value.description + '</td><td>' + value.price + '</td></tr>';
                    });
                    $('#reward_table').append(tr);
                }
            }
        });
    })
</script>
