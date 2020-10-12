<!-- Hero Start -->
<section class="bg-half bg-blog  w-100 bg-info" style="background: url('<?php echo base_url('assets/main/images/account/bg.png');?>') center center;">
<div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-12 text-center">
                        <div class="page-next-level">
                            <h4 class="title text-light">Artikel</h4>
                        </div>
                    </div><!--end col-->
                </div><!--end row-->
            </div>
</section><!--end section-->
<!-- Blog Start -->
<section class="section">
            <div class="container">
                <div class="row">
                    <!-- BLog Start -->
                    <div class="col-lg-8 col-md-6">
                        <div class="row">

                        <?php foreach($data_articles as $articles){?>
                            <div class="col-lg-6 col-md-12 mb-4 pb-2">
                                <div class="card blog rounded border-0 shadow">
                                    <div class="position-relative">
                                        <img src="<?php echo base_url($articles->post_image);?>" class="card-img-top rounded-top img-blog">
                                    <div class="overlay rounded-top bg-dark"></div>
                                    </div>
                                    <div class="card-body content">
                                        <h5><a href="<?php echo base_url('articles/detail/'.$articles->post_slug);?>" class="card-title title text-dark mlink"><?php $post_title = strip_tags($articles->post_title); echo character_limiter($post_title, 100);?></a></h5>
                                        <div class="post-meta d-flex justify-content-between mt-3">
                                            <ul class="list-unstyled mb-0">
                                                <li class="list-inline-item mr-2 mb-0"><a href="javascript:void(0)" class="text-muted like"><i class="mdi mdi-eye-outline mr-1"></i><?= $articles->post_view;?></a></li>
                                            </ul>
                                            <a href="<?php echo base_url('articles/detail/'.$articles->post_slug);?>" class="text-muted readmore mlink">Read More <i class="mdi mdi-chevron-right"></i></a>
                                        </div>
                                    </div>
                                    <div class="author">
                                        <small class="text-light date"><i class="mdi mdi-calendar-check"></i><?php echo date("d M Y", strtotime($articles->post_date));?></small>
                                    </div>
                                </div>
                            </div><!--end col-->
                            <?php } ?>

        
                            <!-- PAGINATION START -->
                            <div class="col-12 pt-5 mt-5">
                                <?php echo $this->pagination->create_links();?>
                            </div><!--end col-->
                            <!-- PAGINATION END -->
                        </div><!--end row-->
                    </div><!--end col-->
                    <!-- BLog End -->

                    <!-- START SIDEBAR -->
                    <div class="col-lg-4 col-md-6 col-12 mt-4 mt-sm-0 pt-2 pt-sm-0">
                        <div class="card border-0 sidebar sticky-bar rounded shadow">
                            <div class="card-body">

                                <!-- RECENT POST -->
                                <div class="widget mb-4 pb-2">
                                    <h4 class="widget-title">Artikel Populer</h4>
                                    <div class="mt-4">
                                    <?php foreach($popular_articles as $articles){?>
                                        <div class="clearfix post-recent">
                                            <div class="post-recent-thumb float-left"> <a href="<?php echo base_url('articles/detail/'.$articles->post_slug);?>" class="mlink"> <img alt="img" src="<?php echo base_url($articles->post_image);?>" class="img-fluid rounded"></a></div>
                                            <div class="post-recent-content float-left"><a href="<?php echo base_url('articles/detail/'.$articles->post_slug);?>" class="mlink"><?php $post_title = strip_tags($articles->post_title); echo character_limiter($post_title, 30);?></a><span class="text-muted mt-2"><?php echo date("d M Y", strtotime($articles->post_date));?></span></div>
                                        </div>
                                        <?php } ?>
                                        
                                    </div>
                                </div>
                                <!-- RECENT POST -->
    
                            </div>
                        </div>
                    </div><!--end col-->
                    <!-- END SIDEBAR -->
                </div><!--end row-->
            </div><!--end container-->
        </section><!--end section-->
        <!-- Blog End -->