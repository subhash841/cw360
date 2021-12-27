function buy_plan(game_id,user_id,amount){


	$.ajax({
        // url: base_url+'Games/game_points_payment',
        url: base_url+'Subscription_plans/game_points_payment',
        dataType: 'JSON',
        data: {game_id:game_id, amount:amount},
        type: 'post',
      //   headers: {
				  //   "Access-Control-Allow-Origin" : "*", // Required for CORS support to work
				  //   "Access-Control-Allow-Credentials" : true // Required for cookies, authorization headers with HTTPS 
				  // },
        success: function (data, textStatus, jqXHR) {
        	console.log(data);
        },
        error: function (error) { 
        	console.log(error);
        }
    });

}