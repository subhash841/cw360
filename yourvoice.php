<div class="container-fluid">
    <div class="row">
        <!-- main voice start -->
        <div class="col-md-8 theme-padding main-height">
            <!-- <div class="bredcum-holder">
                <a href="#">Home /</a>
                <a href="#">Article 370 /</a>
                <a href="#" class="active">Game /</a>
            </div> -->
            <div class="row mt-4">
                    <div class="col-6">
                        <h1 class="title" style="font-size:1.5rem;">Blogs</h1>
                    </div>
                    <div class="col-md-6 text-md-right text-left mt-2 mt-md-0">
                        <button class="btn button-plan-bg border-radius-12 text-white py-1" id="post_new_blog">+ Write a blog on this topic and earn</button>
                    </div>
            </div>
            <div class="voice-container mt-4">
                
                <h1 class="title"><?= @$blog['title']?></h1>
                <div class="voice-date mb-3">
                    <img src="<?= base_url() ?>assets/img/cal-icon.svg" class="img-fluid mr-1">
                    <small class="cw-text-color-gray d-inline-block"><?= date('d M Y',strtotime($blog['modified_date']))?></small>
                </div>
                <div class="text-center">
                    <img src="<?= $blog['image']?>" class="img-fluid   border-radius-12" alt="<?= empty ( @$blog['title'] ) ? 'blog_img' : @$blog['title']; ?>">
                </div>
                
                <div class="row mt-3">
                    <div class="col-lg-5">
                        <img src="<?= base_url() ?>assets/img/profile_avatar.png" class="img-fluid mr-1 user-avatar rounded-circle border" alt="profile_avatar">
                        <h6 class="d-inline"><?= empty($blog['user_id']) ? 'Crowdwisdom360' : $blog['user_id']; ?></h6>
                    </div>
                    <div class="col-lg-7">
                        <div class="text-left text-lg-right mt-1 d-flex justify-content-end">
                            <div class="d-flex align-items-center ">
                                <button class="btn btn-blog-share" data-toggle="modal" data-target="#shareModal">
                                    <img src="<?= base_url(); ?>assets/img/share-btn.svg" class="img-fluid" alt="share_btn">
                                    SHARE
                                </button>
                            </div>
                            <!-- <div class="d-flex align-items-center ">
                                <img src="<?= base_url() ?>assets/img/comment-icon.svg" class="img-fluid mr-1"><span class="comment-count"><?= @$blog['total_comments']?></span>
                            </div> -->
                            <div class="d-flex align-items-center ">
                            <?php
                                if($user_like){?>
                                    <img src="<?= base_url() ?>assets/img/Blog_thumbup_Active.svg" 
                                    class="img-fluid ml-3 mr-1 blog-liked blog-action cursor-pointer"><span class="likes-count"><?= @$blog['total_likes']?></span>                                
                                <?php }else{
                                    ?><img src="<?= base_url() ?>assets/img/blog_thumbup.svg"
                                     class="img-fluid ml-3 mr-1 blog-disliked blog-action cursor-pointer"><span class="likes-count"><?= @$blog['total_likes']?></span>                                
                                <?php }
                            ?>
                            </div>
                            <div class="d-flex align-items-center ">
                                <img src="<?= base_url() ?>assets/img/eye-icon.svg" class="img-fluid ml-3 mr-1"><span class="views-count"><?= @$blog['total_views']?></span>                                
                            </div>
                        </div>
                    </div>
                </div>

                <div class="description-container mt-4">
                    <!-- <h6 class="title">
                        Population Control Bill India
                    </h6>
                    <p>
                        Population Control Bill India is the second most populated country in the world after China. As per the report of United Nation’s Ministry of Statistics and Program implementation, population of India is going to be close to 1.37 billion in 2019 compared to 1.35 billion in 2018. Population growth in India is projected to 1.08% in 2019. It must be noted that India is 7th largest country in the world in terms of area but 2nd most populated country in the world. In just 40 years, the country has doubled the size of its population and is expected to go ahead of China in couple of decades. As per East Asia Forum, population of India is expected to 1.69 billion by 2050, higher than that of China’s population which is expected to be 1.31 billion in the same year. By 2050, the demand of water the global demand for water in India is projected to be more than 50 per cent of what it was in 2000. PIL Against Population Explosion In the month of May 2018, Ashwin Kumar Upadhyay moved a PIL in Delhi High Court to direct the Centre to implement population control measures on the ground that population explosion was the root cause behind rise in crimes, pollution and dearth of resources and jobs in the country. Responding to the PIL, Delhi High Court asked the Central Government to file a response on a plea seeking implementation of proposal by the National Commission to Review the Working of the Constitution (NCRWC) on population control and “two child norms” as criteria for government jobs, aids and subsidies.
                    </p> -->
                    <?= $blog['description']?>
                </div>
                <!-- <div class="comment-section my-4">
                    <h6 class="d-inline">Reader's Comment</h6>

                    <form class="mt-3" id="blog_comment">
                        <input type="text" class="border border-radius-15 w-100 px-4 py-2" name="blog-comment" placeholder="Add a Comment..">
                        <button class="btn button-plan-bg border-radius-12 text-white fs08 mt-2 py-1" type="submit">Post comment</button>
                    </form>

                    <div class="users-comment-list my-2">
                            <?php
                                foreach($comment as $key=>$value){
                                    ?>
                                    <div class="user-comment user-comment-main-holder d-flex my-4" data-comment_id="<?= $value['comment_id']?>">
                                        <div>
                                            <?php       
                                            // echo $value['image'];                                      
                                                if(empty($value['image']) || $value['image']==""){
                                                    echo '<img src="'.base_url() .'assets/img/profile_avatar.png" class="img-fluid mr-3 user-avatar border rounded-circle" alt="profile_avatar">';
                                                }else{
                                                    echo '<img src="'.$value['image'].'" class="img-fluid mr-3 user-avatar border rounded-circle" alt="'.@$blog['title'].'">';
                                                }
                                            ?>
                                            
                                        </div>
                                        <div class="w-100">
                                            <h6 class="mb-n1">CW#<?= empty($value['name']) ? $value['id']: $value['name']?></h6>
                                            <small class="cw-text-color-gray"><?= str_replace('-','', $value['created_date'])?></small>
                                            <p class="user-given-comment text-break "><?= $value['comment']?></p>
                                            <div class="actions-box mb-2">
                                                <?php if($value['is_user_like']){
                                                    echo '<img src="'.base_url().'assets/img/Blog_thumbup_Active.svg" class="img-fluid mr-1 cursor-pointer comment-like-action" alt="blog_thumbup"><small>Like</small>';
                                                }else{
                                                    echo '<img src="'.base_url().'assets/img/blog_thumbup.svg" class="img-fluid mr-1 cursor-pointer comment-like-action" alt="blog_img"><small>Like</small>';
                                                }?>
                                                <img src="<?= base_url() ?>assets/img/reply.svg" data-comment-id="<?= $value['comment_id']?>" class="img-fluid ml-3 mr-1 cursor-pointer reply"><small class="cursor-pointer reply" data-comment-id="<?= $value['comment_id']?>" >Reply</small>
                                               </div>
                                            <?php
                                            if($value['total_replies'] > 0){?>
                                                <div class="reply-content-holder-<?=$value['comment_id']?>">
                                                    <a data-toggle="collapse" href="#reply-container-<?=$value['comment_id']?>" role="button"
                                                     aria-expanded="false" aria-controls="<?=$value['comment_id']?>" data-reply-loaded="false" class="load-replies"
                                                      data-comment_id="<?= $value['comment_id']?>" data-reply_count="<?= $value['total_replies'] ?> " >View <?= $value['total_replies'] ?> replies
                                                    </a>
                                                    <div class="collapse" id="reply-container-<?=$value['comment_id']?>"></div>
                                                </div>
                                            <?php } ?>
                                            
                                        </div>
                                    </div>
                                    <?php
                                }
                            ?>
                    </div>
                </div> -->
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
                                        <!-- <div class="banner-img" style="background-image:url(<?= $value['image'] ?>)" title="<?= empty ( @$value['title'] ) ? 'game_img' : @$value['title']; ?>"></div> -->
                                        <div class="card-body">
                                            <button class="btn play-btn" style="bottom:-17px;top:unset;right:18px;">
                                                Play Now
                                            </button>
                                            <h6 class="title">
                                                <?= $value['title'] ?>
                                            </h6>
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <img src="<?= base_url(); ?>assets/img/clock.svg">
                                                        <span class="font-weight-light ml-1">Game Ends : <span
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
                            <div id="pills-quiz-inner">
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
                        ?>
                        </div>
                        <?php
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

