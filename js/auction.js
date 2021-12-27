
// var base_url = $("body").attr("data-base_url");
// // $(document).ready(function(){
// // 	var url ="http://localhost/crowdwisdom360.co.in/auction/prediction_list";

// // 	    $.ajax({
// //         url: url,
// //         dataType: 'JSON',
// //         type: 'GET',
// //         success: function (data, textStatus, jqXHR) {
// //          // alert(data.result);
// //          console.log(data.result)
// //          $.each(data.result, function(key, val) {
// //          	console.log(val)
// // 			  alert('this is predictions_id'+val['predictions_id']);
// // 			});

// //         },
// //         error: function (error) {
// // 			//console.log(error)
// //         }
// //     });

// // });


 var flag=true;
// //alert(flag);

if(flag !=false){
	setInterval(function(){
	get_start_auction();
	}, 5000);
}

function get_start_auction(){
		var url ="http://localhost/crowdwisdom360.co.in/auction/prediction_list";

	    $.ajax({
        url: url,
        dataType: 'JSON',
        type: 'GET',
        success: function (data, textStatus, jqXHR) {
         // alert(data.result);
         console.log(data.result)
         if (data.result!=""){
         	flag=false;
	         $.each(data.result, function(key, val) {
	         	//console.log(val);
	         		buy_sell_process(val['predictions_id']);
				  //alert('this is predictions_id'+val['predictions_id']);
				});
         }
         //alert(flag);
        },

        error: function (error) {
			//console.log(error)
        }
    });
}

// function buy_sell_process(predictions_id){
// 		var url ="http://localhost/crowdwisdom360.co.in/auction/auctionProcess";

// 	    $.ajax({
//         url: url,
//         dataType: 'JSON',
//         data: { predictions_id:predictions_id },
//         type: 'POST',
//         success: function (data, textStatus, jqXHR) {
//          // alert(data.result);
//          console.log(data)
     
//          //alert(flag);
//         },

//         error: function (error) {
// 			console.log(error)
//         }
//     });
// }