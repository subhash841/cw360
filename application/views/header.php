<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="facebook-domain-verification" content="4ifj5shr8lzk4qi61bjvrjeravwpjm" />

        <?php 
            $segment=$this->uri->segment(1);
            
            if($this->uri->segment(1)=="Games"){
                $description = "Play Prediction and Fantasy Games online at CrowdWisdom360, Check out many of free prediction games for Indian Premier, Election Opinion Poll Prediction, COVID India Prediction & more. Play Now!";
                $keywords ="Prediction Games, Fantasy Games";
                $title="Games - Fantasy and Prediction Games For Free | Play Fantasy Games Online";
              }else if($this->uri->segment(1)=="blog" && $this->uri->segment(2)=="all_list"){
                $description ="Check out the Latest Opinion Poll, Predictions, Betting, Analysis, top quiz and more only at CrowdWisdom360. Know about politics, sports, Bollywood and more topics. Explore Now!";
                $keywords="Latest Opinion Poll";
                $title="Latest Opinion Poll, Predictions and Betting Analysis - CrowdWisdom 360";
              }else if($this->uri->segment(1)=="About_us"){
                $description ="Crowdwisdom360 is India’s based prediction and fantasy market games to test the knowledge of people on various topics. Check out Political Prediction, Sports Prediction and more. Play all exciting Game online!"; 
                $keywords="About Us"; 
                $title="About Us - CrowdWisdom360";
              }else if($this->uri->segment(1)=="Quiz" && $this->uri->segment(2)=="all_quiz_list"){
                $description ="Check out the all quiz list here; Mythology Friendship Quiz, APJ Abdul Kalam Quiz, Dark Netflix Quiz, The Hamlet Quiz, Quiz on Julius Caesar, Netflix Indian Matchmaking Quiz and more. Play Now!";
                $keywords="Quiz";
                $title="Quiz – Play Latest Quiz and Win | Quiz Online - CrowdWisdom360";
              }else if($this->uri->segment(1)=="topic"){
                $title="Crowdwisdom360 - Topics";
                $description="";
                $keywords="";
              }else if($this->uri->segment(1)=="subscriptions"){
                
                $description="";
                $keywords="";
                $title="Crowdwisdom360 - Subscriptions";
              }else{
                  
                          $title="crowdwisdom";
                }
                $common_description = "CrowdWisdom360 is India’s first prediction market game to test the knowledge of an individual on various 
                topics. In 2019, the platform was launched as India’s first Political Prediction Market. It is also one of the earliest platforms to launch
                LIVE prediction games. The most unique proposition of this platform is the concept of changing price which makes the game far more exciting
                than every other platform";
    
                $common_keywords = "CrowdWisdom, Crowd Wisdom, crowdwisdom, crowd wisdom, India Predictions, India Election Predictions,
                Stock Market Predictions, Movie Predictions, Movie Reviews, Crowdsourced Content, Crowdsourced Surveys, Crowdsourced Advice, Advice,
               Advise, Prediction Market,election game, opinion poll, election polls, vidhan sabha election, upcoming election in India, next election 
               in India, assembly election 2020, Delhi election 2020,	lok sabha election, India result, election results, election, India Crowd Sourcing, 
               Wisdom Of The Crowds, India Free Surveys,Best Performing Mutual Funds, Best Performing Life Insurance, Asian Games Hockey Predictions, 
               Modi Ratings, Rahul Ratings, Andhra Pradesh Assembly Opinion Polls 2019,Cricket Results Prediction, best mutual funds 2018, best mutual
               funds for sip, best mutual funds with top 5 mutual funds for sip, best mutual fund company in india,cricket match predictions, 
               Top Indian Paid surveys, Top Rated Surveys for India, assembly election 2019, assembly election 2019";
              
      
                empty(@$description) ? $description=$common_description : @$description;
                empty(@$keywords) ? $keywords=$common_keywords : @$keywords;
                // echo $description;
        ?>

        <meta name="description" content="<?= empty(@$meta_data['meta_description']) ? $description : @$meta_data['meta_description']; ?>" />
        <meta name="title" content="<?= empty ( @$meta_data['title'] ) ? $title : @$meta_data['title']; ?>">
        <meta name="keywords" content="<?= empty(@$meta_data['meta_keywords']) ? $keywords : @$meta_data['meta_keywords']; ?>" />

        <!--Twitter Meta tags-->
       <meta name="twitter:card" content="summary_large_image" />
       <meta name="twitter:site" content="@crowdwisdom" />
       <meta name="twitter:description" content="<?= empty ( @$meta_data['meta_description'] ) ? $description : @$meta_data['meta_description']; ?>" />
       <meta name="twitter:title" content="<?= empty ( @$meta_data['title'] ) ? $title : @$meta_data['title']; ?>"/>
       <meta name="twitter:image" content="<?= @$meta_data['image'] ?>" />
       
       <!--Whatsapp Meat Tags-->
      <meta property="og:type" content="website" />
       <meta property="og:description" content="<?= empty ( @$meta_data['meta_description'] ) ? $description : @$meta_data['meta_description']; ?>" />
       <meta property="og:title" content="<?= empty ( @$meta_data['title'] ) ? $title : @$meta_data['title']; ?>" />
       <!-- <meta property="og:url" content="<?= base_url(); ?>" /> -->
       <meta property="og:url" content="<?= base_url($_SERVER['REQUEST_URI'])?>" />  
       <meta property="og:image" content="<?= @$meta_data['image'] ?>" />
       <meta property="og:image:width" content="1200" />
       <meta property="og:image:height" content="627" /> 


        <!-- Bootstrap CSS -->
        <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">-->
        <?php if($this->uri->segment('1')!= "blog") { ?>
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css">
        <?php } ?>   
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.min.css">
        <link rel="stylesheet" href="<?= base_url(); ?>assets/css/style.css?v=0.2">

        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

        <!-- <script src="https://securepubads.g.doubleclick.net/tag/js/gpt.js"></script>
		<script src="https://crowdwisdom360.com/ad-scripts.js"></script>
		<script async src="https://jscdn.greeter.me/dynamicforall.js" defer></script> -->


         <!-- blog script -->
         <?php if($this->uri->segment('3')!= "" && $this->uri->segment('1')== "blog"){ 
          //$googleadsensecode= '<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-4527310681159742" crossorigin="anonymous"></script>';
          // $googleadsensecode= '<script data-ad-client="ca-pub-4527310681159742" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>';
        //   $googleadsensecode=' <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-4527310681159742" crossorigin="anonymous"></script>';
         // $googleadsensecode='<script data-ad-client="ca-pub-4527310681159742" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>';
         $googleadsensecode = '<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-4527310681159742"
      crossorigin="anonymous"></script>';
            
           echo $googleadsensecode;
          

             ?>
         <?php } ?>
         <?php if($this->uri->segment('1')== "Predictions"){ ?>
            <!-- <script data-ad-client="ca-pub-4527310681159742" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script> -->
         <?php } ?>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-111765819-4"></script>
        
        <?php if($this->uri->segment('1')!= "blog") { ?>
        <script src="<?= base_url(); ?>assets/js/moment.js"></script>
         <?php } ?>
        <?php if($this->uri->segment('1')== "Predictions"){ ?>
        <script src="<?php echo base_url(); ?>js/leaderboard.js"></script>        
         <?php } ?>
         <?php if($this->uri->segment('1')!= "blog") { ?>
        <script src="<?= base_url()?>assets/js/duplicate.js"></script>
         <?php } ?>
        <script>
         window.dataLayer = window.dataLayer || [];
         function gtag(){dataLayer.push(arguments);}
         gtag('js', new Date());

         gtag('config', 'UA-111765819-4');
        </script>
        <!-- Global site tag (gtag.js) - Google Analytics -->
      

        <!-- Facebook Pixel Code -->
            <script>
            !function(f,b,e,v,n,t,s)
            {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};
            if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
            n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t,s)}(window,document,'script',
            'https://connect.facebook.net/en_US/fbevents.js');
             fbq('init', '260317214301855'); 
            fbq('track', 'PageView');
            </script>
            <noscript>
             <img height="1" width="1" 
            src="https://www.facebook.com/tr?id=260317214301855&ev=PageView
            &noscript=1"/>
            </noscript>
        <!-- End Facebook Pixel Code -->
        <script type="text/javascript">
            base_url = "<?php echo base_url(); ?>";
        </script>
        <!--Google GPT/ADM code -->
		<script type="text/javascript" async="async" src="https://securepubads.g.doubleclick.net/tag/js/gpt.js"></script>
		<script type="text/javascript">
	    	window.googletag = window.googletag || { cmd: [] };
    		window.googletag.cmd.push(function () {
	        	window.googletag.pubads().enableSingleRequest();
	    	});
		</script>
		<!--Site config -->
		<script type="text/javascript" async="async" src="https://protagcdn.com/s/crowdwisdom360.com/site.js"></script>
		<script type="text/javascript">
		    window.protag = window.protag || { cmd: [] };
		    window.protag.config = { s:'crowdwisdom360.com', childADM: '22367406785', l: 'Arf30PQf' };
		    window.protag.cmd.push(function () {
		        window.protag.pageInit();
		    });
		</script>
        <title><?= empty ( @$meta_data['title'] ) ? 'Wisdom Of The Crowds: India Crowd Sourcing, India Free Surveys - CrowdWisdom' : @$meta_data['title']; ?></title>
    </head>

    <body>
         <!-- user journey start -->
         <?php
            if(@$user_game_joureny == true || @$user_leaderboard_joureny == true ){
                $class = "position";
                ?>

            <div id="overlay" class="modal-backdrop fade show"></div> 
            <div class="close-bn curosr-pointer"  onclick="location.reload(); return false;" >
                <img src='<?= base_url()?>assets/img/close.png' class="img-fluid cursor-pointer">
            </div>

            <?php }

            if(@$user_summary_joureny == true){
                $class = "position";
                ?>
            <div id="overlay" class="modal-backdrop fade show"></div> 
            <div class="close-bn curosr-pointer next-slide" >
                <img src='<?= base_url()?>assets/img/next.png' class="img-fluid cursor-pointer mob-right-arrow" alt="right_arrow">
            </div>
            <?php }
         ?>
         
        <!-- user journey end -->
