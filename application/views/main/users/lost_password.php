<!-- Hero Start -->
<section class="bg-home d-flex align-items-center">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-7 col-md-6">
                        <div class="mr-lg-5">   
                            <img src="<?php echo base_url('assets/main/images/user/recovery.svg');?>" class="img-fluid d-block mx-auto" alt="">
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-6">
                        <div class="card login_page shadow rounded border-0 form-body">
                            <div class="card-body">
                                <h4 class="card-title text-center">Recover Account</h4>  

                                <form class="ajaxFormAuth login-form mt-4" action="<?php echo base_url('account/forgot-password'); ?>" method="post">
                                <input type="hidden" id="mz-csrf" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">    
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <p class="text-muted">Please enter your email address. You will receive a link to create a new password via email.</p>
                                            <div class="form-group position-relative">
                                                <label>Email address <span class="text-danger">*</span></label>
                                                <i data-feather="mail" class="fea icon-sm icons"></i>
                                                <input type="email" class="form-control pl-5" placeholder="Enter Your Email Address" name="identity" required="">
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <button class="btn btn-primary btn-block">Send</button>
                                        </div>
                                        <div class="mx-auto">
                                            <p class="mb-0 mt-3"><small class="text-dark mr-2">Remember your password ?</small> <a href="<?php echo base_url('account/login');?>" class="text-primary font-weight-bold mlink">Sign in</a></p>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div> <!--end col-->
                </div><!--end row-->
            </div> <!--end container-->
        </section><!--end section-->
        <!-- Hero End -->