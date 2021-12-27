<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="CrowdWisdom360 is India’s first prediction market game to test the knowledge of an individual on various 
            topics. In 2019, the platform was launched as India’s first Political Prediction Market. It is also one of the earliest platforms to launch
            LIVE prediction games. The most unique proposition of this platform is the concept of changing price which makes the game far more exciting
            than every other platform" />

        <meta name="keywords" content="CrowdWisdom, Crowd Wisdom, crowdwisdom, crowd wisdom, India Predictions, India Election Predictions,
             Stock Market Predictions, Movie Predictions, Movie Reviews, Crowdsourced Content, Crowdsourced Surveys, Crowdsourced Advice, Advice,
            Advise, Prediction Market,election game, opinion poll, election polls, vidhan sabha election, upcoming election in India, next election 
            in India, assembly election 2020, Delhi election 2020,	lok sabha election, India result, election results, election, India Crowd Sourcing, 
            Wisdom Of The Crowds, India Free Surveys,Best Performing Mutual Funds, Best Performing Life Insurance, Asian Games Hockey Predictions, 
            Modi Ratings, Rahul Ratings, Andhra Pradesh Assembly Opinion Polls 2019,Cricket Results Prediction, best mutual funds 2018, best mutual
            funds for sip, best mutual funds with top 5 mutual funds for sip, best mutual fund company in india,cricket match predictions, 
            Top Indian Paid surveys, Top Rated Surveys for India, assembly election 2019, assembly election 2019" />

        <!--Twitter Meta tags-->
       <meta name="twitter:card" content="summary_large_image" />
       <meta name="twitter:site" content="@crowdwisdom" />
       <meta name="twitter:title" content="<?= @$meta_data['meta_description'] ?>"/>
       <meta name="twitter:image" content="<?= @$meta_data['image'] ?>" />
       
       <!--Whatsapp Meat Tags-->
      <meta property="og:type" content="website" />
       <meta property="og:description" content="<?= empty ( @$meta_data['meta_description'] ) ? 'crowdwisdom' : @$meta_data['meta_description']; ?>" />
       <meta property="og:title" content="<?= empty ( @$meta_data['title'] ) ? 'crowdwisdom' : @$meta_data['title']; ?>" />
       <!-- <meta property="og:url" content="<?= base_url(); ?>" /> -->
       <meta property="og:url" content="<?= base_url($_SERVER['REQUEST_URI'])?>" />  
       <meta property="og:image" content="<?= @$meta_data['image'] ?>" />
       <!-- <meta property="og:image" content="https://imgcdn.crowdwisdom.co.in/www.crowdwisdom.co.in/images/logo/preview.jpg" /> -->
       <meta property="og:image:width" content="1200" />
       <meta property="og:image:height" content="627" /> 


        <!-- Bootstrap CSS -->
        <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">-->
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.min.css">
        <link rel="stylesheet" href="<?= base_url(); ?>assets/css/style.css">

        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script src="https://cdn.pagesense.io/js/crowdwisdom360/b273b67dd68f4bdcade607ac8b8c35aa.js"></script>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-111765819-4"></script>
        <script src="<?= base_url(); ?>assets/js/moment.js"></script>
        <script src="<?php echo base_url(); ?>js/leaderboard.js"></script>
        <script>
         window.dataLayer = window.dataLayer || [];
         function gtag(){dataLayer.push(arguments);}
         gtag('js', new Date());

         gtag('config', 'UA-111765819-4');
        </script>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script type="text/javascript">
            base_url = "<?php echo base_url(); ?>";
        </script>
        <title>Wisdom Of The Crowds: India Crowd Sourcing, India Free Surveys - CrowdWisdom</title>
    </head>

    <body>
        <div class="w-100 " style="position:relative;height:59px;">
            <nav class="navbar justify-content-start navbar-light navbar-holder navbar-expand-lg py-md-0 fixed-top bg-white">
                <button class="navbar-toggler border-0 pl-0" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <img src="<?= base_url(); ?>assets/img/mobile-menu-icon.svg" class="img-fluid">
                    <!--<span class="navbar-toggler-icon"></span>-->
                </button>
                <a class="navbar-brand" href="<?= base_url(); ?>"><img src="<?= base_url(); ?>assets/img/ce_beta_logo.svg" class="img-fluid mr-4"></a>


                <div class="collapse navbar-collapse navbar py-0" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <!--<pre>-->
                            <?php
                           $className = strtolower($this->router->fetch_class());
                            ?>
                            <a class="nav-link <?php echo $className == 'home' || $className == 'topic' ? "active" : "" ?>" href="<?= base_url(); ?>">Home</a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link <?php echo $className == 'games' ? "active" : $className == 'predictions' ? "active" : ""  ?> " href="<?= base_url(); ?>Games">Games</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $className == 'quiz' ? "active" : "" ?>" href="<?= base_url(); ?>Quiz/all_quiz_list">Quiz</a>
                        </li>
                        <li class="nav-item d-none">
                            <a class="nav-link <?php echo $className == 'blog' ? "active" : "" ?>" href="#">Blog</a>
                        </li>
                        <!-- <li class="nav-item">
                            <a class="nav-link" href="#">Article</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Discussion</a>
                        </li> -->
                        <li class="nav-item ">
                            <a class="nav-link <?php echo (strpos($_SERVER['REQUEST_URI'], 'About')) ? "active" : "" ?>" href="<?= base_url(); ?>About_us" >About Us</a>
                        </li>
                    </ul>

                </div>
                    <?php 
                        $segment_total = count($this->uri->segment_array());
                        if($segment_total == '3' && $this->uri->segment('1')!= "quiz"){
                            $segment_url=base_url()."login?section=".strtolower($this->uri->segment('1'))."&sub_section=".strtolower($this->uri->segment('2'))."&gid=".$this->uri->segment('3');
                        }else if($this->uri->segment('1')== "quiz"){
                            $segment_url=base_url()."login?section=instruction&section2=".$this->uri->segment('3')."&section3=".$this->input->get('topic_id');
                        }else{
                            $segment_url=base_url()."login?section=".strtolower($this->uri->segment('1'))."&gid=".$this->uri->segment('2');
                        }
                        // print_r($segment_url);die;
                    ?>
                <div class="d-flex profile-info align-items-center justify-content-sm-end">
                    <button class="btn text-red border border-10 border-red mr-3 d-none d-md-block redeem">Redeem</button>
                    <a  href="<?= base_url('subscriptions') ?>" class="btn bg-red text-white border-10 mr-4 d-none d-md-block">Purchase</a>
                    <?php if (@$this->user_id != 0) { ?>
                        <h6 class="mr-3 d-flex align-items-center mb-0 points"><img src="<?= base_url(); ?>assets/img/wallet.png" class="img-fluid mr-2 "><?=get_User_Coins(); ?></h6>
                    <?php } ?>   
                    <!-- <img src="<?= base_url(); ?>assets/img/notification.svg" id="user_notifications" class="img-fluid mr-3 "> -->
                    <?php if (@$this->user_id != 0) { ?>
                        <img src="<?= base_url(); ?>assets/img/profile.svg" id="user-profile-info" class="img-fluid">
                    <?php } else { ?>
                        <!--<a href="<?= base_url(); ?>login?section=home">-->
                            <!--<img src="<?= base_url(); ?>assets/img/profile.svg" id="user-profile-info" class="img-fluid">--> 
                        <a href="<?= $segment_url?>">Login</a>
                        <!--</a>-->
                    <?php } ?>   
                </div>
            </nav>
        </div>
