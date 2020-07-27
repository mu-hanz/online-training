
<section id="hero_in" class="courses" style="background:url(<?php echo base_url($articles->post_image);?>) center center no-repeat">
	<div class="wrapper">
		<div class="container">
			<h1 class="fadeInUp title-blog"><span></span><?=$articles->post_title;?></h1>
		</div>
	</div>
</section>
<!--/hero_in-->

<div class="container margin_60_35">
	<div class="row">
		<div class="col-lg-9">
			<div class="bloglist singlepost">
				<div class="postmeta">
					<ul>
						<li><a href="<?php echo base_url('articles/category/'.$articles->slug);?>"><i class="icon_folder-alt"></i> <?=$articles->name;?></a></li>
						<li><a><i class="icon_clock_alt"></i> <?php echo date("d M Y H:i", strtotime($articles->post_date));?></a></li>
						<li><a><i class="icon_pencil-edit"></i> By. <?=$articles->first_name;?></a></li>
					</ul>
				</div>
				<!-- /post meta -->
				<div class="post-content">
					<div class="dropcaps">
					<?php echo htmlspecialchars_decode(stripslashes($articles->post_content)); ?>
					</div>
				</div>
				<!-- /post -->
			</div>
			<!-- /single-post -->
		</div>
		<!-- /col -->

		<aside class="col-lg-3 sideblog"  id="sidebar">
			<div class="widget">
				<form>
				<div class="input-group mb-3">
				<input type="text" class="form-control" placeholder="Search..." aria-label="Search..." aria-describedby="basic-addon2">
				<div class="input-group-append">
					<button class="btn btn-primary" type="submit"><i class="icon-search"></i></button>
				</div>
				</div>
					
				</form>
			</div>
			<!-- /widget -->
			<div class="widget">
				<div class="widget-title">
					<h4>Recent Articles</h4>
				</div>
				<ul class="comments-list">
					<?php foreach($data_articles as $articles){?>
						<li>
							<div class="alignleft">
								<a href="<?php echo base_url('articles/detail/'.$articles->post_slug);?>" class="mlink"><img src="<?php echo base_url($articles->post_image);?>" alt=""></a>
							</div>
							<small><?php echo date("d M Y H:i", strtotime($articles->post_date));?></small>
							<h3><a  class="mlink" href="<?php echo base_url('articles/detail/'.$articles->post_slug);?>" title="<?=$articles->post_title;?>"><?php $post_title = strip_tags($articles->post_title); echo character_limiter($post_title, 30);?></a></h3>
						</li>
					<?php } ?>
					
				</ul>
			</div>
			<!-- /widget -->
			<div class="widget">
				<div class="widget-title">
					<h4>Articles Categories</h4>
				</div>
				<ul class="cats">
				<?php foreach ($data_category as $category):?>
					<li><a  class="mlink" href="<?php echo base_url('articles/category/'.$category->slug);?>"><?=$category->name;?> <span>(<?=$category->count;?>)</span></a></li>
				<?php endforeach; ?>
				</ul>
			</div>
			<!-- /widget -->
		</aside>
		<!-- /aside -->
	</div>
	<!-- /row -->
</div>
<!-- /container -->
