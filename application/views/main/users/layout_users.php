
<!doctype html>
<html lang="en">
    <head>

        <meta charset="utf-8" />
        <title><?php echo $title;?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="description" content="Training Ahli K3, HSE Consultant, Konsultan ISO Indonesia oleh Training Center. WA 0812 9826 2727 untuk info lebih lanjut." />
        <meta name="keywords" content="Training Ahli K3 Umum,HSE Consultant,Konsultan ISO">

        <!-- favicon -->
        <link rel="shortcut icon" href="<?php echo base_url('assets/store/img/favicon.ico') ;?>">
        <!-- Bootstrap -->
        <link href="<?php echo base_url('assets/main/css/bootstrap.min.css') ;?>" rel="stylesheet" type="text/css" />
        <!-- Icons -->
        <link href="<?php echo base_url('assets/main/css/materialdesignicons.min.css') ;?>" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="https://unicons.iconscout.com/release/v2.1.9/css/unicons.css">
        <!-- Magnific -->
        <link href="<?php echo base_url('assets/main/css/magnific-popup.css') ;?>" rel="stylesheet" type="text/css" />
        <!-- Slider -->               
        <link rel="stylesheet" href="<?php echo base_url('assets/main/css/owl.carousel.min.css') ;?>"/> 
        <link rel="stylesheet" href="<?php echo base_url('assets/main/css/owl.theme.default.min.css') ;?>"/>   
        <!-- FLEXSLIDER -->
        <link href="<?php echo base_url('assets/main/css/flexslider.css') ;?>" rel="stylesheet" type="text/css" />
        <!-- Main Css -->
        <link href="<?php echo base_url('assets/main/css/style.css') ;?>" rel="stylesheet" type="text/css" id="theme-opt" />
        <link href="<?php echo base_url('assets/main/css/colors/green.css') ;?>" rel="stylesheet" id="color-opt">
        <link href="<?php echo base_url('assets/main/css/main.css') ;?>" rel="stylesheet">
    
    </head>

    <body>
    
    <div class="css-majax">
            <?php foreach($css as $file){ echo "\n\t\t"; ?>
                <link rel="stylesheet" href="<?php echo $file; ?>" type="text/css"/>
            <?php } echo "\n\t"; ?>
        </div>

        <!-- Navbar Start -->
        <header id="topnav" class="defaultscroll sticky">
            <?php echo $this->load->get_section('header'); ?>
        </header>
        <!-- Navbar End -->
        
        <!-- Content -->
        <section class="ajax-content">

            <!-- Hero Start -->
            <section class="bg-profile d-table w-100 bg-primary" style="background: url('<?php echo base_url('assets/main/images/account/bg.png');?>') center center;">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card public-profile border-0 rounded shadow" style="z-index: 1;">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-lg-2 col-md-3 text-md-left text-center">
                                            <?php if($user->oauth_photoURL == NULL) {
                                                $photo = base_url('assets/app/images/users/avatar.jpg');
                                            } else {
                                                $photo = $user->oauth_photoURL;
                                            } ?>
                                                <img src="<?php echo $photo;?>" class="avatar avatar-large rounded-circle shadow d-block mx-auto" alt="<?php echo $user->first_name.' '.$user->last_name;?>">
                                            </div><!--end col-->
            
                                            <div class="col-lg-10 col-md-9">
                                                <div class="row align-items-end">
                                                    <div class="col-md-7 text-md-left text-center mt-4 mt-sm-0">
                                                        <h3 class="title mb-0"><?php echo $user->first_name.' '.$user->last_name;?></h3>
                                                        <small class="text-muted h6 mr-2"><?php echo $user->email;?></small>
                                                        <ul class="list-inline mb-0 mt-3">
                                                            <?php if($user->active == 1){?>
                                                            <li class="list-inline-item mr-2"><a href="javascript:void(0)" class="text-muted"><span class="badge badge-pill badge-primary" style="line-height: normal;"> Verified Users <i data-feather="check-circle" class="fea icon-sm mr-2"></i></span></a></li>
                                                            <?php } else { ?>
                                                            <li class="list-inline-item mr-2"><a href="javascript:void(0)" class="text-muted"><span class="badge badge-pill badge-warning" style="line-height: normal;"> Not Verified Users <i data-feather="x-circle" class="fea icon-sm mr-2"></i></span></a></li>
                                                            <?php } ?>
                                                            <?php if($user->oauth_provider  != null){?>
                                                            <li class="list-inline-item mr-2"><a href="javascript:void(0)" class="text-muted"><span class="badge badge-pill badge-dark" style="line-height: normal;"> <i class="mdi mdi-google"> </i></span></a></li>
                                                            <?php } ?>
                                                        </ul>
                                                    </div><!--end col-->
                                                    <div class="col-md-5 text-md-right text-center">
                                                        <div class="social-icon social mb-0 mt-4">
                                                           <a href="account-setting.html" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="bottom" title="Edit Profil">Edit Profil <i data-feather="edit" class="fea icon-sm fea-social"></i></a>
                                                           <a href="<?php echo base_url('account/auth/logout');?>" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="bottom" title="Logout">Logout <i data-feather="log-out" class="fea icon-sm fea-social"></i></a>
                                                        </div><!--end icon-->
                                                    </div><!--end col-->
                                                </div><!--end row-->
                                            </div><!--end col-->
                                        </div><!--end row-->
                                    </div>
                                </div>
                            </div><!--end col-->
                        </div><!--end row-->
                    </div><!--ed container-->
                </section><!--end section-->
                <!-- Hero End -->
                <section class="section mt-60">
                    <div class="container mt-lg-3">
                        <div class="row">
                            <div class="col-lg-4 col-md-6 col-12 d-lg-block d-none">
                                <?php echo $this->load->get_section('menu'); ?>
                            </div>
                            <div class="col-lg-8 col-12">
                                <?php echo $output;?>
                            </div>
                        </div>
                    </div>
                </section>
        </section>

        <footer class="footer footer-bar">
            <div class="container text-center">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <div class="text-sm-left">
                            <p class="mb-0">© 2017-<?php echo date('Y');?> <span class="text-primary font-weight-bold">Training Center</span> Provided by <span class="text-warning font-weight-bold">Premysis Consulting</span></p>
                        </div>
                    </div><!--end col-->

                    <div class="col-sm-6 mt-4 mt-sm-0 pt-2 pt-sm-0">
                        <ul class="list-unstyled text-sm-right mb-0">
                            <li class="list-inline-item"><a href="javascript:void(0)"><img src="<?php echo base_url('assets/main/images/payments/bca.png');?>" class="avatar avatar-ex-sm" title="BCA" alt="BCA"></a></li>
                            <li class="list-inline-item"><a href="javascript:void(0)"><img src="<?php echo base_url('assets/main/images/payments/bni.png');?>" class="avatar avatar-ex-sm" title="BNI" alt="BNI"></a></li>
                            <li class="list-inline-item"><a href="javascript:void(0)"><img src="<?php echo base_url('assets/main/images/payments/mandiri.png');?>" class="avatar avatar-ex-sm" title="Mandiri" alt="Mandiri"></a></li>
                            <li class="list-inline-item"><a href="javascript:void(0)"><img src="<?php echo base_url('assets/main/images/payments/atmbersama.png');?>" class="avatar avatar-ex-sm" title="ATM Bersama" alt="Mandiri"></a></li>
                            <li class="list-inline-item"><a href="javascript:void(0)"><img src="<?php echo base_url('assets/main/images/payments/gopay.png');?>" class="avatar avatar-ex-sm" title="GoPay" alt="GoPay"></a></li>
                            <li class="list-inline-item"><a href="javascript:void(0)"><img src="<?php echo base_url('assets/main/images/payments/kartukredit.png');?>" class="avatar avatar-ex-sm" title="Visa dan Master Card" alt="Visa dan Master Card"></a></li>
                        </ul>
                    </div><!--end col-->
                </div><!--end row-->
            </div><!--end container-->
        </footer><!--end footer-->
        

        <a href="#" class="btn btn-icon btn-soft-primary back-to-top"><i data-feather="arrow-up" class="icons"></i></a>

        <!-- Javascript Start -->
        <!-- javascript -->
        <script src="<?php echo base_url('assets/main/js/jquery-3.5.1.min.js');?>"></script>
        <script src="<?php echo base_url('assets/main/js/bootstrap.bundle.min.js');?>"></script>
        <script src="<?php echo base_url('assets/main/js/jquery.easing.min.js');?>"></script>
        <script src="<?php echo base_url('assets/main/js/scrollspy.min.js');?>"></script>
        <!-- Icons -->
        <script src="<?php echo base_url('assets/main/js/feather.min.js');?>"></script>
        <script src="https://unicons.iconscout.com/release/v2.1.9/script/monochrome/bundle.js"></script>
        
        <script src="<?php echo base_url('assets/aform/jquery.form.min.js') ;?>"></script>
        <script src="<?php echo base_url('assets/pjax/pjax.js') ;?>"></script>
        <script data-pace-options='{ "ajax": false }' src='<?php echo base_url('assets/app/js/pace.min.js') ;?>'></script>
        <script src="<?php echo base_url('assets/app/js/blockUI.min.js') ;?>"></script>
        <script src="<?php echo base_url('assets/sweetalert/sweetalert2.all.min.js') ;?>"></script>
        <script src="<?php echo base_url('assets/scripts/auth.pjax.js') ;?>"></script>

        <!-- Main Js -->
        <script src="<?php echo base_url('assets/main/js/app.js');?>"></script>

       
    </body>
</html>
