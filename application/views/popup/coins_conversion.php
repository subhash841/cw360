<div class="modal fade" id="convert_coins_to_points" tabindex="-1" role="dialog" aria-labelledby="challengeModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mx-auto" role="document" style="max-width: 331px;">
        <div class="modal-content modal-blue-bg border-radius-10 border-0 popup-bg">
            <div class="text-center text-white">
                <h5 class="title">
                    Add Coins to the Game
                </h5>
                <div class="desc">
                    <p class="mb-0">You can add maximum of <span id="max_points"></span><br>GAME coins at a cost of <span id="coin_transfer_limit"></span> WALLET coins</p>
                </div>
                <b>Enter coins</b>
                <div>
                    <div class="input-group my-4 mx-auto">
                        <div class="input-group-prepend">
                            <div class="input-group-text bg-white"><img src="<?= base_url('assets/img/coin.png') ?>" class="coin-img img-fluid"></div>
                        </div>
                        <input type="text" class="form-control" name="coins_to_convert" id="coins_to_convert" oninput="this.value = this.value.replace(/[^0-9.]|^0+|\.|\s/g, '').replace(/(\..*)\./g, '$1');">
                    </div>
                </div>
                <div id="points_to_get">
                </div>
                <div>
                    <button id="convert-coins" class="btn text-white convert-coins">SUBMIT</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $("#coins_to_convert").keyup(function() {
        var game_id = '<?= $game_id ?>';
        var user_id = '<?= $this->user_id ?>';
        var coins_to_transfer = parseInt($(this).val());
        $.ajax({
            url: base_url + 'Games/coins_coversion_details',
            data: {
                game_id: game_id,
                user_id: user_id
            },
            type: 'POST',
            dataType: 'JSON',
            success: function(res, textStatus, jqXHR) {
                if (typeof coins_to_transfer === 'undefined' || coins_to_transfer == null || coins_to_transfer == '' || coins_to_transfer == 0 || isNaN(coins_to_transfer) == true) {
                    $('#points_to_get').html('');
                } else {
                    if (coins_to_transfer > res.user_coins.coins) {
                        $('#points_to_get').html("<p>You do not have enough coins in your wallet. Click <a  id='link' href="+base_url+"subscriptions>here</a> to purchase coins</p>");
                    } else if (coins_to_transfer > res.coin_transfer_limit) {
                        $('#points_to_get').html("<p class='text-danger'>Max coins transfer limit exceeds</p>");
                    } else {
                        $('#points_to_get').html('<p>You will get ' + Math.round(res.point_value_per_coin * coins_to_transfer) + ' coins</p>');
                    }
                }

            },
            error: function(jqXHR, textStatus, errorThrown) {}
        })
    });
    $("#convert-coins").click(function() {
        $('#convert-coins').prop('disabled', true);
        $(".convert-coins").removeAttr( "id");           
        var game_id = '<?= $game_id ?>';
        var user_id = '<?= $this->user_id ?>';
        var coins_convert = $('#coins_to_convert').val();
        if (coins_convert == '') {
            $('#points_to_get').html("<p class='text-danger'>Coins field cannot be empty</p>");
            $( ".convert-coins" ).attr( "id","convert-coins");
            $('#convert-coins').removeAttr('disabled');
        } else {
            $.ajax({
                url: base_url + 'Games/convert_coins_into_points',
                data: {
                    game_id: game_id,
                    user_id: user_id,
                    coins_convert: coins_convert
                },
                type: 'POST',
                dataType: 'JSON',
                success: function(res, textStatus, jqXHR) {
                    if (res.status == 'failure') {
                        $('#points_to_get').html("<p class='text-danger'>" + res.message + "</p>");
                        $( ".convert-coins" ).attr( "id","convert-coins");
                        $('#convert-coins').removeAttr('disabled');
                        if(res.message =="You have exceeded your attempts"){
                            setTimeout(function() {
                             $('#convert_coins_to_points').modal('hide');
                             $('#points_to_get').html('');
                            }, 2000);
                        }
                    } else {
                        $('#points_to_get').html("<p class='text-success'>" + res.message + "</p>");
                        $( ".convert-coins" ).attr( "id","convert-coins");
                        $('#convert-coins').removeAttr('disabled');
                        setTimeout(function() {
                            // $('#convert_coins_to_points').modal('hide');
                            location.reload();
                        }, 2000);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {}
            })
        }
    });
</script>
