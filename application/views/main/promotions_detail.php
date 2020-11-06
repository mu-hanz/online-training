
<!-- Hero Start -->
<section class="bg-half w-100 d-table" data-jarallax='{"speed": 0.5}' <?php if ($promotions_image == '') { ?> style="background: url('<?php echo base_url('assets/main/images/slider/1.jpg');?>') center center; height: auto;" <?php } else { ?> style="background: url('<?php echo base_url('assets/app/images/promotions/'.$promotions_image.'');?>') center center; height: auto;" <?php } ?>>
            <div class="bg-overlay "></div>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10 text-center">
                        <div class="title-heading">
                            <h4 class="text-light mb-3"><?=date('d M Y', strtotime($start_date));?></h4>
                            <h1 class="display-4 title-dark text-white font-weight-bold mb-3"><?=$promotions_name;?></h1>
                            <p class="para-desc title-dark mx-auto text-light"><?=$promotions_content;?></p>
                            
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <div id="eventdown"></div>
                                </div>
                            </div>
                            <?php
                            $date_now = date('Y-m-d H:i:s', now());
                            if(strtotime($start_date) >= strtotime($date_now)){
                                $date_promo = $start_date;
                            } else {
                                $date_promo = $end_date;
                            }  
                            ?>
                            
                            <input type="hidden" id="date_promo" data-date="" value="<?=date('Y/m/d', strtotime($date_promo));?>">
                            <input type="hidden" id="date_now" data-date="" value="<?=date('Y/m/d', strtotime($date_now));?>">
                            
                        </div>
                    </div><!--end col-->
                </div><!--end row-->
            </div><!--end container-->
        </section><!--end section-->

<!-- Shape Start -->
<div class="position-relative">
    <div class="shape overflow-hidden text-white">
        <svg viewBox="0 0 2880 48" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 48H1437.5H2880V0H2160C1442.5 52 720 0 720 0H0V48Z" fill="currentColor"></path>
        </svg>
    </div>
</div>
<!--Shape End-->

<!-- Blog STart -->
<section class="section">
    <div class="container">
        <div class="row">
            <?php foreach($promotions as $pop){?>
                <a href="<?php echo base_url('events/detail/'.$pop->event_slug);?>" class="mlink"> 
            <div class="col-lg-4 col-md-6 col-12 mt-4 pt-2">
                <div class="card blog rounded border-0 shadow overflow-hidden">
                    <div class="position-relative">
                        <img src="<?php echo base_url($pop->event_thumbs);?>" class="card-img-top" alt="<?=$pop->event_name;?>">
                        <div class="overlay bg-dark"></div>
                        <a href="<?php echo base_url('events/detail/'.$pop->event_slug);?>" class="mlink">
                            <div class="course-fee bg-white text-center shadow-lg rounded-circle">
                                <h6 class="text-primary font-weight-bold fee"><i data-feather="arrow-up-right" class="fea icon-md text-success"></i> </h6>
                            </div>
                        </a>
                    </div>
                    <div class="position-relative">
                        <div class="shape overflow-hidden text-white" style="bottom: -3px;">
                            <svg viewBox="0 0 2880 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0 48H1437.5H2880V0H2160C1442.5 52 720 0 720 0H0V48Z" fill="currentColor"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="card-body content">
                        <small><a href="javascript:void(0)" class="text-primary h6"><?=$pop->group_name;?></a></small>
                        <h5 class="mt-2"><a href="<?php echo base_url('events/detail/'.$pop->event_slug);?>" class="title text-dark mlink"><?=$pop->event_name;?></a></h5>
                        <ul class="list-unstyled d-flex justify-content-between border-top mt-3 pt-3 mb-0">
                            <li class="text-muted small"><i data-feather="award" class="fea icon-sm text-info"></i> <?=$pop->cert_name;?></li>
                            <li class="text-muted small ml-3"><i data-feather="bookmark" class="fea icon-sm text-warning"></i><?= string_type($pop->event_type);?></li>
                        </ul>
                    </div>
                </div> <!--end card / course-blog-->
            </div><!--end col-->
            </a>
            <?php } ?>
            <!-- PAGINATION START -->
            <div class="col-12 pt-5 mt-5">
                <?php echo $this->pagination->create_links();?>
            </div><!--end col-->
            <!-- PAGINATION END -->
        </div><!--end row-->
    </div><!--end container-->
</section><!--end section-->
<!-- Blog End -->