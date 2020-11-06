
<section class="section pt-0 pb-0 mt-0 search-course" id="find-course">
            <div class="container-fluid  px-0">
                <div class="rounded bg-light pb-5 px-3 px-sm-0">
                    <div class="row">
                        <div class="container">
                            <div class="row align-items-center">
                                <div class="col-lg-7 col-md-6 col-12  overlay-search">
                                    <div class="title-heading mr-lg-4">
                                        <div class="alert alert-primary alert-pills shadow" role="alert">
                                            <span class="content"> Are you ready to learn online ?</span>
                                        </div>
                                        
                                        <h1 class="heading mb-3">Start Online Learning <br> With <span class="text-primary">: Training Center</span></h1>
                                        <p class="para-desc text-muted">Konsultasikan kepada kami apa saja kebutuhan Anda melaui email ataupun Whatsapp tim kami akan siap membantu Anda. atau gunakan kolom pencarian di bawah ini</p>
                                        <div class="subcribe-form mt-4 pt-2">
                                            <form action="<?php echo base_url('events-search')?>" action="GET" class="m-0">
                                                <div class="form-group">
                                                    <input type="text"  name="keyword" class="rounded" placeholder="Search your course...">
                                                    <button type="submit" class="btn btn-primary">Search <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search fea icon-sm"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg></button>
                                                </div>
                                            </form><!--end form-->
                                        </div>
                                    </div>
                                </div><!--end col-->
                                <a href="https://www.youtube.com/watch?v=DE_iYhYJLSk" class="video-play-icon">
                                <div class="col-lg-5 col-md-6 col-12 mt-4 pt-2 mt-sm-0 pt-sm-0">
                                    <div class="position-relative">
                                        <img src="<?= base_url('assets/main/images/testimonial.jpg');?>" class="rounded img-fluid mx-auto d-block" alt="">
                                        <div class="play-icon">
                                            <a href="https://www.youtube.com/watch?v=DE_iYhYJLSk" class="play-btn video-play-icon">
                                                <i class="mdi mdi-play text-primary rounded-circle bg-danger shadow"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div><!--end col-->
                                </a>
                            </div><!--end row-->
                        </div><!--end container-->
                    </div><!--end row-->
                </div><!--end div-->
            </div><!--end container fluid-->
        </section>
        <?php if(is_array($data_promotions)){?>
        <section class="section pt-4" id="courses">
            <div class="container">
                <div class="row justify-content-center">
                        <div class="col-12 text-center">
                            <div class="section-title  pb-2">
                                <h4 class="title mb-0">Promo Bulan ini</h4>
                            </div>
                        </div><!--end col-->
                    </div>
                    <div class="row">
                        <?php foreach ($data_promotions as $row) { ?>
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
                                            <a href="<?=base_url();?>promotions/detail-promotion/<?=$row->slug;?>" class="btn btn-sm btn-primary mouse-down mlink">Lihat Promo</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!--end col-->    
                        <?php } ?> 

                        <div class="col-12 mt-4 pt-2 text-center">
                        <a href="<?php echo base_url('promotions/all-promotions');?>" class="btn btn-primary mlink">Find Out More <i class="mdi mdi-chevron-right"></i></a>
                    </div>

                    </div>
                </div>
            </div><!--end container fluid-->
        </section>
        <?php } ?> 
