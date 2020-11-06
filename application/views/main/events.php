<section class="bg-home bg-light d-flex align-items-center" style="background: url('<?php echo base_url('assets/main/images/slider/1.jpg');?>') center center; height: auto;" id="home">
<div class="bg-overlay overlay-search"></div>            
<div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-9 text-center mt-0 mt-md-5 pt-0 pt-md-5">
                        <div class="title-heading margin-top-100">
                        <h1 class="heading mb-3 text-white">Start Learning  With : <span class="badge badge-pill badge-light"> Training Center </span></h1>
                                        <p class="text-white">Konsultasikan kepada kami apa saja kebutuhan Anda melaui email ataupun Whatsapp tim kami akan siap membantu Anda. atau gunakan kolom pencarian di bawah ini</p>
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
                <?php foreach($event as $pop){?>
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
                        <?php if($pop->event_type !== 'e-training' && $pop->event_type !== 'in-house-training'){?>
                            <ul class="list-unstyled head mb-0 mx-4 text-center">
                                <li class="badge badge-danger badge-pill"><?= date('d M Y', strtotime($pop->event_start_date));?></li>
                            </ul>
                        <?php } ?>
                        <div class="card-body content">
                            <small><a href="<?=base_url('events-groups/'.$pop->groupid.'/'.$pop->group_slug);?>" class="text-primary h6 mlink"><?=$pop->group_name;?></a></small>
                            <h5 class="mt-2"><a href="<?php echo base_url('events/detail/'.$pop->event_slug);?>" class="title text-dark mlink"><?=$pop->event_name;?></a></h5>
                            <ul class="list-unstyled d-flex justify-content-between border-top mt-3 pt-3 mb-0">
                                <li class="text-muted small"><i data-feather="award" class="fea icon-sm text-info"></i> <?=$pop->cert_name;?></li>
                                <li class="text-muted small ml-3"><i data-feather="bookmark" class="fea icon-sm text-warning"></i><?= string_type($pop->event_type);?></li>
                            </ul>
                        </div>
                    </div> <!--end card / course-blog-->
                    </div><!--end col-->
                    </a>
                    <?php }?>

                    <!-- PAGINATION START -->
                    <div class="col-12 pt-5 mt-5">
                        <?php echo $this->pagination->create_links();?>
                    </div><!--end col-->
                    <!-- PAGINATION END -->
                </div><!--end row-->
            </div><!--end container-->
        </section><!--end section-->
        <!-- Blog End -->