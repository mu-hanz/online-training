
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
        <link href="<?php echo base_url('assets/sweetalert/sweetalert2.min.css') ;?>" rel="stylesheet">
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
            <?php echo $this->load->get_section('slider'); ?>

            <?php echo $output;?>
        </section>
        <!-- Content -->

        <!-- Footer Start -->
        <?php echo $this->load->get_section('footer'); ?>
        <!-- Footer End -->

        <!-- Back To Home Start -->
        <a href="#" class="btn btn-icon btn-soft-primary back-to-top"><i data-feather="arrow-up" class="icons"></i></a>
        <!-- Back To Home End -->

        <!-- Javascript Start -->
        <!-- javascript -->
        <!-- Main Js -->
        <?php $this->load->config('midtrans', true);

        $production         = $this->config->item('production', 'midtrans');

        if ($production) {
            $client_key         = $this->config->item('client_key', 'midtrans');
            $url_js = $this->config->item('url', 'midtrans');
        } else {
            $client_key = $this->config->item('client_key_sandbox', 'midtrans'); // sandbox
            $url_js = $this->config->item('url_sandbox', 'midtrans'); // sandbox
        }

        ?>
        <script type="text/javascript" src="<?=$url_js;?>" data-client-key="<?=$client_key;?>"></script>
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
        <script src="<?php echo base_url('assets/scripts/store.pjax.js') ;?>"></script>

        
        


        <!-- Javascript End -->

        <!-- Load Dynamically JS -->
        <div class="js-majax">
        
        <script src="<?php echo base_url('assets/main/js/app.js');?>"></script>
            <?php foreach($js as $file){ echo "\n\t\t"; ?>
            <script src="<?php echo $file; ?>"></script>
            <?php } echo "\n\t"; ?>
        </div>
        <!-- End Load Dynamically JS -->
        
    </body>
</html>
