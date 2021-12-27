<style type="text/css">
   .screen_1{
        background-image: url("<?= base_url();?>assets/img/screen_info/leaderboard_info.png");
        background-position: center center;
        background-size: cover;
        height:100%; 
        width:100%;
    }
    .screen_2{
        background-image: url("<?= base_url();?>assets/img/screen_info/prediction_info.png");
        background-position: center center;
        background-size: cover;
        height:100%; 
        width:100%;
    }
    .arrow{
        margin-top: 40%;
        margin-right: 5%;
        float: right;
        cursor: pointer;
    }
    .a{
    height: 100vh;
    width: 100vw;
    }
</style>
<div class="container-fluid px-0">
<!-- SCREEN 1 -->
<div class="screen_1 img-fluid responsive" id="screen_1">
    <img src="<?= base_url();?>assets/img/overlay/arrow.svg" class="arrow responsive">
</div> 
<!-- SCREEN 2 -->
<div class="screen_2 img-fluid responsive" id="screen_2" style="display: none">
    <img src="<?= base_url();?>assets/img/overlay/arrow.svg" class="arrow responsive">
</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        $(".arrow").on('click',function () { 
             $("#screen_1").toggle();
             $("#screen_2").toggle();
            
           
        });
    });
</script>