<div class="loading">
    <div class="spinner"></div>
</div> 

<!-- Add Post Modal -->
<div class="modal fade" id="addPostModal"  data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="addPostModalTitle" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered" role="document" style="max-width: 460px;">
        <div class="modal-content border-radius-10 border-0s">
        <div class="modal-header">
            <h5 class="modal-title">Add Blog</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>

            <div class="px-3 px-md-4 py-4">
            <div class="row mx-0 mb-4" style="
    background: #c1c1ef;
    border-radius: 10px;
    padding: 14px 11px;
">
<div class="col-md-8 d-flex px-0"><div><img src="<?= base_url()?>/assets/img/info.svg" class="img-fluid mr-4"></div><h6 style="line-height: 22px; margin-bottom: 0;">Don't know how to write a blog and earn?</h6></div> <div class="col px-0 d-md-flex align-items-center justify-content-center ml-4 pl-2 mt-3 mt-md-0 pl-md-0 mt-md-0 ml-md-0">
<a href="https://www.crowdwisdom360.com/blog/detail/1042" style="
    border: 1px solid blue;
    font-size: 13px;
    padding: 5px 14px;
    border-radius: 10px;
    font-weight: 600;
">KNOW MORE</a>
    
</div></div>
                <form method="POST" id="add_user_post">
                    <h6>Title</h6>
                    <input  maxlength="75" type="text" class="border border-radius-15 w-100 px-3 py-2" id="blog-title" name="blog-title" placeholder="">
                    <h6 class="mt-4">Image</h6>
                    <div class="w-100 border border-radius-15 py-2 d-flex justify-content-between">
                        <input type="text" required="required" class="selected-image border-0 px-3" style="width: 64%;" id="blog-image-name" name="blog-image-name" placeholder="" readonly="readonly">
                        <button type="button" class="btn choose-img-file choose-file-bg border-radius-20 text-white px-3 fs08 mr-2">SELECT FILE</button>
                    </div>
                    <input type="file" class="blog-image border border-radius-15 w-100 px-3 py-2 d-none" name="blog-image" placeholder="">
                    <h6 class="mt-4">Description</h6>
                    <textarea name="editor1" class="border w-100 border-radius-15 px-3 py-2" rows="7"></textarea>
                    <center>
                        <button type="submit" class="btn button-plan-bg border-radius-12 text-white mt-4 px-5">SUBMIT</button>
                    </center>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- <script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script> -->

