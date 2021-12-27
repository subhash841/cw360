function is_blank(value) {
	if (value == '') {
	    value = 0;
	} else if (typeof value === 'undefined') {
	    value = 0;
	} else if (value == null) {
	    value = 0;
	} else if (value == 'null') {
	    value = 0;
	} else {
	    value = value;
	}
	return value;
}

$(document).on('click', '.average_portfolio', function () {
	user_image = $(this).attr('data-img');
	user_name = $(this).attr('data-name');
	user_email = $(this).attr('data-email');
	userId = is_blank($(this).attr('data-userid'));
    create_user_info_html(user_image,user_name,user_email,userId);
	$('#leaderboardprofileModal').modal('show');
	showRankAvgLoader();
    $.ajax({
        url: base_url + 'Games/get_average_portfolio',
        data: {user_id: userId},
        type: 'POST',
        dataType: 'JSON',
        success: function (res, textStatus, jqXHR) {
           // console.log(res);
        	hideRankAvgLoader(); 
        	create_categorywise_ranking_html(res.categorywise_rank);
        },
        error: function (jqXHR, textStatus, errorThrown) { }
    })
})

function create_user_info_html(user_image,user_name,user_email,userId){
	user_email = is_blank(user_email)==0 ? '' : user_email;
	user_img_html = '<div class="default_profile" style="height:120px;width:120px; background:url('+user_image+') center center no-repeat;background-size:cover;margin: 0 auto;border-radius: 50%;">';	
   $("#profile_img").html(user_img_html);
   $("#profile_name").html(user_name);
   $("#profile_email").html(user_email);
   $("#profile_id").html(userId);
}

function create_categorywise_ranking_html(categorywise_rank){
    	ranking_html = '';
    	// avg_rank = '';
       	ranking_html += '<h5 class="text-center">Average Game Profile Accuracy</h5>';
       	// ranking_html += '<h5 class="text-center">Average Game Profile Ranking</h5>';
   	if (categorywise_rank!='') {
       	$.each(categorywise_rank, function (key, value) {
			//    console.log(value.category_name+' '+value.prediction_data);
			//    return false;
			if(value.prediction_data =='0'){
				avg_rank = value.prediction_data+'%';
			   }else if (value.prediction_data!='0' && value.prediction_data!='NA') {
				   avg_rank = (value.prediction_data/value.prediction_data_count);
				//    console.log(avg_rank);
				   check_decimal = avg_rank % 1;
				//    console.log(check_decimal);
				if (check_decimal!=0) {
					avg_rank = avg_rank.toFixed(2)+'%';
				}else if (check_decimal!=0 && avg_rank==0){
					avg_rank = 'NA';
				}else{
					avg_rank = avg_rank+'%';
					
				}
			}else{
				avg_rank = 'NA';

			}
       		ranking_html += '<div class="my-3 up-cat-box">';
       		ranking_html += '<div class="row mx-0">';
       		ranking_html += '<div class="col-8 p-3 d-flex">';
       		ranking_html += '<img class="img-fluid" src="'+base_url+'assets/img/category-icon.svg">';
       		ranking_html += '<span class="ml-1">'+value.category_name+'</span></div>';
       		ranking_html += '<div class="col-4 up-cat-rank-bg text-right py-3">';
       		ranking_html += '<h6 class="up-rank-txt-color font-weight-bold pt-1 mb-n1">'+avg_rank+'</h6>';
       		// ranking_html += '<small class="up-rank-txt-color mb-0">Avg. Rank</small>';
       		ranking_html += '<small class="up-rank-txt-color mb-0">Accuracy</small>';
       		ranking_html += '</div></div></div>';
        })
    }else{
    		ranking_html += '<div class="my-3 up-cat-box">';
       		ranking_html += '<div class="row mx-0">';
       		ranking_html += '<div class="p-3">';
       		ranking_html += '<h6 class="text-center">You have not played any game yet.</h6>'; 
       		ranking_html += '</div></div></div>';
    }
        $("#categorywise_ranking").html(ranking_html);
}
function hideRankAvgLoader() {
    $('#loading_details').addClass('d-none');
}
function showRankAvgLoader() {
    $('#loading_details').removeClass('d-none');
}

$(function(e){
	$('#leaderboardprofileModal').on('show.bs.modal',function(e){
		close_drawer('user-profile-info');
		user_profile = false;
	})
})

