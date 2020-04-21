<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title><?php echo $this->config->item('system_name');?> - Admin & Dashboard Center</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimal-ui" />
        <meta content="Online Training Center" name="description" />
        <meta content="MuHanz" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <!-- Hidden from google -->
        <meta name="robots" content="noindex">
        <meta name="googlebot" content="noindex">

        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">

        <!-- App css -->
        <link href="<?php echo base_url('assets/app/css/bootstrap.min.css') ;?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/app/css/icons.min.css') ;?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/app/css/app.min.css') ;?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/app/css/styles.css') ;?>" rel="stylesheet" type="text/css" />

    </head>

    <body class="authentication-bg">
        
        <div class="account-pages my-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-10">
                        <div class="card">
                            <div class="card-body p-0">
                                <div class="row">
                                <div class="col-lg-6 d-none d-md-inline-block">
                                        <div class="auth-page-sidebar">
                                            <div class="overlay"></div>
                                            <div class="auth-user-testimonial">
                                                <p class="font-size-24 font-weight-bold text-white mb-1">Go out and change the world.</p>
                                                <p class="lead">"The more you study, the more you should have."</p>
                                                <p>- Anonymous</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 p-5">
                                        <div class="mx-auto mb-5">
                                            <a href="<?php echo base_url();?>">
                                            <img src="<?php echo base_url('assets/app/images/logo.png');?>" alt="" height="24" />
                                                <h3 class="d-inline align-middle ml-1 text-logo">Training Center</h3>
                                            </a>
                                        </div>

                                        <h6 class="h5 mb-0 mt-4">Welcome back!</h6>
                                        <p class="text-muted mt-1 mb-4">Enter your email address and password to
                                            access admin panel.</p>

                                        <form action="#" class="authentication-form">
                                            <div class="form-group">
                                                <label class="form-control-label">Email Address</label>
                                                <div class="input-group input-group-merge">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="icon-dual" data-feather="mail"></i>
                                                        </span>
                                                    </div>
                                                    <input type="email" class="form-control" id="email" placeholder="hello@trainingcenter.events">
                                                </div>
                                            </div>

                                            <div class="form-group mt-4">
                                                <label class="form-control-label">Password</label>
                                                <div class="input-group input-group-merge">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="icon-dual" data-feather="lock"></i>
                                                        </span>
                                                    </div>
                                                    <input type="password" class="form-control" id="password"
                                                        placeholder="Enter your password">
                                                </div>
                                            </div>

                                            <div class="form-group mb-4">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input"
                                                        id="checkbox-signin">
                                                    <label class="custom-control-label" for="checkbox-signin">Remember
                                                        me</label>
                                                </div>
                                            </div>

                                            <div class="form-group mb-0 text-center">
                                                <button class="btn btn-primary btn-block" type="submit"> Log In
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                    
                                </div>
                                
                            </div> <!-- end card-body -->
                        </div>
                        <!-- end card -->
                    </div> <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end page -->
        <script src="<?php echo base_url('assets/app/js/vendor.min.js') ;?>"></script>
        <script src="<?php echo base_url('assets/app/js/app.min.js') ;?>"></script>
    </body>
</html>