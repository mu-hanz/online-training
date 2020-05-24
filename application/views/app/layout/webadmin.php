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

        <?php if($this->input->cookie('themes') == 'dark'){
            $bsCss = base_url('assets/app/css/bootstrap-dark.min.css');
            $appCss = base_url('assets/app/css/app-dark.min.css');
        } else {
            $bsCss = base_url('assets/app/css/bootstrap.min.css');
            $appCss = base_url('assets/app/css/app.min.css');
        }
        ?>
        <!-- App css -->
        <link href="<?php echo base_url('assets/app/libs/select2/select2.min.css') ;?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/app/libs/flatpickr/flatpickr.min.css') ;?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo $bsCss;?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/app/css/icons.min.css') ;?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo $appCss;?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/app/css/styles.css') ;?>" rel="stylesheet" type="text/css" />

    </head>

<body data-layout="topnav">

    <!-- Load Dynamically CSS -->
    <div class="css-majax">
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
        <div class="content-page ajax-content" >
            <div class="content ajax-content-child">    
                <?php echo $output;?>
            </div>
        </div>
        <!-- End Content -->

        <!-- Footer Start -->
        <div class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        2017-<?php echo date('Y');?> &copy; <?php echo $this->config->item('system_name');?>. All Rights Reserved. Crafted with <i class='uil uil-heart text-danger font-size-12'></i>
                    </div>
                </div>
            </div>
        </div>
        <!-- end Footer -->

    </div>
    <!-- End page -->

    <!-- Vendor js -->
    <script src="<?php echo base_url('assets/app/js/vendor.min.js') ;?>"></script>
    <script src="<?php echo base_url('assets/app/js/moment-with-locales.min.js') ;?>"></script>

    <!-- optional plugins -->
    <script src="<?php echo base_url('assets/pjax/pjax.js') ;?>"></script>
    <script src="<?php echo base_url('assets/aform/jquery.form.min.js') ;?>"></script>
    <script src="<?php echo base_url('assets/app/js/blockUI.min.js') ;?>"></script>

    <!-- App js -->
    <script src="<?php echo base_url('assets/app/js/app.min.js') ;?>"></script>
    
    <script data-pace-options='{ "ajax": false }' src='<?php echo base_url('assets/app/js/pace.min.js') ;?>'></script>
    <script src="<?php echo base_url('assets/scripts/mz.pjax.js') ;?>"></script>

    <!-- Load Dynamically JS -->
    <div class="js-majax">
        <?php foreach($js as $file){ echo "\n\t\t"; ?>
        <script src="<?php echo $file; ?>"></script>
        <?php } echo "\n\t"; ?>
        <script src="<?php echo base_url('assets/scripts/mz.core.js') ;?>"></script>
    </div>
    <!-- End Load Dynamically JS -->

    </body>
</html>

