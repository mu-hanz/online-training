<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title><?php echo $title;?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Training Ahli K3, HSE Consultant, Konsultan ISO Indonesia oleh Training Center. WA 0812 9826 2727 untuk info lebih lanjut." />
    <meta name="keywords" content="Training Ahli K3 Umum,HSE Consultant,Konsultan ISO">
    
    <link rel="shortcut icon" href="<?php echo base_url('assets/store/img/favicon.png') ;?>">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,400,600,700,800,900&display=swap" rel="stylesheet">
    <!-- build:css -->
    <link rel="stylesheet" href="<?php echo base_url('assets/store/vendor/css/line-awesome.cs') ;?>s">
    <link rel="stylesheet" href="<?php echo base_url('assets/store/vendor/css/swiper.min.css') ;?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/store/css/bootstrap-custom.css') ;?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/store/css/theme.css') ;?>">
    <!-- endbuild -->
    <link rel="stylesheet" href="<?php echo base_url('assets/store/css/custom.css') ;?>">
</head>

<body>
    <!-- Load Dynamically CSS -->
    <div class="css-majax">
        <?php foreach($css as $file){ echo "\n\t\t"; ?>
            <link rel="stylesheet" href="<?php echo $file; ?>" type="text/css"/>
        <?php } echo "\n\t"; ?>
    </div>
    <!-- End Load Dynamically CSS -->

    <!-- Menubar -->
    <?php echo $this->load->get_section('mainmenu'); ?>
    <!-- End Menubar -->

    <main role="main">
        <div class="ajax-content">    
            <?php echo $output;?>
        </div>
    </main>
    
    <!-- Menubar -->
    <?php echo $this->load->get_section('footer'); ?>
    <!-- End Menubar -->
    
    <script src="<?php echo base_url('assets/store/vendor/js/jquery.js'); ?>"></script>
    <script src="<?php echo base_url('assets/store/vendor/js/popper.js'); ?>"></script>
    <script src="<?php echo base_url('assets/store/vendor/js/bootstrap.js'); ?>"></script>
    <script src="<?php echo base_url('assets/store/vendor/js/swiper.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/store/vendor/js/prism.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/aform/jquery.form.min.js') ;?>"></script>
    <script src="<?php echo base_url('assets/pjax/pjax.js') ;?>"></script>
    <script data-pace-options='{ "ajax": false }' src='<?php echo base_url('assets/app/js/pace.min.js') ;?>'></script>
    <script src="<?php echo base_url('assets/scripts/store.pjax.js') ;?>"></script>
    

    <!-- Load Dynamically JS -->
    <div class="js-majax">
        <?php foreach($js as $file){ echo "\n\t\t"; ?>
        <script src="<?php echo $file; ?>"></script>
        <?php } echo "\n\t"; ?>
        <script src="<?php echo base_url('assets/store/js/custom.js'); ?>"></script>
    </div>
    <!-- End Load Dynamically JS -->

    </body>
</html>

