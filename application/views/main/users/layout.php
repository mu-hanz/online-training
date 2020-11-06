
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
    <div class="back-to-home rounded d-none d-sm-block">
            <a href="<?php echo base_url();?>" class="btn btn-icon btn-soft-primary"><i data-feather="home" class="icons"></i></a>
        </div>

    <?php echo $output;?>
    

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
       
        <script>
            $(document).on('click', '.google-sign-in', function(e) {
                e.preventDefault();
                var base_url = window.location.origin;
                var popupWinWidth = 500;
                var popupWinHeight = 600;
                var left = (screen.width - popupWinWidth) / 2; 
                var top = (screen.height - popupWinHeight) / 2; 
                
                var authWindow = window.open(base_url + '/socialconnect/auth/Google', 'Google Sign-in - Training Center',  
                        'resizable=yes, width=' + popupWinWidth 
                        + ', height=' + popupWinHeight + ', top=' 
                        + top + ', left=' + left); 
                window.closeAuthWindow = function () {
                    authWindow.close();
                }

            });


    </script>
    </body>
</html>
