<section class="slider">
			<div id="slider" class="flexslider">
				<ul class="slides">
					<?php foreach($data_content as $slider){?>
					<li>
						<img src="<?php echo base_url($slider->event_images);?>" alt="<?=$slider->event_name;?>">
						<div class="meta">
							<h3><?=$slider->event_name;?></h3>
							<div class="info">
								<p><?=$slider->event_subtitle;?></p>
							</div>
							<a href="<?php echo base_url('events/detail/'.$slider->event_slug);?>" class="btn_1 mlink">Selengkapnya</a>
						</div>
					</li>
					<?php } ?>
				</ul>
				<div id="icon_drag_mobile"></div>
			</div>
			<div id="carousel_slider_wp">
				<div id="carousel_slider" class="flexslider">
					<ul class="slides">
					<?php foreach($data_content as $slider){?>
						<li>
							<img src="<?php echo base_url($slider->event_images);?>" alt="<?=$slider->event_name;?>">
							<div class="caption">
								<h3><?=$slider->event_name;?></h3>
							</div>
						</li>
						<?php }?>
						
					</ul>
				</div>
			</div>
		</section>
		<!-- /slider -->

		<div class="features clearfix">
			<div class="container">
				<ul>
					<li><i class="pe-7s-study"></i>
						<h4>+200 courses</h4><span>Explore a variety of fresh topics</span>
					</li>
					<li><i class="pe-7s-cup"></i>
						<h4>Expert teachers</h4><span>Find the right instructor for you</span>
					</li>
					<li><i class="pe-7s-target"></i>
						<h4>Focus on target</h4><span>Increase your personal expertise</span>
					</li>
				</ul>
			</div>
		</div>
		<!-- /features -->