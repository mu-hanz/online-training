        <section id="hero_in" class="cart_section">
			<div class="wrapper">
				<div class="container">
					<div class="bs-wizard clearfix">
						<div class="bs-wizard-step active">
							<div class="text-center bs-wizard-stepnum">Your cart</div>
							<div class="progress">
								<div class="progress-bar"></div>
							</div>
							<a href="#0" class="bs-wizard-dot"></a>
						</div>

						<div class="bs-wizard-step disabled">
							<div class="text-center bs-wizard-stepnum">Payment</div>
							<div class="progress">
								<div class="progress-bar"></div>
							</div>
							<a href="#0" class="bs-wizard-dot"></a>
						</div>

						<div class="bs-wizard-step disabled">
							<div class="text-center bs-wizard-stepnum">Finish!</div>
							<div class="progress">
								<div class="progress-bar"></div>
							</div>
							<a href="#0" class="bs-wizard-dot"></a>
						</div>
					</div>
					<!-- End bs-wizard -->
				</div>
			</div>
		</section>
        <!--/hero_in-->
        
        <div class="bg_color_1">
			<div class="container margin_60_35">
				<div class="row">
					<div class="col-lg-9">
						<div class="box_cart">
							<h3 class="text-center <?php if ($status_shopping_cart != 'Empty') { ?> cart-is-empty <?php } ?>"><i class="icon-cart"></i> <i>Cart Is Empty</i></h3>
							<div id="loader-blur"></div>
							<div id="box-blur">
								<input type="hidden" id="csrftoken" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
								<?php
								if ($status_shopping_cart != 'Empty') {
								?> 
									<table class="table table-striped cart-list">
										<thead>
											<tr>
												<th>
													Item
												</th>
												<th class="column-qty-shopping-cart">
													Qty
												</th>
												<th>
													Price
												</th>
												<th>
													Actions
												</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$no = 1;
											$global_voucher = '';
											foreach ($list_shopping_cart_detail as $row) {
											if ($row->status_voucher == 'Available') {
												$global_voucher = 'Redi';
											} else {
												$global_voucher = 'Not';
											}
											?>
											<tr>
												<td>
													<div class="container-thumb-cart-custom">
														<div class="thumb_cart">
															<img src="<?php echo base_url(); ?><?=substr($row->thumbs_event,1);?>" alt="Image" class="custom">
														</div>
													</div>
													<div class="container-item-cart-custom">
														<span class="item_cart m-0"><?=$row->name_event;?></span><br>
														@
														<?php
														if ($row->cost_campaign_promo == '0') { ?>
															<?php if ($row->cost_promo_event != '0') { ?>
																<?=rupiah($row->cost_promo_event);?>
															<?php } else { ?>
																<?=rupiah($row->cost_event);?>
															<?php } ?>		
														<?php } else { ?>
															<?=rupiah($row->cost_campaign_promo);?>
														<?php } ?><br>

														<?php
														if ($row->cost_promo_event != '0' || $row->cost_campaign_promo != '0') {
														?>
															<?php
															$discount_product = 100 - percent1($row->cost_promo_event, $row->cost_event); 
															?>
															<span class="discount-info-custom">
																<s><?=rupiah($row->cost_event);?></s>
																<?php if ($row->cost_promo_event != '0') { ?> <?=$discount_product;?>% Discount <?php } ?>

																<?php if ($row->cost_campaign_promo == '0') {

																} else { ?>
																	<?php if ($row->cost_promo_event != '0') { ?> + <?php } ?> 
																	
																	<?php if ($row->cost_promo_event != '0') { ?>
																	<?php
																	$discount_campaign = 100 - percent1($row->cost_campaign_promo, $row->cost_promo_event);
																	?>
																	<?=$discount_campaign;?>% discount campaign 
																<?php } else { ?>
																	<?php
																	$discount_campaign = 100 - percent1($row->cost_campaign_promo, $row->cost_event);
																	?>
																	<?=$discount_campaign;?>% discount campaign 
																<?php } ?>
																<?php } ?>
															</span>
														<?php } ?>
													</div>
													<div class="clearfix"></div>
												</td>
												<td>
													<span class="input">
														<input class="input_field m-0 qty-sc" value="<?=$row->qty;?>" type="text" id="<?=$row->id;?>">
														<label class="input_label">
															<span class="input__label-content"></span>
														</label>
													</span>
												</td>
												<td class="text-right">
													<?php
													if ($row->cost_campaign_promo != '0') {
														$price_event = $row->qty*$row->cost_campaign_promo;
													} else if ($row->cost_promo_event != '0' && $row->cost_campaign_promo == '0') {
														$price_event = $row->qty*$row->cost_promo_event;
													} else if ($row->cost_event != '0' && $row->cost_promo_event == '0' && $row->cost_campaign_promo == '0') {
														$price_event = $row->qty*$row->cost_event;
													}
													?>
													<span id="price_event<?=$row->id;?>"><?=rupiah($price_event);?></span>
													<input type="hidden" name="input_price_event" value="<?=$price_event;?>" id="input_price_event<?=$row->id;?>" class="input_price_event">
													<input type="hidden" name="input_status_voucher" value="<?=$row->status_voucher;?>" class="input_status_voucher">
												</td>
												<td class="options" style="width:5%; text-align:center;">
													<a class="delete-row-shopping-cart" id="<?=$row->id;?>"><i class="icon-trash"></i></a>
												</td>
											</tr>
											
											<?php $no++; } ?>
										</tbody>
									</table>
									<div class="cart-options clearfix">
										<div class="float-left">
											<div class="apply-coupon">
												<div class="form-group">
													<input type="hidden" id="status_voucher" value="<?=$voucher;?>">
													<input type="hidden" id="id_shopping_cart" value="<?=$id_shopping_cart;?>">
													<input type="text" name="coupon-code" id="coupon_code" value="" placeholder="Your Coupon Code" class="form-control">
												</div>
												<div class="form-group">
													<button type="button" id="check-coupon-code" class="btn_1 outline">Apply Coupon</button>
												</div><br>
												<span class="alert-voucher"><i></i></span>
											</div>
										</div>
										<!-- <div class="float-right fix_mobile">
											<button type="button" class="btn_1 outline">Update Cart</button>
										</div> -->
									</div>
								<?php } ?>
							</div>
							<!-- /cart-options -->
						</div>
					</div>
					<!-- /col -->
					
					<aside class="col-lg-3" id="sidebar">
						<div class="box_detail">
							<div class="add_bottom_30">
								Sub Total :
								<span class="float-right" id="sub-total-shopping-cart"></span>
								<input type="hidden" name="name_sub-total-shopping-cart" id="id_sub-total-shopping-cart"><br>
								<?php if ($status_shopping_cart != 'Empty') { ?>
									<!-- <div class="container-discount-collectible-voucher"> -->
									<div class="container-discount-collectible-voucher <?php if ($status_collectible_voucher != 'Found' OR $discount_collectible_voucher == '0') { ?> display-none <?php } ?>">
										Diskon Collectible Voucher : 
										<span class="float-right" id="discount-collectible-voucher-shopping-cart"><?=rupiah($discount_collectible_voucher);?></span>
										<input type="hidden" name="id_collectible_voucher" id="id_collectible_voucher" value="<?=$id_collectible_voucher;?>">
										<input type="hidden" name="name_discount_collectible_voucher-shopping-cart" id="id-discount-collectible-voucher-shopping-cart" value="<?=$discount_collectible_voucher;?>">
										<input type="hidden" name="name_limit_discount_collectible_voucher-shopping-cart" class="discount-limit-collectible-voucher-shopping-cart" value="<?=$limit_collectible_voucher;?>">
										<!-- Menyimpan Value Pertama Collectible Voucher Untuk Mengantisipasi Perubahan Value Qty Event -->
										<input type="hidden" name="first_name_discount_collectible_voucher-shopping-cart" id="first-discount-collectible-voucher-shopping-cart" value="<?=$discount_collectible_voucher;?>">
									</div>
									<span class="container-discount-voucher">Diskon Voucher : 
										<span class="float-right" id="discount-voucher-shopping-cart"></span>
										<input type="text" name="name_discount_voucher-shopping-cart" id="id-discount-voucher-shopping-cart">
									</span>
								
								<?php } ?>
							</div>
							<div id="total_cart">
								Total <span class="float-right">69.00$</span>
							</div>
							<a href="cart-2.html" class="btn_1 full-width">Checkout</a>
							<a href="courses-grid-sidebar.html" class="btn_1 full-width outline"><i class="icon-right"></i> Continue Shopping</a>
						</div>
					</aside>
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /bg_color_1 -->