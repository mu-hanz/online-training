<!-- Hero Start -->
<section class="bg-home d-flex align-items-center">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-7 col-md-6">
                        <div class="mr-lg-5">   
                            <img src="<?php echo base_url('assets/main/images/user/signup.svg');?>" class="img-fluid d-block mx-auto" alt="">
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-6">
                        <div class="card login_page shadow rounded border-0 form-body">
                            <div class="card-body">
                                <h4 class="card-title text-center">Create New Password</h4>  
                                    <form class="ajaxFormAuth login-form mt-4" action="<?=$action; ?>" method="post">
                                    <input type="hidden" id="mz-csrf" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">  

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <p class="text-muted">Please enter your new password for your account <strong>Training Center</strong></p>
                                            <div class="form-group position-relative">
                                                <label>New Password <span class="text-danger">*</span></label>
                                                <i data-feather="key" class="fea icon-sm icons"></i>
                                                <input type="password" pattern=".{8,}"   required title="8 characters minimum" class="form-control pl-5" placeholder="Enter your new password" name="password" required="">
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                        <button class="btn btn-primary btn-block">Reset</button>
                                    
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