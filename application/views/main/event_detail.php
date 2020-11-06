 <!-- Hero Start -->
 <section class="bg-half bg-light d-table w-100" style="background-image:url('<?php echo base_url($event->event_images);?>')">
 <div class="bg-overlay"></div>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-12 text-center">
                        <div class="page-next-level">
                            <h4 class="title text-light"> <?=$event->event_name;?> </h4>
<p class="text-light"><?=$event->event_subtitle;?> </p>
<?php if($campaign->num_rows() > 0){ $cmp = $campaign->row(); ?> <span class="badge badge-pill badge-primary"> <?= $cmp->promotions_name;?> </span> <?php } ?>
                            
                        </div>
                    </div>  <!--end col-->
                </div><!--end row-->
            </div> <!--end container-->
        </section><!--end section-->
        <!-- Hero End -->

        <!-- Shape Start -->
        <div class="position-relative">
            <div class="shape overflow-hidden text-white">
                <svg viewBox="0 0 2880 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 48H1437.5H2880V0H2160C1442.5 52 720 0 720 0H0V48Z" fill="currentColor"></path>
                </svg>
            </div>
        </div>
        <!--Shape End-->

        <!-- Blog Start -->
        <section class="section">
            <div class="container">
                <div class="row">
                    <!-- BLog Start -->
                    <div class="col-lg-8 col-md-6">
                    <div class="card blog blog-detail border-0 shadow rounded">
                            
                            <div class="card-body content">
                                
                                <div class="text-muted mt-3">
                                <?php echo htmlspecialchars_decode(stripslashes($event->post_content)); ?>
                                </div>

                                    
                            </div>
                        </div>
                    </div><!--end col-->
                    <!-- BLog End -->

                    <!-- START SIDEBAR -->
                    <div class="col-lg-4 col-md-6 col-12 mt-4 mt-sm-0 pt-2 pt-sm-0">
                    <?php if($event->event_video != null){ ?>
                            <div class="border-bottom">
                                <div class="position-relative">
                                    <img src="<?php echo base_url($event->event_thumbs);?>" class="rounded-bottom-0 img-fluid mx-auto d-block" alt="">
                                    <div class="job-overlay bg-white"></div>
                                    <div class="play-icon">
                                        <a href="<?=$event->event_video;?>" class="play-btn video-play-icon">
                                            <i class="mdi mdi-play text-primary rounded-circle bg-danger shadow"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                    <div class="card border-0 job-box sidebar sticky-bar rounded shadow">
                        
                            <div class="card-body content position-relative">
                          

                                <?php if($promo_flexi):?>
                                <?php if($promo_flexi->criteria_qty != 0){
                                    $text = 'Buy more than '.$promo_flexi->criteria_qty;
                                    
                                } else {
                                    $text = 'Spend more than '.rupiah($promo_flexi->criteria_price);
                                }
                                
                                if($promo_flexi->discount_percent != 0){
                                    $info = 'Extra Discount - '.$promo_flexi->discount_percent.'%';

                                } else {
                                    $info = 'Extra Discount - '.rupiah($promo_flexi->discount_price);
                                }
                                ?>

                                
                                <div class="alert alert-outline-danger alert-pills" role="alert">
                                    <span class="badge badge-pill badge-danger"> HOT </span>
                                    <span class="alert-content"> <?=$text;?> </span>
                                    <span class="alert-content" style="display: block;margin-left: 43px;"> <?=$info;?> </span>
                                   
                                </div> 
                                <?php endif;?>

                                <div class="company-detail mt-3">
                                    <del><h5 class="mb-0 text-muted"><?=rupiah($event->event_cost);?></h5></del>
                                    <?php if($campaign->num_rows() > 0){ $cmp = $campaign->row(); ?>
                                        <h5 class="mb-0 text-primary font-weight-bold"><?=rupiah($cmp->price_campaign);?> <span class="badge badge-pill badge-primary"> <?=percent_price($cmp->price_campaign, $event->event_cost);?>% OFF </span></h5>
                                    <?php } else { ?>
                                        <h5 class="mb-0 text-primary font-weight-bold"><?=rupiah($event->event_cost_promo);?> <span class="badge badge-pill badge-primary"> <?=percent_price($event->event_cost_promo, $event->event_cost);?>% OFF </span></h5>
                                    <?php } ?>
                                </div>
                                <ul class="job-facts list-unstyled mt-4">

                                    <?php if($event->event_type !== 'e-training' && $event->event_type !== 'in-house-training'){?>
                                    <li class="list-inline-item text-muted">
                                    <span class="text-primary h5 mr-2"><span class="uim-svg" style=""><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="1em"><path class="uim-primary" d="M10.3125,16.09375a.99676.99676,0,0,1-.707-.293L6.793,12.98828A.99989.99989,0,0,1,8.207,11.57422l2.10547,2.10547L15.793,8.19922A.99989.99989,0,0,1,17.207,9.61328l-6.1875,6.1875A.99676.99676,0,0,1,10.3125,16.09375Z" opacity=".99"></path><path class="uim-tertiary" d="M12,2A10,10,0,1,0,22,12,10.01146,10.01146,0,0,0,12,2Zm5.207,7.61328-6.1875,6.1875a.99963.99963,0,0,1-1.41406,0L6.793,12.98828A.99989.99989,0,0,1,8.207,11.57422l2.10547,2.10547L15.793,8.19922A.99989.99989,0,0,1,17.207,9.61328Z"></path></svg></span></span>
                                    <?=date("d M", strtotime($event->event_start_date)).' - '.date("d M Y", strtotime($event->event_end_date));?></li>
                                    <?php } ?>  
                                    
                                    <?php if($event->event_duration != null ){?>
                                    <li class="list-inline-item text-muted">
                                    <span class="text-primary h5 mr-2"><span class="uim-svg" style=""><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="1em"><path class="uim-primary" d="M10.3125,16.09375a.99676.99676,0,0,1-.707-.293L6.793,12.98828A.99989.99989,0,0,1,8.207,11.57422l2.10547,2.10547L15.793,8.19922A.99989.99989,0,0,1,17.207,9.61328l-6.1875,6.1875A.99676.99676,0,0,1,10.3125,16.09375Z" opacity=".99"></path><path class="uim-tertiary" d="M12,2A10,10,0,1,0,22,12,10.01146,10.01146,0,0,0,12,2Zm5.207,7.61328-6.1875,6.1875a.99963.99963,0,0,1-1.41406,0L6.793,12.98828A.99989.99989,0,0,1,8.207,11.57422l2.10547,2.10547L15.793,8.19922A.99989.99989,0,0,1,17.207,9.61328Z"></path></svg></span></span>
                                    <?=$event->event_duration;?></li>
                                    <?php } ?>
                                    
                                    <?php if($event->cert_name != null ){?>
                                    <li class="list-inline-item text-muted">
                                    <span class="text-primary h5 mr-2"><span class="uim-svg" style=""><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="1em"><path class="uim-primary" d="M10.3125,16.09375a.99676.99676,0,0,1-.707-.293L6.793,12.98828A.99989.99989,0,0,1,8.207,11.57422l2.10547,2.10547L15.793,8.19922A.99989.99989,0,0,1,17.207,9.61328l-6.1875,6.1875A.99676.99676,0,0,1,10.3125,16.09375Z" opacity=".99"></path><path class="uim-tertiary" d="M12,2A10,10,0,1,0,22,12,10.01146,10.01146,0,0,0,12,2Zm5.207,7.61328-6.1875,6.1875a.99963.99963,0,0,1-1.41406,0L6.793,12.98828A.99989.99989,0,0,1,8.207,11.57422l2.10547,2.10547L15.793,8.19922A.99989.99989,0,0,1,17.207,9.61328Z"></path></svg></span></span>
                                    Certificate (<?=$event->cert_name;?>)</li>
                                    <?php } ?>  

                                    <?php if($event->group_name != null ){?>
                                    <li class="list-inline-item text-muted">
                                    <span class="text-primary h5 mr-2"><span class="uim-svg" style=""><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="1em"><path class="uim-primary" d="M10.3125,16.09375a.99676.99676,0,0,1-.707-.293L6.793,12.98828A.99989.99989,0,0,1,8.207,11.57422l2.10547,2.10547L15.793,8.19922A.99989.99989,0,0,1,17.207,9.61328l-6.1875,6.1875A.99676.99676,0,0,1,10.3125,16.09375Z" opacity=".99"></path><path class="uim-tertiary" d="M12,2A10,10,0,1,0,22,12,10.01146,10.01146,0,0,0,12,2Zm5.207,7.61328-6.1875,6.1875a.99963.99963,0,0,1-1.41406,0L6.793,12.98828A.99989.99989,0,0,1,8.207,11.57422l2.10547,2.10547L15.793,8.19922A.99989.99989,0,0,1,17.207,9.61328Z"></path></svg></span></span>
                                    Provided by <?=$event->group_name;?></li>
                                    <?php } ?>  

                                    <?php if($event->reg_name != null ){?>
                                    <li class="list-inline-item text-muted">
                                    <span class="text-primary h5 mr-2"><span class="uim-svg" style=""><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="1em"><path class="uim-primary" d="M10.3125,16.09375a.99676.99676,0,0,1-.707-.293L6.793,12.98828A.99989.99989,0,0,1,8.207,11.57422l2.10547,2.10547L15.793,8.19922A.99989.99989,0,0,1,17.207,9.61328l-6.1875,6.1875A.99676.99676,0,0,1,10.3125,16.09375Z" opacity=".99"></path><path class="uim-tertiary" d="M12,2A10,10,0,1,0,22,12,10.01146,10.01146,0,0,0,12,2Zm5.207,7.61328-6.1875,6.1875a.99963.99963,0,0,1-1.41406,0L6.793,12.98828A.99989.99989,0,0,1,8.207,11.57422l2.10547,2.10547L15.793,8.19922A.99989.99989,0,0,1,17.207,9.61328Z"></path></svg></span></span>
                                    Regional <?=$event->reg_name;?></li>
                                    <?php } ?>  

                                    <?php if($event->type_name != null ){?>
                                    <li class="list-inline-item text-muted">
                                    <span class="text-primary h5 mr-2"><span class="uim-svg" style=""><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="1em"><path class="uim-primary" d="M10.3125,16.09375a.99676.99676,0,0,1-.707-.293L6.793,12.98828A.99989.99989,0,0,1,8.207,11.57422l2.10547,2.10547L15.793,8.19922A.99989.99989,0,0,1,17.207,9.61328l-6.1875,6.1875A.99676.99676,0,0,1,10.3125,16.09375Z" opacity=".99"></path><path class="uim-tertiary" d="M12,2A10,10,0,1,0,22,12,10.01146,10.01146,0,0,0,12,2Zm5.207,7.61328-6.1875,6.1875a.99963.99963,0,0,1-1.41406,0L6.793,12.98828A.99989.99989,0,0,1,8.207,11.57422l2.10547,2.10547L15.793,8.19922A.99989.99989,0,0,1,17.207,9.61328Z"></path></svg></span></span>
                                    Type <?=$event->type_name;?></li>
                                    <?php } ?>  
                                </ul>
                                <div class="text-center">
                                <?php 
                                $date_now = strtotime(date('Y-m-d H:i:s', now()));
                                $close_date = strtotime($event->event_close_date.' '.$event->event_close_time);
                                if($close_date > $date_now): 
                                    if($event->event_register == 0):
                                        if($event->event_max_participant > 0):?>   
                                
                                        <a href="javascript:void(0)"  data-id="<?php echo $event->event_id;?>" id="enroll" class="btn btn-primary enroll">Enroll Now</a>
                                        <a href="javascript:void(0)" data-id="<?php echo $event->event_id;?>" id="add-to-cart" class="btn btn-outline-primary add-to-cart">Add to Cart</a>
                                        
                                        <?php else: ?>

                                        <a href="javascript:void(0)" class="btn btn-soft-secondary btn-block">Closed</a>

                                        <?php endif; ?>

                                        <?php else: ?>

                                        <a href="javascript:void(0)" class="btn btn-soft-secondary btn-block">Closed</a>

                                        <?php endif; ?>

                                    <?php else: ?>

                                    <a href="javascript:void(0)" class="btn btn-soft-secondary btn-block">Closed</a>

                                <?php endif; ?>
                                </div>
                                </div>
                            </div>
                        </div>

                    
                    </div><!--end col-->
                    <!-- END SIDEBAR -->
                </div><!--end row-->
            </div><!--end container-->
        </section><!--end section-->
        <!-- Blog End -->