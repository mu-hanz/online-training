<section id="hero_in" class="courses"  style="background:url(<?php echo base_url('assets/store/img/landing-bg.jpg');?>) center center no-repeat">
			<div class="wrapper">
				<div class="container">
					<h1 class="fadeInUp"><span></span>Semua Artikel</h1>
				</div>
			</div>
		</section>
		<!--/hero_in-->

		<div class="container margin_60_35">
			<div class="row" id="data-event">

			<?php foreach($articles as $data){?>
				<div class="col-xl-4 col-lg-6 col-md-6">
					<div class="box_grid wow">
					<figure class="block-reveal blog-grid">	
						<a href="<?php echo base_url('articles/detail/'.$data->post_slug);?>" class="mlink">
							<img src="<?php echo base_url($data->post_image);?>" class="img-fluid blog-grid-img" alt="<?=$data->post_title;?>">
						</a>
						</figure>
						<div class="wrapper">
							<small><i class="icon_folder-alt"></i>  <?=$data->name;?></small> <small><i class="icon_clock_alt"></i>  <?php echo date("d M Y H:i", strtotime($data->post_date));?></small>
							<a href="<?php echo base_url('articles/detail/'.$data->post_slug);?>" class="mlink"><h4 class="event-name1 mt-2"><?php $post_title = strip_tags($data->post_title); echo character_limiter($post_title, 100);?></h4></a>
							<p><?php $content = strip_tags($data->post_content); echo character_limiter($content, 100);?></p>
						</div>
					</div>
				</div>
				<?php }?>
			</div>

			<!-- /row -->
			<p class="text-center">
			<button class="btn_1 rounded add_top_30" type="button" data-page="1" id="loadmore">
				Load More
			</button>
			
			</p>
		</div>
		<!-- /container -->