<!-- <script type="text/javascript">
var infolinks_pid = 3298607;
var infolinks_wsid = 0;
</script>
<script type="text/javascript" src="//resources.infolinks.com/js/infolinks_main.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.11.4/ckeditor.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        
        userloged_in = Boolean('<?= $user_id !=0 ? true : false; ?>');

        //reply to specific comment start
        $(document).on('click','.reply',function(){
            var scroll = ( $('.col-md-8.theme-padding.main-height').scrollTop()  )+100 ;
            var cmnt_id = $(this).attr('data-comment-id');
            if($(this).nextAll('form').length ==0){
                var reply="<form onsubmit='return false;' id='reply-box'><input autofocus type='text' name='comment-reply' data-comment_id="+cmnt_id+" class='border border-radius-15 w-100 px-4 py-2 mt-3' placeholder='Add your reply...'>\n\
                            <button data-attr-clicked='false' class='btn button-plan-bg border-radius-12 text-white fs08 mt-2 py-1 submit-reply'>Post Your Reply</button></form>";
                $(this).closest('.actions-box').append(reply);
                $('.col-md-8.theme-padding.main-height').animate({scrollTop: scroll  }, 800);

            }else{
              $(this).nextAll('form').toggle();
            }
        });

        $(document).on('click','.submit-reply', function(e){
            var is_clicked_reply = $(this).attr('data-attr-clicked');
            console.log(is_clicked_reply);
            if(is_clicked_reply == 'false'){
            e.preventDefault();
            $(this).attr('data-attr-clicked','true');
            $(this).attr('disabled',true);
            console.log(is_clicked_reply);
            var this_ = this;
            var cmnt_id = $(this).prev('input[name="comment-reply"]').attr('data-comment_id');
            var reply = $.trim($(this).prev('input[name="comment-reply"]').val());
            if(userloged_in){
                if(reply.length !=0){
                    $(this).prev('input[name="comment-reply"]').removeClass('border border-danger');
                    $.ajax({
                    url:base_url+'blog/add_reply',
                    dataType:'json',
                    type:'POST',
                    data:{'cmnt_id':cmnt_id,'reply':reply,'blog_id':<?= @$blog['id']?>}
                    }).done(function(e){
                        $(this_).attr('disabled',false);
                        if(e.status){
                            if($('.reply-content-holder-'+cmnt_id).length !==0){
                                //if reply div exist click that triiger event to get replies
                                handle_rply_condition($('.reply-content-holder-'+cmnt_id).find('a'),true,true,true);
                                // $('.reply-content-holder-'+cmnt_id).find('a').attr('data-reply-loaded','false').trigger('click');
                                $(this_).closest('form').hide('slow','linear',function(){$(this_).closest('form').remove();
                                $(this_).attr('data-attr-clicked','false'); });
                            }else{
                                //'add new reply div';
                                var rply_div='';
                                rply_div+="<div class='reply-content-holder-"+cmnt_id+"' >";
                                rply_div+="<a data-toggle='collapse' href='#reply-container-"+cmnt_id+"' role='button'";
                                rply_div+="aria-expanded='false' aria-controls='"+cmnt_id+"' data-reply-loaded='false' class='load-replies'";
                                rply_div+="data-comment_id='"+cmnt_id+"' data-reply_count='1' >View 1 replies";
                                rply_div+="</a>";
                                rply_div+="<div class='collapse' id='reply-container-"+cmnt_id+"'></div>";
                                rply_div+="</div>";
                                $(this_).closest('.actions-box').after(rply_div);
                                handle_rply_condition($('.reply-content-holder-'+cmnt_id).find('a'),true,true);
                                // $('.reply-content-holder-'+cmnt_id).find('a').trigger('click');
                                $(this_).closest('form').hide('slow','linear',function(){$(this_).closest('form').remove();
                                    $(this_).attr('data-attr-clicked','false');});
                            }
                        }else{
                            alert('Something went wrong try again later');
                            $(this_).attr('data-attr-clicked','false');
                        }
                    })
                }else{
                    $(this_).attr('disabled',false);
                    $(this).prev('input[name="comment-reply"]').addClass('border border-danger');
                    $(this_).attr('data-attr-clicked','false');
                }
                
            }else{
                // alert('Please Login');
                window.location.href = base_url+"login?section=blog&sub_section=detail&gid="+<?= @$blog['id']?>;
            }
            }
        });
        
        //reply to specific comment end

        // get comment reply start
        $(document).on('click','.load-replies', function(e){

            handle_rply_condition(this);
            // var cment_id = $(this).attr('data-comment_id');
            // var rply_status = $(this).attr('data-reply-loaded');
            // if(rply_status =='false'){
            //     get_list_of_comment_reply(cment_id,this);
            // }

     
            
        })
        // get comment reply end
        
        function handle_rply_condition(selector,ajax=null,open=null,new_added=false){
            var cment_id = $(selector).attr('data-comment_id');
            var response=false;

            if(ajax == null){
                var rply_status = $(selector).attr('data-reply-loaded');
                if(rply_status =='false'){
                    if(get_list_of_comment_reply(cment_id,selector)){
                        response = true;
                    }
                }
            }else if(ajax){
                if(get_list_of_comment_reply(cment_id,selector)){
                        response = true;                       
                };
            }

            
            if(!response){
                if(open == null){
                    $('#reply-container-'+cment_id).collapse('toggle');
                }else if(open){
                    $('#reply-container-'+cment_id).collapse('show');
                }else{
                    $('#reply-container-'+cment_id).collapse('hide');
                }
                var count = parseInt($(selector).attr('data-reply_count')) + 1;

                if(new_added){
                    $(selector).html( 'Hide '+count+ ' replies').attr('data-reply_count',count);
                }else{
                    if($(selector).attr('aria-expanded') == 'true'){
                        $(selector).html( 'Hide '+$(selector).attr('data-reply_count')+ ' replies');
                    }else{
                        $(selector).html( 'View '+$(selector).attr('data-reply_count')+ ' replies');
                    }
                }
            }
           

        }

        function get_list_of_comment_reply(cment_id,main_selector){
            var i=0;
            $.ajax({
                beforeSend:function(){
                    if($('.load-replies[data-comment_id="'+cment_id+'"]').next('.loader').length ==0){
                        $('.load-replies[data-comment_id="'+cment_id+'"]').after('<div class="loader"></div>');
                    }
                },
                url:base_url+'blog/get_comment_replies',
                type:'post',
                data:{'comment_id':cment_id},
                dataType:'json'
            }).done(function(e){
                $('.load-replies[data-comment_id="'+cment_id+'"]').next('.loader').remove();
                var scroll = ( $('.col-md-8.theme-padding.main-height').scrollTop()  )+100 ;
                $('.col-md-8.theme-padding.main-height').animate({scrollTop: scroll  }, 800);
                if(e.status){
                    add_comment_reply(e.data,cment_id);
                    $(main_selector).attr('data-reply-loaded','true');
                    return true;
                }else{
                    alert('Something went wrong try again later');
                    return false;
                }
            });
        }

        function add_comment_reply(data,selector){
            $('#reply-container-'+selector).html('');
            $.each(data, function(key,value){
                if(value.image == null){
                    value.image = base_url+'assets/img/profile_avatar.png';
                }
                if(value.name == null){
                    value.name = value.user_id;
                }
                var image = '';
                if(value.user_like == '1'){
                    image = base_url+'assets/img/Blog_thumbup_Active.svg';
                }else{
                    image = base_url+'assets/img/blog_thumbup.svg';
                }
                var div='';
                div+="<div class='user-comment user-comment-main-holder d-flex my-4' data-comment_id="+value.id+">";
                div+="<div><img src="+value.image+" class='img-fluid mr-3 user-avatar border rounded-circle' alt="+value.name+"></div>";
                div+="<div class='w-100'>";
                div+="<h6 class='mb-n1'>CW#"+value.name+"</h6>";
                div+="<small class='cw-text-color-gray'>"+value.coment_rply_date.replace('-',' ')+"</small>";
                div+="<p class='user-given-comment text-break '>"+value.reply+"</p>";
                div+="<div class='actions-box mb-2'>";
                div+="<img src='"+image+"' class='img-fluid mr-1 cursor-pointer comment_reply_like'><small>Like</small>";
                // div+="<img src='"+base_url+"assets/img/reply.svg' class='img-fluid ml-3 mr-1'><small>Comment</small>";
                // div+="<img src='"+base_url+"assets/img/c-share.svg' class='img-fluid ml-3 mr-1'><small>Share</small>";
                div+="</div>";
                div+="</div>";
                $('#reply-container-'+selector).append(div);
            })
        }

        // add comment like start
        $(document).on('click','.comment-like-action',function(e){
            var this_ = this;
            if(userloged_in){
                comment_id = $(this_).closest('.user-comment-main-holder').attr('data-comment_id');
                if(comment_id.length !=0){
                    $.ajax({
                        url:base_url+'blog/update_comment_like',
                        type:'post',
                        data:{'blog_id':<?= @$blog['id']?>,'comment_id':comment_id},
                        dataType:'json',
                    }).done(function(e){
                        if(e.like_value=="1"){
                            $(this_).attr('src',base_url+'assets/img/Blog_thumbup_Active.svg');
                        }else{
                            $(this_).attr('src',base_url+'assets/img/blog_thumbup.svg');
                        }       
                    })
                }else{
                    alert('something went wrong try again later');
                }
            }else{
                // alert('Please Login');
                window.location.href = base_url+"login?section=blog&sub_section=detail&gid="+<?= @$blog['id']?>;
            }
        });
        // add comment like end

        
        // add cc like start
        $(document).on('click','.comment_reply_like',function(e){
            var this_ = this;
            if(userloged_in){
                comment_id = $(this_).closest('.user-comment-main-holder').attr('data-comment_id');
                if(comment_id.length !=0){
                    $.ajax({
                        url:base_url+'blog/update_comment_reply_like',
                        type:'post',
                        data:{'blog_id':<?= @$blog['id']?>,'comment_reply_id':comment_id},
                        dataType:'json',
                    }).done(function(e){
                        console.log(e);
                        if(e.like_value=="1"){
                            $(this_).attr('src',base_url+'assets/img/Blog_thumbup_Active.svg');
                        }else{
                            $(this_).attr('src',base_url+'assets/img/blog_thumbup.svg');
                        }    
                    })
                }else{
                    alert('something went wrong try again later');
                }
            }else{
                // alert('Please Login');
                window.location.href = base_url+"login?section=blog&sub_section=detail&gid="+<?= @$blog['id']?>;
            }
        });
        // add comment reply like end

        // add comment start
        $('#blog_comment').on('submit',function(e){
            e.preventDefault();
            var this_ = this;
            $(this).find('button').attr('disabled',true);
            var comment = $.trim($('[name=blog-comment]').val());
            if(comment.length!=0){
                if(userloged_in){
                    $.ajax({
                        url:base_url+'blog/addcomment',
                        type:'post',
                        dataType:'json',
                        data:{'comment':comment,'blog_id':<?= @$blog['id']?>}
                    }).done(function(e){
                        if(e.status){
                            $('#blog_comment').trigger('reset');
                            $(this_).find('button').attr('disabled',false);
                            if(e.data.name == null){
                                e.data.name = e.data.user_id;
                            }
                            // add comment div in dom 
                            var comment='';
                            comment+="<div class='user-comment user-comment-main-holder d-flex my-4' data-comment_id='"+e.data.id+"'>";
                            comment+="<div>";
                            comment+="<img src='"+base_url+"/assets/img/profile_avatar.png' class='img-fluid mr-3 user-avatar border rounded-circle' alt="+e.data.name+">";
                            comment+="</div>";
                            comment+="<div class='w-100'>";
                            comment+="<h6 class='mb-n1'>CW#"+e.data.name+"</h6>";
                            comment+="<small class='cw-text-color-gray'>Today</small>";
                            comment+="<p class='user-given-comment text-break '>"+e.data.comment+"</p>";
                            comment+="<div class='actions-box mb-2'>";
                            comment+="<img src='"+base_url+"/assets/img/blog_thumbup.svg' class='img-fluid mr-1 cursor-pointer comment-like-action' alt='blog_thumbup'><small>Like</small>";
                            comment+="<img src='"+base_url+"/assets/img/reply.svg' data-comment-id='"+e.data.id+"' class='img-fluid ml-3 mr-1 cursor-pointer reply' alt='reply'><small class='cursor-pointer reply' data-comment-id='"+e.data.id+"'>Reply</small>";
                            // comment+="<img src='http://localhost/crowdwisdom/assets/img/c-share.svg' class='img-fluid ml-3 mr-1'><small>Share</small>";
                            comment+="</div>";                                          
                            comment+="</div>";
                            comment+="</div>";
                            $('.users-comment-list').prepend(comment);
                            //update comment count
                            var current_comment_count = $('.comment-count').text();
                            current_comment_count++;
                            $('.comment-count').text(current_comment_count);
                            //remove error red border
                            $('input[name="blog-comment"]').removeClass('border-danger');
                        }else{
                            alert('something went wrong')
                        }
                    });
                }else{
                    // alert('login to submit your comment');
                    window.location.href = base_url+"login?section=blog&sub_section=detail&gid="+<?= @$blog['id']?>;
                }
            }else{
                $(this_).find('button').attr('disabled',false);
                //$(this_).attr('disabled',false);
                $('input[name="blog-comment"]').addClass('border border-danger');
            }
        });
        // add comment end

        $.ajax({
            url:base_url+'blog/update_view',
            type:'POST',
            data:{id:'<?= @$blog['id']?>'}
        }).done(function(e){
            // console.log(e);
        });

        $('.blog-action').click(function(e){
            if(userloged_in){
                update_like();
            }else{
                // alert('Please login');
                window.location.href = base_url+"login?section=blog&sub_section=detail&gid="+<?= @$blog['id']?>;
            }
        });

        function update_like(like_value){
            $.ajax({
                    url:base_url+'blog/update_like',
                    type:'post',
                    data:{'blog_id':<?= @$blog['id']?>},
                    dataType:'json',
            }).done(function(e){
                like_count = parseInt($('.blog-action').next('.likes-count').html());
                if(e.status){
                    if(e.like_value=="1"){
                        like_count = like_count+1;
                        $('.blog-action').attr('src',base_url+'assets/img/Blog_thumbup_Active.svg');
                        $('.blog-action').next('.likes-count').html(like_count);
                    }else{
                        like_count = like_count-1;
                        $('.blog-action').attr('src',base_url+'assets/img/blog_thumbup.svg');
                        $('.blog-action').next('.likes-count').html(like_count);
                    }    
                }
                
            })
        }
    });
