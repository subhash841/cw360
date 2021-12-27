$(function () {
    loadgames(0, 9);
    $('.loadgame').click(function (e) {
        $(this).parent().after('<div class="loader mx-auto mt-3 "></div>');
        var offset = $(this).attr('data-offset');
        var limit = $(this).attr('data-limit');
        loadgames(offset, limit);
    });
});
//setInterval(function(){ 
//    loadgames(0, 0);
//    }, 1000*60);

function removegameloader() {
    $('.loader').addClass('d-none');
}

function loadgames(offset, limit) {
    $.ajax({
        method: 'POST',
        url: base_url + 'Home/game_list',
        data: {offset: offset, limit: limit}
    }).done(function (response) {
        removegameloader();
        response = JSON.parse(response);
        if (response.length > 0) {
            $.each(response, function (key, value) {
                if (value.game_end_date>=0) {
                    game_status = value.game_end_date + " Days left";
                }else{
                    game_status = "Game Ended";
                }
                $('#gamelist').append($('<a />', {class: "nostyle pl-md-0 d-block w-100 col-md-4 gamelink", href: base_url + "Games/prediction/" + value.id, 'data-gameid': value.id}).append($('<div />', {class: ' game-card pl-md-0  mb-4 position-relative'}).
                    append($('<div />', {class: 'game-card-img d-flex align-items-end py-2'}).css({'background-image': "url(" + value.image + ")"})
                        .append(
                            $('<div />', {class: 'w-100 playnow-btn-container'})
                            .append($('<a />', {class: "playnow-btn bg-white rounded-pill shadow", href: base_url + "Games/prediction/" + value.id})
                                .append($('<span />', {class: "mb-0"}).html('PLAY NOW'))
                                .append($('<img />', {class: "img-fluid", src: base_url + "images/home360/arrow.png"}))
                                )
                            )
                        )
                    .append($('<div />', {class: "game-detail px-md-3"})
                        .append($('<h4 />', {class: "game-title mt-2 mb-1 text-truncate pl-3 pl-md-0"}).html(value.title))
                        .append($('<h6 />', {class: "predection-count font-weight-500 pl-3 pl-md-0 float-left w-50"})
                            .html(value.count_prediction + " Predictions")
                            .prepend($('<img />', {src: base_url + "images/common/predection.svg", class: "mr-2 game_icon"})
                                ))
                        .append(
                            $('<div />', {class: "game-prize-detail mb-md-3 "})
                            .append($('<h6 />', {class: "w-50 float-right"}).html(value.user_count + " Players")
                                .prepend($('<span />')
                                    .append($('<img />', {src: base_url + "images/gamebanner/players.png", class: "mr-2 game_icon"})))
                                )
                            // .append($('<h6 />', {class: "w-50 float-right"}).html(value.game_end_date + " Days left")
                            .append($('<h6 />', {class: "w-50 float-right"}).html(game_status)
                                .prepend($('<span />')
                                    .append($('<img />', {src: base_url + "images/gamebanner/calender.png", class: "mr-2 game_icon"})))
                                )
                            .append($('<h6 />', {class: "w-50 float-left"}).html(value.reward)
                                .prepend($('<span />')
                                    .append($('<img />', {src: base_url + "/images/gamebanner/prize.png", class: "mr-2 game_icon"})))
                                )
                            ))))

            });
            if (response.length < 9) {
                $('.gameloadmore').addClass('d-none');
            } else {
                $('.gameloadmore').removeClass('d-none');
            }

//            $('.gameloadmore').removeClass('d-none');
$('.loadgame').attr({'data-offset': Number(offset) + 9, 'data-limit': 9});
} else {
    $('.loadgame').addClass('d-none');
}
});
}
