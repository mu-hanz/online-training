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
							<?=rupiah($event->event_cost_promo);?><span class="original_price"><br><em class="m-0"><?=rupiah($event->event_cost);?></em> <?=percent1($event->event_cost_promo, $event->event_cost);?>% discount</span>
							</div>
							<a href="#0" class="btn_1 full-width">Register Event</a>
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
						</div>
					</aside>
							<?php } ?>
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /bg_color_1 -->