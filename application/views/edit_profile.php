<style type="text/css">
    .pro_id {
        font-size: 12px;
    }

    .uname {
        font-size: 20px;
    }

    .u_info {
        margin-top: 26px;
        margin-left: -62px;
    }

    @media screen and (max-width: 480px) {

        .left,
        .main,
        .right {
            width: 100%;

            /* The width is 100%, when the viewport is 800px or smaller */
            .u_info {
                margin-top: 26px;
                margin-left: -62px;
            }
        }
    }

    .profile-form label {
        margin-top: 15px;
    }

    @media screen and (max-width: 320px) {
        .default_profile {
            width: 80px !important;
            height: 80px !important;
        }

        .u_info {
            margin-top: 0px;
            margin-left: -32px;
        }

    }

    input[type=text]:focus {
        outline: 2px solid #80bdff;
    }


    .labelfocus {
        color: #094ada;
    }
</style>
<?php @$user_details = user_details($this->user_id);  ?>
<div class="container-fluid">
    <div class="row ">
        <div class="col-md-8 theme-padding main-height">
            <div id="">
                <div class="user-wallet-history">
                    <div>
                        <h4 class="mt-4" >Edit Profile</h4>
                        <div class="row no-gutters">
                            <div class="px-4 py-3 pb-4 ">
                                <div class="text-right">
                                    <img class="img-fluid profile-close-btn" src="<?= base_url(); ?>assets/img/close-btn-white.svg">
                                    <div class="row mt-3 text-center">
                                        <div class="text-center">
                                            <div class="position-relative">

                                                <?php if (@$user_details['image'] == "") { ?>

                                                    <div class="default_profile" style="height:100px;width:100px; background:url('https://www.abc.net.au/news/image/8314104-1x1-940x940.jpg') center center no-repeat;background-size:cover;border-radius: 50%;"></div>
                                                <?php } else { ?>
                                                    <div class="default_profile" style="height:100px;width:100px; background:url(<?= @$user_details['image']; ?>) center center no-repeat;background-size:cover;border-radius: 50%;"></div>
                                                <?php } ?>


                                                <img class="img-fluid uploaded-img-preview">
                                                <!-- <img class="img-fluid position-absolute profile-edit-icon" src="<?= base_url(); ?>assets/img/edit-profile-icon.svg"> -->
                                                <input type="image" style="bottom: 30px;right: 4px;" class="img-fluid position-absolute profile-edit-icon" src="<?= base_url(); ?>assets/img/edit-profile-icon.svg" />
                                                <!-- <input type="file" id="my_file" style="display: none;" /> -->
                                            </div>
                                        </div>
                                        <div class="col pl-0 u_info ml-2">
                                            <h5 class="font-weight-bold mt-2 pt-1 u_name pull-left text-break"><?= @$user_details['name']; ?></h5>
                                            <h6 class="font-weight-light pro_id ml-3">Profile ID: CW #<span id='userId'><?= $this->user_id ?></span></h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- row end   -->
                        <!-------------------------------for form ------------------------------------------------>
                        <div class="">
                            <div class="my-0 px-2">
                                <div class="profile-form">
                                    <form id="persondetailform" name="persondetail" method="post" enctype="multipart/form-data" autocomplete="off">
                                        <input type="file" id="uploadBtn" name="poll_img" class="upload d-none">
                                        <input type="text" id="main_image" name="main_image" class="d-none" value="<?= $user_details['image']; ?>">
                                        <div>
                                            <label for="name">Full Name</label>

                                            <input class="w-100 border p-2 border-radius-12" type="text" name="name" value="<?= @$user_details['name']; ?>" id="name" maxlength="25">
                                            <div class="text-danger" id="name_error"></div>
                                        </div>
                                        <div class="row">
                                            <div class="mt-1 col-md-6">
                                                <label for="dob">Date Of Birth</label>
                                                <input class="w-100 border p-2 border-radius-12 datepicker" type="text" name="dob" value="<?= @$user_details['dob']; ?>" id="dob">
                                                <div class="text-danger" id="dob_error"></div>
                                            </div>
                                            <div class="mt-1 col-md-6">
                                                <label for="gender">Gender </label>
                                                <select class="w-100 border p-2 border-radius-12 custom-select" name="gender" id="gender">
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
                                        </div>
                                        <div class="row">
                                            <div class="mt-1 col-md-6">
                                                <label for="phone">Mobile Number</label>
                                                <input class="w-100 border p-2 border-radius-12" type="text" value="<?= @$user_details['phone']; ?>" name="phone" id="phone" maxlength="10" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                                                <div class="text-danger" id="phone_error"></div>
                                            </div>
                                            <div class="mt-1 col-md-6">
                                                <label for="email">Email ID</label>
                                                <input class="w-100 border p-2 border-radius-12" type="email" value="<?= @$user_details['email']; ?>" name="email" id="email">
                                                <div class="text-danger" id="email_error"></div>
                                            </div>
                                        </div>
                                        <div style="margin-top: 15px;">
                                            <left>
                                                <button type="button" class="btn button-plan-bg border-radius-12 mt-3 mb-5 text-white px-3" onclick="update_profile();">SAVE CHANGES</button>
                                            </left>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
        <!--right side game start-->
        <div class="col-md-4 theme-bg border-15 theme-padding main-height">
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
                            if (!empty($sidebar_quiz)) {
                                foreach ($sidebar_quiz as $key => $value) {
                            ?>

                                    <a href="<?= base_url('quiz/instruction/' . base64_encode($value['quiz_id']) . '?topic_id=' . base64_encode($value['topic_id'])) ?>" class="card prediction-card text-decoration-none mb-5">
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
                        <div class="tab-pane fade" id="pills-blogs" role="tabpanel" aria-labelledby="pills-blogs-tab">
                            <?php
                            if (!empty($sidebar_blogs)) {
                                foreach ($sidebar_blogs as $key => $value) {
                            ?>

                                  <!--   <a href="<?= base_url('blog/'. $value['id'].'/'.rtrim(preg_replace('/[^a-zA-Z0-9]+/', '-', $value['title']),"-").'/') ?>" class="card prediction-card text-decoration-none"> -->
                                    <a href="<?= base_url('blog/detail'. $value['id']) ?>" class="card prediction-card text-decoration-none">
                                        <!-- <div class="banner-img" style="background-image:url(<?= $value['image'] ?>)"></div> -->
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
            </div>
        </div>
        <!--right side game end-->
    </div>
</div>



<!-- <script src="<?= base_url() ?>assets/js/quiz.js"></script> -->
<script>
    $(function() {

        $('.load-wallet-history').on('click', function() {
            var main_offset = parseInt(20);
            var offset = parseInt($(this).attr('data-offset'));
            $(this).attr('data-offset', offset + main_offset);
            $.ajax({
                url: base_url + "Wallet_history/get_history",
                type: "POST",
                dataType: 'JSON',
                data: {
                    offset: offset
                },
            }).done(function(e) {
                console.log(e);
                if (e.data) {
                    add_histrory(e.data);
                } else {
                    console.log('else');
                    $('.load-wallet-history').hide();
                }
            })
        })

        $('#sidegames').click(function() {
            var main_offset = parseInt('<?= get_right_side_game_limit() ?>');
            var offset = $(this).data('offset');
            $(this).data('offset', offset + main_offset)
            $.ajax({
                url: "<?= base_url('Wallet_history/load_games'); ?>",
                type: "POST",
                dataType: 'JSON',
                data: {
                    offset: offset
                },
                success: function(data) {
                    console.log(data.length);
                    if (data.length == 0 || data.length < main_offset) {
                        $('#sidegames').hide();
                    }
                    if (data.length != 0) {
                        add_game('sidegames', data);
                    }
                }
            });
        });
    });

    function add_game(selector, data) {
        var div = '';
        $.each(data, function(key, value) {
            div += '<a href="' + base_url + 'Predictions/prediction_game/' + value.id + '" class="card prediction-card text-decoration-none mb-5">';
            // div += '<div class="banner-img" style="background-image:url(' + value.image + ')"></div>';
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
            // div += '"+value.end_date+" < /span></span >';
            div += '</div>';
            // div += '<img src="' + base_url + 'assets/img/share.svg" >';
            div += '</div>';
            div += '</div>';
            div += '</a>';
        });
        $('#' + selector).before(div);
    }

    function add_histrory(data) {
        var div = '';

        $(data).each(function(key, value) {
            var data = get_title(value.package_name, value.quiz_name, value.game_name, value.type, value.coins);
            div += '<div class="row mx-0 mb-3 py-3 px-2 theme-bg border-15">';
            div += '<div class="col-8">';
            div += '<h6 class="fs09">' + data.title + '</h6>';
            div += '<h6 class="fs08 cw-text-color-gray mb-0">' + data.type + ' . ' + value.date + '</h6>';
            div += '</div>';
            div += '<div class="col-4">';
            div += '<h6 class="text-right ' + data.class + ' font-weight-normal">' + data.coins + '</h6>';
            div += '</div>';
            div += '</div>';
        });
        $('.sub-history-list').append(div);
    }

    function get_title($package_name, $quiz_name, $game_name, $type, $coins) {
        if ($type == '0') {
            return {
                'title': 'free initial game coins',
                'type': 'Admin',
                'class': 'text-greencolor',
                'coins': '+'.$coins
            };
        } else if ($type == '1') {
            return {
                'title': $package_name,
                'type': 'subscription',
                'class': 'text-greencolor',
                'coins': '+'.$coins
            };
        } else if ($type == '2') {
            return {
                'title': 'Gift game coins',
                'type': 'Gift',
                'class': 'text-greencolor',
                'coins': '+'.$coins
            };
        } else if ($type == '3') {
            return {
                'title': $game_name,
                'type': 'Require game coins',
                'class': 'text-red',
                'coins': '-' + $coins
            };
        } else if ($type == '4') {
            return {
                'title': 'Deducted coins',
                'type': 'Deduction admin',
                'class': 'text-red',
                'coins': '-' + $coins
            };
        } else if ($type == '5') {
            return {
                'title': $quiz_name,
                'type': 'Quiz right ans',
                'class': 'text-greencolor',
                'coins': '+'.$coins
            };
        } else if ($type == '6') {
            return {
                'title': $quiz_name,
                'type': 'Quiz wrong ans',
                'class': 'text-red',
                'coins': '-' + $coins
            };
        } else if ($type == '7') {
            return {
                'title': 'Coins redeemed',
                'type': 'On',
                'class': 'text-red',
                'coins': '-' + $coins
            };
        } else {
            return {
                'title': 'Coins',
                'type': '',
                'class': '',
                'coins': $coins
            };
        }
        // else if($quiz_name == null && $game_name == null ){
        //     return {'title':$predection_title,'type':'Predection','class':'','coins':$coins} ;
        // }else if($game_name == null && $predection_title==null ){
        //     return {'title':$quiz_name,'type':'Quiz','class':'','coins':$coins} ;
        // }else{
        //     return {'title':$game_name,'type':'Game','class':'','coins':$coins} ;
        // }
    }

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
                    //console.log(data);
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
            //console.log(value);
            div += '<a href="' + base_url + 'quiz/instruction/' + btoa(value.quiz_id) + '?topic_id=' + btoa(value.topic_id) + '" class="card prediction-card text-decoration-none mb-5">';
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
    $('#sideblog').click(function() {
        var topic_id = '';
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
                console.log(data.length);
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
            var str=value.title;
            var string = str.replace(/[^A-Z0-9]+/ig, "-");
            var newString = string.replace(/-+$/,'/');
            div += '<a href="' + base_url + 'blog/' + value.id + '/'+newString+'" class="card prediction-card text-decoration-none">';
            // div += '<div class="banner-img" style="background-image:url(' + value.image + ')"></div>';
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

    //focus label of selected field
    $('form input[type="text"]').focus(function() {
            $("label[for='" + this.id + "']").addClass("labelfocus");
        })
        .blur(function() {
            $("label.labelfocus").removeClass("labelfocus");
        });
    //mobile number validation(Allow only numeric data)
    // $("input[name='phone']").keypress(function(e){
    //  if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
    //       return false;
    //   }
    //    });




    $("input[name='phone']").keyup(function(e) {
        var number = $(this).val();

        if (number.charAt(0) >= 0 && number.charAt(0) <= 5) {
            $(this).val('');

        }
    });
</script>
