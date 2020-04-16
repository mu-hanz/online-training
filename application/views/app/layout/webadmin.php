<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <title><?php echo $title;?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimal-ui" />
        <meta content="Online Training Center" name="description" />
        <meta content="MuHanz" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <!-- Hidden from google -->
        <meta name="robots" content="noindex">
        <meta name="googlebot" content="noindex">

        <!-- App favicon -->
        <link rel="shortcut icon" href="<?php echo base_url('assets/app/images/favicon.png') ;?>">

        <!-- App css -->
        <link href="<?php echo base_url('assets/app/css/bootstrap.min.css') ;?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/app/css/icons.min.css') ;?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/app/css/app.min.css') ;?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/app/css/styles.css') ;?>" rel="stylesheet" type="text/css" />

    </head>

<body data-layout="topnav">
    <!-- Pre-loader -->
    <div id="preloader">
        <div id="status">
            <div class="spinner">
                <div class="circle1"></div>
                <div class="circle2"></div>
                <div class="circle3"></div>
            </div>
        </div>
    </div>
    <!-- End Preloader-->

    <!-- Load Dynamically CSS -->
    <div css-majax>
        <?php foreach($css as $file){ echo "\n\t\t"; ?>
            <link rel="stylesheet" href="<?php echo $file; ?>" type="text/css"/>
        <?php } echo "\n\t"; ?>
    </div>
    <!-- End Load Dynamically CSS -->

    <!-- Begin page -->
    <div class="wrapper">

        <!-- Topbar -->
        <?php echo $this->load->get_section('topbar'); ?>
        <!-- End Topbar-->

        <!-- Menubar -->
        <?php echo $this->load->get_section('menubar'); ?>
        <!-- End Menubar -->

        <!-- Content -->
        <div class="content-page">
            <div class="content" id="ajax-content">    
                <?php echo $output;?>
            </div>
        </div>
        <!-- End Content -->

        <!-- Footer Start -->
        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        2017-<?php echo date('Y');?> &copy; <?php echo $this->config->item('system_name');?>. All Rights Reserved. Crafted with <i class='uil uil-heart text-danger font-size-12'></i>
                    </div>
                </div>
            </div>
        </footer>
        <!-- end Footer -->

    </div>
    <!-- End page -->

    <!-- Vendor js -->
    <script src="<?php echo base_url('assets/app/js/vendor.min.js') ;?>"></script>
    <script src="<?php echo base_url('assets/app/js/moment-with-locales.min.js') ;?>"></script>

    <!-- optional plugins -->
    <script src="<?php echo base_url('assets/pjax/pjax.min.js') ;?>"></script>
    <script src="<?php echo base_url('assets/aform/jquery.form.min.js') ;?>"></script>
    <script src="<?php echo base_url('assets/app/js/blockUI.min.js') ;?>"></script>

    <!-- App js -->
    <script src="<?php echo base_url('assets/app/js/app.js') ;?>"></script>
    <script src="<?php echo base_url('assets/scripts/mz.pjax.js') ;?>"></script>

    <!-- Load Dynamically JS -->
    <footer id="footer">
        <?php foreach($js as $file){ echo "\n\t\t"; ?>
        <script src="<?php echo $file; ?>"></script>
        <?php } echo "\n\t"; ?>
		<script src="<?php echo base_url('assets/scripts/mz.core.js') ;?>"></script>
    </footer>
    <!-- End Load Dynamically JS -->

    </body>
</html>
