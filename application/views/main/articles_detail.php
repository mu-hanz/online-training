
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

    <section class="section  b-content">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="row">
                            <div class="col-md-2 d-none d-md-block">
                                <ul class="list-unstyled text-center sticky-bar social-icon mb-0">
                                    <li class="mb-3 h6">Share</li>
                                    <div  id="share">
                                    </div>
                                    
                                </ul><!--end icon-->
                            </div>
        
                            <div class="col-md-10">
                                
                                
                                <img src="<?php echo base_url($articles->post_image);?>" class="img-fluid rounded-md shadow" alt="<?=$articles->post_title;?>">
                                <ul class="list-unstyled d-flex justify-content-between mt-4">
                                    <li class="list-inline-item user mr-2"><a href="javascript:void(0)" class="text-muted"><i class="mdi mdi-tag-multiple-outline text-dark"></i> <?=$articles->name;?></a></li>
                                    <li class="list-inline-item date text-muted"><i class="mdi mdi-calendar-check text-dark"></i> <?php echo date("d M Y H:i", strtotime($articles->post_date));?></li>
                                </ul>
                                <h5 class="mt-4"><?=$articles->post_title;?></h5>

                                <p class="text-muted"><?php echo htmlspecialchars_decode(stripslashes($articles->post_content)); ?></p>

   
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            
        </section>

        <section class="section">
            <div class="container">
                <div class="row">
        
                <?php $no = 1; foreach($data_articles as $articles){
                    
                    if($no ==1){
                    ?>
                    
                    <div class="col-lg-6 col-12 mb-4 pb-2">
                    
                        <div class="card blog rounded border-0 shadow overflow-hidden">
                            <div class="row align-items-center no-gutters">
                            
                                <div class="col-md-6">
                                    <img src="<?php echo base_url($articles->post_image);?>" class="img-fluid recent-blog" alt="<?= $articles->post_title;?>">
                                    <div class="overlay bg-dark"></div>
                                    <div class="author">
                                        
                                        <small class="text-light date"><i class="mdi mdi-calendar-check"></i> <?php echo date("d M Y", strtotime($articles->post_date));?></small>
                                    </div>
                                </div><!--end col-->

                                <div class="col-md-6">
                                    <div class="card-body content">
                                        <h5><a href="<?php echo base_url('articles/detail/'.$articles->post_slug);?>" class="mlink card-title title text-dark"><?php $post_title = strip_tags($articles->post_title); echo character_limiter($post_title, 100);?></a></h5>
                                        
                                        <div class="post-meta d-flex justify-content-between mt-3">
                                           
                                            <a href="<?php echo base_url('articles/detail/'.$articles->post_slug);?>" class="mlink text-muted readmore">Read More <i class="mdi mdi-chevron-right"></i></a>
                                        </div>
                                    </div>
                                </div><!--end col-->
                                
                            </div> <!--end row-->
                        </div><!--end blog post-->
                       
                    </div><!--end col-->
                    
                    <?php } else { ?>  
                    
                    <div class="col-lg-6 col-12 mb-4 pb-2">
                        <div class="card blog rounded border-0 shadow overflow-hidden">
                            <div class="row align-items-center no-gutters">
                     
                                <div class="col-md-6 order-2 order-md-1">
                                    <div class="card-body content">
                                        <h5><a href="<?php echo base_url('articles/detail/'.$articles->post_slug);?>" class="mlink card-title title text-dark"><?php $post_title = strip_tags($articles->post_title); echo character_limiter($post_title, 100);?></a></h5>
                                        
                                        <div class="post-meta d-flex justify-content-between mt-3">
                                           
                                            <a href="<?php echo base_url('articles/detail/'.$articles->post_slug);?>" class="mlink text-muted readmore">Read More <i class="mdi mdi-chevron-right"></i></a>
                                        </div>
                                    </div>
                                </div><!--end col-->
                                
                                <div class="col-md-6 order-1 order-md-2">
                                    <img src="<?php echo base_url($articles->post_image);?>" class="img-fluid recent-blog" alt="<?= $articles->post_title;?>">
                                    <div class="overlay bg-dark"></div>
                                    <div class="author">

                                        <small class="text-light date"><i class="mdi mdi-calendar-check"></i> <?php echo date("d M Y", strtotime($articles->post_date));?></small>
                                    </div>
                                </div><!--end col-->
                             
                            </div> <!--end row-->
                        </div><!--end blog post-->
                    </div><!--end col-->
                    
                    <?php } $no++; } ?>     
                    
                </div><!--end row-->
            </div><!--end container-->
        </section><!--end section -->
        <!--Blog Lists End-->