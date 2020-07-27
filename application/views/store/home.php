<div class="container-fluid margin_120_0">
			<div class="main_title_2">
				<span><em></em></span>
				<h2>Training Terpopuler</h2>
				<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
			</div>
			<div id="reccomended" class="owl-carousel owl-theme">
			<?php foreach($event_popular as $pop){?>
				<div class="item">
					<div class="box_grid">
						<figure>
							
							<a href="<?php echo base_url('events/detail/'.$pop->event_slug);?>" class="mlink">
								<div class="preview"><span>Lihat Training</span></div><img src="<?php echo base_url($pop->event_thumbs);?>" class="img-fluid" alt="<?=$pop->event_name;?>"></a>
							

						</figure>
						<div class="wrapper">
							<small><?=$pop->group_name;?></small>
							<h3><?=$pop->event_name;?></h3>
						</div>
						<ul>
							<li><i class="icon_shield_alt  text-primary"></i> <?=$pop->cert_name;?></li>
							<li><a href="<?php echo base_url('events/detail/'.$pop->event_slug);?>" class="mlink">View Detail</a></li>
						</ul>
					</div>
				</div>
				<?php }?>

			</div>
			<!-- /carousel -->
			<div class="container">
				<p class="btn_home_align"><a href="<?php echo base_url('events/all-events');?>" class="btn_1 rounded">View all courses</a></p>
			</div>
			<!-- /container -->
			<hr>
		</div>
		<!-- /container -->

		<div class="container margin_30_95">
			<div class="main_title_2">
				<span><em></em></span>
				<h2>Training Kategori</h2>
				<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
			</div>
			<div class="row">
				<div class="col-lg-4 col-md-6 wow" data-wow-offset="150">
					<a href="#0" class="grid_item">
						<figure class="block-reveal">
							<div class="block-horizzontal"></div>
							<img src="<?php echo base_url('assets/store/img/safety.jpg');?>" class="img-fluid" alt="">
							<div class="info">
								<small><i class="ti-layers"></i>15 Pelatihan</small>
								<h3>Safety Profesional</h3>
							</div>
						</figure>
					</a>
				</div>
				<!-- /grid_item -->
				<div class="col-lg-4 col-md-6 wow" data-wow-offset="150">
					<a href="#0" class="grid_item">
						<figure class="block-reveal">
							<div class="block-horizzontal"></div>
							<img src="<?php echo base_url('assets/store/img/quality.jpg');?>" class="img-fluid" alt="">
							<div class="info">
								<small><i class="ti-layers"></i>23 Pelatihan</small>
								<h3>Quality & EHS</h3>
							</div>
						</figure>
					</a>
				</div>
				<!-- /grid_item -->
				<div class="col-lg-4 col-md-6 wow" data-wow-offset="150">
					<a href="#0" class="grid_item">
						<figure class="block-reveal">
							<div class="block-horizzontal"></div>
							<img src="<?php echo base_url('assets/store/img/food.jpg');?>" class="img-fluid" alt="">
							<div class="info">
								<small><i class="ti-layers"></i>23 Pelatihan</small>
								<h3>Food Safety-Quality</h3>
							</div>
						</figure>
					</a>
				</div>
				<!-- /grid_item -->
				<div class="col-lg-4 col-md-6 wow" data-wow-offset="150">
					<a href="#0" class="grid_item">
						<figure class="block-reveal">
							<div class="block-horizzontal"></div>
							<img src="<?php echo base_url('assets/store/img/leadership.jpg');?>" class="img-fluid" alt="">
							<div class="info">
								<small><i class="ti-layers"></i>23 Pelatihan</small>
								<h3>Leadership & Service Quality</h3>
							</div>
						</figure>
					</a>
				</div>
				<!-- /grid_item -->
				<div class="col-lg-4 col-md-6 wow" data-wow-offset="150">
					<a href="#0" class="grid_item">
						<figure class="block-reveal">
							<div class="block-horizzontal"></div>
							<img src="<?php echo base_url('assets/store/img/healthcare.jpg');?>" class="img-fluid" alt="">
							<div class="info">
								<small><i class="ti-layers"></i>23 Pelatihan</small>
								<h3>Health Care Training</h3>
							</div>
						</figure>
					</a>
				</div>
				<!-- /grid_item -->
				<div class="col-lg-4 col-md-6 wow" data-wow-offset="150">
					<a href="#0" class="grid_item">
						<figure class="block-reveal">
							<div class="block-horizzontal"></div>
							<img src="<?php echo base_url('assets/store/img/onlinetraining.jpg');?>" class="img-fluid" alt="">
							<div class="info">
								<small><i class="ti-layers"></i>23 Pelatihan</small>
								<h3>Virtual Training</h3>
							</div>
						</figure>
					</a>
				</div>
				<!-- /grid_item -->
			</div>
			<!-- /row -->
		</div>
		<!-- /container -->

		<div class="bg_color_1">
			<div class="container margin_120_95">
				<div class="main_title_2">
					<span><em></em></span>
					<h2>Artikel Terbaru</h2>
					<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
				</div>
				<div class="row">
				<?php foreach($data_articles as $articles){?>
					<div class="col-lg-6">
						<a class="box_news mlink" href="<?php echo base_url('articles/detail/'.$articles->post_slug);?>">
							<figure><img src="<?php echo base_url($articles->post_image);?>" alt="<?=$articles->post_title;?>">
								<figcaption><strong><?php echo date("d", strtotime($articles->post_date));?></strong><?php echo date("M", strtotime($articles->post_date));?></figcaption>
							</figure>
							<h4><?php $post_title = strip_tags($articles->post_title); echo character_limiter($post_title, 100);?></h4>
							<ul>
								<li>Publish on</li>
								<li><?php echo date("d M Y H:i", strtotime($articles->post_date));?> </li>
							</ul>
							<p><?php $content = strip_tags($articles->post_content); echo character_limiter($content, 100);?></p>
						</a>
					</div>
				<?php } ?>
				</div>
				<!-- /row -->
				<p class="btn_home_align"><a href="<?php echo base_url('articles/all-articles');?>" class="btn_1 rounded">View all news</a></p>
			</div>
			<!-- /container -->
		</div>
		<!-- /bg_color_1 -->

		<div class="bg_color_1">
			<div class="container margin_60_35">
				<div class="row">
					<div class="col-md-4">
						<a href="#0" class="boxed_list">
							<i class="pe-7s-help2"></i>
							<h4>Need Help? Contact us</h4>
							<p>Cum appareat maiestatis interpretaris et, et sit.</p>
						</a>
					</div>
					<div class="col-md-4">
						<a href="#0" class="boxed_list">
							<i class="pe-7s-wallet"></i>
							<h4>Payments and Refunds</h4>
							<p>Qui ea nemore eruditi, magna prima possit eu mei.</p>
						</a>
					</div>
					<div class="col-md-4">
						<a href="#0" class="boxed_list">
							<i class="pe-7s-note2"></i>
							<h4>Quality Standards</h4>
							<p>Hinc vituperata sed ut, pro laudem nonumes ex.</p>
						</a>
					</div>
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>