</script>


<script>
    CKEDITOR.tools.callFunction(1, this);

    CKEDITOR.plugins.addExternal('simpleImageUpload', '<?php echo base_url();?>assets/ck_editor/simpleImageUpload/', 'plugin.js');
    CKEDITOR.on('instanceReady', function (evt) {
        var editor = evt.editor;
        editor.on('focus', function (e) {
            $('.error').html('');
        });
    });
            
    CKEDITOR.replace('editor1',{
                uploadUrl: "https://imgupload.crowdwisdom.co.in",
                removeButtons: "EasyImageUpload,Copy,Paste,PasteText,PasteFromWord,Replace,SelectAll,Scayt,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,Subscript,Superscript,CopyFormatting,RemoveFormat,NumberedList,BulletedList,Outdent,Indent,Blockquote,CreateDiv,BidiLtr,BidiRtl,Language,Anchor,Flash,Smiley,SpecialChar,PageBreak,Iframe,Format,ShowBlocks,About,Save,NewPage,Preview,Print,Templates,Cut,Table,HorizontalRule,links",
                extraPlugins: 'simpleImageUpload',
                removePlugins: 'image',
                toolbarGroups: [
                {name: 'document', groups: ['mode', 'document', 'doctools']},
                {name: 'clipboard', groups: ['clipboard', 'undo']},
                {name: 'editing', groups: ['find', 'selection', 'spellchecker', 'editing']},
                {name: 'forms', groups: ['forms']},
                {name: 'basicstyles', groups: ['basicstyles', 'cleanup']},
                {name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align', 'bidi', 'paragraph']},
                // {name: 'links', groups: ['links']},
                {name: 'insert', groups: ['insert']},
                {name: 'styles', groups: ['styles']},
                {name: 'colors', groups: ['colors']},
                {name: 'tools', groups: ['tools']},
                {name: 'others', groups: ['others']},
                {name: 'about', groups: ['about']}
                ]
            });
            
    $(function () {
        var images = $('.description-container img');
        if(!images.hasClass('img-fluid')){
            images.addClass('img-fluid');
        }
        
        $('#sidegames').click(function () {
            var topics = '<?= empty($blog['topic_id']) ? '': $blog['topic_id'] ?>';
            var main_offset = parseInt('<?= sidebar_card_limit() ?>');
            var offset = $(this).data('offset');
            $(this).data('offset', offset + main_offset)
            $.ajax({
                url: "<?= base_url('Sidebar/load_games'); ?>",
                type: "POST",
                dataType: 'JSON',
                data: {offset: offset,'topics':topics},
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

        $('#sidequiz').click(function () {
            var topics = '<?= empty($blog['topic_id']) ? '': $blog['topic_id'] ?>';
            var main_offset = parseInt('<?= sidebar_card_limit() ?>');
            var offset = $(this).data('offset');
            $(this).data('offset', offset + main_offset)
            $.ajax({
                url: "<?= base_url('Sidebar/load_quiz'); ?>",
                type: "POST",
                dataType: 'JSON',
                data: {offset: offset,'topics':topics},
                success: function (data) {
                    console.log(data.length);
                    if (data.length == 0 || data.length < main_offset ) {
                        $('#sidequiz').hide();
                    } 
                    if(data.length != 0){
                        add_quiz_list('pills-quiz-inner', data);
                    }
                }
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
        $('#' + selector).append(div);
    }

        // add user post start
        var modalId = localStorage.getItem('openModal');
        if (modalId != null){
            if(userloged_in==true){
                $('#addPostModal').modal('show');
            }            
        localStorage.removeItem('openModal');
        }
        $('#post_new_blog').on('click',function(e){
            if(userloged_in){
                $('#addPostModal').modal('show');
            }else{
                window.location.href = base_url+"login?section=blog&sub_section=detail&gid="+<?= @$blog['id']?>;
                localStorage.setItem('openModal', '#message539');
            }
        })

        $('.choose-img-file').click(function(){
            $('.blog-image').click();
        });

        $('input[type="file"]').change(function(e){
            if(e.target.files[0] !=undefined){
                var fileName = e.target.files[0].name;
                var filesize = e.target.files[0].size;
                var filetype = e.target.files[0].type;
                var filesizeinkb = (Math.round(filesize*100/100000));
                allowded_files = ['image/svg+xml','image/png','image/jpg','image/jpeg'];

                var file = e.target.files[0];
                var imageData = new FormData();
                imageData.append('file', file);

                if(allowded_files.includes(filetype)){
                    ajax_call_multipart("POST", imageData, function (result) {
                        $('.selected-image').val(result);
                    });
                }else{
                    alert('only images you can upload');
                }
            }
        });

        function ajax_call_multipart(method, param, cb) {
            $.ajax({
                url: "https://imgupload.crowdwisdom.co.in",
                method: method,
                data: param,
                cache: false,
                contentType: false,
                processData: false
            }).done(function (result) {
                cb(result);
            });
        }

        $("#addPostModal").on("show.bs.modal",function(event){
            setTimeout(function(){
                $(document).find(".modal-backdrop").css({"background-color":"#000"});
            },50);
        });

        $(document).on('submit','#add_user_post',function(e){
            e.preventDefault();
            var title = $.trim($('#blog-title').val());
            var image = $('#blog-image-name').val();
            var description = CKEDITOR.instances.editor1.getData();
            if(title ==''){
                showmessage('Title canot be empty','danger');
            }else if(title.length > 75){
                showmessage('Title canot be greater than 75 character','danger');
            }else if(image ==''){
                showmessage('Image canot be empty','danger');
            }else if(description ==''){
                showmessage('Description canot be empty','danger');
            }else{
                $.ajax({
                    url:base_url+'Blog/add_user_blog',
                    type:'POST',
                    data:{'title':title,'image':image,'description':description},
                    dataType:'json'
                }).done(function(e){
                    console.log(e);
                    if(e.status){
                        $('#add_user_post').trigger('reset');
                        CKEDITOR.instances.editor1.setData('');
                        $('#addPostModal').modal('hide');
                        alert('We have sent your blog for approval');
                    }else{
                        alert('Someting went wrong please try again later');
                    }
                })
            }
        })
        // add user post end


    });

    function add_game(selector, data) {
        var div = '';
        $.each(data, function (key, value) {
            div += '<a href="'+base_url+'Predictions/prediction_game/'+value.id+'" class="card prediction-card text-decoration-none mb-5">';
            // div += '<div class="banner-img" style="background-image:url(' + value.image + ')" title="'+value.title+'"></div>';
            div += '<div class="card-body">';
            div += '<button class="btn play-btn" style="bottom:-17px;top:unset;right:18px;">';
            div += 'Play Now';
            div += '</button>';
            div += '<h6 class="title text-left" >';
            div += value.title;
            div += '</h6>';
            div += '<div class="d-flex justify-content-between" >';
            div += '<div >';
            div += '<img src="' + base_url + 'assets/img/clock.svg" >';
            div += '<span class= "font-weight-light ml-1" > Game Ends : <span';
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
    function showloader() {
        $('.loading').css({"display": 'flex'});
        $('body').css({'height': "100vh", 'overflow': "hidden"});
    }

    function hideloader() {
        $('.loading').fadeOut(800);
        $('body').css({'height': "100vh", 'overflow': "auto"});
    }

</script>
