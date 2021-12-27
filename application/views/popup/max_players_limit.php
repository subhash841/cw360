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
<div class="modal fade" id="max_players" tabindex="-1" role="dialog" aria-labelledby="challengeModalCenterTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false" data-gamePlayer-limit="<?=$game_details['max_players']?>">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 410px;">
        <div class="modal-content modal-blue-bg border-radius-10 border-0 popup-bg">
            <div class="px-4 py-5 text-center text-white">
                <p class="font-weight-light sub-text-color my-4">
                	Maximum players limit of <?=$game_details['max_players']?> players for this game has been reached. Try out other games.
                </p>
                <a href="<?=base_url()?>Games">
                	<button class="btn button-plan-bg border-radius-12 text-white mt-2 px-4">OK</button>
                </a>
            </div>
        </div>
    </div>
</div>