<!-- Courses Start -->
        <section class="section pt-4" id="courses">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 text-center">
                        <div class="section-title mb-4 pb-2">
                            <h4 class="title mb-4">Explore Popular Courses</h4>
                            <p class="text-muted para-desc mx-auto mb-0">Are you ready to learn with <span class="text-primary font-weight-bold">Training Center</span>?</p>
                        </div>
                    </div><!--end col-->
                </div><!--end row-->

                <div class="row">
                    <?php foreach($event_popular as $pop){?>
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
                                <small><a href="<?=base_url('events-groups/'.$pop->groupid.'/'.$pop->group_slug);?>" class="text-primary h6"><?=$pop->group_name;?></a></small>
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


                    <div class="col-12 mt-4 pt-2 text-center">
                        <a href="<?php echo base_url('events/all-events');?>" class="btn btn-primary mlink">See More Courses <i class="mdi mdi-chevron-right"></i></a>
                    </div>
                </div><!--end row-->
            </div><!--end container-->

            
        </section><!--end section-->


        <!-- Partners start -->
        <section class="py-4 border-bottom border-top">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-2 col-md-2 col-6 text-center py-4">
                        <img src="<?php echo base_url('assets/main/images/client/pertamina.png');?>" class="avatar avatar-ex-md" alt="">
                    </div><!--end col-->

                    <div class="col-lg-2 col-md-2 col-6 text-center py-4">
                        <img src="<?php echo base_url('assets/main/images/client/telkomsel.png');?>" class="avatar avatar-ex-md" alt="">
                    </div><!--end col-->
                    
                    <div class="col-lg-2 col-md-2 col-6 text-center py-4">
                        <img src="<?php echo base_url('assets/main/images/client/garuda.png');?>" class="avatar avatar-ex-md" alt="">
                    </div><!--end col-->
                    
                    <div class="col-lg-2 col-md-2 col-6 text-center py-4">
                        <img src="<?php echo base_url('assets/main/images/client/mandiri.png');?>" class="avatar avatar-ex-md" alt="">
                    </div><!--end col-->
                    
                    <div class="col-lg-2 col-md-2 col-6 text-center py-4">
                        <img src="<?php echo base_url('assets/main/images/client/jasamarga.png');?>" class="avatar avatar-ex-md" alt="">
                    </div><!--end col-->
                    
                    <div class="col-lg-2 col-md-2 col-6 text-center py-4">
                        <img src="<?php echo base_url('assets/main/images/client/komatsu.png');?>" class="avatar avatar-ex-md" alt="">
                    </div><!--end col-->
                </div><!--end row-->
            </div><!--end container-->
        </section><!--end section-->
        <!-- Partners End -->
       
        
        <!-- Start -->
        <section class="section">
            <!-- About Start -->
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6">
                        <div class="row align-items-center">
                            <div class="col-lg-6 col-6 mt-4 mt-lg-0 pt-2 pt-lg-0">
                                <div class="card work-container work-modern overflow-hidden rounded border-0 shadow-lg">
                                    <div class="card-body p-0">
                                        <img src="<?php echo base_url('assets/main/images/about/1.jpg');?>" class="img-fluid" alt="work-image">
                                       
                                       
                                    </div>
                                </div>
                                    
                            </div><!--end col-->

                            <div class="col-lg-6 col-6">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 mt-4 mt-lg-0 pt-2 pt-lg-0">
                                        <div class="card work-container work-modern overflow-hidden rounded border-0 shadow-lg">
                                            <div class="card-body p-0">
                                                <img src="<?php echo base_url('assets/main/images/about/2.jpg');?>" class="img-fluid" alt="work-image">
                                              
                                            </div>
                                        </div>
                                    </div><!--end col-->
    
                                    <div class="col-lg-12 col-md-12 mt-4 pt-2">
                                        <div class="card work-container work-modern overflow-hidden rounded border-0 shadow-lg">
                                            <div class="card-body p-0">
                                                <img src="<?php echo base_url('assets/main/images/about/3.jpg');?>" class="img-fluid" alt="work-image">
                                              
                                               
                                            </div>
                                        </div>
                                    </div><!--end col-->
                                </div><!--end row-->
                            </div><!--end col-->
                        </div><!--end row-->
                    </div><!--end col-->

                    <div class="col-lg-6 col-md-6 mt-4 mt-lg-0 pt- pt-lg-0">
                        <div class="ml-lg-4">
                            <div class="section-title mb-4 pb-2">
                                <h4 class="title mb-4">About Our Story</h4>
                                <p class="text-muted para-desc"><span class="text-primary font-weight-bold">Training Center</span> merupakan produk dari <span class="text-info font-weight-bold">Premysis Consulting</span> dan Kami menyediakan berbagai macam informasi seputar Program Training Strategic and Improvement Management yang bertujuan untuk memberikan kemudahan dalam membantu kebutuhan Training di Perusahaan Anda.</p>
                                <p class="text-muted para-desc mb-0">Pengalaman langsung dengan lebih dari 2.000 klien di industri manufaktur dan jasa, Serta mendirikan kurikulum pelatihan sudah lebih dari 8.000 jam pelatihan yang disampaikan setiap tahun. Kami berkomitmen terhadap keunggulan dan akuntabilitas dalam setiap aspek pekerjaan kami dan berusaha untuk melayani pelanggan sebaik mungkin. Untuk mencapai tujuan tersebut, kami hanya mempekerjakan profesional terbaik yang mampu memberikan hasil yang sangat baik.</p>
                            </div>

                            <h5>Our Branches :</h5>

                            <div class="row">
                                <div class="col-md-6 col-12 mt-4">
                                    <div class="d-flex align-items-center">
                                        <i data-feather="map-pin" class="fea icon-md text-muted"></i>
                                        <div class="content ml-2">
                                            <h5 class="mb-0"><a href="#" class="video-play-icon text-primary">Jakarta</a></h5>
                                            <p class="text-muted mb-0">Menara Rajawali 11 Floor</p>
                                            <p class="text-muted mb-0">Jl. Mega Kuningan Lot 5.1, Jakarta 12950 </p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 col-12 mt-4">
                                    <div class="d-flex align-items-center">
                                        <i data-feather="map-pin" class="fea icon-md text-muted"></i>
                                        <div class="content ml-2">
                                            <h5 class="mb-0"><a href="#" class="video-play-icon text-primary">Surabaya</a></h5>
                                            <p class="text-muted mb-0">Graha Pena, 10th FLoor</p>
                                            <p class="text-muted mb-0">Jl. Jendral A. Yani No 88 Ketingtang Gayungan 60246 </p>
                                        </div>
                                    </div>
                                </div>
                                
                            
                        </div>
                    </div>
                </div><!--end row-->
            </div><!--end container-->



            <!-- Testi Start -->
            <div class="container mt-100 mt-60">
                <div class="row justify-content-center">
                    <div class="col-12 text-center">
                        <div class="section-title mb-4 pb-2">
                            <h4 class="title mb-4">What Our Client Say ?</h4>
                            <p class="text-muted para-desc mx-auto mb-0">Kami berkomitmen terhadap keunggulan dan akuntabilitas dalam setiap aspek pekerjaan kami dan berusaha untuk melayani pelanggan sebaik mungkin. Untuk mencapai tujuan tersebut, kami hanya mempekerjakan profesional terbaik yang mampu memberikan hasil yang sangat baik.</p>
                        </div>
                    </div><!--end col-->
                </div><!--end row-->

                <div class="row justify-content-center">
                    <div class="col-lg-12 mt-4">
                        <div id="customer-testi" class="owl-carousel owl-theme">
                            <div class="media customer-testi m-2">
                                <img src="<?= base_url('assets/main/images/user-testimoni.png');?>" class="avatar avatar-small mr-3 rounded shadow" alt="">
                                <div class="media-body content p-3 shadow rounded bg-white position-relative">
                                    <ul class="list-unstyled mb-0">
                                        <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                        <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                        <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                        <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                        <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                    </ul>
                                    <p class="text-muted mt-2">"Premysis consulting is such a professional institution supported by professional consultants with excellent skills, both hard and soft skills. Its experience in managing project is interesting."</p>
                                    <h6 class="text-primary">- Adji Pambudi<br><small class="text-muted">PT. LEN Industri (Persero)</small></h6>
                                </div>
                            </div>
                            
                            <div class="media customer-testi m-2">
                                <img src="<?= base_url('assets/main/images/user-testimoni.png');?>" class="avatar avatar-small mr-3 rounded shadow" alt="">
                                <div class="media-body content p-3 shadow rounded bg-white position-relative">
                                    <ul class="list-unstyled mb-0">
                                        <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                        <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                        <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                        <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                        <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                    </ul>
                                    <p class="text-muted mt-2">"We are pleased with the work of Premysis Consulting. Their professional background and experiences were extremely valuable."</p>
                                    <h6 class="text-primary">– TS Lye<br><small class="text-muted">PT. Mattel Indonesia.</small></h6>
                                </div>
                            </div>

                            <div class="media customer-testi m-2">
                                <img src="<?= base_url('assets/main/images/user-testimoni.png');?>" class="avatar avatar-small mr-3 rounded shadow" alt="">
                                <div class="media-body content p-3 shadow rounded bg-white position-relative">
                                    <ul class="list-unstyled mb-0">
                                        <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                        <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                        <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                        <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                        <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                    </ul>
                                    <p class="text-muted mt-2">"I want to thank you for the privilege of working with Premysis."</p>
                                    <h6 class="text-primary">– Rena Mutia<br><small class="text-muted">Head Operations of BRI Syariah</small></h6>
                                </div>
                            </div>

                            <div class="media customer-testi m-2">
                                <img src="<?= base_url('assets/main/images/user-testimoni.png');?>" class="avatar avatar-small mr-3 rounded shadow" alt="">
                                <div class="media-body content p-3 shadow rounded bg-white position-relative">
                                    <ul class="list-unstyled mb-0">
                                        <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                        <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                        <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                        <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                        <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                    </ul>
                                    <p class="text-muted mt-2">" Only two words, Fun and Energetic Training! Thank you for this experience, we will miss it. "</p>
                                    <h6 class="text-primary">– Moch. Aminudin<small class="text-muted">Management SBU Garuda Cargo</small></h6>
                                </div>
                            </div>
                        </div>
                    </div><!--end col-->
                </div><!--end row-->
            </div><!--end container-->
            <!-- Testi End -->

            <!-- Blog Start -->
            <div class="container mt-100 mt-60">
                <div class="row justify-content-center">
                    <div class="col-12 text-center">
                        <div class="section-title mb-4 pb-2">
                            <h4 class="title mb-4">Latest News</h4>
                            <p class="text-muted para-desc mx-auto mb-0">Telah kami sediakan Tips dan Artikel yang sudah kami rangkum semoga bermanfaat.</p>
                        </div>
                    </div><!--end col-->
                </div><!--end row-->

                <div class="row">

                <?php foreach($data_articles as $articles){?>
                    <a href="<?php echo base_url('articles/detail/'.$articles->post_slug);?>" class="mlink"> 
                    <div class="col-lg-4 col-md-6 mt-4 pt-2">
                        <div class="card blog rounded border-0 shadow">
                            <div class="position-relative">
                                <img src="<?php echo base_url($articles->post_image);?>" class="card-img-top rounded-top img-blog">
                            <div class="overlay rounded-top bg-dark"></div>
                            </div>
                            <div class="card-body content">
                                <h5><a href="<?php echo base_url('articles/detail/'.$articles->post_slug);?>" class="card-title title text-dark mlink"><?php $post_title = strip_tags($articles->post_title); echo character_limiter($post_title, 100);?></a></h5>
                                <div class="post-meta d-flex justify-content-between mt-3">
                                    <a href="<?php echo base_url('articles/detail/'.$articles->post_slug);?>" class="text-muted readmore mlink">Read More <i class="mdi mdi-chevron-right"></i></a>
                                </div>
                            </div>
                            <div class="author">
                                <small class="text-light date"><i class="mdi mdi-calendar-check"></i><?php echo date("d M Y", strtotime($articles->post_date));?></small>
                            </div>
                        </div>
                    </div><!--end col-->
                    </a>
                    <?php } ?>
                </div><!--end row-->
            </div><!--end container-->
            <!-- Blog End -->

            <div class="col-12 mt-4 pt-2 text-center">
                        <a href="<?php echo base_url('articles/all-articles');?>" class="btn btn-primary mlink">See More Articles <i class="mdi mdi-chevron-right"></i></a>
                    </div>


            <!-- youtube -->
            <div class="container mt-100 mt-60">
                <div class="row justify-content-center">
                    <div class="col-12 text-center">
                        <div class="section-title mb-4 pb-2">
                            <h4 class="title mb-4">Latest Videos</h4>
                            <p class="text-muted para-desc mx-auto mb-0">Berbagi pengalaman yang kami miliki untuk menjawab tantangan di setiap perusahaan.</p>
                        </div>
                    </div><!--end col-->
                </div><!--end row-->

                <div class="row" id="videoYoutube">
                
            
                </div><!--end row-->
            </div><!--end container-->
            <!-- youtube End -->

            <div class="col-12 mt-4 pt-2 text-center">
                        <a href="https://www.youtube.com/channel/UCvwUtIPkSiqlL6b5lTqi9fA" target="_blank" class="btn btn-danger"><i class="mdi mdi-youtube"></i> See More Videos <i class="mdi mdi-chevron-right"></i></a>
                    </div>
                    
        </section><!--end section-->
        <!-- End -->

        <!-- Testi Subscribe Start -->
<section class="section pt-0 mailchimp">
            <div class="container mt-100 mt-4">
                <div class="row justify-content-center">
                    <div class="col-12 text-center">
                        <div class="section-title mb-4 pb-2">
                            <h4 class="title mb-4">Sign up for our Newsletter</h4>
                            <p class="text-muted para-desc mx-auto mb-0">Berlangganan email di <span class="text-primary font-weight-bold">Training Center</span> dapatkan ebook dan tips pelatihan lainnya.</p>
                        </div>
                    </div><!--end col-->
                </div><!--end row-->

                <div class="row justify-content-center mt-4 pt-2">
                    <div class="col-lg-7 col-md-10">
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <input name="email" id="emailchimp" type="email" class="form-control" placeholder="Your email :" required aria-describedby="newssubscribebtn">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary submitBnt" type="submit" id="newssubscribebtn">Subscribe</button>
                                    </div>
                                </div>
                            </div>
                    </div><!--end col-->
                </div><!--end row-->
            </div><!--end container-->
        </section><!--end section-->
        <!-- Testi Subscribe End -->

 