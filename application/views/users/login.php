<!DOCTYPE html>
<html lang="en"><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Training Center</title>


    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/login/bootstrap.css') ;?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/login/fontawesome-all.css') ;?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/login/style.css') ;?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/login/custom.css') ;?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/sweetalert/sweetalert2.min.css') ;?>">

</head>
<body>
    <div class="form-body without-side">
        <div class="website-logo">
            <a href="<?php echo base_url();?>">
                <div class="">
                    <img class="logo-size" src="<?php echo base_url('assets/store/img/logo_2x.png');?>" alt="Training Center">
                </div>
            </a>
        </div>
        <div class="row">
            <div class="img-holder">
                <div class="bg"></div>
                <div class="info-holder">
                    <img src="    <?php echo base_url('assets/login/graphic3.svg') ;?>" alt="">
                </div>
            </div>
            <div class="form-holder">
                <div class="form-content">
                    <div class="form-items">
                        <h3>Login to account</h3>
                        <p>Access to the most powerfull<br> Online and Virtual Training.</p>
                        <form class="ajaxForm" action="<?php echo base_url('webadmin/auth/auth/login'); ?>" method="post">
                        <input type="hidden" id="mz-csrf" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">    
                            <input class="form-control" type="text" name="identity" placeholder="E-mail Address" required="">
                            <input class="form-control" type="password" name="password" placeholder="Password" required="">
                            <div class="form-button">
                                <button id="submit" type="submit" class="ibtn">Login</button> <a href="#">Forget password?</a>
                            </div>
                        </form>
                        <div class="other-links">
                            <div class="text">Or login with</div>
                            <a href="#"><i class="fab fa-facebook-f"></i>Facebook</a>
                            <a href="#"><i class="fab fa-google"></i>Google</a>
                          
                        </div>
                        <div class="page-links">
                            <div class="other-links">
                                <a href="#"><i class="fas fa-user-plus"></i> Buat akun baru</a>
                            </div>
                        </div>
                        <div class="page-links">
                            <a href="#" class="goback"><i class="fas fa-arrow-circle-left"></i> Kembali ke halaman utama</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script src="<?php echo base_url('assets/login/jquery.js') ;?>"></script>
<script src="<?php echo base_url('assets/login/popper.js') ;?>"></script>
<script src="<?php echo base_url('assets/login/bootstrap.js') ;?>"></script>
<script src="<?php echo base_url('assets/aform/jquery.form.min.js') ;?>"></script>
<script src="<?php echo base_url('assets/app/js/blockUI.min.js') ;?>"></script>
<script src="<?php echo base_url('assets/sweetalert/sweetalert2.all.min.js') ;?>"></script>
<script src="<?php echo base_url('assets/login/main.js') ;?>"></script>
<script src="<?php echo base_url('assets/login/login.init.js') ;?>"></script>

</body>
</html>