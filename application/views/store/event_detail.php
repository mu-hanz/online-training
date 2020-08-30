<section id="hero_in" class="courses" style="background:url(<?php echo base_url($event->event_images);?>) center center no-repeat">
			<div class="wrapper">
				<div class="container">
					<h1 class="fadeInUp"><span></span><?=$event->event_name;?></h1>
				</div>
			</div>
		</section>
		<!--/hero_in-->

		<div class="bg_color_1">
			<div class="container margin_60_35">
				<div class="row">
					<div class="col-lg-<?php echo ($event->event_register == '1' ? '12' : "8") ;?>">
						<section id="description">
						
						<div class="event-detail"><?php echo htmlspecialchars_decode(stripslashes($event->post_content)); ?></div>
							<!-- /row -->
						</section>
						<!-- /section -->
					</div>
					<!-- /col -->
					
					<?php if($event->event_register == '0'){?>
					<aside class="col-lg-4" id="sidebar">
						<div class="box_detail">
							<?php if($event->event_video != null){ ?>
							<figure>
								<a href="<?=$event->event_video;?>" class="video"><i class="arrow_triangle-right"></i><img src="<?php echo base_url($event->event_thumbs);?>" alt="" class="img-fluid"><span>View course preview</span></a>
							</figure>
							<?php } ?>
							<div class="price">
							<?php
							if ($count_campaign == '0') { ?>
								<?php if ($event->event_cost_promo != '0') { ?>
									<?=rupiah($event->event_cost_promo);?>
								<?php } else { ?>
									<?=rupiah($event->event_cost);?>
								<?php } ?>		
							<?php } else { ?>
								<?=rupiah($campaign->price_campaign);?>
							<?php } ?>
							<span class="original_price">
							<br>
							<ul class="bullets mb-0 mt-2">
								<li>
									<?php
									if ($event->event_cost_promo != '0' || $count_campaign != '0') {
									?>
									<em class="m-0"><?=rupiah($event->event_cost);?></em> 
									<?php } ?>
									
									<?php
									if ($event->event_cost_promo != '0') {
									?>
										<?php
										$discount_product = 100 - percent1($event->event_cost_promo, $event->event_cost); 
										?>
										<?=$discount_product;?>% discount 
									<?php } ?>

									<?php 
									if ($count_campaign == '0') { 
									?> 
									<?php 
									} else { 
									?> 
										<?php if ($event->event_cost_promo != '0') { ?> + <?php } ?> 
										
										<?php if ($event->event_cost_promo != '0') { ?>
											<?php
											$discount_campaign = 100 - percent1($campaign->price_campaign, $event->event_cost_promo);
											?>
											<?=$discount_campaign;?>% discount campaign 
										<?php } else { ?>
											<?php
											$discount_campaign = 100 - percent1($campaign->price_campaign, $event->event_cost);
											?>
											<?=$discount_campaign;?>% discount campaign 
										<?php } ?>
									<?php } ?></li>
										
										<?php if ($flexi_combo != '0') {
										?>
											<?php
											foreach ($flexi_combo_tier as $row) {
											?>
												<li>Buy 
												<?php if ($row->criteria_qty != '0') { ?>
													<?=$row->criteria_qty;?>
												<?php } else { ?>
													<?=rupiah($row->criteria_price);?>
												<?php } ?>
												,
												<?php if ($row->discount_percent != '0') { ?>
													<?=$row->discount_percent;?>%
												<?php } else { ?>
													<?=rupiah($row->discount_price);?>
												<?php } ?> discount</li>
												
											<?php } ?>
									<?php 
									} 
									?>
							</ul>
							</span>
							</div>
							<?php if ($this->ion_auth->logged_in()) { ?>
									
							<?php } else { ?>
									<form method="post" action="<?php echo base_url(); ?>shopping-cart/save">
										<input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
										<input type="hidden" name="id_event" value="<?=$event->event_id;?>">
										<input type="hidden" name="id_user" class="id_user" value="1">
										<input type="hidden" name="qty_event" value="1">
										<?php if ($count_campaign != '0') { ?>
										<input type="hidden" name="cost_campaign_promo" value="<?=$campaign->price_campaign;?>">
										<?php } ?>
										<button type="submit" class="btn_1 full-width">Register Event</button>
									</form>
									<!-- <a href="#" data-effect="mfp-zoom-in" class="btn_1 full-width login">Register Event</a> -->
							<?php } ?>
							<a href="#0" class="btn_1 full-width outline"><i class="icon_heart"></i> Add to wishlist</a>
							<div id="list_feat">
								<h3>What's includes</h3>
								<ul>
									<li><i class="icon_mobile"></i>Mobile support</li>
									<li><i class="icon_archive_alt"></i>Lesson archive</li>
									<li><i class="icon_mobile"></i>Mobile support</li>
									<li><i class="icon_chat_alt"></i>Tutor chat</li>
									<li><i class="icon_document_alt"></i>Course certificate</li>
								</ul>
							</div>
							<?php if ($count_collectible_voucher != '0') {
							?>
								<h3>Collectible Voucher</h3>
								<div class="alert alert-success display-none" role="alert">
									Voucher akan otomatis ditambahan pada keranjang belanja.
								</div>
								<div class="alert alert-danger display-none" role="alert">
									Voucher gagal tersimpan, silahkan ulangi kembali.
								</div>
								<?php foreach ($list_collectible_voucher as $row) {
								?>
								<div class="container container-collectible-voucher p-3" id="<?=$row->promotions_id;?>">
									<div class="row">
										<div class="col-12">
											<div class="row">
												<div class="col-12 pt-1">
													<div class="f13 bold text-center border-bottom-1 border-white text-white pb-1"><h6 class="text-white"><?=$row->promotions_name;?></h6></div>
												</div>
											</div>
											<div class="row">
												<div class="col-12 text-center mb-1 mt-1">
													<?php
													if ($row->type_discount == 'nominal') {
													?>
														<h6 class="text-white m-1">Belanja Min <?=rupiah($row->nominal_limit);?>, <br>Diskon <?=rupiah($row->nominal_discount);?></h6>
													<?php } else { ?>
														<h6 class="text-white m-1">Belanja Min <?=rupiah($row->percent_limit);?>, <br>Diskon <?=$row->percent_discount;?>% / <br>Max Diskon <?=rupiah($row->percent_max_discount);?></h6>
													<?php } ?>
												</div>
											</div>
											<div class="row bg-light mb-2">
												<div class="col-6 p-1 text-dark">
													<div class="f10 pl-2">Berlaku dari</div>
													<div class="f10 pl-2">Sampai</div>
												</div>
												<div class="col-6 p-1 text-dark">
													<div class="f10"><span class="pr-2">:</span><?=date('d-m-Y',strtotime($row->start_date));?></div>
													<div class="f10"><span class="pr-2">:</span><?=date('d-m-Y',strtotime($row->end_date));?></div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<?php } ?>
							<?php } ?>
						</div>
					</aside>
							<?php } ?>
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /bg_color_1 -->