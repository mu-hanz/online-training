<section id="hero_in" class="courses"  style="background:url(<?php echo base_url('assets/store/img/landing-bg.jpg');?>) center center no-repeat">
			<div class="wrapper">
				<div class="container">
					<h1 class="fadeInUp"><span></span>Online courses</h1>
				</div>
			</div>
		</section>
		<!--/hero_in-->
		<div class="filters_listing sticky_horizontal">
			<div class="container">
				<ul class="clearfix">
					<li>
						<div class="switch-field">
							<input type="radio" id="all" name="listing_filter" value="all" checked>
							<label for="all">All</label>
							<input type="radio" id="popular" name="listing_filter" value="popular">
							<label for="popular">Popular</label>
							<input type="radio" id="latest" name="listing_filter" value="latest">
							<label for="latest">Latest</label>
						</div>
					</li>
					<li>
						<select name="orderby" class="selectbox">
							<option value="category">Semua Kategori</option>
							<option value="category">ISO</option>
							<option value="category 2">Safety</option>
							<option value="category 3">Food Safety</option>
							<option value="category 4">Health</option>
							</select>
					</li>
				</ul>
			</div>
			<!-- /container -->
		</div>
		<!-- /filters -->

		<div class="container margin_60_35">
			<div class="row" id="data-event">

			<?php foreach($event as $data){?>
				<div class="col-xl-4 col-lg-6 col-md-6">
					<div class="box_grid wow">
					<figure class="block-reveal">	
					<div class="block-horizzontal"></div>
						<a href="<?php echo base_url('events/detail/'.$data->event_slug);?>" class="mlink">
							<div class="preview"><span>Lihat Training</span></div><img src="<?php echo base_url($data->event_thumbs);?>" class="img-fluid" alt="<?=$data->event_name;?>">
						</a>
						</figure>
						<div class="wrapper">
							<small><?=$data->group_name;?></small>
							<h4 class="event-name"><?=$data->event_name;?></h4>
						</div>
						<ul>
							<li><i class="icon_shield_alt  text-primary"></i> <?=$data->cert_name;?></li>
							<li><a href="<?php echo base_url('events/detail/'.$data->event_slug);?>" class="mlink">View Detail</a></li>
						</ul>
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
		<!-- /bg_color_1 -->