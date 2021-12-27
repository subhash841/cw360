    $(document).ready(function(){
        showLeaderboardLoader();
        var game_id = $('#game_id_leaderboard').attr('data-gameId');
            $.ajax({
                url: base_url + 'Games/leaderboard',
                data: {game_id: game_id},
                type: 'POST',
                dataType: 'JSON',
                success: function (res, textStatus, jqXHR) {
                     hideLeaderboardLoader();
                    // console.log(res);return;
                    if (res.status=='success') {
                        create_leaderboard(res);
                    }else if (res.status=='failure' && res.message=='redirect_to_home'){
                        window.location.href = base_url;
                    }else if (res.status=='failure' && res.message=='empty_records'){
                        empty_leaderboard_records();
                    }else{
                        console.log(res.message);
                    } 
                },
                error: function (jqXHR, textStatus, errorThrown) { }
            })
    })

    function create_leaderboard(res){
        $('#your_points').html(check_null(res.user_points));
        $('#your_rank').html('#'+check_null(res.user_rank));
        users_ranking = '';
        if (res.leaderboard_data!='') {
            singleRank = res.leaderboard_data.length==1 ? 'single-rank' : '';
            $.each(res.leaderboard_data, function (key, value) {
                rank = '#'+parseInt(key + 1);
                if (res.sess_user_id == value.user_id) {
                    self_rank_class = 'active';
                    self_position = 'YOU';
                }else{
                    self_rank_class = '';
                    self_position = '';
                }
                if (is_blank(value.image)==0) {
                    avg_rank_image = 'https://www.abc.net.au/news/image/8314104-1x1-940x940.jpg';
                }else{
                    avg_rank_image = value.image;
                }
                users_ranking += '<div class="rankall '+self_rank_class+' '+singleRank+'">';
                users_ranking += '<div class="w-15 pb">';
                users_ranking += '<small>'+rank+'</small>';
                users_ranking += '</div>';
                users_ranking += '<div class="w-15 pb">';
                users_ranking += '<span class="average_portfolio" data-img="'+avg_rank_image+'" data-name="'+value.name+'" data-email="" data-userid="'+value.user_id+'"><img class="profilepic cursor-pointer" src="'+null_image(value.image)+'" /><span>';
                users_ranking += '</div>';
                users_ranking += '<div class="innerdiv w-70">';
                users_ranking += '<span class="w-70 float-left">';
                users_ranking += '<small>'+check_null(value.name)+'</small><br>';
                users_ranking += '<small class="num">'+value.total_points+'</small>';
                users_ranking += '</span>';
                users_ranking += '<div class="w-30 float-right justify-content-center">';
                users_ranking += '<small class="text-whites">'+self_position+'</small>';
                users_ranking += '</div>';
                users_ranking += '</div>';
                users_ranking += '</div>';
            })
            // console.log(users_ranking);
            $("#users_ranking").html(users_ranking);
        }else{
            console.log('No records found');
        }
    }

    function check_null(string){
        if (string==null || string=='' || typeof string==='undefined') {
            return '0';
        }else{
            return string;
        }
    }
    function null_image(image){
        if (image==null || image=='' || typeof image==='undefined') {
            return base_url+'assets/img/profile_avatar.png';
        }else{
            return image;
        }
    }
    function empty_leaderboard_records(){
        $('#your_points').html('--');
        $('#your_rank').html('--');
        users_ranking = '';
        users_ranking += '<div class="col-12 col-md-9 mx-auto px-0 mb-0 bg-blue text-center border-15 p-5">';
        users_ranking += '<img src="'+base_url+'assets/img/leaderboardtrophy.svg" class="img-fluid mb-5">';
        users_ranking += '<p class="text-white opacity6 font-weight-light">Play the game to appear on the <br>Leaderboard</p>';
        users_ranking += '</div>';
        $("#users_ranking").html(users_ranking);
    }
    function hideLeaderboardLoader() {
        $('.leaderboardLoader').addClass('d-none');
    }
    function showLeaderboardLoader() {
        $('.leaderboardLoader').removeClass('d-none');
    }