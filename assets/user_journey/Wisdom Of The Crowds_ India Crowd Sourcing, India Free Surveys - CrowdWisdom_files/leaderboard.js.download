function show_leaderboard(base_url,gameId,userNameExist) {
    if (userNameExist=='' || userNameExist==null) {
        showmessage('Please complete your profile first to view Leaderboard', 'success');
        setInterval(function(){
             window.location.href = base_url+'Games/leaderboard/'+gameId;
        }, 3000);
    }else{
        window.location.href = base_url+'Games/leaderboard/'+gameId;
    }
}