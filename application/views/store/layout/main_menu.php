
		<div id="logo">
			<a href="<?php echo base_url();?>" class="mlink"><img src="<?php echo base_url('assets/store/img/logo.png');?>" width="149" height="42" data-retina="true" alt=""></a>
		</div>
		<ul id="top_menu">
			<li><a href="#" data-effect="mfp-zoom-in" class="cart">Cart</a></li>
			<?php  if (!$this->ion_auth->logged_in()){?>
				<li><a href="#" class="loginpop login" data-id="1">Login</a></li>
			<?php } else { ?>
				<li><a href="<?php echo base_url('users/dashboard');?>" class="login">Dashboard</a></li>
				<li><a href="<?php echo base_url('webadmin/auth/auth/logout');?>" class="logout">Logout</a></li>
			<?php } ?>

			<li><a href="#0" class="search-overlay-menu-btn">Search</a></li>
			<li class="hidden_tablet"><a href="admission.html" class="btn_1 rounded">Hubungi</a></li>
		</ul>
		<!-- /top_menu -->
		<a href="#menu" class="btn_mobile">
			<div class="hamburger hamburger--spin" id="hamburger">
				<div class="hamburger-box">
					<div class="hamburger-inner"></div>
				</div>
			</div>
		</a>
		<nav id="menu" class="main-menu">
			<ul class="mz-menu">
				<li><span><a href="<?php echo base_url();?>">Home</a></span></li>
				<li><span><a href="#0">Program Pelatihan</a></span>
					<ul>
						<li><a href="courses-grid.html">Safety Professional</a></li>
						<li><a href="courses-grid-sidebar.html">Quality & EHS</a></li>
						<li><a href="courses-list.html">Food Safety-Quality</a></li>
						<li><a href="courses-list-sidebar.html">Leadership & Service Quality</a></li>
						<li><a href="course-detail.html">Health Care Training</a></li>
                        <li><a href="course-detail-2.html">Virtual Training</a></li>
					</ul>
				</li>
				<li><span><a href="#0">Tentang Kami</a></span></li>
				<li><span><a href="<?php echo base_url('articles/all-articles');?>">Artikel</a></span></li>
			</ul>
		</nav>
		<!-- Search Menu -->
		<div class="search-overlay-menu">
			<span class="search-overlay-close"><span class="closebt"><i class="ti-close"></i></span></span>
			<form role="search" id="searchform" method="get">
				<input value="" name="q" type="search" placeholder="Search..." />
				<button type="submit"><i class="icon_search"></i>
				</button>
			</form>
		</div><!-- End Search Menu -->


