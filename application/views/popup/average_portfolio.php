<div class="modal" id="leaderboardprofileModal" tabindex="-1" role="dialog" aria-labelledby="commonModalLabel" aria-modal="true" style="padding-right: 17px;">
    <div class="modal-dialog modal-dialog-centered " role="document">
        <div class="modal-content theme-sm-modal p-0 mx-auto">
            <div>
                <div class="px-4 py-3 pb-4 leaderboard-profile-bg" style="border-top-right-radius: 15px; border-top-left-radius: 15px;">
                    <div class="text-right">
                        <img class="img-fluid cursor-pointer" data-dismiss="modal" aria-label="Close" src="<?= base_url(); ?>/assets/img/close-btn-white.svg">
                        <div class="row mt-3" id="user_info">
                            <div class="col-12 text-center">
                               <div class="position-relative d-inline-block" id="profile_img">
                                    
                                </div>
                            </div>
                            <div class="col-12 text-center">
                               <h5 class="font-weight-normal mt-2 pt-1 text-white" id="profile_name"></h5>
                               <h6 class="font-weight-light fs08 text-light" id="profile_email"></h6>
                               <h6 class="font-weight-light fs08 text-light">Profile ID: #<span id="profile_id"></span></h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-4 py-3 leaderboard-category-box" id="categorywise_ranking">
                    <span id="loading_details" class="d-none">
                        <h6 class="text-center">Please wait while we are processing your details</h6>
                        <div class="loader mx-auto mt-5 mb-5"></div>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>