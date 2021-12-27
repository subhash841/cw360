<!--summay screen start-->
<div id="predection-list-main-container" class="mx-md-5 px-2 pb-4 row ">
    <div class="predection-list-container">
        <!-- <h5 class="font-weight-bold mb-0 mt-md-0 mt-3">Predictions</h5> -->
        <div class="predection-list" data-gameid="<?=$game_id?>" id="data-gameId">
            <?php 
            // print_r($prediction_list);die;
            if (!empty($prediction_list)):
                foreach ($prediction_list as $key => $prediction):
            ?>
            <?php $predictionInfo = predictionClassDetails($prediction);?>
            <div class="predection pre-<?=$prediction['prediction_id']?> row <?=$predictionInfo['className']?>">
                <div class="main-title col-md-4 col-md-12 mb-3"><?=$prediction['title'];?></div>
                <div class="c-price col border-right">
                    <span class="title">Current Value</span>
                    <b><?=$prediction['wrong_prediction']=='1' ? '0' : $prediction['current_price']?></b><span></span>
                </div>
                <div class="c-profit col border-right">
                    <span class="title">Current Profit</span>
                    <b class="<?=$predictionInfo['price_fontColor']?>"><?=$predictionInfo['price_diff']?></b><span class="<?=$predictionInfo['price_fontColor']?>"></span>
                </div>
                <?php if ($prediction['swipe_status']=='disagreed'): ?>
                    <div class="p-skipped col">
                        <span class="title align-self-start">Skipped/<br>Predicted No</span>
                    </div>
                <?php else: ?>
                    <div class="p-price col">
                        <span class="title">Purchased Value</span>
                        <b><?=$prediction['executed_points']?></b><span></span>
                    </div>
                <?php endif; ?>
                <div class="status">
                    <?php if ($predictionInfo['buttonName']!= 'Completed'): ?>
                        <button onclick="openpopup('<?=$predictionInfo['popup']?>','<?=$prediction['prediction_id']?>','<?=$prediction['game_id']?>','<?=$predictionInfo['condition']?>','<?=$prediction['created_date']?>','<?=$change_prediction_time?>')";><?=$predictionInfo['buttonName']?></button>
                     <?php else:?>    
                        <button><?=$predictionInfo['buttonName']?></button>
                     <?php endif; ?>
                </div>
                <div class="col-12 pt-3 text-center end-date"><span>Ends : </span><span><?=date("d-M-Y h:i A", strtotime($prediction['end_date']));?></span></div>
            </div>
            <?php endforeach; 
                    endif; ?> 
        </div>
    </div>
</div>

<!--suummay screen end--> 
<script>
    $(function () {
        if (window.IsDuplicate()) {
              // alert user the tab is duplicate
              window.location.href=base_url+'/home';          
          }

    });
</script>