<?php if(@$type !='app'){ ?>
        <div class="w-100 <?= isset($class)? $class : '' ?>" style="position:relative;height:59px;">
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
                            <a class="nav-link <?php echo $className == 'games' ? "active" :( $className == 'predictions' ? "active" : "")  ?> " href="<?= base_url(); ?>Games">Games</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $className == 'quiz' ? "active" : "" ?>" href="<?= base_url(); ?>Quiz/all_quiz_list">Quiz</a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link <?php echo $className == 'blog' ? "active" : "" ?>" href="<?= base_url(); ?>blog/all_list">Blogs</a>
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
                    <button class="btn text-red border border-10 border-red mr-3 d-none d-md-block redeem hover-redeem">Redeem</button>
                    <a  href="<?= base_url('subscriptions') ?>" class="btn bg-red text-white border-10 mr-4 d-none d-md-block hover-purchase">Purchase</a>
                    <?php if (@$this->user_id != 0) { ?>
                        <h6 class="mr-3 d-flex align-items-center mb-0 points"><img src="<?= base_url(); ?>assets/img/wallet.png" class="img-fluid mr-2 "><span id="user_coins"><?=get_User_Coins(); ?></span></h6>
                    <?php } ?>   
                    <?php if (@$this->user_id != 0) { ?>
                        <div class="position-relative text-center d-none d-lg-block">
                            <a href="<?= base_url(); ?>games_dashboard"><img src="<?= base_url(); ?>assets/img/dash.png" class="img-fluid mr-3 cursor-pointer"></a>
                        </div>
                    <?php } ?>   
                    <?php if (@$this->user_id != 0) { ?>
                        <?php $notification_ids = notification_ids(); 
                              $notification_count = get_notification_details($notification_ids); 
                        ?>
                        <div class="position-relative text-center ">
                            <img src="<?= base_url(); ?>assets/img/notification.svg" id="user_notifications" class="img-fluid mr-3 cursor-pointer">
                            <?php if (!empty($notification_count['notificationCount'])): ?>
                                <span class="notify-count position-absolute d-flex align-items-center justify-content-center cursor-pointer" id="notificationCount"><?=$notification_count['notificationCount'] ?></span>
                            <?php endif ?>
                        </div>
                        <img src="<?= base_url(); ?>assets/img/profile.svg" id="user-profile-info" class="img-fluid cursor-pointer">
                    <?php } else { ?>
                        <!--<a href="<?= base_url(); ?>login?section=home">-->
                            <!--<img src="<?= base_url(); ?>assets/img/profile.svg" id="user-profile-info" class="img-fluid">--> 
                        <a href="<?= $segment_url?>">Login</a>
                        <!--</a>-->
                    <?php } ?>   
                </div>
                    <?php } ?>   

            </nav>
        </div>
         