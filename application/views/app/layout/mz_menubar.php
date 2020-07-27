<div class="topnav shadow-sm">
                <div class="container-fluid">
                    <nav class="navbar navbar-light navbar-expand-lg topbar-nav">
                        <div class="collapse navbar-collapse" id="topnav-menu-content">
                            <ul class="metismenu mz-menu" id="menu-bar">
                                <li class="menu-title">Navigation</li>

                                <li>
                                    <a href="<?php echo base_url('webadmin');?>">
                                        <i data-feather="home"></i>
                                        <span class="badge badge-success float-right">1</span>
                                        <span> Dashboard </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url('webadmin/dashboard/starter');?>">
                                        <i data-feather="shopping-cart"></i>
                                        <span class="badge badge-success float-right">1</span>
                                        <span> Manage Order </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript: void(0);">
                                        <i data-feather="calendar"></i>
                                        <span> Events </span>
                                        <span class="menu-arrow"></span>
                                    </a>
    
                                    <ul class="nav-second-level" aria-expanded="false">
                                        <li>
                                            <a href="<?php echo base_url('webadmin/posts/events/create');?>"> Create Event</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url('webadmin/posts/events/content');?>">Create Content</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url('webadmin/posts/events/list_event');?>">List Events</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url('webadmin/posts/events/list_content');?>">List Content</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url('webadmin/posts/terms/create/groups');?>">Groups</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url('webadmin/posts/terms/create/events');?>">Category</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url('webadmin/posts/terms/create/events-type');?>">Type</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url('webadmin/posts/terms/create/certification');?>">Certificate</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url('webadmin/posts/terms/create/location');?>">Location</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url('webadmin/posts/terms/create/regional');?>">Regional</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="javascript: void(0);">
                                        <i data-feather="package"></i>
                                        <span> Products </span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <ul class="nav-second-level" aria-expanded="false">
                                        <li>
                                            <a href="<?php echo base_url('webadmin/products/products/create');?>">Add new</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url('webadmin/products/products');?>">List Products</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url('webadmin/posts/terms/create/products');?>">Category</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="javascript: void(0);">
                                        <i data-feather="file-text"></i>
                                        <span> Articles </span>
                                        <span class="menu-arrow"></span>
                                    </a>
    
                                    <ul class="nav-second-level" aria-expanded="false">
                                        <li>
                                            <a href="<?php echo base_url('webadmin/posts/articles/create');?>">Add new</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url('webadmin/posts/articles/list');?>">List Articles</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url('webadmin/posts/terms/create/articles');?>">Category</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="javascript: void(0);">
                                        <i data-feather="bookmark"></i>
                                        <span> Pages </span>
                                        <span class="menu-arrow"></span>
                                    </a>
    
                                    <ul class="nav-second-level" aria-expanded="false">
                                        <li>
                                            <a href="<?php echo base_url('webadmin/posts/pages/create');?>">Add Pages</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url('webadmin/posts/pages/list');?>">List Pages</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="javascript: void(0);">
                                        <i data-feather="volume-2"></i>
                                        <span> Promotion </span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <ul class="nav-second-level" aria-expanded="false">
                                        <li>
                                            <a href="<?=base_url();?>webadmin/promotions/campaign">Campaign</a>
                                        </li>
                                        <li>
                                            <a href="<?=base_url();?>webadmin/promotions/voucher">Voucher</a>
                                        </li>
                                        <li>
                                            <a href="<?=base_url();?>webadmin/promotions/flexi_combo">Flexi Combo</a>
                                        </li>
                                        <li>
                                            <a href="<?=base_url();?>webadmin/promotions/slider">Slider</a>
                                        </li>
                                        <li>
                                            <a href="<?=base_url();?>webadmin/promotions/banner">Banner</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="javascript: void(0);">
                                        <i data-feather="archive"></i>
                                        <span> Reports </span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <ul class="nav-second-level" aria-expanded="false">
                                        <li>
                                            <a href="#">Orders</a>
                                        </li>
                                        <li>
                                            <a href="#">Referals</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>