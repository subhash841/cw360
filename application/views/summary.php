<div class="container-fluid main-height" id="predection-list-main-container">
    <div class="row">

        <div class="col-md-12 theme-padding">
            <!-- <div class="bredcum-holder">
                <a href="#">Home /</a>
                <a href="#">Article 370 /</a>
                <a href="#" class="active">Game /</a>
            </div> -->
            <div>
                <h5 class="title mt-4"><?=$game_details['title']?></h5>
            </div>
            
            <div class="profile-info">
                <!-- <div class="holder">

                    <h6 class="title">Rank</h6>
                    <h6 class="mb-0"><img src="http://localhost/crowdwisdom/assets/img/trophy.svg" class="img-fluid"><b>141</b></h6>
                </div>
                <div class="holder">
                    <h6 class="title">Portfolio</h6>
                    <h6 class="mb-0"><b>339</b><span>Points</span></h6>
                </div> -->
                <div class="holder border-0">
                    <h6 class="title">Available</h6>
                    <h6 class="mb-0" ><b class="avlb-points"><?=empty($available_points['points']) ? '0' : $available_points['points']?></b><span>Coins</span></h6>
                </div>
            </div>
            <div class="predection-list-container">
                <h5 class="font-weight-bold">Predictions</h5>
                <div class="predection-list" data-gameId="<?=$game_id?>" id="data-gameId">
                <?php if (!empty($prediction_list)):
                // print_r($prediction_list );
                    foreach ($prediction_list as $key => $prediction):
                        ?>
                <?php $predictionInfo = predictionClassDetails($prediction);?>
                    <div class="predection pre-<?=$prediction['prediction_id']?> row <?=$predictionInfo['className']?>">
                        <div class="main-title col-md-4 col-12"><?=$prediction['title'];?></div>
                        <div class="c-price col">
                            <span class="title">Current Price</span>
                            <b><?=$prediction['current_price'];?></b><span> Coins</span>
                        </div>
                        <div class="c-profit col">
                            <span class="title">Current Profit</span>
                            <b class="<?=$predictionInfo['price_fontColor']?>"><?=$predictionInfo['price_diff']?></b><span class="<?=$predictionInfo['price_fontColor']?>"> Coins</span>
                        </div>
                    <?php if ($prediction['swipe_status']=='disagreed'): ?>
                        <div class="p-skipped col">
                            <span class="title">Prediction Skipped</span>
                        </div>
                    <?php else: ?>
                        <div class="p-price col">
                            <span class="title">Purchased Price</span>
                            <b><?=$prediction['executed_points']?></b><span> Coins</span>
                        </div>
                    <?php endif; ?>
                        <div class="status col">
                        <?php 
                        //if($current_dateTime)

                        if ($predictionInfo['buttonName']!= 'Completed'): ?>
                            <button onclick="openpopup('<?=$predictionInfo['popup']?>','<?=$prediction['prediction_id']?>','<?=$prediction['game_id']?>','<?=$predictionInfo['condition']?>','<?=$prediction['created_date']?>')";><?=$predictionInfo['buttonName']?></button>
                         <?php else:?>    
                            <button><?=$predictionInfo['buttonName']?></button>
                         <?php endif; ?>    
                        </div>
                    </div>  
                <?php endforeach; 
                     endif; ?>
                </div>
            </div>
            <?php if (count($prediction_list)==10): ?>
                <div class="status col text-center">
                    <button id="loadMore" data-offset="10" class="btn btn-primary rounded-pill mb-3 mt-3">Load More</button>
                </div>
            <?php endif ?>

        </div>

    </div>
</div>
