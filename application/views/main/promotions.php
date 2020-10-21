<section class="bg-home bg-light d-flex align-items-center" style="background: url('<?php echo base_url('assets/main/images/slider/1.jpg');?>') center center; height: auto;" id="home">
    <div class="bg-overlay overlay-search"></div>            
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9 text-center mt-0 mt-md-5 pt-0 pt-md-5">
                <div class="title-heading margin-top-100">
                    <h1 class="heading mb-3 text-white">All Promotions</h1>
                    <div class="text-center subcribe-form my-4 pt-2 aos-init aos-animate" data-aos="fade-up" data-aos-duration="1800">
                        <form action="<?php echo base_url('events-search-ajax')?>" action="GET" class="ajaxForm">
                            <div class="form-group mb-0">
                                <input type="text" name="keyword" class="shadow bg-white rounded-pill" required=""  placeholder="Search course...">
                                <button type="submit" class="btn btn-pills btn-primary">Search <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search fea icon-sm"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div><!--end col-->
        </div><!--end row-->
    </div><!--end container-->
</section>

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
            <?php foreach($promotions as $row){?>
            <div class="col-lg-6 mt-4 pt-2">
                <div class="card event-schedule rounded border">
                    <div class="card-body">
                        <div class="media">
                            <ul class="date text-center text-primary mr-3 mb-0 list-unstyled">
                                <?php
                                $newdate    = strtotime($row->start_date);
                                $date       = date('d', $newdate);
                                $month      = date('F', $newdate);
                                ?>
                                <li class="day font-weight-bold mb-2"><?=$date;?></li>
                                <li class="month font-weight-bold"><?=$month;?></li>
                            </ul>
                            <div class="media-body content">
                                <div class="alert alert-outline-primary alert-pills" role="alert">
                                    <span class="badge badge-pill badge-danger"> New </span>
                                    <span class="alert-content"> 
                                    <?php if ($row->type == 'voucher') { ?>
                                        Voucher
                                    <?php } else if ($row->type == 'flexi_combo') { ?>
                                        Flexi Combo
                                    <?php } else { ?>
                                        Campaign
                                    <?php } ?>
                                    </span>
                                </div>
                                <h4>
                                    <a href="javascript:void(0)" class="text-dark title"><?=$row->promotions_name;?></a>
                                </h4>
                                <p class="text-muted location-time"><span class="text-muted h6"><?=$row->promotions_content;?></p>
                                <a href="<?=base_url();?>promotions/detail-promotion/<?=$row->slug;?>" class="btn btn-sm btn-primary mouse-down">Lihat Promo</a>
                            </div>
                        </div>
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
    </div><!--end container-->
</section><!--end section-->
<!-- Blog End -->