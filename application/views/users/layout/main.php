<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title><?php echo $title;?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Training Ahli K3, HSE Consultant, Konsultan ISO Indonesia oleh Training Center. WA 0812 9826 2727 untuk info lebih lanjut." />
    <meta name="keywords" content="Training Ahli K3 Umum,HSE Consultant,Konsultan ISO">
    <!-- Favicons-->
    <link rel="shortcut icon" href="<?php echo base_url('assets/store/img/favicon.ico') ;?>" type="image/x-icon">
    <link rel="apple-touch-icon" type="image/x-icon" href="<?php echo base_url('assets/store/img/apple-touch-icon-57x57-precomposed.png') ;?>">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="72x72" href="<?php echo base_url('assets/store/img/apple-touch-icon-72x72-precomposed.png') ;?>">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="114x114" href="<?php echo base_url('assets/store/img/apple-touch-icon-114x114-precomposed.png') ;?>">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="144x144" href="<?php echo base_url('assets/store/img/apple-touch-icon-144x144-precomposed.png') ;?>">
    

    <!-- BASE CSS -->
    <link href="<?php echo base_url('assets/users/css/main.min.css') ;?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/users/css/custom.css') ;?>" rel="stylesheet">
	<link href="<?php echo base_url('assets/users/css/rtl.css') ;?>" rel="stylesheet">
</head>

<body>
    
    <!-- Load Dynamically CSS -->
    <div class="css-majax">
        <?php foreach($css as $file){ echo "\n\t\t"; ?>
            <link rel="stylesheet" href="<?php echo $file; ?>" type="text/css"/>
        <?php } echo "\n\t"; ?>
    </div>
    <!-- End Load Dynamically CSS -->
        
    <header class="nav-wrap bg-dark fixed-top">
        <?php echo $this->load->get_section('menu'); ?>
    </header>
    

    <main role="main">
         
        <div class="wrapper">  
            <div class="ajax-content">
                <?php echo $this->load->get_section('breadcrumb'); ?>

                <div class="container">
                    
                <div class="wrapper-one"> 
                    <div id="sidebar">
                        <?php echo $this->load->get_section('menu_users'); ?>
                    </div>
                    <div id="content">

                        <?php echo $output;?>
                    </div>  
                </div>
                
            </div>
        </div>
            
        </div>
    </main>
    

    <footer>
        <?php echo $this->load->get_section('footer'); ?>
    </footer>
    
    

    
    
    <!-- COMMON SCRIPTS -->
    <script src="<?php echo base_url('assets/users/js/main.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/users/js/jquery.blockUI.js'); ?>"></script>
    <script src="<?php echo base_url('assets/aform/jquery.form.min.js') ;?>"></script>
    <script src="<?php echo base_url('assets/pjax/pjax.js') ;?>"></script>
    <script data-pace-options='{ "ajax": false }' src='<?php echo base_url('assets/app/js/pace.min.js') ;?>'></script>
    <script src="<?php echo base_url('assets/scripts/users.pjax.js') ;?>"></script>
          
    <!-- Load Dynamically JS -->
    <div class="js-majax">
    <script src="<?php echo base_url('assets/users/js/core.init.js'); ?>"></script> 
        <?php foreach($js as $file){ echo "\n\t\t"; ?>
        <script src="<?php echo $file; ?>"></script>
        <?php } echo "\n\t"; ?>
    </div>
    <!-- End Load Dynamically JS -->

    </body>
</html>

