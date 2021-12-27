<div class="container-fluid main-height subscription-plan-container">
	<div class="row ">
		<div class="col-md-12 theme-padding pr-3">
			<!-- <div class="bredcum-holder">
				<a href="#" class="text-white">Home /</a>
				<a href="#" class="text-white active">Subscription /</a>
			</div> -->
			<div class="pt-3 subs-blue-bg pb-3">
				<!-- <h3 class="font-weight-600 text-white mb-0">Get Started to Win Exciting .Prizes</h3> -->
				<h3 class="font-weight-600 text-white mb-0 subs-title">You will need Coins to play Games</h3>
			</div>
			<div>
				<p class="text-white subs-issue-title">Pay for Coins using UPI, In case of any issues mail us at subscriptions@crowdwisdom.live</p>
			</div>
			<div class="row">
				<div class="col-md-4 px-0 px-md-3">
					<div class="d-none d-md-block">
						<img class="d-block d-md-none w-100" src="<?php echo base_url(); ?>assets/img/sub_mbg_blue.svg">
					</div>
				</div>
				<div class="col-md-8 pr-0 slide-bg pt-5 pt-md-0 pb-5 pb-md-0">
					<div class="position-relative pt-0 pt-md-5">
						<div class="subs-slide pb-0 pb-sm-5">
						<?php 
								foreach ($get_subscription_list as $key => $value) {
				
						?>
							<div>
								<div class="m-3" style="min-width: 228px;">
									<div class="w-100 px-0 pt-4 pb-3 bg-white rounded" style=" border-radius: 15px !important;">
										<h6 class="mt-2 px-4 font-weight-bold"><?= $value['package_name']?></h6>
										<div class="position-relative py-1">
											<hr style="border-color: #ffdfdd">
											<div class="position-absolute py-1 pl-4 pr-5 price-tag">
												<span style="font-family: none;"> &#x20B9;</span><?= $value['price']?>
											</div>
										</div>
										<div class="mt-4 pt-2 pl-4">
											<h2 class="font-weight-600 mb-0">
												<img class="d-inline" src="<?php echo base_url(); ?>assets/img/coins.png">
												<?= $value['coins']?>
											</h2>
											<div class="ml-4 pl-3 mt-n2"><small>Coins</small></div>
										</div>
										<div class="px-3 mt-4">
											<!-- <a href="<?=base_url()?>subscriptions/payment_neft"><button class="btn w-100 text-white btn-plan">SELECT PLAN</button></a> -->
											<a href="<?=base_url()?>subscription_plans/game_points_payment/<?= $value['id']?>"><button class="btn w-100 text-white btn-plan">PAY NOW</button></a>
											<!-- <a href="https://paytm.business/link/49540/LL_20587543" target="_blank"><button class="btn w-100 text-white btn-plan">SELECT PLAN</button></a> -->
										</div>
										
										
									</div>
								</div>
							</div>
							<?php } ?>
							<!-- <div class="d-none">
								<div class="m-3" style="min-width: 228px;">
									<div class="w-100 px-0 pt-4 pb-3 bg-white rounded" style=" border-radius: 15px !important;">
										<h6 class="mt-2 px-4 font-weight-bold">Gold</h6>
										<div class="position-relative py-1">
											<hr style="border-color: #ffdfdd">
											<div class="position-absolute py-1 pl-4 pr-5 price-tag">
												<span style="font-family: none;"> &#x20B9;</span>699
											</div>
										</div>
										<div class="mt-4 pt-2 pl-4">
											<h2 class="font-weight-600 mb-0">
												<img class="d-inline" src="<?php echo base_url(); ?>assets/img/coins.png">
												15000
											</h2>
											<div class="ml-4 pl-3 mt-n2"><small>Coins</small></div>
										</div>
										<div class="px-3 mt-4">
											<a href="<?=base_url()?>subscription_plans/game_points_payment/2"><button class="btn w-100 text-white btn-plan">SELECT PLAN</button></a>
										</div>
										
										
									</div>
								</div>
							</div> -->
							<!-- <div>
								<div class="m-3" style="min-width: 228px;">
									<div class="w-100 px-0 pt-4 pb-3 bg-white rounded" style=" border-radius: 15px !important;">
										<h6 class="mt-2 px-4 font-weight-bold">Silver</h6>
										<div class="position-relative py-1">
											<hr style="border-color: #ffdfdd">
											<div class="position-absolute py-1 pl-4 pr-5 price-tag">
												<span style="font-family: none;"> &#x20B9;</span>599
											</div>
										</div>
										<div class="mt-4 pt-2 pl-4">
											<h2 class="font-weight-600 mb-0">
												<img class="d-inline" src="<?php echo base_url(); ?>assets/img/coins.png">
												10000
											</h2>
											<div class="ml-4 pl-3 mt-n2"><small>Coins</small></div>
										</div>
										<div class="px-3 mt-4">
											<button class="btn w-100 text-white btn-plan">SELECT PLAN</button>
										</div>
										
										
									</div>
								</div>
							</div> -->
					<!-- 		<div>
								<div class="m-3" style="min-width: 228px;">
									<div class="w-100 px-0 pt-4 pb-3 bg-white rounded" style=" border-radius: 15px !important;">
										<h6 class="mt-2 px-4 font-weight-bold">Gold</h6>
										<div class="position-relative py-1">
											<hr style="border-color: #ffdfdd">
											<div class="position-absolute py-1 pl-4 pr-5 price-tag">
												<span style="font-family: none;"> &#x20B9;</span>699
											</div>
										</div>
										<div class="mt-4 pt-2 pl-4">
											<h2 class="font-weight-600 mb-0">
												<img class="d-inline" src="<?php echo base_url(); ?>assets/img/coins.png">
												15000
											</h2>
											<div class="ml-4 pl-3 mt-n2"><small>Coins</small></div>
										</div>
										<div class="px-3 mt-4">
											<button class="btn w-100 text-white btn-plan">SELECT PLAN</button>
										</div>
										
										
									</div>
								</div>
							</div> -->
						</div>
					</div>
                                    
                                    <div>
                                        <p class="text-white text-md-left text-center subscription-text mt-5">*GST Inclusive, Residents of Assam, Odisha, Telangana, Nagaland and Sikkim are not allowed to Purchase Coins</p>
                                    </div>
				</div>
			</div>
		</div>
	</div>
</div>
