
            <div class="container">
                <!-- Logo container-->
                <div>
                <a href="<?php echo base_url();?>" class="mlink logo">
  
                        <img src="<?php echo base_url('assets/main/images/logo-dark.png');?>" class="l-dark" height="50" alt="Training Center">
                        <img src="<?php echo base_url('assets/main/images/logo-light.png');?>" class="l-light" height="50" alt="Training Center">
           
                    </a>
                </div>                 
                <div class="buy-button box-users">
                
    
                <div class="btn-group" role="group" aria-label="">
                    <?php
                    
                    if (!$this->ion_auth->logged_in()) {
                        $link = base_url('account/login');
                        $tooltip = 'Login or Register';
                        $icon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>';
                    } else {
                        $link = base_url('users/dashboard');
                        $tooltip = 'My Dashboard';
                        $icon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-check"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><polyline points="17 11 19 13 23 9"></polyline></svg>';
                    }

                    if(!empty($this->cart->contents())){
                        $css="px-2";
                        $count = count($this->cart->contents());
                    } else {
                        $css="";
                    }
                    ?> 
                    <a href="<?php echo $link;?>" class="btn btn-primary mlink" data-toggle="tooltip" data-placement="bottom" title="<?=$tooltip;?>"><?=$icon;?></a>
                    <a href="<?php echo base_url('events-cart');?>" class="btn btn-secondary mlink cart-btn <?php echo $css;?>" data-toggle="tooltip" data-placement="bottom" title="Click to View Cart">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                        <?php if(!empty($this->cart->contents())){ ?>
                            <span class="badge badge-pill badge-primary" id="cart-btn-count"> <?php echo $count;?></span>
                            <?php } ?>
                        </a>
                </div>
                    
                  
                </div><!--end login button-->
                <!-- End Logo container-->
                <div class="menu-extras">
                    <div class="menu-item">
                        <!-- Mobile menu toggle-->
                        <a class="navbar-toggle">
                            <div class="lines">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </a>
                        <!-- End mobile menu toggle-->
                    </div>
                </div>
        
                <div id="navigation">
                    <!-- Navigation Menu-->   
                    <ul class="navigation-menu nav-light mz-menu">
                        <li><a href="<?php echo base_url();?>">Home</a></li>
                        <li class="has-submenu">
                            <a href="javascript:void(0)">Pelatihan</a><span class="menu-arrow"></span>
                            <ul class="submenu megamenu">
                                <li>
                                    <ul>
                                    <li><a href="<?= base_url('events-type/27/e-learning');?>">E-Learning <span class="badge badge-info rounded"> New</span></a></li>
                                        <li><a href="<?= base_url('events-type/11/virtual-training');?>">Virtual Training <span class="badge badge-info rounded"> New</span></a></li>
                                        <li><a href="<?= base_url('events-type/9/inhouse-training');?>">In-House Training</a></li>
                                        <li><a href="<?= base_url('events-type/10/public-training');?>">Public Training</a></li>
                                        <li><a href="<?= base_url('events-groups/2/gosafe-academy');?>">Safety Professional</a></li>
                                        
                                    </ul>
                                </li>

                                <li>
                                    <ul>
                                    <li><a href="<?= base_url('events-groups/1/premysis-consulting');?>">Quality & EHS</a></li>
                                        <li><a href="<?= base_url('events-groups/3/food-safety-quality');?>">Food Safety-Quality</a></li>
                                        <li><a href="<?= base_url('events-groups/4/lsq-academy');?>">Leadership & Service Quality</a></li>
                                        <li><a href="<?= base_url('events-groups/5/health-care');?>">Health Care</a></li>
                                        
                                        <li><a href="<?php echo base_url('events/all-events');?>">View All Training</a></li>
                                    </ul>
                                </li>  
                            </ul>
                        </li>
                        <li><a href="<?php echo base_url('articles/all-articles');?>">Artikel</a></li>
        
                        <li><a href="<?php echo base_url('contact-us');?>">Hubungi Kami</a></li>
                    </ul><!--end navigation menu-->
                </div><!--end navigation-->
            </div><!--end container-->

		
